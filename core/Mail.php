<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\Exception as MailException;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Contact notifications using HTML templates in app/Views/contact/_emails/
 * Settings: config/mail.php (loaded from .env).
 */
final class Mail
{
    /**
     * @param array<string, string> $data Keys: full_name, email, subject, message, service_interest (optional)
     */
    public static function notifyContactSubmission(array $data, ?string $fallbackRecipient = null): void
    {
        if (!MAIL_NOTIFY_ENABLED) {
            return;
        }

        $adminTo = MAIL_NOTIFY_TO;
        if ($adminTo === '' && $fallbackRecipient !== null) {
            $adminTo = trim($fallbackRecipient);
        }
        if ($adminTo === '' || !filter_var($adminTo, FILTER_VALIDATE_EMAIL)) {
            log_error('Contact email notification skipped: set MAIL_NOTIFY_TO in .env or a valid company email in site settings.');

            return;
        }

        $from = MAIL_FROM;
        if ($from === '' || !filter_var($from, FILTER_VALIDATE_EMAIL)) {
            $host = parse_url((string) APP_URL, PHP_URL_HOST);
            $host = \is_string($host) && $host !== '' ? $host : 'localhost';
            $from = 'noreply@' . $host;
        }

        $name = (string) ($data['full_name'] ?? '');
        $visitorEmail = (string) ($data['email'] ?? '');
        $subjectLine = (string) ($data['subject'] ?? '');
        $message = (string) ($data['message'] ?? '');
        $service = (string) ($data['service_interest'] ?? '');

        if ($visitorEmail === '' || !filter_var($visitorEmail, FILTER_VALIDATE_EMAIL)) {
            log_error('Contact email: invalid visitor email, skipping notifications.');

            return;
        }

        $replyMailto = 'mailto:' . rawurlencode($visitorEmail) . '?subject=' . rawurlencode('Re: ' . $subjectLine);

        $ctx = [
            'full_name' => $name,
            'email' => $visitorEmail,
            'subject' => $subjectLine,
            'service_interest' => $service,
            'message' => $message,
            'reply_mailto_href' => $replyMailto,
            'site_url' => base_url(),
        ];

        $htmlReceiver = self::renderEmailTemplate('receiver.mail', $ctx);
        $htmlSender = self::renderEmailTemplate('sender.mail', $ctx);

        if ($htmlReceiver === '' || $htmlSender === '') {
            log_error('Contact email: template render returned empty.');

            return;
        }

        $adminSubject = '[Contact form] ' . $subjectLine;
        $senderSubject = MAIL_SENDER_SUBJECT;
        if ($senderSubject === '') {
            $senderSubject = 'Thank you for contacting Wincon Pilling';
        }

        /* Admin: Reply-To visitor */
        self::sendHtmlMessage($adminTo, $from, $adminSubject, $htmlReceiver, $visitorEmail);

        /* Visitor confirmation: Reply-To company inbox */
        if (MAIL_NOTIFY_SENDER) {
            self::sendHtmlMessage($visitorEmail, $from, $senderSubject, $htmlSender, $adminTo);
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    private static function renderEmailTemplate(string $basename, array $data): string
    {
        $path = APP_PATH . '/Views/contact/_emails/' . $basename . '.php';
        if (!is_file($path)) {
            log_error('Email template not found: ' . $path);

            return '';
        }
        extract($data, EXTR_SKIP);
        ob_start();
        include $path;

        return (string) ob_get_clean();
    }

    private static function sendHtmlMessage(
        string $to,
        string $from,
        string $subject,
        string $htmlBody,
        string $replyTo,
    ): void {
        $mailer = MAIL_MAILER;
        $smtpHost = SMTP_HOST;

        if ($mailer === 'smtp' && $smtpHost !== '' && class_exists(PHPMailer::class)) {
            self::sendViaSmtp($to, $from, $subject, $htmlBody, $replyTo);

            return;
        }

        if ($mailer === 'smtp' && $smtpHost !== '' && !class_exists(PHPMailer::class)) {
            log_error('SMTP requested but PHPMailer is missing. Run: composer install');
        }

        self::sendViaPhpMail($to, $from, $subject, $htmlBody, $replyTo);
    }

    private static function sendViaSmtp(
        string $to,
        string $from,
        string $subject,
        string $htmlBody,
        string $replyTo,
    ): void {
        try {
            $mail = new PHPMailer(true);
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->Port = SMTP_PORT;
            $mail->SMTPAuth = SMTP_AUTH;

            if ($mail->SMTPAuth && SMTP_USER !== '') {
                $mail->Username = SMTP_USER;
                $mail->Password = SMTP_PASSWORD;
            }

            $enc = SMTP_ENCRYPTION;
            $mail->SMTPSecure = match ($enc) {
                'ssl' => PHPMailer::ENCRYPTION_SMTPS,
                'tls', 'starttls' => PHPMailer::ENCRYPTION_STARTTLS,
                default => '',
            };

            $mail->setFrom($from, APP_NAME);
            $mail->addAddress($to);
            $mail->addReplyTo($replyTo);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $htmlBody;
            $plain = html_entity_decode(\strip_tags(\preg_replace('/<br\s*\/?>/i', "\n", $htmlBody)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $mail->AltBody = $plain;

            $mail->send();
        } catch (MailException $e) {
            log_error('SMTP send failed: ' . $e->getMessage(), ['to' => $to]);
        }
    }

    private static function sendViaPhpMail(
        string $to,
        string $from,
        string $subject,
        string $htmlBody,
        string $replyTo,
    ): void {
        if (\function_exists('mb_encode_mimeheader')) {
            $enc = mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n");
            if (\is_string($enc) && $enc !== '') {
                $subject = $enc;
            }
        }

        $boundary = 'b_' . bin2hex(random_bytes(8));
        $plain = html_entity_decode(\strip_tags(\preg_replace('/<br\s*\/?>/i', "\n", $htmlBody)), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $body = "--{$boundary}\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
        $body .= $plain . "\r\n";
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $body .= $htmlBody . "\r\n";
        $body .= "--{$boundary}--\r\n";

        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
            'From: ' . $from,
            'Reply-To: ' . $replyTo,
        ];

        $ok = @mail($to, $subject, $body, implode("\r\n", $headers));
        if (!$ok) {
            log_error('mail() failed for contact notification', ['to' => $to]);
        }
    }
}

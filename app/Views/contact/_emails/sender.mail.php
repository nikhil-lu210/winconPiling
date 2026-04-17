<?php
declare(strict_types=1);
/** @var string $full_name */
/** @var string $subject */
/** @var string $message */
/** @var string $service_interest */
/** @var string $site_url */
$service_interest = (($service_interest ?? '') !== '') ? (string) $service_interest : '—';
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title>Thank You for Contacting Wincon Pilling</title>
    <!--[if mso]>
    <style>
        table {border-collapse:collapse;border-spacing:0;border:none;margin:0;}
        div, td {padding:0;}
        div {margin:0 !important;}
    </style>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        body, table, td, div, p, a {
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            word-break: break-word;
            -webkit-font-smoothing: antialiased;
            background-color: #f4f4f4;
        }
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: auto !important;
            }
            .content-padding {
                padding: 20px !important;
            }
            .button {
                display: block !important;
                width: 100% !important;
                text-align: center !important;
            }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;">
    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background-color:#f4f4f4;">
        <tr>
            <td align="center" style="padding:40px 10px;">
                <table role="presentation" class="email-container" style="width:600px;border-collapse:collapse;border:1px solid #d1d6e0;border-spacing:0;text-align:left;background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center" style="padding:30px 20px;background-color:#ffffff;border-bottom:3px solid #f2b705;">
                            <h1 style="margin:0;font-size:28px;font-weight:800;letter-spacing:-0.5px;color:#0f1e3a;">
                                WINCON<span style="color:#f2b705;">PILLING</span>
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:40px 40px 20px 40px;background-color:#fff8e6;">
                            <h2 style="margin:0;font-size:24px;font-weight:800;color:#c99404;">Message Received!</h2>
                        </td>
                    </tr>
                    <tr>
                        <td class="content-padding" style="padding:30px 40px 20px 40px;">
                            <p style="margin:0 0 20px 0;font-size:16px;line-height:24px;color:#334155;">
                                Dear <strong><?= e($full_name) ?></strong>,
                            </p>
                            <p style="margin:0 0 20px 0;font-size:16px;line-height:26px;color:#475569;">
                                Thank you for reaching out to <strong>Wincon Pilling and Constructing Company Limited</strong>. This email is to confirm that we have successfully received your inquiry regarding <strong>"<?= e($subject) ?>"</strong>.
                            </p>
                            <p style="margin:0 0 30px 0;font-size:16px;line-height:26px;color:#475569;">
                                Our specialist team is currently reviewing your message. We aim to respond to all inquiries as quickly as possible, typically within 1-2 business days.
                            </p>
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background-color:#f4f4f4;border-radius:6px;border:1px solid #d1d6e0;">
                                <tr>
                                    <td style="padding:20px;">
                                        <p style="margin:0 0 10px 0;font-size:14px;font-weight:700;color:#0f1e3a;text-transform:uppercase;letter-spacing:0.5px;">Summary of your inquiry:</p>
                                        <p style="margin:0 0 5px 0;font-size:14px;color:#475569;"><strong>Service Interest:</strong> <?= e($service_interest) ?></p>
                                        <p style="margin:0;font-size:14px;color:#475569;line-height:22px;"><strong>Message:</strong><br><span style="color:#64748b;font-style:italic;">"<?= e($message) ?>"</span></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="content-padding" style="padding:20px 40px 40px 40px;">
                            <p style="margin:0 0 20px 0;font-size:15px;line-height:24px;color:#475569;">
                                If you need immediate assistance, please feel free to call us directly or reply to this email.
                            </p>
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                    <td align="center">
                                        <a href="tel:+2348037568817" class="button" style="display:inline-block;padding:14px 30px;background-color:#0f1e3a;color:#ffffff;text-decoration:none;border-radius:6px;font-weight:bold;font-size:16px;text-align:center;letter-spacing:0.5px;">Call Us Now</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;background-color:#0f1e3a;text-align:center;">
                            <p style="margin:0 0 10px 0;font-size:14px;color:#e2e8f0;">
                                <strong>Wincon Pilling and Constructing Company Limited</strong>
                            </p>
                            <p style="margin:0 0 15px 0;font-size:13px;color:#94a3b8;">
                                Abuja, Nigeria | +234 803 756 8817
                            </p>
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                    <td align="center">
                                        <a href="<?= e($site_url) ?>" style="color:#f2b705;text-decoration:none;font-size:13px;font-weight:bold;">Visit Our Website</a>
                                    </td>
                                </tr>
                            </table>
                            <hr style="border:0;border-top:1px solid #334155;margin:20px 0;">
                            <p style="margin:0;font-size:11px;color:#64748b;">
                                RC: 766863 | Incorporated August 20, 2008<br>
                                Please do not hesitate to reach out if you have any further questions.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

<?php
declare(strict_types=1);
/** @var string $full_name */
/** @var string $email */
/** @var string $subject */
/** @var string $service_interest */
/** @var string $message */
/** @var string $reply_mailto_href */
$service_interest = (($service_interest ?? '') !== '') ? (string) $service_interest : '—';
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title>New Website Inquiry - Wincon Pilling</title>
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
                        <td align="center" style="padding:24px 20px 20px 20px;background-color:#ffffff;border-bottom:3px solid #f2b705;">
                            <table role="presentation" style="margin:0 auto;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                    <td style="padding:0 14px 0 0;vertical-align:middle;">
                                        <picture>
                                            <source srcset="<?= e(base_url('assets/images/logo.webp')) ?>" type="image/webp">
                                            <img src="<?= e(base_url('assets/images/logo.png')) ?>" alt="Wincon Pilling" width="56" style="display:block;border:0;height:auto;max-width:56px;">
                                        </picture>
                                    </td>
                                    <td style="vertical-align:middle;text-align:left;">
                                        <h1 style="margin:0;font-size:28px;font-weight:800;letter-spacing:-0.5px;color:#0f1e3a;line-height:1.1;">
                                            WINCON<span style="color:#f2b705;">PILLING</span>
                                        </h1>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="content-padding" style="padding:40px 40px 20px 40px;">
                            <h2 style="margin:0 0 15px 0;font-size:20px;font-weight:700;color:#1e2f4a;">New Inquiry Received</h2>
                            <p style="margin:0 0 25px 0;font-size:16px;line-height:24px;color:#475569;">
                                Hello Admin,<br><br>
                                You have received a new message from the contact form on your website. Here are the details:
                            </p>
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                    <td style="padding:0 0 5px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;">Full Name</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 0 20px 0;font-size:16px;color:#0f1e3a;font-weight:600;"><?= e($full_name) ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:0 0 5px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;">Email Address</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 0 20px 0;font-size:16px;color:#c99404;font-weight:600;">
                                        <a href="mailto:<?= e($email) ?>" style="color:#c99404;text-decoration:none;"><?= e($email) ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 0 5px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;">Subject</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 0 20px 0;font-size:16px;color:#0f1e3a;"><?= e($subject) ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:0 0 5px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;">Service Interest</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 0 20px 0;font-size:16px;color:#0f1e3a;"><?= e($service_interest) ?></td>
                                </tr>
                            </table>
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;margin-top:10px;">
                                <tr>
                                    <td style="padding:0 0 5px 0;font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;">Message</td>
                                </tr>
                                <tr>
                                    <td style="padding:20px;background-color:#f4f4f4;border-left:4px solid #f2b705;border-radius:0 4px 4px 0;font-size:15px;line-height:24px;color:#334155;white-space:pre-wrap;"><?= e($message) ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="content-padding" style="padding:20px 40px 40px 40px;">
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
                                    <td align="center">
                                        <a href="<?= e($reply_mailto_href) ?>" class="button" style="display:inline-block;padding:14px 30px;background-color:#f2b705;color:#0f1e3a;text-decoration:none;border-radius:6px;font-weight:bold;font-size:16px;text-align:center;letter-spacing:0.5px;">Reply to Sender</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;background-color:#0f1e3a;text-align:center;">
                            <p style="margin:0 0 10px 0;font-size:14px;color:#94a3b8;">
                                <strong>Wincon Pilling and Constructing Company Limited</strong>
                            </p>
                            <p style="margin:0 0 10px 0;font-size:12px;color:#64748b;">
                                RC: 766863 | Incorporated August 20, 2008
                            </p>
                            <p style="margin:0;font-size:12px;color:#64748b;">
                                This email was generated automatically from your website.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

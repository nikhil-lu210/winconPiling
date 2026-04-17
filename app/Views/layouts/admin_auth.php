<?php
declare(strict_types=1);
/** @var string $content */
$pageTitle = $pageTitle ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e((string) $pageTitle) ?> — Wincon Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
    <style>
        body.admin-auth-body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            font-family: "Plus Jakarta Sans", system-ui, sans-serif;
            background: radial-gradient(ellipse 120% 80% at 50% 0%, #1a2d52 0%, #0f1e3a 55%, #070d18 100%);
            color: #e8ecf1;
        }
        .admin-auth-card {
            width: 100%;
            max-width: 400px;
            background: rgba(30, 42, 58, 0.92);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 2rem 2rem 1.75rem;
            box-shadow: 0 24px 48px rgba(0,0,0,0.45);
        }
        .admin-auth-logo {
            text-align: center;
            margin-bottom: 0.25rem;
        }
        .admin-auth-logo strong {
            font-size: 1.35rem;
            letter-spacing: 0.04em;
            color: #fff;
        }
        .admin-auth-logo span {
            display: block;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.5);
            margin-top: 0.35rem;
        }
        .admin-auth-sub {
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.65);
            margin: 0 0 1.5rem;
        }
        .admin-auth-alert {
            padding: 0.65rem 0.85rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }
        .admin-auth-alert--error {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid rgba(220, 53, 69, 0.35);
            color: #f8b4bd;
        }
        .admin-auth-alert--info {
            background: rgba(13, 110, 253, 0.12);
            border: 1px solid rgba(13, 110, 253, 0.3);
            color: #9ec5fe;
        }
        .admin-auth-field { margin-bottom: 1rem; }
        .admin-auth-field label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: rgba(255,255,255,0.55);
            margin-bottom: 0.35rem;
        }
        .admin-auth-input-wrap {
            position: relative;
        }
        .admin-auth-field input[type="text"],
        .admin-auth-field input[type="password"] {
            width: 100%;
            padding: 0.65rem 2.75rem 0.65rem 0.85rem;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(0,0,0,0.25);
            color: #fff;
            font-size: 0.95rem;
        }
        .admin-auth-field input:focus {
            outline: none;
            border-color: #f2b705;
            box-shadow: 0 0 0 2px rgba(242, 183, 5, 0.22);
        }
        .admin-auth-toggle-pw {
            position: absolute;
            right: 0.35rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.45);
            cursor: pointer;
            padding: 0.35rem 0.5rem;
            font-size: 0.8rem;
        }
        .admin-auth-toggle-pw:hover { color: #f2b705; }
        .admin-auth-submit {
            width: 100%;
            padding: 0.75rem;
            margin-top: 0.25rem;
            border: none;
            border-radius: 8px;
            background: #f2b705;
            color: #0f1e3a;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            font-family: inherit;
        }
        .admin-auth-submit:hover { filter: brightness(1.05); }
        .admin-auth-foot {
            text-align: center;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.35);
            margin: 1.5rem 0 0;
            letter-spacing: 0.02em;
        }
    </style>
</head>
<body class="admin-auth-body">
<?= $content ?>
</body>
</html>

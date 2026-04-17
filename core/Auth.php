<?php

declare(strict_types=1);

final class Auth
{
    private static string $sessionKey = '_admin_user';

    public static function check(): bool
    {
        return Session::has(self::$sessionKey);
    }

    public static function login(array $user): void
    {
        Session::regenerate();
        Session::set(self::$sessionKey, $user);
    }

    public static function logout(): void
    {
        Session::delete(self::$sessionKey);
        Session::regenerate();
    }

    public static function user(): ?array
    {
        $u = Session::get(self::$sessionKey);
        return is_array($u) ? $u : null;
    }

    public static function guard(): void
    {
        if (!self::check()) {
            $response = new Response();
            $response->redirect(base_url('admin'));
        }
    }
}

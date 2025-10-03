<?php

class Session {
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_httponly' => true,
                'cookie_secure' => isset($_SERVER['HTTPS']),
                'cookie_samesite' => 'Strict',
            ]);
        }
    }

    public static function set(string $key, $value): void {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key) {
        self::start();
        return $_SESSION[$key] ?? null;
    }

    public static function exists(string $key): bool {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function destroy(): void {
        self::start();
        $_SESSION = [];
        session_destroy();
    }

    public static function isAuthenticated(): bool {
        self::start();
        return self::exists('user');
    }

    public static function user(): ?array {
        return self::get('user');
    }

    public static function checkRole(array $roles): bool {
        $user = self::user();
        if (!$user) return false;
        return in_array($user['tipo'], $roles);
    }
}

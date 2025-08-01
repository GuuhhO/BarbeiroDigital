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
        $_SESSION[$key] = $value;
    }

    public static function get(string $key) {
        return $_SESSION[$key] ?? null;
    }

    public static function destroy(): void {
        $_SESSION = [];
        session_destroy();
    }

    public static function isAuthenticated(): bool {
        return isset($_SESSION['user']);
    }
}

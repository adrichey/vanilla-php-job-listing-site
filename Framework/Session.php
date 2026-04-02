<?php

namespace Framework;

class Session {
    public function __construct() {
        throw new \Exception('Not implemented');
    }

    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public static function has(string $key): bool {
        return isset($_SESSION[$key]);
    }

    public static function clear(string $key): void {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function clearAll(): void {
        session_unset();
        session_destroy();
    }

    public static function setFlashMessage(string $key, string $message): void {
        self::set("flash_message_{$key}", $message);
    }

    public static function getFlashMessage(string $key): string {
        $flashKey = "flash_message_{$key}";
        $message = self::get($flashKey, '');
        self::clear($flashKey);

        return $message;
    }
}

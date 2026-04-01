<?php

namespace Framework;

class Validation {
    public static function string(string $value, int $min = 1, int $max = PHP_INT_MAX): bool {
        if (!is_string($value)) {
            return false;
        }

        $length = strlen($value);

        if ($length < $min) {
            return false;
        }

        if ($length > $max) {
            return false;
        }

        return true;
    }

    public static function email(string $value): bool {
        if (filter_var(trim($value), FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        
        return false;
    }

    public static function match(string $value1, string $value2): bool {
        if (trim($value1) === trim($value2)) {
            return true;
        }

        return false;
    }
}

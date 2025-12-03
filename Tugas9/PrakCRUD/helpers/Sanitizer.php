<?php

class Sanitizer {
    public static function phone($value) {
        // Format phone number to +62-XXX-XXXX-XXXX
        return preg_replace('/[^0-9]/', '', $value);
    }

    public static function name($value) {
        // Capitalize and remove special characters
        return ucwords(preg_replace('/[^a-zA-Z ]/', '', $value));
    }

    public static function alphanumeric($value) {
        // Only allow letters and numbers
        return preg_replace('/[^a-zA-Z0-9]/', '', $value);
    }
}

?>
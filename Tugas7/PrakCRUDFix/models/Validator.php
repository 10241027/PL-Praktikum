<?php

class Validator {
    // Existing validation methods

    public static function numeric($value) {
        return is_numeric($value);
    }

    public static function between($value, $min, $max) {
        return $value >= $min && $value <= $max;
    }

    public static function in($value, $array) {
        return in_array($value, $array);
    }

    public static function unique($table, $column, $exceptId = null) {
        // Implement unique check logic here
        // Example: Query database to check uniqueness
        return true; // Placeholder
    }

    public static function confirmed($field, $confirmationField) {
        return $field === $confirmationField;
    }

    public static function dateFormat($date, $format) {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}

?>
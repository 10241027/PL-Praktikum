<?php

class Validator {
    
    public static function numeric($value) {
        return is_numeric($value);
    }

    public static function between($value, $min, $max) {
        return $value >= $min && $value <= $max;
    }

    public static function in($value, $array) {
        return in_array($value, $array);
    }

    /**
     * Check database uniqueness for a given table.column and value.
     * Returns true if value is unique (no other row has it), false otherwise.
     * @param string $table
     * @param string $column
     * @param mixed $value
     * @param int|null $exceptId optional id to exclude (useful on update)
     * @return bool
     */
    public static function unique($table, $column, $value, $exceptId = null) {
        
        $dbFile = __DIR__ . '/../config/database.php';
        if (file_exists($dbFile)) {
            require_once $dbFile;
        }

        if (!isset($conn) || !$conn) {
            
            $conn = new mysqli('localhost', 'root', '', 'minimarket');
            if ($conn->connect_error) return false; // cannot verify uniqueness
        }

        $sql = "SELECT id FROM {$table} WHERE {$column} = ?";
        if ($exceptId !== null) {
            $sql .= " AND id <> ?";
        }

        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;

        if ($exceptId !== null) {
            $stmt->bind_param('si', $value, $exceptId);
        } else {
            $stmt->bind_param('s', $value);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        $exists = $res->fetch_assoc();
        $stmt->close();

        return $exists ? false : true;
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
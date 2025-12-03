<?php

class DateHelper {
    public static function format($date, $format) {
        return date($format, strtotime($date));
    }

    public static function age($birthdate) {
        $birthDate = new DateTime($birthdate);
        $today = new DateTime();
        $age = $today->diff($birthDate);
        return $age->y;
    }

    public static function diffHuman($date) {
        $dateTime = new DateTime($date);
        $now = new DateTime();
        $interval = $now->diff($dateTime);
        return $interval->format('%y years, %m months, %d days');
    }

    public static function toMysql($date) {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public static function isWeekend($date) {
        $day = date('N', strtotime($date));
        return $day >= 6;
    }
}

?>
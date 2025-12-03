<?php

class DoctorFactory {
    public static function create($data) {
        // Logic to create a single doctor
    }

    public static function createMany($doctors) {
        foreach ($doctors as $data) {
            self::create($data);
        }
    }

    public static function createBySpecialization($specialization, $data) {
        $data['specialization'] = $specialization;
        self::create($data);
    }

    public static function createWithSchedule($data, $schedule) {
        $data['schedule'] = $schedule;
        self::create($data);
    }
}

?>
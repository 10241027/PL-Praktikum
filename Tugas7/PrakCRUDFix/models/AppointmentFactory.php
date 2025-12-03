<?php

class AppointmentFactory {
    public static function create($data) {
        // Logic to create a single appointment
    }

    public static function createMany($appointments) {
        foreach ($appointments as $data) {
            self::create($data);
        }
    }

    public static function createForPatient($patientId, $data) {
        $data['patient_id'] = $patientId;
        self::create($data);
    }

    public static function createForDoctor($doctorId, $data) {
        $data['doctor_id'] = $doctorId;
        self::create($data);
    }

    public static function createInRange($startDate, $endDate, $data) {
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $data['date'] = $currentDate;
            self::create($data);
            $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
        }
    }
}

?>
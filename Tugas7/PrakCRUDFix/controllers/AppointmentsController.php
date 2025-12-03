<?php

require_once '../models/Validator.php';

class AppointmentsController {
    public function create($data) {
        require_once '../helpers/Csrf.php';
        Csrf::verifyOrFail($data['csrf_token']);

        $validator = new Validator();

        if (!$validator::between($data['time'], '08:00', '17:00')) {
            throw new Exception('Appointment time must be between 08:00 and 17:00');
        }

        if (!$validator::unique('appointments', 'time', $data['id'])) {
            throw new Exception('Appointment time must be unique');
        }

        // Additional validation and logic
    }
}

?>
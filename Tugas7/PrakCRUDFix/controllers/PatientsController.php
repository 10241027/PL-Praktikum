<?php

require_once '../models/Validator.php';

class PatientsController {
    public function create($data) {
        require_once '../helpers/Csrf.php';
        Csrf::verifyOrFail($data['csrf_token']);

        $validator = new Validator();

        if (!$validator::numeric($data['age'])) {
            throw new Exception('Age must be numeric');
        }

        if (!$validator::dateFormat($data['birthdate'], 'Y-m-d')) {
            throw new Exception('Invalid date format');
        }

        // Additional validation and logic
    }
}

?>
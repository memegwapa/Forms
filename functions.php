<?php

class Validator {
    private $errors = [];
    private $countries;
    private $data;

    public function __construct($countries = []) {
        $this->countries = $countries;
    }

    /**
     * Get all validation errors.
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Check if a value is not empty or just spaces.
     */
    public function isNotEmptyOrSpaces($value) {
        return trim($value) !== '';
    }

    /**
     * Validate if the selected country exists in the given list.
     */
    public function validateCountry($country) {
        if (!in_array($country, $this->countries)) {
            $this->errors['country'] = "Please select a valid country.";
        } else {
            $_SESSION['country'] = $country;
        }
    }

    /**
     * Validate required fields.
     */
    public function validateRequiredFields($fields) {
        foreach ($fields as $field) {
            if (empty($_POST[$field]) || trim($_POST[$field]) === '') {
                $this->errors[$field] = ucfirst(str_replace("_", " ", $field)) . " is required.";
            }
        }

        // Validate country selection
        if (!empty($_POST['country'])) {
            $this->validateCountry($_POST['country']);
        } else {
            $this->errors['country'] = "Country is required.";
        }
    }

    /**
     * Validate civil status and 'Others' field if applicable.
     */
    public function validateCivilStatus() {
        if (empty($_POST['civil_status'])) {
            $this->errors['civil_status'] = "Civil Status is required.";
        } elseif ($_POST['civil_status'] === 'Others' && empty(trim($_POST['civil_other']))) {
            $this->errors['civil_other'] = "The 'Others' field cannot be empty.";
        } else {
            $_SESSION['civil_status'] = $_POST['civil_status'];
            if ($_POST['civil_status'] === 'Others') {
                $_SESSION['civil_other'] = $_POST['civil_other'];
            }
        }
    }

    /**
     * Ensure name fields do not contain numbers.
     */
    public function validateNameFields($fields) {
        foreach ($fields as $field) {
            if (!empty($_POST[$field]) && preg_match("/\d/", $_POST[$field])) {
                $this->errors[$field] = ucfirst(str_replace("_", " ", $field)) . " must not contain numbers.";
            }
        }
    }

    /**
     * Ensure numeric fields contain only digits.
     */
    public function validateNumericFields($fields) {
        foreach ($fields as $field) {
            if (!empty($_POST[$field]) && !ctype_digit($_POST[$field])) {
                $this->errors[$field] = ucfirst(str_replace("_", " ", $field)) . " must contain numbers only.";
            }
        }
    }

    /**
     * Validate date of birth and ensure the user is at least 18 years old.
     */
    public function validateDateOfBirth() {
        if (empty($_POST['date_of_birth'])) {
            $this->errors['date_of_birth'] = "Date of Birth is required.";
        } else {
            $dob = date("Y-m-d", strtotime($_POST['date_of_birth']));
            $birthDate = new DateTime($dob);
            $today = new DateTime();
            $age = $today->diff($birthDate)->y;

            if ($age < 18) {
                $this->errors['date_of_birth'] = "You must be at least 18 years old.";
            } else {
                $_SESSION['date_of_birth'] = $dob;
                $_SESSION['age'] = $age;
            }
        }
    }

    /**
     * Validate email format.
     */
    public function validateEmail() {
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Please enter a valid email address (e.g., example@domain.com).";
        }
    }

    public function validateSex($field) {
        $validSexOptions = ['Male', 'Female', 'Other'];
    
        // Check if the field exists before validating
        if (!isset($_POST[$field])) {
            $this->errors[$field] = "Sex is required.";
            return;
        }
    
        if (!in_array($_POST[$field], $validSexOptions)) {
            $this->errors[$field] = "Please select a valid gender.";
        } else {
            $_SESSION['sex'] = $_POST[$field];
        }
    }
    

    public function validatePhoneNumber($field) {
        // Check if the field exists and is not empty 
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            return; // Skip validation if empty
        }
    
        // Remove spaces, parentheses, and hyphens before validation
        $telephone = preg_replace("/[\s\-\(\)]/", "", $_POST[$field]);
    
        // Ensure only numbers and an optional leading "+" (for international numbers)
        if (!preg_match("/^\+?\d+$/", $telephone)) {
            $this->errors[$field] = ucfirst(str_replace("_", " ", $field)) . " must accept numbers only.";
            return;
        }
    
        // Validate phone numbers in the format: +1 (882) 907-2862 or other allowed formats
        if (!preg_match("/^\+1\d{10}$|^\+639\d{9}$|^09\d{9}$/", $telephone)) {
            $this->errors[$field] = ucfirst(str_replace("_", " ", $field)) . " must be a valid phone number.";
        }
    }
    
 }      
?>

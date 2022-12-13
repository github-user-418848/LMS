<?php

class Request_Validate {

    public function __construct($method, $fields) {

        $this -> method = $method;
        $this -> fields = $fields;
        $this -> redirect = CURRENT_URL;

        $this -> Fields($this -> method, $this -> fields);

    }

    public function TextField($value, $min_length=3, $max_length=80) {
        if ($this -> Output($value) && strlen($value) >= $min_length && strlen($value) <= $max_length) {
            return $this -> Output($value);
        }
        else {
            Redirect("It should be longer than {$min_length} characters and should not exceed of {$max_length} characters", $this -> redirect);
        }
    }
    
    public function DigitField($value, $min_length=1, $max_length=32) {
        if (ctype_digit((string)$this -> Output($value)) ) {
            if ($value === "0") {
                Redirect("Cannot accept 0 as a value", $this -> redirect);
            }
            else {
                if (strlen($value) >= $min_length && strlen($value) <= $max_length) {
                    return $this -> Output($value);
                }
                else {
                    Redirect("Minimum of {$min_length} and a maximum of {$max_length} input characters are accepted only.", $this -> redirect);
                }
            }
        }
        else {
            Redirect("Digits are only accepted.", $this -> redirect);
        }
    }

    public function EmailField($value) {
        if (filter_var($this -> Output($value), FILTER_VALIDATE_EMAIL)) {
            return $this -> Output($value);
        }
        else {
            Redirect("Input must be an email. Please try again.", $this -> redirect);
        }
    }

    public function ChoicesField($value, $array) {
        if (in_array($value, $array)) {
            return $this -> Output($value);
        }
        else {
            Redirect("Select from the value of the choices only.", $this -> redirect);
        }
    }

    public function PasswordField($value) {
        if ($this -> Output($value)) {
            return $this -> Output($this -> TextField(password_hash($value, PASSWORD_BCRYPT, ['cost' => SALT_COUNT])));
        }
    }

    public function CheckBoxField($value) {
        if (isset($value)) {
            return "true";
        }
        else {
            return "false";
        }
    }

    public function DateField($value) {
        $arr  = explode('-', $value);
        if (count($arr) == 3) {
            return (checkdate($this -> DigitField($arr[1]), $this -> DigitField($arr[2]), $this -> DigitField($arr[0]))) ? $arr[0]."-".$arr[1]."-".$arr[2] : "Not a valid date";
        }
        else {
            Redirect("Not a valid date", $this -> redirect);
        }
    }

    // Could be optional, but it is most often recommended to be added as much as possible

    public function CSRF($value) {
        if (!isset($_SESSION["csrf_token"]) || $this -> TextField($value) !== $_SESSION["csrf_token"]) {
            Redirect("Token has been expired/invalid. Please try again.", $this -> redirect);
        }
    }
    
    public function Fields($method, $fields) {
        foreach ($fields as $field) {
            if (!in_array($field, array_keys($method))) {
                Redirect("Some fields are missing. Please try again.", $this -> redirect);
            }
        }
    }

    public function Output($input) {
        if (!empty($input)) {
            return htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES, "UTF-8");
        }
        else {
            Redirect("All fields are required.", $this -> redirect);
        }
    }
}

<?php
// Handles data validation

declare(strict_types= 1);

// Return True if any inputs are empty
function is_input_empty(string $fname, string $surname, string $email, string $pwd, string $confirm_pwd){

    if (empty($fname) || empty($surname)  || empty($email) || empty($pwd) || empty($confirm_pwd)) {
        return true;
    } else{
        return false;
    }
}

// Return True if email is invalid
function is_email_invalid($email){

    // Returns true if the email is valid, and false otherwise
    /* return !filter_var($email, FILTER_VALIDATE_EMAIL) */
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    } else{
        return false;
    }
}

// Return True if email is already registered
function is_email_registered(object $pdo, string $email){
    return email_isregistered($pdo, $email);
}

// Return True if the user's date of birth cannot be parsed into a unix timestamp
function dob_is_non_date($dob){
    return !strtotime($dob);
}

// Return True if password is fewer than 8 characters long
function password_is_too_short($pwd){
    return strlen($pwd) < 8;
}
// Return True if password does not match the confirm password
function are_passwords_different($pwd, $confirm_pwd){
    return $pwd !== $confirm_pwd;
}

// Return true if the user does not give consent for us to store their data
function consent_withheld($consent){
    return !$consent;
}

// Return an associative array containing errors found with entered data
function validate_signup($pdo, $fname, $surname, $email, $pwd, $confirm_pwd, $consent){
    // Stores all errors found with user's inputs
    $errors = [];

    // Stores and returns all errors in the errors associative array
    if (is_input_empty($fname, $surname, $email, $pwd, $confirm_pwd)) {
        $errors["empty_input"] = "Fill in all the fields!";
    }

    // Check if entered email is valid
    if (is_email_invalid($email)) {
        $errors["email"] = "Invalid email";
    }

    // Check if entered email is already registered
    if (is_email_registered($pdo, $email)) {
        $errors["email_used"] = "Email already registered";
    }

    // Check if entered password is too short
    if (password_is_too_short($pwd)){
        $errors["short_pwd"] = "Password must be 8 characters or longer";
    }
    
    // Check if password and confirm password don't match
    if (are_passwords_different($pwd, $confirm_pwd)){
        $errors["no_match"] = "Passwords don't match";
    }

    // Check if user gave or withheld their consent
    if (consent_withheld($consent)){
        $errors["consent"] = "You must give consent to make an account";
    }

    return $errors;
}

// Create a new entry in the users table
function create_user(object $pdo, string $fname, string $surname, string $email, string $pwd){
    set_user($pdo, $fname, $surname, $email, $pwd);
}
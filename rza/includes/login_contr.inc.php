<?php
// This file handles data validation

declare(strict_types= 1);

// Return True if any inputs are empty
function is_input_empty(string $email, string $pwd){
    // If either argument is empty...
    if (empty($email) || empty($pwd)) {
        return true;
    } else{
        return false;
    }
}

// Return True is the entered email is wrong
function is_email_wrong(bool|array $user){
    // If the SQL query looking for the user returns false...
    if (!$user){
        return true;
    } else{
        return false;
    }
}

// Return True if the password doesn't match the hashed password
function is_password_wrong(string $pwd, string $hashpwd){
    // If the hashed version of entered password does not match hash stored in database...
    if (!password_verify($pwd, $hashpwd)){
        return true;
    } else{
        return false;
    }
}

// Check for errors in user's login attempt
function validate_login(object $pdo, string $email, string $pwd){
    // Store all found errors in associative array $errors
    $errors = [];
    
    // Check if the user entered any empty inputs
    if (is_input_empty($email, $pwd)) {
        $errors["empty_input"] = "Fill in all the fields!";
    }

    // Attempt to get the user from the database
    $user_by_email = get_user_by_email($pdo, $email);

    // Check if the user entered an invalid email
    if(is_email_wrong($user_by_email)){
        $errors["login_incorrect"] = "Incorrect login info.";
    }
    
    // Check if the user entered the wrong password for the email
    if(!is_email_wrong($user_by_email) && is_password_wrong($pwd, $user_by_email["password"])){
        $errors["login_incorrect"] = "Incorrect login info.";
    }
    
    // Return an associative array of errors
    return $errors;
}
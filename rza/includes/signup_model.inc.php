<?php

declare(strict_types= 1);

// Return True if an email is already registered
function email_isregistered($pdo, $email){

    // Define query and placeholders
    $query = "SELECT email FROM users WHERE email = :email;";

    // Treat all placeholders as data
    $stmt = $pdo->prepare($query);

    // Bind placeholders to variables
    $stmt->bindParam(":email", $email);

    // Execute the query
    $stmt->execute();

    // Store the result in $result as an associative array
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

// Create a new entry in the users table with the entered information
function set_user(object $pdo, string $fname, string $surname, string $email, string $pwd) {
    $query = "INSERT INTO users (first_name, surname, email, password) VALUES (:fname, :surname, :email, :pwd)";

    // Ensure that all inputs are treated as data- prevents SQL injections
    $stmt = $pdo->prepare($query);

    // Determine the intensity of password hashing
    $options = [
        "cost" => 12
    ];

    // Hash user's password before storage so no one can read it
    $hashpwd = password_hash($pwd, PASSWORD_DEFAULT, $options);

    // Bind each of the user's datapoints to their respective field
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":surname", $surname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pwd", $hashpwd);

    // Execute the query
    $stmt->execute();
}
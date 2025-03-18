<?php
// This file handles SQL queries

declare(strict_types= 1);

function get_user_by_email(object $pdo, string $email){
    // The colon before a value indicates a placeholder
    $query = "SELECT * FROM users WHERE email = :email;";

    // Makes sure all inputs are treated as data rather than code
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    // Stores the result in an associative array
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result;
}

// Returns the running spend attribute associated with the entered user's id
function get_user_running_spend(object $pdo, string $user_id){
    // The colon before a value indicates a placeholder
    $query = "SELECT running_spend FROM users WHERE user_id = :user_id;";

    // Makes sure all inputs are treated as data rather than code
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();

    // Stores the result in an associative array
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result['running_spend'];
}


// Uses an user's id to update their running spend
function update_spend(object $pdo, string $user_id, string|float $prev_spend, string|float $new_spend){
    $query = "UPDATE Users SET running_spend = :running_spend
        WHERE user_id = :user_id";

    // Add new spend to running spend
    $running_spend = intval($prev_spend) + intval($new_spend);

    // Ensure all placeholders are treated as data rather than code
    $stmt = $pdo -> prepare($query);

    // Attach variables to their palceholders
    $stmt->bindParam(':running_spend', $running_spend);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Update information in the table
    $stmt -> execute();
}
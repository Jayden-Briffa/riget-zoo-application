<?php
// Handles data validation

declare(strict_types= 1);

// Return True if any inputs are empty
function zoo_is_input_empty(string $adult_tickets, string $child_tickets, string $date){
    if (empty($date) || $adult_tickets === "" || $child_tickets === ""){
        return true;
    } else {
        return false;
    }
}


// Return True if the entered date cannot be parsed into a unix timestamp
function zoo_date_is_non_date(string $date){
    return !strtotime($date);
}

// Return True  if the entered date is passed current unix timestamp
function zoo_date_is_passed(string $date){
    $dateTimestamp = strtotime($date);
    $currentTimestamp = time();

    if ($dateTimestamp < $currentTimestamp){
        return true;
    } else{
        return false;
    }
}

// Returns True if the input is not an integer
function zoo_not_positive_int(string $num){
    $filtered_num = filter_var($num, FILTER_VALIDATE_INT);
    if ($filtered_num === false){
        return true;
    };
    
    if ($filtered_num < 0){
        return true;
    } else {
        return false;
    }
}

// Returns True if the number of tickets in the order is 0
function zoo_order_is_empty(string $adult, string $child){
    $total = intval($adult) + intval($child);

    if ($total <= 0){
        return true;
    } else {
        return false;
    }
}

// Add a record to the Zoo_Bookings table in the database
function zoo_create_booking(object $pdo, string $user_id, string $adult_tickets, string $child_tickets, string $date){

    // Get the user's running spend
    $user_spend = get_user_running_spend($pdo, $user_id);
     
    // If the user has spent at least £150, their order is free and their running spend is reset
    if (intval($user_spend) >= 150){
        $total_cost = 0;

        zoo_reset_spend($pdo, $user_id);

    } else {

        // Calculate cost of booking
        $costs = [
            "adult" => 15,
            "child" => 10
        ];

        // Calculate cost of adult and child tickets
        $adult_cost = $costs['adult'] * intval($adult_tickets);
        $child_cost = $costs['child'] * intval($child_tickets);

        // Calculate total cost of order
        $total_cost = $adult_cost + $child_cost;

        // Update user's running spend
        update_spend($pdo, $user_id, $user_spend, $total_cost);
    }

    // Create the user's booking
    zoo_insert_booking($pdo, $user_id, $adult_tickets, $child_tickets, $total_cost, $date);
}

// Delete zoo booking with the given id
function zoo_remove_booking($pdo, $zoo_booking_id){
    zoo_delete_booking($pdo, $zoo_booking_id);
}

// Return an associative array of errors and their messages
// Ticket values are optional in case the user wants to change the visit date
function zoo_validate_booking(string $date, string $adult_tickets = "1", string $child_tickets = "1"){

    // Store all found errors in an array $errors
    $errors = [];

    // Check for empty inputs
    if (zoo_is_input_empty($adult_tickets, $child_tickets, $date)){
        $errors["empty_input"] = "Fill in all fields";
    }

    // Check for invalid date
    if (zoo_date_is_non_date($date)){
        $errors["date_invalid"] = "The entered date must be a valid date";
    }

    if (zoo_date_is_passed($date)){
        $errors["date_passed"] = "The entered date must be for after today";
    }

    // Check if adult tickets is invalid
    if (zoo_not_positive_int($adult_tickets)){
        $errors["adult_tickets"] = "Adult tickets must be a positive whole number";
    }

    // Check if child tickets is invalid
    if (zoo_not_positive_int($child_tickets)){
        $errors["child_tickets"] = "Child tickets must be a positive whole number";
    }

    // Check if order has no tickets
    if (zoo_order_is_empty($adult_tickets,  $child_tickets)){
        $errors["order_empty"] = "You must have at least 1 ticket in the order";
    }

    // Return all errors
    return $errors;
}
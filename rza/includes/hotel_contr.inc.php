<?php
// Handles data validation

declare(strict_types= 1);

// Return True if any inputs are empty
function hotel_is_input_empty(string $start_date, string|null $num_nights, string|null $end_date = "01/01/2025"){
    if (empty($start_date) || $num_nights === "" || $end_date === ""){
        return true;
    } else {
        return false;
    }
}


// Return True if the record's date cannot be parsed into a unix timestamp
function hotel_date_is_non_date($date){
    return !strtotime($date);
}


// Return True  if the entered date is passed current unix timestamp
function hotel_date_is_passed(string $date){
    $dateTimestamp = strtotime($date);
    $currentTimestamp = time();

    if ($dateTimestamp < $currentTimestamp){
        return true;
    } else{
        return false;
    }
}



// Give an error if any selected dates are fully booked
function hotel_date_is_unavailable(object $pdo, string $start_date, string $end_date){

    // Get availability data for the selected date range
    $availability = hotel_get_booking_availability($pdo, $start_date, $end_date);

    // Check each date's availability
    foreach ($availability as $night_date){

        // If any date is unavailable, give an error
        if ($night_date['available'] === "NO"){
           return true;
        } else {
            return false;
        }
    }
}

// Returns True if the input is not an integer of value 1 or greater
function hotel_not_int_above_0(string $num){
    $filtered_num = filter_var($num, FILTER_VALIDATE_INT);

    // If it isn't an integer
    if ($filtered_num === false){
        return true;
    };
    
    // If it isn't greater than 0
    if ($filtered_num < 1){
        return true;
    }
    
    return false;
   
}

// Add a record to the Hotel_Bookings table in the database
function hotel_create_booking(object $pdo, string $user_id, string $num_nights, string $date){
    require 'login_model.inc.php';

    // Get the user's running spend
    $user_spend = get_user_running_spend($pdo, $user_id);

    // Calculate cost of booking
    $costs = [
        "night" => 20
    ];

    // Calculate cost of n number of nights stayed
    $total_cost = $costs['night'] * intval($num_nights);

    // Update user's running spend
    update_spend($pdo, $user_id, $user_spend, $total_cost);

    // Create overall hotel booking
    hotel_insert_booking($pdo, $user_id, $total_cost, $date);

    // Get the id of the newly-created hotel booking and the unix timestamp of its date
    $last_id = hotel_get_last_booking_id($pdo);
    $booking_unix = strtotime($date);

    // Repeat for a number of times equal to $num_nights
    for ($i = 0; $i < $num_nights; $i++){
        // Add 24 hours in each iteration, then convert it to a date
        $night_date = date("Y-m-d", $booking_unix + $i * 86400);
        hotel_insert_night($pdo, $last_id, $night_date);
    }
}

// Remove all data from the database associated with the given hotel_booking_id
function hotel_remove_booking($pdo, $hotel_booking_id){
    // Delete sub bookings
    hotel_delete_nights($pdo, $hotel_booking_id);

    // Delete parent booking
    hotel_delete_booking($pdo, $hotel_booking_id);
}

// Return an associative array of errors and their messages
// Nights values is optional in case the user wants to change the visit date
function hotel_validate_booking(string $start_date, string $num_nights = "1", object $pdo = null){

    // Store all found errors in an array $errors
    $errors = [];

    // Check for empty inputs
    if (hotel_is_input_empty($start_date, $num_nights)){
        $errors["empty_input"] = "Fill in all fields";
    }

    // Check for invalid date
    if (hotel_date_is_non_date($start_date)){
        $errors["date_invalid"] = "The entered date must be a valid date";
    }

    // Check for invalid date
    if (hotel_date_is_passed($start_date)){
        $errors["date_passed"] = "The entered date must be for after today";
    }

    // Check for invalid nights
    if (hotel_not_int_above_0($num_nights)){
        $errors['num_nights'] = "The number of nights must be a whole number of 1 or more";
    }

    
    // If no issues were found with the number of nights or the start date's validity, check the availability
    if (!isset($errors["num_nights"]) && !isset($errors["date_invalid"])){

        // Find the end date from the start date and $num_nights
        $end_date = date("Y-m-d", strtotime($start_date) + $num_nights * 86400);

        // Give an error if any selected dates are fully booked
        if (hotel_date_is_unavailable($pdo, $start_date, $end_date)){
            $errors["unavailable"] = "One or more of the dates you wish to stay on are fully booked";
        }
    }

    // Return all errors
    return $errors;
}

// Return an associative array of errors and their messages
function hotel_validate_booking_availability(string $start_date, string|null $end_date, string|null $num_nights){

    // Store all found errors in an array $errors
    $errors = [];

    // Check for empty inputs
    if (hotel_is_input_empty($start_date, $num_nights, $end_date)){
        $errors["empty_input"] = "Fill in all fields";
    }

    // If there is a set end date, check it
    if($end_date !== null){
        
        // Check for invalid end date
        if (hotel_date_is_non_date($end_date)){
            $errors["end_invalid"] = "The end date must be a valid date";
        }

    // If there is no set end date, check num_nights
    } else {

        // Check for invalid nights
        if (hotel_not_int_above_0($num_nights)){
            $errors['num_nights'] = "The number of nights must be a whole number of 1 or more";
        }
    }

    // Check for invalid date
    if (hotel_date_is_passed($start_date)){
        $errors["start_passed"] = "The start date must be for after today";
    }

    // Return all errors
    return $errors;
}
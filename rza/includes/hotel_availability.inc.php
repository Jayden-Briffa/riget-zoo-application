<?php

require_once "config_session.inc.php";

// Sends the user back to index if they didn't use the form and are signed in
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])){

    // Store each of the form inputs in corresponding variables
    $start_date = $_POST["stay-date"] ?? $_POST["start-date"];
    $num_nights = $_POST["num-nights"] ?? null;
    $end_date = $_POST["end-date"] ?? null;

    // Pulls the user's id from the session ID
    $user_id = $_SESSION["user_id"];

    try{
        require_once "dbh.inc.php";
        require_once "hotel_model.inc.php";
        require_once "hotel_contr.inc.php";

        // Will store all errors that occur in an associative array
        $errors = hotel_validate_booking_availability($start_date, $end_date, $num_nights);

        // If there is no end date explicitely defined, calculate it using the current unix timestamp and $num_nights
        if (!isset($errors['num_nights']) && $end_date === null){
            // Get current unix timestamp, get timestamp of the end date, translate that timestamp into an end date
            $start_unix = strtotime($start_date); 
            $end_unix = $start_unix + (intval($num_nights) - 1) * 86400;
            $end_date = date("Y-m-d", $end_unix);
        }

        // Store the data entered by user to fill form in with automatically
        $booking_data = [
            "start_date" => $start_date,
            "num_nights" => $num_nights,
            "end_date" => $end_date
        ];

        // Store data in the session whether there are errors or not
        $_SESSION["hotel_booking_data"] = $booking_data;

        // If there are any errors, send the user back to...
        //hotel_availability.php and display the errors
        if ($errors){

            $_SESSION["hotel_errors_booking"] = $errors;
            $_SESSION['availability'] = null;

            // Send the user back to hotel_availability.php with an error message and end current script
            header("Location: ../hotel_availability.php?availability-found=false");
            die();
        }

        // Get the number of bookings in each day
        $availability = hotel_get_booking_availability($pdo, $start_date, $end_date);

        // Store booking numbers in SESSION
        $_SESSION['availability'] = $availability;

        // Kill connection to the database and free resources
        $pdo = null;
        $stmt = null;

        // Send user back to hotel_availability page with success message and end current script
        header("Location: ../hotel_availability.php?availability-found=true");
        die();

    } catch (PDOException $e){
        // End current script and show error message
        die("Query failed: " . $e->getMessage());
    }
    
} else{

    // Send the user back to account page with error message
    header("Location: ../account.php?redirected=true");
}

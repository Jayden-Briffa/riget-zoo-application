<?php

require_once "config_session.inc.php";

// Sends the user back to index if they didn't use the form and are signed in
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])){

    // Store each of the form inputs in corresponding variables
    $num_nights = $_POST["num-nights"];
    $date = $_POST["stay-date"];

    // Pulls the user's id from the session ID
    $user_id = $_SESSION["user_id"];

    try{
        require_once "dbh.inc.php";
        require_once "hotel_model.inc.php";
        require_once "hotel_contr.inc.php";

        // Will store all errors that occur in an associative array
        $errors = hotel_validate_booking($date, $num_nights, $pdo);

        // If there are any errors, send the user back to...
        //hotel_bookings.php and display the errors
        if ($errors){
            $_SESSION["hotel_errors_booking"] = $errors;

            // Store the data entered by user to fill form in with automatically
            $booking_data = [
                "num_nights" => $num_nights,
                "stay_date" => $date
            ];

            $_SESSION["hotel_booking_data"] = $booking_data;

            // Send the user back to hotel_bookings.php with an error message and end current script
            header("Location: ../hotel_bookings.php?hotel-new-booking=fail#booking-errors");
            die();
        }

        // Add the booking to the database
        hotel_create_booking($pdo, $user_id, $num_nights, $date);

        // Kill connection to the database and free resources
        $pdo = null;
        $stmt = null;

        // Send user back to hotel_bookings page with success message and end current script
        header("Location: ../hotel_bookings.php?hotel-new-booking=success");
        die();

    } catch (PDOException $e){
        // End current script and show error message
        die("Query failed: " . $e->getMessage());
    }
    
} else{

    // Send the user back to account page with error message
    header("Location: ../acount.php?redirected=true");
}

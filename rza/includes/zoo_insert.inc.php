<?php

require_once "config_session.inc.php";

// Sends the user back to index if they didn't use the form and are signed in
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])){

    // Store each of the form inputs in corresponding variables
    $date = $_POST["visit-date"];
    $adult_tickets = $_POST["adult-tickets"];
    $child_tickets = $_POST["child-tickets"];

    // Pulls the user's id from the session ID
    $user_id = $_SESSION["user_id"];
    
    try{
        require_once "dbh.inc.php";
        require_once "zoo_model.inc.php";
        require_once "zoo_contr.inc.php";
        require_once "login_model.inc.php";
        
        // Will store all errors that occur in an associative array
        $errors = zoo_validate_booking($date, $adult_tickets, $child_tickets);

        // If there are any errors, send the user back to...
        //zoo_bookings.php and display the errors
        if ($errors){

            $_SESSION["zoo_errors_booking"] = $errors;
 
            // Store the data entered by user to fill form in with automatically
            $booking_data = [
                "visit_date" => $date,
                "adult_tickets" => $adult_tickets,
                "child_tickets" => $child_tickets
            ];

            $_SESSION["zoo_booking_data"] = $booking_data;

            // Send the user back to zoo_bookings.php with an error message and end current script
            header("Location: ../zoo_bookings.php?zoo-new-booking=fail#booking-errors");
            die();
        }

        // Add the booking to the database
        zoo_create_booking($pdo, $user_id, $adult_tickets, $child_tickets, $date);

        // Kill connection to the database and free resources
        $pdo = null;
        $stmt = null;

        // Send user back to zoo_bookings page with success message and end current script
        header("Location: ../zoo_bookings.php?zoo-new-booking=success");
        die();

    } catch (PDOException $e){
        // End current script and show error message
        die("Query failed: " . $e->getMessage());
    }
    
} else{

    // Send the user back to account page with error message
    header("Location: ../account.php?redirected=true");
}

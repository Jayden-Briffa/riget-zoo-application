<?php

require_once "config_session.inc.php";

// If the user is signed in and accessed the page through a form...
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["user_id"])){

    // Stores each of the form inputs in corresponding variables
    $booking_id = $_POST["hotel-booking-id"];

    try{
        require_once "dbh.inc.php";
        require_once "hotel_model.inc.php";
        require_once "hotel_contr.inc.php";

        // Delete the booking and kill the database connection...
        //then send the user back to the hotel bookings page
        hotel_remove_booking($pdo, intval($booking_id));

        // Send the user back to the hotel bookings page with success message
        header("Location: ../account.php?hotel-delete=success#user-hotel-bookings");

        // Kill connection to the database and end current script
        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $e){

        // End current script and show error on screen
        die("Query failed: " . $e->getMessage());
    }

// Send the use back to the login page if they weren't signed in
} else{
    header("Location: ../account.php?redirected=true");
}


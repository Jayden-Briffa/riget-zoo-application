<?php

require_once "config_session.inc.php";

// If the user is signed in and accessed the page through a form...
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["user_id"])){

    // Stores each of the form inputs in corresponding variables
    $zoo_booking_id = $_POST["zoo-booking-id"];

    try{
        require_once "dbh.inc.php";
        require_once "zoo_model.inc.php";  
        require_once "zoo_contr.inc.php";  

        // Delete the booking and the database connection...
        //then send the user back to the zoo bookings page
        zoo_remove_booking($pdo, intval($zoo_booking_id));

        // Send the user back to the zoo bookings page with success message
        header("Location: ../account.php?zoo-delete=success");

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


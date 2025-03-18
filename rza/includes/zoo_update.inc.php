<?php 

require_once "config_session.inc.php";

// Sends the user back to login if they didn't use the form or aren't signed in
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])){

    // Store each of the form inputs in corresponding variables
    $visit_date = $_POST["visit-date"];

    try{
        // Establish database connection and import zoo functions
        require_once "dbh.inc.php";
        require_once "zoo_model.inc.php";
        require_once "zoo_contr.inc.php";

        // Store id of booking to be updated
        $zoo_booking_id = $_POST["zoo-booking-id"];

        // Pass all inputs through error checks and store found errors in $errors
        $errors = zoo_validate_booking($visit_date);

        // If there are errors, send the user back and display error messages
        if ($errors){
            $_SESSION["zoo_errors_booking"] = $errors;

            // Send the user back to zoo bookings page and show failure message
            header("Location: ../account.php?zoo-update=fail#user-zoo-bookings");

            // End current script
            die();
        }


        // Change the data stored in bookings to reflect the new data
        zoo_update_booking($pdo, $zoo_booking_id, $visit_date);
        
        // Send the user back to their zoo bookings page and end current script
        header("Location: ../account.php?zoo-update=success#user-zoo-bookings");
        die();

    } catch (PDOException $e) {

        // If there is an error, end current script, and show the error
        die("Query failed: " . $e->getMessage());
    }

} else {
    // Send the user to the login page with failure message
    header("Location: ../account.php?redirected=true");
}
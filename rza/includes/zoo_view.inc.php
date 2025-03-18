<?php
// This file handles data output for zoo bookings

declare(strict_types=1);

// Checks for and prints all errors associated with zoo bookings
function check_zoo_booking_errors() {
    
    // If there are errors...
    if (isset($_SESSION["zoo_errors_booking"])){
    
        // Start the string with a line break
        $errStr = "<br>";
    
        $errors = $_SESSION["zoo_errors_booking"];

        // If any errors are present, append them to $errStr
        foreach ($errors as $error) {
            // Append error string with the error in a <p> tag
            $errStr .= "<p>". $error ."</p>";
        }

        // Remove all errors from session
        unset($_SESSION["zoo_errors_booking"]);

        return $errStr;

    // If there is no error variable in $_SESSION...
    } else {
        return false;
    }
}

// Display all zoo bookings associated with the entered user id
function show_zoo_bookings($pdo, $user_id){
    include "zoo_model.inc.php";

    $user_bookings = zoo_search_bookings_by_user($pdo, $user_id);
    ?>

    <section class="d-flex flex-column text-center p-4">

        <?php if ($user_bookings) { ?>
        <div class="row">
            <p class="col">Adults</p>
            <p class="col">Children</p>
            <p class="col">Cost</p>
            <p class="col">Date</p>
            <p class="col d-none d-md-block">Options</p>
        </div>

        <div class="d-flex flex-column gap-3">
            <?php 
            foreach ($user_bookings as $booking){
                $zoo_booking_id = $booking['zoo_booking_id'];
                $adult_tickets = $booking['adult_tickets'];
                $child_tickets = $booking['child_tickets'];
                $total_cost = $booking['total_cost'];
                $visit_date = $booking['visit_date'];
                
                include "./templates/zoo_booking.php";
            }

        } else { ?>
        </div>
            <p>No bookings found</p>
        <?php } ?>
    </section>

<?php }

// Show a success message if booking was deleted
function alert_zoo_booking_delete_success(){
    if (isset($_GET["zoo-delete"]) && $_GET["zoo-delete"] === "success"){ 
    
        $alert_type = "success";
        $alert_text = "Booking successfully deleted";
        include "templates/alert.php";
    }
}

// Show an error message if booking could not be deleted
function alert_zoo_booking_delete_fail(){
    if (isset($_GET["zoo-delete"]) && $_GET["zoo-delete"] === "fail"){ 
    
        $alert_type = "danger";
        $alert_text = "Booking could not be deleted";
        include "templates/alert.php";
    
    }
}

// Show a success message if the booking was updated
function alert_zoo_booking_update_success() {
    if (isset($_GET["zoo-update"]) && $_GET["zoo-update"] === "success") {
        $alert_type = "success";
        $alert_text = "Booking successfully updated";
        include "templates/alert.php";
    }
}

// Show an error message if the booking update failed
function alert_zoo_booking_update_fail() {
    if (isset($_GET["zoo-update"]) && $_GET["zoo-update"] === "fail") {
        $alert_type = "danger";
        $alert_text = "Booking could not be updated";
        include "templates/alert.php";
    }
}

// Show a success message if the new booking was added
function alert_zoo_booking_add_success() {
    if (isset($_GET["zoo-new-booking"]) && $_GET["zoo-new-booking"] === "success") {
        $alert_type = "success";
        $alert_text = "Booking successfully added";
        include "templates/alert.php";
    }
}

// Show an error message if the new booking addition failed
function alert_zoo_booking_add_fail() {
    if (isset($_GET["zoo-new-booking"]) && $_GET["zoo-new-booking"] === "fail") {
        $alert_type = "danger";
        $alert_text = "Booking could not be added";
        include "templates/alert.php";
    }
}

// Call all alert functions to check for and display alerts
function display_all_zoo_alerts() {
    // Call each alert function in sequence
    alert_zoo_booking_delete_success();
    alert_zoo_booking_delete_fail();
    alert_zoo_booking_update_success();
    alert_zoo_booking_update_fail();
    alert_zoo_booking_add_success();
    alert_zoo_booking_add_fail();
}
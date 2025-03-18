<?php
// This file handles data output for zoo bookings

declare(strict_types=1);

// Checks for and prints all errors associated with zoo bookings
function check_hotel_booking_errors() {
    
    // If there are errors...
    if (isset($_SESSION["hotel_errors_booking"])){
    
        // Start the string with a line break
        $errStr = "<br>";
    
        $errors = $_SESSION["hotel_errors_booking"];

        // If any errors are present, append them to $errStr
        foreach ($errors as $error) {
            // Append error string with the error in a <p> tag
            $errStr .= "<p>". $error ."</p>";
        }

        // Remove all errors from session
        unset($_SESSION["hotel_errors_booking"]);

        return $errStr;

    // If there is no error variable in $_SESSION...
    } else {
        return false;
    }
}

// Displays all hotel bookings associated wit the given user id
function show_hotel_bookings($pdo, $user_id){
    include "hotel_model.inc.php";

    $user_bookings = hotel_search_bookings_by_user($pdo, $user_id);
    ?>

    <section class="d-flex flex-column text-center p-4">

    <?php if ($user_bookings) { ?>
        <div class="row">
            <p class="col">Date</p>
            <p class="col">Nights</p>
            <p class="col d-none d-md-block">Options</p>
        </div>

        <div class="d-flex flex-column gap-3">
            <?php
            foreach ($user_bookings as $booking){
                $hotel_booking_id = $booking['hotel_booking_id'];
                $first_night = $booking['stay_date'];
                $num_nights = hotel_get_num_nights($pdo, $hotel_booking_id);
                
                include "./templates/hotel_booking.php";
            }

        } else {?>
            <p>No booking data found</p>
        <?php } ?>
        </div>
        
    </section>

<?php }

// Show a success message if booking was deleted
function alert_hotel_delete_success(){
    if (isset($_GET["hotel-delete"]) && $_GET["hotel-delete"] === "success"){ 
    
        $alert_type = "success";
        $alert_text = "Booking successfully deleted";
        include "templates/alert.php";
    }
}

// Show an error message if booking could not be deleted
function alert_hotel_delete_fail(){
    if (isset($_GET["hotel-delete"]) && $_GET["hotel-delete"] === "fail"){ 
    
        $alert_type = "danger";
        $alert_text = "Booking could not be deleted";
        include "templates/alert.php";
    
    }
}

// Show a success message if the booking was updated
function alert_hotel_update_success() {
    if (isset($_GET["hotel-update"]) && $_GET["hotel-update"] === "success") {
        $alert_type = "success";
        $alert_text = "Booking successfully updated";
        include "templates/alert.php";
    }
}

// Show an error message if the booking update failed
function alert_hotel_update_fail() {
    if (isset($_GET["hotel-update"]) && $_GET["hotel-update"] === "fail") {
        $alert_type = "danger";
        $alert_text = "Booking could not be updated";
        include "templates/alert.php";
    }
}

// Show a success message if the new booking was added
function alert_hotel_add_success() {
    if (isset($_GET["hotel-new-booking"]) && $_GET["hotel-new-booking"] === "success") {
        $alert_type = "success";
        $alert_text = "Booking successfully added";
        include "templates/alert.php";
    }
}

// Show an error message if the new booking addition failed
function alert_hotel_add_fail() {
    if (isset($_GET["hotel-new-booking"]) && $_GET["hotel-new-booking"] === "fail") {
        $alert_type = "danger";
        $alert_text = "Booking could not be added";
        include "templates/alert.php";
    }
}

// Call all alert functions to check for and display alerts
function display_all_hotel_alerts() {
    // Call each alert function in sequence
    alert_hotel_delete_success();
    alert_hotel_delete_fail();
    alert_hotel_update_success();
    alert_hotel_update_fail();
    alert_hotel_add_success();
    alert_hotel_add_fail();
}
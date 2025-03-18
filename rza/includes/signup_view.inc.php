<?php

declare(strict_types= 1);

// Return HTML detailing any errors that occurred
// Return false if there are none
function check_signup_errors(){
    
    // If there are errors...
    if (isset($_SESSION["errors_signup"])){
        
        // Start the string with a line break
        $errStr = "<br>";
    
        $errors = $_SESSION["errors_signup"];

        // If any errors are present, append them to $errStr
        foreach ($errors as $error) {
            // Append error string with the error in a <p> tag
            $errStr .= "<p>". $error ."</p>";
        }

        // Remove all errors from session
        unset($_SESSION["errors_signup"]);

        return $errStr;
    
    // If there is no error variable in $_SESSION...
    } else {
        return false;
    }
}

// Show a success message if the account was successfully created
function alert_signup_success() {
    if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        $alert_type = "success";
        $alert_text = "Account successfully created";
        include "templates/alert.php";
    }
}

// Show an error message if account creation failed
function alert_signup_fail() {
    if (isset($_GET["signup"]) && $_GET["signup"] === "fail") {
        $alert_type = "danger";
        $alert_text = "Could not create your account";
        include "templates/alert.php";
    }
}

// Show an alert if the user was redirected because they need to sign in
function alert_redirect() {
    if (isset($_GET["redirected"]) && $_GET["redirected"] === "true") {
        $alert_type = "danger";
        $alert_text = "You need to sign in to an account";
        include "templates/alert.php";
    }
}

function display_all_signup_alerts() {
    alert_signup_success();
    alert_signup_fail();
    alert_redirect();
}

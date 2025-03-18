<?php
// This file handles data output for login

declare(strict_types=1);

// Output a string of all login errors
function check_login_errors(){
    
    // If there are errors...
    if (isset($_SESSION["errors_login"])){
        
        // Start the string with a line break
        $errStr = "<br>";
    
        $errors = $_SESSION["errors_login"];

        // If any errors are present, append them to $errStr
        foreach ($errors as $error) {
           $errStr .= "<p>". $error ."</p>";
        }

        // Remove all errors from session
        unset($_SESSION["errors_login"]);

        return $errStr;

    // If there is no error variable in $_SESSION...
    } else {
        return false;
    }
}

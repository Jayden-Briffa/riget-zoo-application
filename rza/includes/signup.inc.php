<?php

// Only happens if the page is accessed with POST
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Sets variables based on the name attributes of inputs
    $fname = $_POST["fname"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $pwd = $_POST["password"];
    $confirm_pwd = $_POST["confirmPassword"];
    $consent = $_POST["consentGiven"];

    try{
        require_once "dbh.inc.php";
        require_once "signup_model.inc.php";
        require_once "signup_contr.inc.php";

        // Stores all errors found with user's inputs
        $errors = validate_signup($pdo, $fname, $surname, $email, $pwd, $confirm_pwd, $consent);

        // Reconfigure the user's session
        require_once "config_session.inc.php";

        // If the errors array contains any elements
        if($errors){

            // Stores all errors in the session superglobal
            $_SESSION["errors_signup"] = $errors;

            // Store the user's entered data to fill form with automatically
            $signup_data = [
                "fname" => $fname,
                "surname" => $surname,
                "email" => $email,
            ];

            $_SESSION["signup_data"] = $signup_data;

            // Send the user back to the account page with an error message and end current script
            header("Location: ../account.php?signup=fail#signup-errors");
            die();
        }


        // Enters their information and gives a success message
        create_user($pdo,  $fname, $surname, $email, $pwd);
        header("Location: ../account.php?signup=success");
        
        // Kill the connection to the database
        $pdo = null;
        $stmt = null;

        // End current script
        die();

    } catch (PDOException $e) {

        // Ends the connection and gives an error message if an error occurs
        die("Query failed: " . $e->getMessage());
    }

} else{

    // Send the user back to the login page with an error message and end current script
    header("Location: ../account.php?redirect=true");
    die();
}

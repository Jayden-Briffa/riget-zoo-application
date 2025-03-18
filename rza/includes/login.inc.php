<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    // Store each input from the form in corresponding variables
    $email = $_POST['email'];
    $pwd = $_POST['password'];
    
    try{
        // Import all needed functions and connection to the database
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';
        
        // Stores all errors found with user's inputs
        $errors = validate_login($pdo, $email, $pwd);

        require_once "config_session.inc.php";

        if($errors){

            // Stores all errors in the session superglobal
            $_SESSION["errors_login"] = $errors;
            
            // Pass login information back to page through $_SESSION
            $login_data = [
                "email" => $email,
            ];

            $_SESSION["login_data"] = $login_data;

            // Send the user back to account page and kill connection to the database
            header("Location: ../account.php?login=fail#account-login");
            die();
        }

        // Get all data about the user by their email
        $user_by_email = get_user_by_email($pdo, $email);

        // Create a new session for a logged-in user
        regenerate_session_id_loggedin();

        // Decide which fields will be stored and used
        $_SESSION["user_id"] = htmlspecialchars($user_by_email["user_id"]);
        $_SESSION["user_first_name"] = htmlspecialchars($user_by_email["first_name"]);
        $_SESSION["user_email"] = htmlspecialchars($user_by_email["email"]);
        $_SESSION["last_regeneration"] = time();

        // Send the user back to account page with successful login message
        header("Location: ../account.php?login=success");
        $pdo = null;
        $stmt = null;

        die();

    } catch (PDOException $e) {
        die('Query failed: ' . $e->getMessage());
    }

} else{

    // If the post method was not used, send the user back to index.php
    header("Location: ../account.php");
    die();
}
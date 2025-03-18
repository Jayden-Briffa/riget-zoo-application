<?php

// Tell the program to only use cookies, making it more secure
ini_set("session.use_only_cookies", 1);
ini_set("session.use_strict_mode", 1);

// Set constraints on cookies
session_set_cookie_params([
    "lifetime" => 1800, // Lasts 30 minutes
    "domain"=> "localhost", // Applies on localhost domain
    "path"=> "/", // Applies on all files
    "secure"=> true, // Will only be sent over secure (https) connections
    "httponly"=> true, // Cookie can't be accessed by JS
]);

// Start the session
session_start();

$interval = 1800;

// If the user is logged in...
if (isset($_SESSION["user_id"])){
    // Restart the session every half-hour and every time they log in
    if (!isset($_SESSION["last_regeneration"])){
        regenerate_session_id_loggedin();
    } else {
        // If the difference between current time and time of last regen...
        //is above 1800, restart the session
        if(time() - $_SESSION["last_regeneration"] >= $interval){
            regenerate_session_id_loggedin();
        }

    }
    
// If the user hasn't made a session yet...
} else if (!isset($_SESSION["last_regeneration"])){
        regenerate_session_id();

} else {

    // If the difference between current time and time of last regen...
    //is above 1800, restart the session
    if(time() - $_SESSION["last_regeneration"] >= $interval){
        regenerate_session_id();
    }

}


// Used to regenerate session ID if the user is logged in
function regenerate_session_id_loggedin(){
    $userId = $_SESSION["user_id"];

    // Clear all $_SESSION variables and destroy current session
    session_unset();
    session_destroy();

    // Create a new session id and append with user's id
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userId;

    // Set the session id and start new session
    session_id($sessionId);
    session_start();

    // Keep track of when each session was generated in $_SESSION
    $_SESSION["last_regeneration"] = time(); 
    
}

// Used to regenerate session ID if the user is not logged in
function regenerate_session_id(){

    // Create a whole new session and delete the old one
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}
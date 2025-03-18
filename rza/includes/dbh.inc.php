<?php 

// Import this file to establish a database connection

$host = "localhost";
$dbname = "rza";
$dbusername = "root";
$dbpassword = "";

// Attempts to connect to the database
try {
    // Store database connection in $pdo
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);

    // Ensures that an error will be thrown if any issues arise
    $pdo->setAttribute(PDO::ATTR_ERRMODE,
     PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // End current script and display error message
    die("Connection failed: " . $e->getMessage());
}

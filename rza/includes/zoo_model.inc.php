<?php 
declare(strict_types= 1);

function zoo_insert_booking(object $pdo, string $user_id, string $adult_tickets, string $child_tickets, float $total_cost, string $date){
    
    // Select which columns to insert into
    $query = "INSERT INTO Zoo_Bookings (user_id, child_tickets, adult_tickets, total_cost, visit_date) VALUES (:user_id, :child_tickets, :adult_tickets, :total_cost, :visit_date);";

    // Binds each of the variables to their specific fields
    $stmt = $pdo->prepare($query);

    // Bind each placeholder to a variable
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":adult_tickets", $adult_tickets);
    $stmt->bindParam(":child_tickets", $child_tickets);
    $stmt->bindParam(":total_cost", $total_cost);
    $stmt->bindParam(":visit_date", $date);

    // Execute the query
    $stmt->execute();
}

// Get all zoo bookings associated with a user
function zoo_search_bookings_by_user(object $pdo, string|int $user_id){
    $query = "SELECT * FROM Zoo_Bookings WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);  

    $stmt->bindParam(":user_id", $user_id);

    $stmt->execute();

    // Gets and returns all data within $stmt
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}   

// Removes an booking from the database based on its id
function zoo_delete_booking(object $pdo, string|int $zoo_booking_id) {
    $query = "DELETE FROM Zoo_Bookings WHERE zoo_booking_id = :zoo_booking_id;";

    $stmt = $pdo -> prepare($query);

    // Binds each of the variables to their specific fields
    $stmt->bindParam(":zoo_booking_id", $zoo_booking_id);

    // No data needs to be returned for deleting
    $stmt->execute();
} 

// Uses an booking's id to update a single booking 
function zoo_update_booking(object $pdo, string|int $zoo_booking_id, string $visit_date){ 
    $query = "UPDATE Zoo_Bookings SET visit_date = :visit_date 
        WHERE zoo_booking_id = :zoo_booking_id"; 
 
    // Ensure all placeholders are treated as data rather than code 
    $stmt = $pdo -> prepare($query); 

    // Attach variables to their palceholders 
    $stmt->bindParam(':visit_date', $visit_date); 
    $stmt->bindParam(':zoo_booking_id', $zoo_booking_id, PDO::PARAM_INT); 
 
    // Update information in the table 
    $stmt -> execute(); 
}

// Uses an user's id to reset their running spend
function zoo_reset_spend(object $pdo, string|int $user_id){
    $query = "UPDATE Users SET running_spend = '0'
        WHERE user_id = :user_id";

    // Ensure all placeholders are treated as data rather than code
    $stmt = $pdo -> prepare($query);

    // Attach variables to their palceholders
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Update information in the table
    $stmt -> execute();
}
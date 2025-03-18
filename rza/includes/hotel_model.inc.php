<?php 
declare(strict_types= 1);

// Gets the id of the last booking made
function hotel_get_last_booking_id(object $pdo){
    // Select which columns to get
    $query = "SELECT hotel_booking_id FROM Hotel_Bookings";

    // Binds each of the variables to their specific fields
    $stmt = $pdo->prepare($query);

    $stmt -> execute();

    // Gets and returns all data within $stmt
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return end($results)['hotel_booking_id'];
}

function hotel_get_booking_availability(object $pdo, string $start_date, string $end_date){

    // Return dates and whether they are available 
    $query = "SELECT night_date, CASE WHEN COUNT(*) < :max_rooms THEN 'YES' ELSE 'NO' END AS available FROM Hotel_Nights WHERE night_date BETWEEN :start_date AND :end_date GROUP BY night_date";

    // Binds each of the variables to their specific fields
    $stmt = $pdo->prepare($query);

    // Bind each placeholder to a variable
    $stmt->bindValue(":max_rooms", 2);
    $stmt->bindParam(":start_date", $start_date);
    $stmt->bindParam(":end_date", $end_date);

    $stmt -> execute();

    // Gets and returns all data within $stmt
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

// Return the number of nights in a given hotel booking
function hotel_get_num_nights(object $pdo, string|int $hotel_booking_id){
    // Return dates and whether they are available 
    $query = "SELECT COUNT(*) AS count FROM Hotel_Nights WHERE hotel_booking_id=:id";

    // Binds each of the variables to their specific fields
    $stmt = $pdo->prepare($query);

    // Bind each placeholder to a variable
    $stmt->bindParam(":id", $hotel_booking_id);

    $stmt -> execute();

    // Gets and returns all data within $stmt
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results[0]['count'];
}

// Creates an individual night's stay
function hotel_insert_night(object $pdo, string|int $hotel_booking_id, $date){
    // Select which columns to insert into
    $query = "INSERT INTO Hotel_Nights (hotel_booking_id, night_date) VALUES (:hotel_booking_id, :date);";

    // Binds each of the variables to their specific fields
    $stmt = $pdo->prepare($query);

    // Bind each placeholder to a variable
    $stmt->bindParam(":hotel_booking_id", $hotel_booking_id);
    $stmt->bindParam(":date", $date);

    // Execute the query
    $stmt->execute();
}

// Creates a new hotel booking
function hotel_insert_booking(object $pdo, string $user_id, float $total_cost, string $date){
    
    // Select which columns to insert into
    $query = "INSERT INTO Hotel_Bookings (user_id, total_cost, stay_date) VALUES (:user_id, :total_cost, :date);";

    // Binds each of the variables to their specific fields
    $stmt = $pdo->prepare($query);

    // Bind each placeholder to a variable
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":total_cost", $total_cost);
    $stmt->bindParam(":date", $date);

    // Execute the query
    $stmt->execute();
}

function hotel_search_bookings_by_user(object $pdo, string $user_id){
    $query = "SELECT * FROM Hotel_Bookings WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);  

    $stmt->bindParam(":user_id", $user_id);

    $stmt->execute();

    // Gets and returns all data within $stmt
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}   

// Removes an booking from the database based on its id
function hotel_delete_booking(object $pdo, string|int $hotel_booking_id) {
    $query = "DELETE FROM Hotel_Bookings WHERE hotel_booking_id = :hotel_booking_id;";

    $stmt = $pdo -> prepare($query);

    // Binds each of the variables to their specific fields
    $stmt->bindParam(":hotel_booking_id", $hotel_booking_id);

    // No data needs to be returned for deleting
    $stmt->execute();
}

// Removes an booking from the database based on its id
function hotel_delete_nights(object $pdo, string|int $hotel_booking_id) {
    $query = "DELETE FROM Hotel_Nights WHERE hotel_booking_id = :hotel_booking_id;";

    $stmt = $pdo -> prepare($query);

    // Binds each of the variables to their specific fields
    $stmt->bindParam(":hotel_booking_id", $hotel_booking_id);

    // No data needs to be returned for deleting
    $stmt->execute();
}

// Uses an booking's id to update a single booking
function hotel_update_booking(object $pdo, string|int $hotel_booking_id, $date){
    $query = "UPDATE Hotel_Bookings SET date = :date
        WHERE hotel_booking_id = :hotel_booking_id";

    // Ensure all placeholders are treated as data rather than code
    $stmt = $pdo -> prepare($query);

    // Attach variables to their palceholders
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':hotel_booking_id', $hotel_booking_id, PDO::PARAM_INT);

    // Update information in the table
    $stmt -> execute();
}
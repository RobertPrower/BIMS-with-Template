<?php
require_once("connecttodb.php");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent via POST
    $residentId = $_POST['resident_id'];
    $firstName = $_POST['fname'];
    $middleName = $_POST['mname'];
    $lastName = $_POST['lname'];
    $houseno = $_POST['house_no'];
    $streetname = $_POST['street'];
    $subdivision = $_POST['subd'];
    $sex = $_POST['sex'];
    $maritalstatus = $_POST['marital_status'];
    $birthdate = $_POST['birth_date'];
    $birthplace = $_POST['birth_place']; 
    $phonenumber = $_POST['cp_number'];
    $isavoter = $_POST['is_a_voter'];
    
    try {
        // Prepare SQL statement for updating resident data
        $statement = $pdo->prepare("UPDATE resident SET first_name = ?, middle_name = ?, last_name = ?, house_number = ?, street_name = ?, subdivision = ?, sex = ?, marital_status = ?, birth_date = ?, birth_place = ?, cellphone_number = ?, is_a_voter = ? WHERE resident_id = ?");
        
        // Bind parameters and execute the statement
        $statement->execute([$firstName, $middleName, $lastName, $houseno, $streetname, $subdivision, $sex, $maritalstatus, $birthdate, $birthplace, $phonenumber, $isavoter, $residentId]);
        
        // Send success response
        echo json_encode(["success" => true, "message" => "Data updated successfully"]);

        
    } catch (PDOException $e) {
        // Handle database connection or query errors
        echo json_encode(["success" => false, "message" => "Error updating data: " . $e->getMessage()]);
    }
} else {
    // Send error response for invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>

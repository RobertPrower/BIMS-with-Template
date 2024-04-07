<?php
require_once("connecttodb.php");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent via POST
    $residentId = $_POST['resident_id'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $houseno = $_POST['houseno'];
    $streetname = $_POST['streetname'];
    $subdivision = $_POST['subd'];
    $sex = $_POST['sex'];
    $maritalstatus = $_POST['maritalstatus'];
    $birthdate = $_POST['birthdate'];
    $birthplace = $_POST['birthplace']; 
    $phonenumber = $_POST['cpnumber'];
    $isavoter = $_POST['isavoter'];

    try {
        // Prepare SQL statement
        $statement = $pdo->prepare("INSERT INTO resident (resident_id, first_name, middle_name, last_name, house_number, street_name, subdivision, sex, marital_status, birth_date, birth_place, cellphone_number, is_a_voter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Bind parameters and execute the statement
        $statement->execute([$residentId, $firstName, $middleName, $lastName, $houseno, $streetname, $subdivision, $sex, $maritalstatus, $birthdate, $birthplace, $phonenumber, $isavoter]);
        
        // Close the database connection
        $pdo = null;
        
        // Send success response
        echo json_encode(["success" => true, "message" => "Data saved successfully"]);
    } catch (PDOException $e) {
        // Handle database connection or query errors
        echo json_encode(["success" => false, "message" => "Error saving data: " . $e->getMessage()]);
    }
} else {
    // Send error response for invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>

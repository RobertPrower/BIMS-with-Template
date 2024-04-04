<?php
        
        require_once("connecttodb.php");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent via POST
    $residentId = $_POST['resident_id'];
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $lastName = $_POST['last_name'];
    $houseno = $_POST['house_no'];
    $streetname = $_POST['street_name'];
    $subdivision = $_POST['subd'];
    $sex = $_POST['sex'];
    $maritalstatus = $_POST['marital_status'];
    $birthdate = $_POST['birth_date'];
    $birthplace = $_POST['birth_place']; 
    $phonenumber = $_POST['phone_number'];
    $isavoter = $_POST['is_a_voter'];


    // Retrieve other data fields as needed

    
    try {
        // Prepare SQL statement
        $statement = $pdo->prepare("UPDATE resident SET first_name = ?, middle_name = ?, last_name = ?, house_number = ?,
         street_name = ?, subdivision = ?, sex = ?, marital_status = ?, birth_date = ?, 
         birth_place = ?, cellphone_number = ?, is_a_voter = ? WHERE id = ?");
        // Bind parameters and execute the statement
        $statement->execute([$firstName, $middleName, $lastName, $houseno, $streetName, $subdivision, $sex, $maritalstatus, $birthdate, $birthplace, $phonenumber, $isavoter, $residentId]);
        // Close the database connection
        $pdo = null;
        
        // Send success response
        echo "Data saved successfully";
    } catch (PDOException $e) {
        // Handle database connection or query errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // Send error response for invalid request method
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method";
}
?>

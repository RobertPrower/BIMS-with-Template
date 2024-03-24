<?php    
// Database connection
require_once('connecttodb.php');

try {

     // For Resident Details Set parameters and execute
    $first_name = $_POST['fname'];
    $middle_name = $_POST['mname'];
    $last_name = $_POST['lname'];
    $house_no = $_POST['house_no'];
    $street = $_POST['street'];
    $subdivision = $_POST['subd'];
    $sex = $_POST['sex'];
    $maritalstatus = $_POST['marital_status'];
    $birth_date = $_POST['birth_date']; 
    $birth_place = $_POST['birth_place']; 
    $cellphone_number = $_POST['cellphone_number'];
    $is_a_voter = $_POST['is_a_voter'];

    //To record the Date Recorded
    $reported_date = date("Y-m-d H:i:s");    
    
    // Retrieve the last used ID from the login table
    $last_id_query = "SELECT resident_id FROM resident ORDER BY resident_id DESC LIMIT 1";
    $last_id_stmt = $pdo->query($last_id_query);

    if ($last_id_stmt && $last_id_stmt->rowCount() > 0) {
        $row = $last_id_stmt->fetch(PDO::FETCH_ASSOC);
        $next_id = $row['resident_id'] + 1;
    } else {
        // If there are no existing records, start with ID 1
        $next_id = 1;
    }

    // Prepare and bind parameters
    $insert_query = "INSERT INTO resident (resident_id, date_recorded, first_name, middle_name, last_name, house_number, street_name, subdivision, sex, marital_status, birth_date, birth_place, cellphone_number, is_a_voter)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $pdo->prepare($insert_query);
    
    $insert_stmt->bindParam(1, $next_id, PDO::PARAM_INT);
    $insert_stmt->bindParam(2, $reported_date);
    $insert_stmt->bindParam(3, $first_name);
    $insert_stmt->bindParam(4, $middle_name);
    $insert_stmt->bindParam(5, $last_name);
    $insert_stmt->bindParam(6, $house_no);
    $insert_stmt->bindParam(7, $street);
    $insert_stmt->bindParam(8, $subdivision);
    $insert_stmt->bindParam(9, $sex);
    $insert_stmt->bindParam(10, $maritalstatus);
    $insert_stmt->bindParam(11, $birth_date);
    $insert_stmt->bindParam(12, $birth_place);
    $insert_stmt->bindParam(13, $cellphone_number);
    $insert_stmt->bindParam(14, $is_a_voter);

    $insert_stmt->execute();
    
    } catch (PDOException $e){
    // Handle exception
    echo "Error: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>

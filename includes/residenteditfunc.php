<?php 
    require_once("connecttodb.php");

    // Check if resident_id is set in the URL
    if(isset($_GET['resident_id'])) {
        $residentId = $_GET['resident_id'];

        // Query to retrieve resident data based on ID
        $query = "SELECT * FROM resident WHERE resident_id = :resident_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':resident_id', $residentId, PDO::PARAM_INT);
        $stmt->execute();
        // Fetch the row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if row is fetched successfully
        if($row) {
            // Access the data
            $first_name = $row['first_name'];
            $middle_name = $row['middle_name'];
            $last_name = $row['last_name'];
            $house_number = $row['house_number'];
            $street = $row['street_name'];
            $subdivision =$row['subdivision'];
            $sex = $row['sex'];
            $maritalstatus = $row['marital_status'];
            $birth_date = $row['birth_date'];
            $birth_place = $row['birth_place'];
            $cellphone_number = $row['cellphone_number'];
            $is_a_voter = $row['is_a_voter'];
    
            // Other fields...
        } else {
            // Handle the case where resident ID is not found
            echo "Resident ID not found.";
            exit; // Optionally exit script or redirect to another page
        }
    } else {
        // Handle the case where resident ID is not set in the URL
        echo "Resident ID is not provided.";
         // Optionally exit script or redirect to another page
    }
?>

<?php

// Database connection
require_once('connecttodb.php');

$ID = (isset($_POST['resident_id']))? $_POST['resident_id']: $_POST['nresident_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $operation_check=$_POST['OPERATION'];

    if($operation_check == "RESIDENT"){

        $residentId = $_POST['resident_id'];

         // Query to fetch resident details based on the ID
        $query = "SELECT first_name, middle_name, last_name, suffix, CONCAT(house_num, ' ', street, ' ', subdivision) AS address, resident_since 
        FROM resident WHERE resident_id = ?";

        $stmt=$pdo->prepare($query);
        $stmt->execute([$ID]);

        if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
        } else {
        echo json_encode(['error' => 'No resident found']);
        }
    }elseif($operation_check == "NON_RESIDENT"){

        // Query to fetch resident details based on the ID
        $query = "SELECT first_name, middle_name, last_name, suffix, CONCAT(house_num, ' ', street, ' ', subdivision) AS address
        FROM non_resident WHERE nresident_id = ?";

        $stmt=$pdo->prepare($query);
        $stmt->execute([$ID]);

        if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
        } else {
        echo json_encode(['error' => 'No resident found']);
        }

    }
        
    $pdo=null;
}

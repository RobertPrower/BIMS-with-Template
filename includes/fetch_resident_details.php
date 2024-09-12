<?php

// Database connection
require_once('connecttodb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $residentId = $_POST['id'];

    // Query to fetch resident details based on the ID
    $query = "SELECT first_name, middle_name, last_name, suffix, CONCAT(house_num, ' ', street, ' ', subdivision) AS address, resident_since 
              FROM resident WHERE resident_id = ?";
    
    $stmt=$pdo->prepare($query);
    $stmt->execute([$residentId]);

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'No resident found']);
    }

    $pdo=null;
}

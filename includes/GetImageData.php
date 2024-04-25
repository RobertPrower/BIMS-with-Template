<?php
require_once'connecttodb.php';

$id = $_GET['id'];
$query = "SELECT img_path FROM resident WHERE resident_id = ?"; 
$statement = $pdo->prepare($query);
$statement->execute([$id]);
$result = $statement->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // Prepare response
    $response = array(
      "imageData" => $result['img_path']
    
    );
} else {
    $response = array("error" => "No data found for id: $id");
}

$pdo = null;

header('Content-Type: application/json');
echo json_encode($response);
?>

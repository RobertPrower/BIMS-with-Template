<?php
require_once'connecttodb.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id = $_GET['id'];
$query = "SELECT path, size, height FROM resident_img WHERE id = ?"; 
$statement = $pdo->prepare($query);
$statement->execute([$id]);
$result = $statement->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // Prepare response
    $response = array(
      "imageData" => $result['path'],
      "imageMetadata" => array(
          "size" => $result['size'],
          "height" => $result['height']
      )
    );
} else {
    $response = array("error" => "No data found for id: $id");
}

$pdo = null;

header('Content-Type: application/json');
echo json_encode($response);
?>

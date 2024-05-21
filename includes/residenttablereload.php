<?php
require_once('connecttodb.php');
$sqlquery="SELECT * FROM resident";
$stmt=$pdo->prepare($sqlquery);
$stmt->execute();
// Fetch all rows as an associative array
$residents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output JSON data
echo json_encode(array("data" => $residents));

?>
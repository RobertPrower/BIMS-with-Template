<?php 

require_once('connecttodb.php');

$items_per_page = isset($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 10;
$current_page=isset($_GET['page']) ? (int)$_GET['page'] :1;
$offset = ($current_page - 1) * $items_per_page;

try {
  $sqlquery="SELECT * FROM resident WHERE is_deleted=0 LIMIT :offset, :items_per_page";
  $stmt = $pdo->prepare($sqlquery);
  $stmt -> execute([$sqlquery]);
  $results = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    ECHO  json_encode($results);
}catch(PDOException $e){
  echo 'ERROR: ' . htmlspecialchars($e -> getMessage()); 
}

$pdo=null;
?>
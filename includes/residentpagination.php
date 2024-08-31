<?php 

require_once('connecttodb.php');

// Number of records per page
$limit = 10;

// Get the total number of records
$stmt = $pdo->query("SELECT COUNT(*) FROM vw_all_resident");
$total_records = $stmt->fetchColumn();

// Calculate the total number of pages
$total_pages = ceil($total_records / $limit);

// Get the current page number from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $limit;

// Fetch the records for the current page
$stmt = $pdo->prepare("SELECT * FROM vw_all_resident ? :limit OFFSET ?");
$stmt->execute([$limit, $offset]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = [
  'items' => $items,
  'total_pages' => $total_pages,
  'current_page' => $page
];

echo json_encode($response);
?>
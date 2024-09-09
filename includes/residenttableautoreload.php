<?php

include 'connecttodb.php';
$limit = 10;
$page = isset($_POST['pageno']) ? $_POST['pageno'] : 1;
$start_from = ($page - 1) * $limit;

try {
        $sql = "SELECT * FROM vw_all_resident ORDER BY last_name ASC LIMIT $start_from, $limit"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any results
    if (count($results) > 0) {
        // Output each row as HTML
        require_once'residenttabletofetch.php';
    } else {
        echo '<tr><td colspan="12">No records found.</td></tr>';
    }
} catch (PDOException $e) {
    echo 'Error: ' . htmlspecialchars($e->getMessage());
}

// Close the connection
$pdo = null;
?>

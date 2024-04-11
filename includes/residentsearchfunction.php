<?php
require_once("connecttodb.php");

// Check if the search query is provided in the URL parameter
if (isset($_GET['search'])) {
    // Sanitize the search query to prevent SQL injection
    $search = $_GET['search'];
    
    // Fetch user data from the database based on the search query
    $query = "SELECT * FROM resident WHERE first_name LIKE :search OR last_name LIKE :search OR cellphone_number LIKE :search OR subdivision LIKE :search";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    // If no search query is provided, fetch all user data from the database
    $stmt = $pdo->query("SELECT * FROM resident WHERE is_deleted = 0");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

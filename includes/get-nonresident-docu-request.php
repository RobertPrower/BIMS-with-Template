<?php 
require_once('connecttodb.php');
require_once('anti-SQLInject.php');

$operation_check = $_POST['OPERATION'];

if ($operation_check == "FETCH_TABLE") {
    $id = $_POST['nresident_id'];
    if (isset($id)) {
        $limit = 5;
        $page = isset($_POST['pageno']) ? sanitizeData($_POST['pageno']) : 1;
        $start_from = ($page - 1) * $limit;

        // Query with corrected LIMIT usage
        $sqlquery = "CALL SearchNonResidentDocu(?, ?, ?)";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$id, $start_from, $limit]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        // Populate table rows with Resident Clearance data
        include_once('requested_docu_tabletofetch.php');

    } else {
        echo json_encode("ID not provided");
    }
} elseif ($operation_check == "PAGINATION") {
    $id = $_POST['nresident_id'];
    
    $pagequery = "SELECT COUNT(*) FROM tbl_docu_request WHERE `nresident_no` = ?";
    $total_records_stmt = $pdo->prepare($pagequery);
    $total_records_stmt->execute([$id]);
    $total_records = $total_records_stmt->fetchColumn();
    $limit = 5;
    $total_pages = ceil($total_records / $limit);
    $page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $current_page = max(1, min($page, $total_pages));

    require_once('paginationtemplateformodal.php');
    
    
}

?>
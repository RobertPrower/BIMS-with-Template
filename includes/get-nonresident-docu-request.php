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

    if ($current_page > 1) {
        echo '<li class="page-item modal-pagination-control"><a class="page-link nrdocmodal-pagination-control" href="#" data-page="' . ($current_page - 1) . '">Previous</a></li>';
    }
    
    $range = 5; // Max number of entries to be displayed
    $half_range = floor($range / 2);//Round down to the nearest value
    
    // Calculate the start and end page numbers
    $start_page = max(1, $current_page - $half_range);
    $end_page = min($total_pages, $current_page + $half_range);
    
    // Ensure that exactly 10 page numbers are displayed if possible
    if ($end_page - $start_page + 1 < $range) {
        if ($start_page == 1) {
            // If at the start, extend the end
            $end_page = min($total_pages, $start_page + $range - 1);
        } elseif ($end_page == $total_pages) {
            // If at the end, shift the start back
            $start_page = max(1, $end_page - $range + 1);
        }
    }
    
    // To generate the Page number buttons
    for ($i = $start_page; $i <= $end_page; $i++) {
        $active = $i == $current_page ? 'active' : '';
        echo '<li class="page-item modal-pagination-control ' . $active . '"><a class="page-link nrdocmodal-pagination-control" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    }
    
    // Next button
    if ($current_page < $total_pages) {
        echo '<li class="page-item modal-pagination-control"><a class="page-link nrdocmodal-pagination-control" href="#" data-page="' . ($current_page + 1) . '">Next</a></li>';
    }
    
    
}

?>
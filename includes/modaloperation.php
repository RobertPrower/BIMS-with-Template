<?php
if($_SERVER['REQUEST_METHOD']!=="POST"){
    exit("Access Denied");
}
require_once 'connecttodb.php';
require_once('anti-SQLInject.php');


$operation_check = (isset($_POST['operation'])) ? $_POST['operation'] : null;
$nresid = (isset($_POST['nresident_id'])) ? sanitizeData($_POST['nresident_id']) : null;
$id = (isset($_POST['resident_id'])) ? sanitizeData($_POST['resident_id']) : null;

$limit = 5;
$page = isset($_POST['page']) ? $_POST['page'] : '1';
$start_from = ($page - 1) * $limit;

if ($operation_check == "SELECT_RESIDENT_TABLELOAD") {

    $sqlquery = "SELECT * FROM vw_select_resident";

    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        echo "Responded nothing";
    } else {
        echo json_encode($results);
    }

} else if ($operation_check == "SELECT_NONRESIDENT_TABLELOAD") {

    $sqlquery = "SELECT * FROM vw_select_nonresident";

    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);

} else if ($operation_check == "RES_DOCUREQ_FETCH_TABLE") {
    $id = (isset($_POST['resident_id'])) ? $_POST['resident_id'] : null;
    if (isset($id)) {
        $limit = 5;
        $page = isset($_POST['pageno']) ? sanitizeData($_POST['pageno']) : 1;
        $start_from = ($page - 1) * $limit;

        // Query with corrected LIMIT usage
        $sqlquery = "CALL SearchResidentDocu(?,?,?)";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$id, $start_from, $limit]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if(!empty($result)){
             // Populate table rows with Resident Clearance data
            include_once('requested_docu_tabletofetch.php');
        }else{
            echo '<tr><td colspan="11"><b>No Records Found</b></td></tr>';

        }
       
    } else {
        echo json_encode("ID not provided");
    }
} else if ($operation_check == "RES_DOCUREQ_PAGINATION") {

    $pagequery = "SELECT COUNT(*) FROM tbl_docu_request WHERE resident_no = ?";
    $total_records_stmt = $pdo->prepare($pagequery);
    $total_records_stmt->execute([$id]);
    $total_records = $total_records_stmt->fetchColumn();
    $limit = 5;
    $total_pages = ceil($total_records / $limit);
    $page = isset($_POST['pageno']) ? (int) $_POST['pageno'] : 1;
    $current_page = max(1, min($page, $total_pages));

    require_once('paginationtemplateformodal.php');

} else if ($operation_check == "NONRES_DOCREQ_FETCH_TABLE") {
    if (isset($nresid)) {
        $limit = 5;
        $page = isset($_POST['pageno']) ? sanitizeData($_POST['pageno']) : 1;
        $start_from = ($page - 1) * $limit;

        // Query with corrected LIMIT usage
        $sqlquery = "CALL SearchNonResidentDocu(?, ?, ?)";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$nresid, $start_from, $limit]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if (count($result) > 0) {
            // Populate table rows with Resident Clearance data
            include_once('requested_docu_tabletofetch.php');
        } else {
            echo '<tr><td colspan="11"><b>No Records found</b></td></tr>';
        }
    } else {
        echo json_encode("ID not provided");
    }
} else if ($operation_check == "NONRES_DOCREQ_PAGINATION") {

    $pagequery = "SELECT COUNT(*) FROM tbl_docu_request WHERE `nresident_no` = ? AND is_deleted = 0";
    $total_records_stmt = $pdo->prepare($pagequery);
    $total_records_stmt->execute([$nresid]);
    $total_records = $total_records_stmt->fetchColumn();
    $limit = 5;
    $total_pages = ceil($total_records / $limit);
    $page = isset($_POST['pageno']) ? (int) $_POST['pageno'] : 1;
    $current_page = max(1, min($page, $total_pages));

    if (isset($nresid)) {
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
    } else {
        echo json_encode("ID not provided");
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


} else if ($operation_check == "FETCH_RESIDENT_DETAILS") {

    // Query to fetch resident details based on the ID
    $query = "SELECT first_name, middle_name, last_name, suffix, CONCAT(house_num, ' ', street, ' ', subdivision) AS address, resident_since 
    FROM resident WHERE resident_id = ?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'No resident found']);
    }

} else if ($operation_check == "FETCH_NON_RESIDENT_DETAILS") {

    // Query to fetch resident details based on the ID
    $query = "SELECT first_name, middle_name, last_name, suffix, CONCAT(house_num, ' ', street, ' ', subdivision,' ',district_brgy,' ',city,' ',province,' ',zipcode) AS address
    FROM non_resident WHERE nresident_id = ?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$nresid]);

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'No resident found']);
    }

} else if ($operation_check == "FETCH-RESIDENT-DETAILS") {
    if ($id) {
        $sqlquery = "SELECT * FROM resident WHERE resident_id=?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
    }
} else if ($operation_check == "FETCH-NON-RESIDENT-DETAILS") {
    if ($nresid) {
        $sqlquery = "SELECT * FROM non_resident WHERE nresident_id=?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$nresid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'No id received']);
    }
} else if ($operation_check == "FETCH_RES_BLOTTER_INVOLVED"){

    $sqlquery = "CALL CheckResidentBlotterRec(?,?,null)";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute([$id, $start_from]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($result)){
        require_once 'blotterinvolvedtemplate.php';
    }else{
        echo '<tr><td colspan="11"><b>No Records found</b></td></tr>';
    }
} else if ($operation_check == "FETCH_NONRES_BLOTTER_INVOLVED"){

    //Not yet maded
    $sqlquery = "CALL CheckNonResidentBlotterRec(?,?)";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute([$id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    require_once 'blotterinvolvedtemplate.php';

}else if ($operation_check == "RES_BLOTTER_PAGINATION"){

    $sqlquery = "SELECT COUNT (CALL CheckResidentBlotterRec(?, ?))";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute([$id, $start_from]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'paginationtemplateformodal.php';    

} else if ($operation_check == "NONRES_BLOTTER_PAGINATION"){

    $sqlquery = "SELECT COUNT (CALL CheckNonResidentBlotterRec(?, ?))";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute([$id, $start_from]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    require_once 'paginationtemplateformodal.php';

}else {
    echo "Invalid operation";
}

$pdo = null;
?>
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
$page = isset($_POST['pageno']) ? $_POST['pageno'] : '1';
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

    // Fetch the total number of records
    $countquery = "SELECT COUNT(*) AS count FROM tbl_docu_request WHERE resident_no = ? AND is_deleted=0";
    $stmt = $pdo->prepare($countquery);
    $stmt->execute([$id]);
    $total_records = $stmt -> fetchColumn();
    $limit = 5; //To limit the number of pages
    $total_pages = ceil($total_records / $limit);

    // Get the current page or set a default
    $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $current_page = max(1, min($current_page, $total_pages));
    $start_from = ($current_page - 1) * $limit;

    require_once'paginationtemplateformodal.php';

} else if ($operation_check == "NONRES_DOCREQ_FETCH_TABLE") {
    if (isset($nresid)) {

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
            echo '<tr><td class="col-span-11"><b>No Records found</b></td></tr>';
        }
    } else {
        echo json_encode("ID not provided");
    }
} else if ($operation_check == "NONRES_DOCREQ_PAGINATION") {

    $pagequery = "SELECT COUNT(*) FROM tbl_docu_request WHERE `nresident_no` = ? AND is_deleted = 0";
    $total_records_stmt = $pdo->prepare($pagequery);
    $total_records_stmt->execute([$nresid]);
    $total_records = $total_records_stmt->fetchColumn();
    $total_pages = ceil($total_records / $limit);

    $page = isset($_POST['pageno']) ? (int) $_POST['pageno'] : 1;
    $current_page = max(1, min($page, $total_pages));

    require_once 'paginationtemplateformodal.php';


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

    try{
        if(!empty($id)){
            $sqlquery = "CALL CheckResidentBlotterRec(?,?)";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$id, $start_from]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "Start From :".$start_from;

            if(!empty($result)){
                require_once 'blotterinvolvedtemplate.php';
            }else{
                echo '<tr><td colspan="11"><b>No Records found</b></td></tr>';
            }
        }else{
            echo '<tr><td colspan="11"><b>No ID Recieved</b></td></tr>';

        }
    }catch(Exception $e){
        echo '<tr><td colspan="11"><b>Error :'.$e->getMessage().'</b></td></tr>';
    }
} else if ($operation_check == "FETCH_NONRES_BLOTTER_INVOLVED"){

    try{
        if(!empty($nresid)){
            $sqlquery = "CALL CheckNonResidentBlotterRec(?,?)";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$nresid, $start_from]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($result)){
                require_once 'blotterinvolvedtemplate.php';
            } else {
                echo '<tr><td colspan="8"><b>No Records found</b></td></tr>';
            }
        }else{
            echo '<td colspan="8"><b>No Records found</b></td>';
        }
    }catch(Exception $e){
        echo '<tr><td colspan="8"><b>Error :'.$e->getMessage().'</b></td></tr>';
    }

}else if ($operation_check == "RES_BLOTTER_PAGINATION"){

    // Fetch the total number of records
    $countquery = "CALL `CountPersonBlotterInvolved`(?)";
    $stmt = $pdo->prepare($countquery);
    $stmt->execute([$id]);
    $total_records = $stmt -> fetchColumn();
    echo "Total Records :". $total_records;
    $limit = 5; //To limit the number of pages
    $total_pages = ceil($total_records / $limit);

     // Get the current page or set a default
     $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
     $current_page = max(1, min($current_page, $total_pages));
     $start_from = ($current_page - 1) * $limit; 

    require_once'paginationtemplateformodal.php';

} else if ($operation_check == "NONRES_BLOTTER_PAGINATION"){

      // Fetch the total number of records
      $countquery = "CALL `CountNonResidentBlotterRec`(?)";
      $stmt = $pdo->prepare($countquery);
      $stmt->execute([$nresid]);
      $total_records = $stmt -> fetchColumn();
      echo "Total Records :". $total_records;
      $limit = 5; //To limit the number of pages
      $total_pages = ceil($total_records / $limit);
  
       // Get the current page or set a default
       $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
       $current_page = max(1, min($current_page, $total_pages));
       $start_from = ($current_page - 1) * $limit; 
  
      require_once'paginationtemplateformodal.php';

}else {
    echo "Invalid operation";
}

$pdo = null;
?>
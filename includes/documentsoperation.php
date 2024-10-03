<?php 
if($_SERVER['REQUEST_METHOD']=="POST"){

}else{
    exit("Access Denied");
}

require_once'connecttodb.php';
$operation_check = (isset($_POST['OPERATION']))? $_POST['OPERATION'] : null ;
$request_Id = (isset($_POST['request_id']))? $_POST['request_id']: null ;
$nowdate = date("y-m-d"); //Checks the current date
$time = date('H:i:s'); //Checks the current time

if($operation_check =="REVOKE"){
    if(isset($request_Id)){
        $sqlquery = "UPDATE tbl_docu_request SET `status`=? WHERE request_id=?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute(["2", $request_Id ]);

        $response="Certificate has been revoked!!";

        echo json_encode(value: ["success" => true, $response]);
    }else{
        $response="No request ID recevied";
        echo "REVOKE";
        exit(json_encode(value: ["success" => false, $response]));
    }

}elseif($operation_check =="RESTORE"){
    if(isset($request_Id)){
        $sqlquery = "UPDATE tbl_docu_request SET `status`=? WHERE request_id=?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute(["0", $request_Id ]);

        $response="Certificate has been restored!!";

        echo json_encode(value: ["success" => true, $response]);
    }else{
        $response="No request ID recevied";
        echo "RESTORE";
        exit(json_encode(value: ["success" => false, $response]));

    }
}elseif($operation_check=="EDIT"){
    if(isset($request_Id)){

        $expiration = $_POST['expiration'];
        $presentedid = $_POST['presented_id'];
        $id_number = $_POST['id_num'];

        $sqlquery = "UPDATE tbl_cert_audit_trail
        SET expiration = ?, date_edited = ?, time_edited = ?
        WHERE audit_trail_id IN (SELECT audit_trail_no FROM tbl_docu_request WHERE request_id=?)";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$expiration, $nowdate, $time, $request_Id]);


        $sqlquery2 = "UPDATE tbl_docu_request SET `presented_id`=?, id_number=? WHERE request_id=?";
        $stmt2 = $pdo->prepare($sqlquery2);
        $stmt2->execute([$presentedid, $id_number, $request_Id]);


        $response="The certificate has been updated";

        echo json_encode(value: ["success" => true, $response]);
    }else{
        exit(json_encode(value: ["success" => false, "No Request ID recieved"]));
    }

}elseif($operation_check == "FETCH_FILENAME"){
    if(isset($_POST['request_id'])){

        $sqlquery="SELECT pdffile FROM tbl_docu_request WHERE request_id=?";

        $stmt= $pdo -> prepare($sqlquery);
        $stmt->execute([$request_Id]);
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

        exit(json_encode($result));

    }else{

        exit(json_encode(['error' => 'No certificate request_id recieved']));
    }
}elseif($operation_check == "DELETE_ENTRY"){

    if(isset($_POST['request_id'])){
        $sqlquery = "UPDATE tbl_docu_request SET is_deleted =? WHERE request_id=?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([1, $request_Id]);

        echo json_encode(['success' => true, 'message' => "Entry has been deleted"]);

    }else{
        echo json_encode(['error' => 'No certificate request_id recieved']);
    }

}elseif($operation_check =="UNDO_DELETE"){
    if(isset($request_Id)){
        $sqlquery = "UPDATE tbl_docu_request SET `is_deleted`= 0 WHERE request_id=?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$request_Id]);

        $response="Certificate has been restored!!";

        echo json_encode(value: ["success" => true, $response]);
    }else{
        $response="No request ID recevied";
        echo "RESTORE";
        exit(json_encode(value: ["success" => false, $response]));

    }
}elseif($operation_check == "PAGINATION"){
     // Fetch the total number of records
     $total_records = $pdo->query("SELECT COUNT(*) FROM vw_all_documents")->fetchColumn();
     $limit = 10; //To limit the number of pages
     $total_pages = ceil($total_records / $limit);
 
     // Get the current page or set a default
     $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
     $current_page = max(1, min($current_page, $total_pages));
     $start_from = ($current_page - 1) * $limit;
 
     // Fetch the data for the current page
     $query = $pdo->prepare("SELECT * FROM vw_all_documents ORDER BY request_id ASC LIMIT $start_from, $limit");
     $query->execute();
     $result = $query->fetchAll();
 
     require_once'paginationtemplate.php';

    
}elseif($operation_check == "TABLE_LOAD"){
    $limit = 10;
    $page = isset($_POST['pageno']) ? $_POST['pageno'] : 1;
    $start_from = ($page - 1) * $limit;

    try {
            $sql = "SELECT * FROM vw_all_documents ORDER BY date_issued DESC"; 
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if there are any results
        if (count($results) > 0) {
            // Output each row as HTML
            require_once('documentstabletofetch.php');

        } else {
            echo '<tr><td colspan="12">No records found.</td></tr>';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . htmlspecialchars($e->getMessage());
    }

}elseif($operation_check == "SHOW_DELETED"){

     // Fetch the total number of records
     $total_records = $pdo->query("SELECT COUNT(*) FROM resident WHERE is_deleted=1")->fetchColumn();
     $limit = 10; //To limit the number of pages
     $total_pages = ceil($total_records / $limit);
 
     // Get the current page or set a default
     $page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
     $page = max(1, min($page, $total_pages));
     $start_from = ($page - 1) * $limit;
 
     // Fetch the data for the current page
     $query = $pdo->prepare("SELECT * FROM vw_all_documents WHERE is_deleted=1 ORDER BY last_name ASC LIMIT $start_from, $limit");
     $query->execute();
     $results = $query->fetchAll();

    if(!empty($results)){
        require_once'residenttabletofetch.php';
    }else{
        echo '<tr><td colspan="11"><b>No Deleted Records found</b></td></tr>';
    }

}elseif($operation_check == "PAGINATION_FOR_DEL_REC"){
    $total_records = $pdo->query("SELECT COUNT(*) FROM vw_all_documents WHERE is_deleted=1")->fetchColumn();
    $limit = 10; //To limit the number of pages
    $total_pages = ceil($total_records / $limit);

    // Get the current page or set a default
    $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $current_page = max(1, min($current_page, $total_pages));
    $start_from = ($current_page - 1) * $limit;

    require_once('paginationtemplate.php');
}elseif($operation_check == "FETCH_BUSINESS_PERMIT"){

    if(isset($request_Id)){
        $searchquery = "CALL search_business_permit(?)";
        $searchstmt = $pdo->prepare($searchquery);
        $searchstmt->execute([$request_Id]);
        $results= $searchstmt->fetchAll(PDO::FETCH_ASSOC);
        $searchstmt->closeCursor();

        echo json_encode($results);
    }else{
        echo json_encode(["error", "message" => "No ID was recieved"]);
    }


}else{
    echo "Nothing was reviced";
}
$pdo = null;
?>
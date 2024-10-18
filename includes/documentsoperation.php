<?php 
if($_SERVER['REQUEST_METHOD']=="POST"){

}else{
    exit("Access Denied");
}

require_once'connecttodb.php';
require_once'anti-SQLInject.php';

$operation_check = (isset($_POST['OPERATION']))? $_POST['OPERATION'] : null ;
$request_Id = (isset($_POST['request_id']))? $_POST['request_id']: null ;
$nowdate = date("y-m-d"); //Checks the current date
$time = date('H:i:s'); //Checks the current time
$limit = 10;
$search = isset($_POST['search']) ? sanitizeData($_POST['search']): '';
$page = isset($_POST['page']) ? $_POST['page'] : '1';
$start_from = ($page - 1) * $limit;

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
    $page = isset($_POST['pageno']) ? sanitizeData($_POST['pageno']) : 1;
    $start_from = ($page - 1) * $limit;

    try {
            $sql = "SELECT * FROM vw_all_documents ORDER BY date_issued DESC LIMIT :start_from, :lim"; 
            $stmt = $pdo->prepare($sql);
            $stmt -> bindValue(':start_from', (int)$start_from, PDO::PARAM_INT);
            $stmt -> bindValue(':lim', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $lastpage = $page;

        // Check if there are any results
        if (count($results) > 1) {
            // Output each row as HTML
            require_once('documentstabletofetch.php');

        }elseif(count($results) === 1){
            switch($lastpage){
                case 1:
                    $page = 1;
                break;
                default:
                    $page = $lastpage -1;
            }

            $page = $lastpage - 1;

            require_once('documentstabletofetch.php');
        }else {
            echo '<tr><td colspan="12">No records found.</td></tr>';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . htmlspecialchars($e->getMessage());
    }

}elseif($operation_check == "SHOW_DELETED"){

     // Fetch the total number of records
     $total_records = $pdo->query("SELECT COUNT(*) FROM vw_deleted_docu")->fetchColumn();
     $limit = 10; //To limit the number of pages
     $total_pages = ceil($total_records / $limit);
 
     // Get the current page or set a default
     $page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
     $page = max(1, min($page, $total_pages));
     $start_from = ($page - 1) * $limit;
 
     // Fetch the data for the current page
     $query = $pdo->prepare("SELECT * FROM vw_deleted_docu ORDER BY date_issued DESC LIMIT :start_from, :lim");
     $query->bindValue('start_from',(int)$start_from, PDO::PARAM_INT);
     $query->bindValue('lim', (int)$limit, PDO::PARAM_INT);
     $query->execute();
     $results = $query->fetchAll();

    if(!empty($results)){
        require_once'documentstabletofetch.php';
    }else{
        echo '<tr><td colspan="11"><b>No Deleted Records found</b></td></tr>';
    }

}elseif($operation_check == "FETCH_BUSINESS_PERMIT"){

    if(isset($request_Id)){
        $searchquery = "CALL SearchBusinessPermits(?)";
        $searchstmt = $pdo->prepare($searchquery);
        $searchstmt->execute([$request_Id]);
        $results= $searchstmt->fetchAll(PDO::FETCH_ASSOC);
        $searchstmt->closeCursor();

        echo json_encode($results);
    }else{
        echo json_encode(["error", "message" => "No ID was recieved"]);
    }


}elseif($operation_check == "FETCH_BUILDING_PERMIT"){

    if(isset($request_Id)){
        $searchquery = "CALL SearchBuildingPermits(?)";
        $searchstmt = $pdo->prepare($searchquery);
        $searchstmt->execute([$request_Id]);
        $results= $searchstmt->fetchAll(PDO::FETCH_ASSOC);
        $searchstmt->closeCursor();

        echo json_encode($results);
    }else{
        echo json_encode(["error", "message" => "No ID was recieved"]);
    }


}elseif($operation_check == "FETCH_EXCAVATION_PERMIT"){

    if(isset($request_Id)){
        $searchquery = "CALL SearchExcavationPermits(?)";
        $searchstmt = $pdo->prepare($searchquery);
        $searchstmt->execute([$request_Id]);
        $results= $searchstmt->fetchAll(PDO::FETCH_ASSOC);
        $searchstmt->closeCursor();

        echo json_encode($results);
    }else{
        echo json_encode(["error", "message" => "No ID was recieved"]);
    }


}elseif($operation_check == "FETCH_FENCING_PERMIT"){

    if(isset($request_Id)){
        $searchquery = "CALL SearchFencingPermits(?)";
        $searchstmt = $pdo->prepare($searchquery);
        $searchstmt->execute([$request_Id]);
        $results= $searchstmt->fetchAll(PDO::FETCH_ASSOC);
        $searchstmt->closeCursor();

        echo json_encode($results);
    }else{
        echo json_encode(["error", "message" => "No ID was recieved"]);
    }


}elseif($operation_check == "FETCH_TPRS"){

    if(isset($request_Id)){
        $searchquery = "CALL SearchTPRS(?)";
        $searchstmt = $pdo->prepare($searchquery);
        $searchstmt->execute([$request_Id]);
        $results= $searchstmt->fetchAll(PDO::FETCH_ASSOC);
        $searchstmt->closeCursor();

        echo json_encode($results);
    }else{
        echo json_encode(["error", "message" => "No ID was recieved"]);
    }


}elseif($operation_check == "FETCH_INDIGENCY"){

    if(isset($request_Id)){
        $searchquery = "CALL SearchIndigency(?)";
        $searchstmt = $pdo->prepare($searchquery);
        $searchstmt->execute([$request_Id]);
        $results= $searchstmt->fetchAll(PDO::FETCH_ASSOC);
        $searchstmt->closeCursor();

        echo json_encode($results);
    }else{
        echo json_encode(["error", "message" => "No ID was recieved"]);
    }


}elseif($operation_check=="SEARCH"){
    if(!empty($search)){

        // query to fetch records with pagination
        $searchquery = "CALL SearchAllDocuments(:search,:start_from,:limit)";
        $stmt = $pdo->prepare($searchquery); 
        $stmt->execute(['search' => "%$search%", 'start_from' => "$start_from", 'limit' => "$limit"]);

        $results = $stmt->fetchAll();

        $lastpage = $page - 1; 

        if(!empty($results)){
            // Code for displaying the results
           require_once'documentstabletofetch.php';
            
        }else if(count($results) === 1){
            $page = $lastpage - 1;
            require_once'documentstabletofetch.php';

        }else{
            echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
        }
    }else{
        echo '<tr><td colspan="11">No Query</td></tr>';
    }
}elseif($operation_check=="DELETED_SEARCH"){
    if(!empty($search)){

        $searchquery = "CALL SearchDelDocu(:search, :start_from, $limit)";
        $stmt = $pdo->prepare($searchquery);
        $stmt -> bindValue(':search',"%$search%", PDO::PARAM_STR);
        $stmt -> bindValue(':start_from',$start_from, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $lastpage = $page;

        if(!empty($results) >= 2){
            // Code for displaying the results
            require_once'documentstabletofetch.php';
            
        }else if(count($results) === 1){
            $page = $lastpage - 1;
            require_once'documentstabletofetch.php';

        }else{
            echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
        }

    }else{
        echo '<tr><td colspan="11">No Query</td></tr>';
    }

}elseif($operation_check=="SEARCH_PAGINATION"){
    
    $query= "CALL SearchAllDocuments(:search, :start_from, :lim)";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':search', (string)"%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':start_from', (int)$start_from, PDO::PARAM_INT);
    $stmt -> bindValue(':lim',$limit, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll();

    $total_entries = count($results);

    $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $total_pages = max(1, min($current_page, $total_entries));
    $start_from = ($current_page - 1) * $limit;
        
    require_once'paginationtemplate.php';

}elseif($operation_check == "PAGINATION_FOR_DEL_REC"){

    if(!empty($search)){

        $searchquery = "CALL SearchDelDocu(:search, :start_from, $limit)";
        $stmt = $pdo->prepare($searchquery);
        $stmt -> bindValue(':search',"%$search%", PDO::PARAM_STR);
        $stmt -> bindValue(':start_from',$start_from, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $total_pages = (ceil(count($results) - 1) / $limit);

    }else{

        // Fetch the total number of records
        $total_records = $pdo->query("SELECT COUNT(*) FROM vw_deleted_docu")->fetchColumn();
        $limit = 10; //To limit the number of pages
        $total_pages = ceil($total_records / $limit);

    }
      // Get the current page or set a default
      $page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
      $current_page = max(1, min($page, $total_pages));
      $start_from = ($page - 1) * $limit;
    require_once('paginationtemplate.php');
}else{
    echo "Nothing was reviced";
}
$pdo = null;
?>
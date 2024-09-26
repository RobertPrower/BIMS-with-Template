<?php 
require_once'connecttodb.php';
$operation_check = $_POST['OPERATION'];
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
}else{
    echo "Nothing was reviced";
}
$pdo = null;
?>
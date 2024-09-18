<?php 
require_once'connecttodb.php';
$operation_check = $_POST['OPERATION'];
$request_Id = $_POST['request_id'];
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

}elseif($_POST['OPERATION'] == "FETCH_FILENAME"){
    if(isset($_POST['request_id'])){

        $sqlquery="SELECT pdffile FROM tbl_docu_request WHERE request_id=?";

        $stmt= $pdo -> prepare($sqlquery);
        $stmt->execute([$request_Id]);
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

        exit(json_encode($result));

    }else{

        exit(json_encode(['error' => 'No certificate request_id recieved']));
    }
}else{
    echo "Nothing was reviced";
}
$pdo = null;
?>
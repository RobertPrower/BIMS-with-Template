<?php 
require_once'connecttodb.php';
$operation_check = $_POST['OPERATION'];
$request_Id = $_POST['request_id'];

if($operation_check =="REVOKE"){
    $sqlquery = "UPDATE tbl_docu_request SET `status`=? WHERE request_id=?";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute(["2", $request_Id ]);

    $response="Certificate has been revoked!!";

    echo json_encode(value: ["success" => true, $response]);

}
?>
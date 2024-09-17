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

}elseif($_POST['FETCH_RESIDENT_DATA']){
    if($_POST['document']=="Certificate of Residency"){

        $sqlquery="SELECT
            `tbl_docu_request`.`request_id`       AS `request_id`,
            `tbl_cert_audit_trail`.`date_issued`  AS `date_issued`,
            tbl_docu_request.`resident_no`,
            `resident`.`last_name`,
            `resident`.`first_name` ,
            `resident`.`middle_name` ,
            `resident`.`suffix`,
            `resident`.`house_num` ,
            `resident`.`street` ,
            `resident`.`subdivision`,
            resident.`resident_since` AS resident_since,
            tbl_documents.`Certificate_of_Residency`,
            `tbl_docu_request`.`age`              AS `age`,
            `resident`.`sex`                      AS `sex`,
            `tbl_docu_request`.`presented_id`     AS `presented_id`,
            `tbl_docu_request`.`ID_number`        AS `ID_number`,
            `tbl_docu_request`.`purpose`          AS `purpose`,
            `tbl_cert_audit_trail`.`expiration`   AS `expiration`,
            `tbl_docu_request`.`status`           AS `status`,
            `tbl_docu_request`.`is_deleted`       AS `is_deleted`,
            `tbl_cert_audit_trail`.`date_edited`  AS `date_edited`,
            `tbl_cert_audit_trail`.`date_deleted` AS `date_deleted`
            FROM `tbl_docu_request`
                LEFT JOIN `resident`
                    ON `tbl_docu_request`.`resident_no` = `resident`.`resident_id`
                LEFT JOIN `non_resident`
                ON `tbl_docu_request`.`nresident_no` = `non_resident`.`nresident_id`
                JOIN `tbl_documents`
                ON `tbl_docu_request`.`document_no` = `tbl_documents`.`docu_id`
            JOIN `tbl_cert_audit_trail`
                ON `tbl_docu_request`.`audit_trail_no` = `tbl_cert_audit_trail`.`audit_trail_id`
                WHERE request_id=?";
        $stmt= $pdo -> prepare($sqlquery);
        $stmt->execute([$request_Id]);
        $stmt=fetch()

    }
}
$pdo = null;
?>
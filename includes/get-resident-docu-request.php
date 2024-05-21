<?php 
require_once('connecttodb.php');

$id=$_POST['id'];

if(isset($id)){

    $sqlquery="
    SELECT 
        tbl_docu_request.`document-no` AS `document_no`,
        tbl_docu_request.`date_requested`,
        tbl_docu_request.`purpose`,
        tbl_docu_request.`status`,
        tbl_documents.`document-desc` AS `document_desc`,
        tbl_documents.`age`
    FROM
        tbl_docu_request
    JOIN
        resident ON tbl_docu_request.`resident-no` = resident.`resident_id`
    JOIN
        tbl_documents ON tbl_docu_request.`document-no` = tbl_documents.`document-id`
    WHERE
        resident.`resident_id` = ?";

    $stmt=$pdo->prepare($sqlquery);
    $stmt->execute([$id]);
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
   
}else{
    echo json_encode("ID not provided");
}

?>
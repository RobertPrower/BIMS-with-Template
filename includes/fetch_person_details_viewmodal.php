<?php 
require_once('connecttodb.php');
include_once('anti-SQLInject.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $operation_check = ($_POST['OPERATION'])? sanitizeData($_POST['OPERATION']): null;
    $id_to_fetch = ($_POST['id_to_fetch'])? sanitizeData($_POST['id_to_fetch']): null;

    if($operation_check == "FETCH-RESIDENT-DETAILS"){
        if($id_to_fetch){
            $sqlquery = "SELECT * FROM resident WHERE resident_id=?" ;
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$id_to_fetch]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($result);
        }
    }elseif($operation_check == "FETCH-NON-RESIDENT-DETAILS"){
        if($id_to_fetch){
            $sqlquery = "SELECT * FROM non_resident WHERE nresident_id=?";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$id_to_fetch]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($result);
        }
    }else{
        echo json_encode(["NO OPERATION RECIEVED"]);
        echo $operation_check;

    }

}else{
    echo "Access Denied";
}
?>
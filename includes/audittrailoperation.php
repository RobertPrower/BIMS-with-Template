<?php

    require_once 'connecttodb.php' ;

    $limit = 10;
    $page = (isset($_POST['pageno']))? $_POST['pageno']: 1 ;
    $start_from = ($page - 1) * $limit;

    $operation_check = ($_POST['operation'])? $_POST['operation'] :null ;
    $id = (isset($_POST['resident_id']))? $_POST['resident_id']: null ;


    if($operation_check == "FETCH_TABLE"){

        $sqlquery = "SELECT * FROM vw_resident_audit_trail ORDER BY event_dt DESC LIMIT :start_from , 10";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'audittrailtabletofetch.php';

    }else if ($operation_check =="FETCH_RESIDENT_DETAILS"){

        $sqlquery="SELECT * FROM resident_shadow_copy WHERE entry_id = ?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);
    }
?>
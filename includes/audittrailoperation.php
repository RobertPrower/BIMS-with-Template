<?php

    require_once 'connecttodb.php' ;

    $limit = 10;
    $page = (isset($_POST['pageno']))? $_POST['pageno']: 1 ;
    $start_from = ($page - 1) * $limit;

    $operation_check = ($_POST['operation'])? $_POST['operation'] :null ;


    if($operation_check == "FETCH_TABLE"){

        $sqlquery = "SELECT * FROM vw_resident_audit_trail LIMIT :start_from , 10";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'audittrailtabletofetch.php';


    }
?>
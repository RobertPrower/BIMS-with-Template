<?php

    require_once 'connecttodb.php';
    $operation_check = $_POST['OPERATION'];


    if($operation_check =="TABLE_LOAD"){
        $limit = 10;
        $page = isset($_POST['pageno']) ? sanitizeData($_POST['pageno']) : 1;
        $start_from = ($page - 1) * $limit;

        try {
                $sql = "SELECT * FROM vw_all_documents ORDER BY date_issued DESC"; 
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode($results);

        } catch (PDOException $e) {
            echo 'Error: ' . htmlspecialchars($e->getMessage());
        }
    }

?>
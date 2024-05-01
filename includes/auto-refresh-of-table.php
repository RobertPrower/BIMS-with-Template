<?php 
    require_once("connecttodb.php");

    try{
        $sqlquery="SELECT * FROM brgy_officials";
        $stmt=$pdo->prepare($sqlquery);
        $stmt -> execute();

        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

       

    echo json_encode(array('data' => $result));
    }catch(PDOException $error){

        echo json_encode(["Error:" ." ". $error->getMessage()]);

    }

    $pdo=null;
    header('Content-Type: application/json');

?>
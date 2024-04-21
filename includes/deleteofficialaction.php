<?php 

    require_once'connecttodb.php';

    $official_id=$_POST['id'];

    $sqlquery = "DELETE FROM brgy_officials WHERE id=?";
    $stmt = $pdo -> prepare($sqlquery);
    $stmt -> execute([$official_id]);

    echo json_encode(['status'=>'success','message' => 'Official Deleted Successfully']);

?>
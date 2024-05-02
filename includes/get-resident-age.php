<?php

    $id=$_POST["resident_id"];

    $sqlquery="SELECT TIMESTAMPDIFF(YEAR, `birth_date`, NOW()) AS Age FROM resident WHERE resident_id=?";
    $stmt=$pdo->prepare($sqlquery);
    $age=$stmt->execute();

    echo json_encode([$age]);

?>
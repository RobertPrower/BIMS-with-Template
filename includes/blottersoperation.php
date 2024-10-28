<?php 
require_once'connecttodb.php';

$operation_check = (isset($_POST['operation']))? $_POST['operation']: null;

if($operation_check == "SELECT_NONRESIDENT_TABLELOAD"){

    $sqlquery = "	SELECT nresident_id, img_filename, CONCAT(first_name,' ',last_name,' ',middle_name,' ',suffix) as full_name,
    CONCAT(house_num,' ',street,' ',subdivision,' ',district_brgy,' ',city,' ',province,' ',zipcode) AS address,
    sex, marital_status, birth_date, cellphone_num FROM non_resident";

    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($results);

}else if($operation_check == "SELECT_RESIDENT_TABLELOAD"){

    $sqlquery = "SELECT resident_id, img_filename, CONCAT(first_name,' ',last_name,' ',middle_name,' ',suffix) as full_name,
    CONCAT(house_num,' ',street,' ',subdivision,' Camarin Caloocan City') AS address,
    sex, marital_status, birth_date, cellphone_num, is_a_voter FROM resident";
    
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($results);


}else if($operation_check == "FETCH_SCHEDULE_ON_MODAL"){

    $sqlquery = "SELECT * FROM vw_blotters_schedule";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
}else if($operation_check == "ADD_BLOTTER"){

    

}
$pdo = null;

?>
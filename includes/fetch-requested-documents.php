<?PHP
    require_once("connecttodb.php");

    /*$id=$_POST['resident_id'];

    if(isset($id)){*/
        $sqlquery="SELECT 

            `tbl-request`.`resident-id`,
            resident.`resident_id`,
            `tbl-request`.`request-id`,
            `tbl-request`.`request-id`,
            `tbl-request`.`date-requested`,
            `tbl-clearance`.`clearance-desc`,
            `tbl-clearance`.`purpose`,
            `tbl-clearance`.`age`,
            `tbl-clearance`.`status`

        FROM	`tbl-request`
        JOIN resident ON `tbl-request`.`resident-id`=resident.resident_id
        JOIN `tbl-clearance` ON `tbl-request`.`request-id`=`tbl-clearance`.`request-id`
        WHERE resident.`resident_id`=1";


        $stmt=$pdo->prepare($sqlquery);
        $stmt -> execute();
        $result = $stmt->fetchAll();

        echo json_encode([$result]);

  /*  }else{
        echo json_encode(["Error"=> "Something went wrong"]);
    }*/

?>
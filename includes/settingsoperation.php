<?php 
require_once"connecttodb.php";
include_once'anti-SQLInject.php';

$operation_check = (isset($_POST['OPERATION'])? $_POST['OPERATION'] : null);
$kagawad_id = (isset($_POST['id'])? sanitizeData($_POST['id']):  null);


if($operation_check == "FETCH_KAGAWAD"){

    $suboperation = (isset($_POST['SUBOPERATION']))? $_POST['SUBOPERATION']: null;

    if($suboperation == "FOR_REFRESHING"){

        $sqlquery = "SELECT * FROM kagawad";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $names){
            $kagawads[] = $names['official_name'];
        }

        echo implode(', ', $kagawads );
        

    }else{
        $sqlquery = "SELECT * FROM kagawad";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $kagawad){

            echo ' <tr>
                        <td>
                            <input type="text" class="form-control" id="kagawad'.$kagawad['kagawad_id'].'" value="'.$kagawad['official_name'].'" data-id="'.$kagawad['kagawad_id'].'" placeholder=""/>
                        </td>
                        <td class="d-flex justify-content-center">
                        <button class="btn btn-success mx-2 editkagawadbtn" data-id='.$kagawad['kagawad_id'].'>Edit</button>
                        <button class="btn btn-danger deletekagawadbtn" data-id='.$kagawad['kagawad_id'].'>Delete</button>

                        </td>
                        
                        
                    </tr>
                    
                    ';


        }

            echo '<tr>
                    <th scope="row">
                        <input type="text" class="form-control" id="newkagawad" placeholder=""/>
                    </th>

                    <td class="d-flex justify-content-center">
                        <button class="btn btn-primary addkagawadbtn">Add</button>
                    </td>
                </tr>';
    }
}else if($operation_check == "EDIT_KAGAWAD"){

    $kagawad_name = $_POST['kagawad_name'];

    try{
        $pdo->beginTransaction();
    
        $sqlquery = "UPDATE kagawad SET official_name = :official_name WHERE kagawad_id=:id";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->bindParam(':id', $kagawad_id, PDO::PARAM_INT);
        $stmt->bindParam(':official_name',$kagawad_name,PDO::PARAM_STR);
        $stmt->execute();

        $pdo->commit();

        echo json_encode(["success"=>true, "message" => "Kagawad updated successfully"]);
    }catch(Exception $e){
        echo json_encode(["success"=>false, "message" => $e->getMessage()]);
        $pdo->rollBack();

    }
}else if($operation_check == "ADD_KAGAWAD"){

    $kagawad_name = $_POST['kagawad_name'];

    try{
        $pdo->beginTransaction();
    
        $sqlquery = "INSERT INTO kagawad(official_name) VALUES (:official_name)";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->bindParam(':official_name',$kagawad_name,PDO::PARAM_STR);
        $stmt->execute();

        $pdo->commit();

        echo json_encode(["success"=>true, "message" => "Kagawad added successfully"]);
    }catch(Exception $e){
        echo json_encode(["success"=>false, "message" => $e->getMessage()]);
        $pdo->rollBack();

    }
}else if($operation_check == "DELETE_KAGAWAD"){

    try{
        $pdo->beginTransaction();
    
        $sqlquery = "DELETE FROM kagawad WHERE kagawad_id=:id";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->bindParam(':id',$kagawad_id,PDO::PARAM_INT);
        $stmt->execute();

        $pdo->commit();

        echo json_encode(["success"=>true, "message" => "Kagawad deleted successfully"]);
    }catch(Exception $e){
        echo json_encode(["success"=>false, "message" => $e->getMessage()]);
        $pdo->rollBack();

    }
}else if($operation_check == "SAVE_PSSK"){

    $punong_barangay = (isset($_POST['pb']))? $_POST['pb']: null;
    $barangay_sec = (isset($_POST['bsec']))? $_POST['bsec']:null;
    $barangay_sk = (isset($_POST['bsk']))? $_POST['bsk']: null;

    try{
        $pdo->beginTransaction();
    
        // Update for Punong Barangay
        $sql1 = "UPDATE brgy_officials SET official_name = :punong_barangay WHERE official_position = 'Punong Barangay'";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindParam(':punong_barangay', $punong_barangay, PDO::PARAM_STR);
        $stmt1->execute();
    
        // Update for Barangay Secretary
        $sql2 = "UPDATE brgy_officials SET official_name = :barangay_sec WHERE official_position = 'Barangay Secretary'";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':barangay_sec', $barangay_sec, PDO::PARAM_STR);
        $stmt2->execute();
    
        // Update for SK Chairperson
        $sql3 = "UPDATE brgy_officials SET official_name = :barangay_sk WHERE official_position = 'SK Chairperson'";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->bindParam(':barangay_sk', $barangay_sk, PDO::PARAM_STR);
        $stmt3->execute();
    
        // Commit the transaction
        $pdo->commit();
        echo json_encode(["success"=>true, "message" => "PSSK updated successfully"]);
    }catch(Exception $e){
        echo json_encode(["success"=>false, "message" => $e->getMessage()]);
        $pdo->rollBack();

    }
}else if($operation_check == "EDIT_BRGY_DETAILS"){

    $barangay_name = (isset($_POST['brgy_name']))? $_POST['brgy_name']: null;
    $barangay_address = (isset($_POST['brgy_address']))? $_POST['brgy_address']:null;
    $barangay_celnum = (isset($_POST['brgy_celnum']))? $_POST['brgy_celnum']: null;
    $barangay_telnum = (isset($_POST['brgy_telnum']))? $_POST['brgy_telnum']: null;
    $barangay_email = (isset($_POST['brgy_email']))? $_POST['brgy_email']: null;
    $barangay_district = (isset($_POST['brgy_district']))? $_POST['brgy_district']: null;
    $barangay_sona = (isset($_POST['brgy_sona']))? $_POST['brgy_sona']: null;


    try{
        $pdo->beginTransaction();
    
        // Update for Punong Barangay
        $sql1 = "UPDATE brgy_details SET brgy_name = ?, sona=?, district=?, tel_num=?, cp_num=?, email=?, `address`=? WHERE brgy_details_id = 1";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([$barangay_name, $barangay_sona, $barangay_district,$barangay_telnum,  $barangay_celnum, $barangay_email,$barangay_address]);
    
        // Commit the transaction
        $pdo->commit();
        echo json_encode(["success"=>true, "message" => "Brgy details updated successfully"]);
    }catch(Exception $e){
        echo json_encode(["success"=>false, "message" => $e->getMessage()]);
        $pdo->rollBack();

    }
}

?>
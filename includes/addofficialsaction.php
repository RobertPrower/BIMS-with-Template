<?php   

    require_once('connecttodb.php');

    $id = $_POST['official_id'];
    $fname = $_POST['fullname'];
    $position = $_POST['position'];
    $datelastedited =  date("Y-m-d H:i:s");

    $last_id_query="SELECT id FROM brgy_officials ORDER BY id DESC LIMIT 1";
    $last_id_stmt=$pdo->query($last_id_query);

    if($last_id_query && $last_id_stmt->rowCount() >0){
        $row = $last_id_stmt->fetch(PDO::FETCH_ASSOC);
        $next_id = $row['id'] + 1;

    }else{
        $next_id = 1;
    }

    if(empty($fname) || empty($position)){
        echo json_encode(['status'=>'error','message' => 'Both fields are required']);
        exit;
    }

if(!empty($id)){
        $sqlquery = "UPDATE brgy_officials SET official_name=?, official_position=?, date_last_edited=? WHERE id=?";
        $stmt=$pdo->prepare($sqlquery);
        $stmt->execute([$fname, $position,$datelastedited,$id]);

        $response = ["success" => true, "message" => "Data updated successfully"];
        echo json_encode($response);
        
    }else{
        $sqlquery = "INSERT INTO brgy_officials (id, official_name, official_position, date_last_edited) VALUES(?, ?, ?, ?)";
        $stmt=$pdo->prepare($sqlquery);
        $stmt->execute([$next_id, $fname, $position, $datelastedited]);

        $response = ["success" => true, "message" => "Data Added successfully"];
        echo json_encode($response);
    }



?>
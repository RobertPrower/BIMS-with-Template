<?php 
if($_SERVER["REQUEST_METHOD"] === "POST"){

    require_once 'connecttodb.php';

    $operation_check = $_POST['operation']?? '';

    if($operation_check === "ADD_USER"){

        
        try{

            require_once 'useroperation_model.inc.php';
            require_once 'useroperation_ctrl.inc.php';
            require_once 'fileUpload.php';
            
            $username = trim($_POST["username"] ?? '');
            $pword = trim($_POST["pword"] ?? '');
            $fname = trim($_POST['fname']?? '');
            $lname = trim($_POST['lname']?? '');
            $mname = trim($_POST['mname']?? '');
            $suffix = trim($_POST['suffix']??'');
            $dept = trim($_POST['department']?? '');
        
            //Error Handles
            $errors = [];
        
            if(is_input_empty($username, $pword, $fname, $lname) === true){
                $errors["empty_input"]="Fill all the fields";
            }
        
            if(is_username_taken($pdo,  $username)){
                $errors["username_taken"]="Username already taken!";
            }

            $hashed_password = password_hash($pword, PASSWORD_DEFAULT);
        
            // require_once 'config.php';
        
            if($errors){
                // $_SESSION["error_signup"]=$errors;
                echo json_encode(["success" => false, "message" => $errors]);
                die();
            }

            $img_filename = uploadImageFile("image_file", "img/users_img/");

            if(record_user($pdo ,$username, $hashed_password, $fname ,$mname, $lname ,$suffix, $dept, $img_filename)){
                echo json_encode(["success" => true, "message" => "User Added Successfully"]);
            }
        
        }catch(PDOException $e){
            die(json_encode(["success" => false, "message" => "Operation Failed: ". $e->getMessage()]));
        }

    }else{
        echo json_encode(["success" => false, "message" => "Invalid Operation"]);
    }

    
   
}else{
    header("Location: ../index.php");
    exit();
}

$pdo=null;

 function is_input_empty($uname, $password, $firstname, $lastname){

    if(empty($uname) || empty($password) || empty($firstname) || empty($lastname)){
        return true;
    }else{
        return false;
    }
}
<?php 
if($_SERVER["REQUEST_METHOD"] === "POST"){

    require_once 'config.php';
    require_once 'enforce_login.php';
    require_once 'connecttodb.php';
    require_once 'anti-SQLInject.php';
    require_once 'paginationfunctions.php';
    require_once 'useroperation_model.inc.php';
    require_once 'useroperation_ctrl.inc.php';
    require_once 'fileUpload.php';

    $operation_check = $_POST['operation'];
    $search = (isset($_POST['search']))?sanitizeData($_POST['search']): null;
    $user_id = (isset($_POST['user_id']))? sanitizeData($_POST['user_id']): null;
    $current_user = $_SESSION["user_id"];
    $pageno=(isset($_POST['pageno']))?$_POST['pageno']: 1;

    $username = sanitizeData($_POST["username"] ?? '');
    $pword = trim(htmlspecialchars($_POST["pword"] ?? ''));
    $pword2 = trim(htmlspecialchars($_POST["pword2"] ?? ''));
    $fname = sanitizeData($_POST['fname']?? '');
    $lname = sanitizeData($_POST['lname']?? '');
    $mname = sanitizeData($_POST['mname']?? '');
    $suffix = sanitizeData($_POST['suffix']??'');
    $dept = sanitizeData($_POST['department']?? '');

    if($operation_check === "ADD_USER"){

        try{
            //Error Handles
            $errors = [];
        
            if(is_input_empty($username, $pword, $fname, $lname) === true){
                $errors["empty_input"]="Fill all the fields";
            }

            if(empty($errors)){
                if(!check_pword_match($pword, $pword2)){
                   $errors["password_mismatch"]="Password did not match.";
                }
            }
        
            if(empty($errors)){
                if(is_username_taken($pdo,  $username)){
                    $errors["username_taken"]="Username already taken!";
                }
            }

            if(empty($errors)){
                $hashed_password = password_hash($pword, PASSWORD_DEFAULT);
            }
                
            if(empty($errors)){
                if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == UPLOAD_ERR_OK){
                    try{

                        $img_filename = uploadImageFile("image_file", "img/users_img/");

                        update_profile_pic($pdo ,$img_filename, $user_id);

                    }catch(Exception $e){
                        $errors["image_upload_error"]="Error Uploading Image: ".$e->getMessage();
                    }
                }else if(isset($_POST['captureImageData'])){
                    try{
                        $img_filename = captureImageUpload('captureImageData',"img/users_img/");
                     }catch(Exception $e){
                         echo json_encode(["success" => false, "message" => $e->getMessage()]);
                         die();
                     }
                }
            }

            if(empty($errors)){
                try{
                    record_user($pdo ,$current_user,$username, $hashed_password, $fname ,$mname, $lname ,$suffix, $dept, $img_filename);
                    echo json_encode(["success" => true, "message" => "User Added Successfully"]);

                }catch(Exception $e){
                    $errors["db_error"]="Error Adding User: ".$e->getMessage();

                }
            }

            if($errors){
                foreach ($errors as $error){
                    echo json_encode(["success" => false, "message" => $error]);
                }
                die();
            }


            
        
        }catch(PDOException $e){
            die(json_encode(["success" => false, "message" => "Operation Failed: ". $e->getMessage()]));
        }

    }else if ($operation_check =="EDIT_USER") {

        try{ 
            //Error Handles
            $errors = [];
        
            if(is_input_empty($username, $pword, $fname, $lname) === true){
                $errors["empty_input"]="Fill all the fields";
            }

            if(empty($errors)){
                if(!check_pword_match($pword, $pword2)){

                    $errors["password_mismatch"]="Password did not match.";

                }
            }
        
            // if(empty($errors)){
            //     if(is_username_taken($pdo,  $username)){
            //         $errors["username_taken"]="Username already taken!";
            //     }
            // }

            if(empty($errors)){
                $hashed_password = password_hash($pword, PASSWORD_DEFAULT);
            }

            if(empty($errors)){
                if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == UPLOAD_ERR_OK){
                    try{

                        $img_filename = uploadImageFile("image_file", "img/users_img/");

                        update_profile_pic($pdo ,$img_filename, $user_id);

                    }catch(Exception $e){
                        $errors["image_upload_error"]="Error Uploading Image: ".$e->getMessage();
                
                    }
                }else if(isset($_POST['captureImageData'])){
                    try{
                        $img_filename = captureImageUpload('captureImageData',"img/users_img/");

                        update_profile_pic($pdo ,$img_filename, $user_id);

                     }catch(Exception $e){
                         echo json_encode(["success" => false, "message" => $e->getMessage()]);
                         die();
                     }
                }
            }

            if(empty($errors)){
                try{

                    update_user($pdo ,$username, $hashed_password, $fname ,$mname, $lname ,$suffix, $dept, $user_id, $current_user);
                    echo json_encode(["success" => true, "message" => "User Edited Successfully"]);

                }catch(Exception $errors){

                    echo json_encode(["success" => false, "message" => "There is an DB error: ".$errors->getMessage()]);
                    die();
                }
            }


            if($errors){
                echo json_encode(["success" => false, "message" => $errors]);
                die();
            }



            
        
        }catch(PDOException $e){
            die(json_encode(["success" => false, "message" => "Operation Failed: ". $e->getMessage()]));
        }


    }elseif($operation_check=="TABLE_LOAD"){
        $start_from = limit_main_table($_POST['pageno']?? 1);

        $sqlquery="SELECT * FROM vw_users WHERE is_deleted=0 LIMIT :start_from, 10";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
        $stmt->execute();
        $results=$stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'userstabletofetch.php';

    }else if($operation_check =="PAGINATION"){

        $total_records = $pdo->query("SELECT COUNT(*) FROM vw_users")->fetchColumn();

        $arrayofparams = limit_pagination($total_records, $_POST['pageno']); 

        $current_page = $arrayofparams['current_page'];
        $start_from = $arrayofparams['start_from'];
        $total_pages = $arrayofparams["total_pages"];

        require_once 'paginationtemplate.php';

    }else if($operation_check=="SHOW_DELETED"){

        $start_from = limit_main_table($pageno);

        $query = "SELECT * FROM vw_users WHERE is_deleted =1 ORDER BY created_dt DESC LIMIT :start_from, 10";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':start_from', (int)$start_from, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($results)){
            require_once'userstabletofetch.php';
        }else{
            echo '<tr><td colspan="11"><b>No Deleted Records found</b></td></tr>';
        }

    }else if($operation_check=="PAGINATION_FOR_DEL_REC"){

        $total_records = $pdo->query("SELECT COUNT(*) FROM vw_users WHERE is_deleted=1")->fetchColumn();

        $arrayofparams = limit_pagination($total_records, $pageno); 

        $current_page = $arrayofparams['current_page'];
        $start_from = $arrayofparams['start_from'];
        $total_pages = $arrayofparams["total_pages"];

        require_once 'paginationtemplate.php';

    }else if($operation_check=="SEARCH"){

        $start_from = limit_main_table($_POST['pageno']);

        echo $start_from;
    
        $search = sanitizeData($_POST['search'])?? '';
    
        $results = search($pdo, $search, $start_from,0);
    
        if(empty($results)){
    
            echo '<td colspan="6"><b>No users found.</b></td>';
    
        }else{
            require_once 'userstabletofetch.php';
        }
    }else if($operation_check=="SEARCH_PAGINATION"){
    
        $start = limit_main_table($_POST['pageno']);
    
        $total_records = count(search($pdo, $search,0 ,0));

        $arrayofparams = limit_pagination($total_records, $_POST['pageno']); 

        $current_page = $arrayofparams['current_page'];
        $start_from = $arrayofparams['start_from'];
        $total_pages = $arrayofparams["total_pages"];
    
        if(empty($result)){
    
        }else{
            require_once 'paginationtemplate.php';
        }
    }else if($operation_check=="DELETED_SEARCH"){

        $start_from = limit_main_table($_POST['pageno']);

        echo $start_from;
    
        $search = sanitizeData($_POST['search'])?? '';
    
        $results = search($pdo, $search, $start_from, 1);
    
        if(empty($results)){
    
            echo '<td colspan="6"><b>No users found.</b></td>';
    
        }else{
            require_once 'userstabletofetch.php';
        }
    }else if($operation_check=="SEARCH_DELETED_PAGINATION"){
    
        $search = sanitizeData($_POST['search'])?? '';
        $start = limit_main_table($_POST['pageno']);
    
        $total_records = count(search($pdo, $search,0,1 ));

        $arrayofparams = limit_pagination($total_records, $_POST['pageno']); 

        $current_page = $arrayofparams['current_page'];
        $start_from = $arrayofparams['start_from'];
        $total_pages = $arrayofparams["total_pages"];
    
        if(empty($result)){
    
        }else{
            require_once 'paginationtemplate.php';
        }
    }else if($operation_check=="DELETE_USER"){

        try{

            try{
                add_audit_trail($pdo, $operation_check, $current_user, $user_id);
            }catch(Exception $e){
                die(json_encode(["success" => false , "message" => "Audit Trail entry failed :".$e->getMessage()]));
            }

            $pdo->beginTransaction();
            
            $deletequery="UPDATE tbl_users SET isdeleted=1 WHERE user_id=?";
            $stmt=$pdo->prepare($deletequery);
            $stmt->execute([$user_id]);

            $pdo->commit();
            echo json_encode(["success" => true, "message" => "User Deleted Successfully"]);


        }catch(Exception $e){
            $pdo->rollBack();
            echo json_encode(["success" => false, "message" => "Error deleting user: " . $e->getMessage()]);

        }
    }else if($operation_check=="RECOVER_USER"){

        try{

            try{
                add_audit_trail($pdo, $operation_check, $current_user, $user_id);
            }catch(Exception $e){
                die(json_encode(["success" => false , "message" => "Audit Trail entry failed :".$e->getMessage()]));
            }

            $pdo->beginTransaction();
            
            $deletequery="UPDATE tbl_users SET isdeleted=0 WHERE user_id=?";
            $stmt=$pdo->prepare($deletequery);
            $stmt->execute([$user_id]);

            $pdo->commit();
            echo json_encode(["success" => true, "message" => "User Deleted Successfully"]);


        }catch(Exception $e){
            $pdo->rollBack();
            echo json_encode(["success" => false, "message" => "Error deleting user: " . $e->getMessage()]);

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

<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $username = $_POST['username'];
    $password = $_POST['password']; 
    
    try{

        require_once 'connecttodb.php';
        require_once 'login-model.php';
        require_once 'login-ctrl.php';

        //Error handles
        $errors=[];

        if(is_input_empty($username, $pwd)){
            $errors['invalid_email']="Fill in all fields!";
        }
     
        $result = get_user($pdo, $username);

        if(is_username_wrong($result)){
            $errors["login_incorrect"] = "Incorect login info!";
        }
        if(!is_username_wrong($result) && is_password_wrong($pwd, $result['pwd'])){
            $errors["login_incorrect"] = "Incorect login info!";
        }

        require_once 'config.php';

        if($errors){
            $_SESSION["errors_signup"] = $errors;

            header("Location: ../index.php");
            die();
        }

        $newSessionId = session_create_id();
        $sessionID = $newSessionId . "_" . $result["id"];
        session_id($sessionID);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars( $result["username"]);

        $_SESSION['last_renergeration'] = time(); 
        header("Location: ..index.php");

        $pdo=null;
        $statement=null;
        die();

    }catch(PDOException $e){
        
        die("Query Failed: " . $e->getMessage());

    }
}else{
    echo "Access Denied";
    header("Location: ../index.php");
    die();
}
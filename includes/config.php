<?php
if(!$_SERVER['REQUEST_METHOD'] !== "POST"){
    header('Location: index.php');
}

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 3600,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();

if(isset($_SESSION["user_id"])){
    if(!isset($_SESSION['last_regeneration'])){
        regenerate_session_id_loggedin();
    }else{
        $interval = 60 * 30;
        if(time() - $_SESSION['last_regeneration']>=$interval){
            regenerate_session_id();
        }
    }

}else{
    if(!isset($_SESSION['last_regeneration'])){
        regenerate_session_id();
    }else{
        $interval = 60 * 30;
        if(time() - $_SESSION['last_regeneration']>=$interval){
            regenerate_session_id();
        }
    }

}

session_regenerate_id(true);

function regenerate_session_id_loggedin(){
    session_regenerate_id(true);

    $userID= $_SESSION["user_id"];
    $newSessionId = session_create_id();
    $sessionID = $newSessionId . "_" . $userID;
    session_id($sessionID);

    $_SESSION['last_renergeration'] = time(); 
}


function regenerate_session_id(){
    session_regenerate_id(true);
    $_SESSION['last_renergeration'] = time(); 
}


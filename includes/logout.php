<?php

session_start();

require_once 'login_model.inc.php';
require_once 'connecttodb.php';

if(!mark_as_active($pdo, $_SESSION['user_id'], 0)){
    echo "User not mark as Active";
    die();
    
}

$_SESSION=[];
session_destroy();
session_write_close();
setcookie(session_name(), '', time()-3600, '/');

header("Location: ../login.php?logout=success");
die();
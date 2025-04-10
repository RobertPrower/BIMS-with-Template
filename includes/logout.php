<?php

session_start();

require_once 'connecttodb.php';
require_once 'login_model.inc.php';


if (isset($_SESSION['user_id']) && is_int($_SESSION['user_id'])) {
    if (!mark_as_active($pdo, $_SESSION['user_id'], 0)) {
        echo "User not marked as inactive";
        exit(); 
    }
}

$_SESSION=[];
session_destroy();
session_write_close();
setcookie(session_name(), '', time()-3600, '/');

header("Location: ../login.php?logout=success");
die();
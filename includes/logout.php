<?php

session_start();

$_SESSION=[];
session_destroy();
session_write_close();
setcookie(session_name(), '', time()-3600, '/');

header("Location: ../login.php?logout=success");
die();
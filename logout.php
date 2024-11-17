<?php

session_start();
session_unset(); // This removes all session variables
session_destroy(); // Destroy the session

header(header: "signin.php");
exit;

?>
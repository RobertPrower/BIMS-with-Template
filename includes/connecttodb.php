<?php

/*$host = "localhost";
$username = "root";
$password = "";
$database = "bims";

// Create DB Connection
$con = new mysqli($host, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}*/

$host = "localhost";
$dbase = "bims";
$uname = "root";
$pword = "";
$dsn = "mysql:host={$host};dbname={$dbase}";

try {
    $pdo = new PDO($dsn, $uname, $pword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exceptions
} catch(PDOException $err) {
    echo $err->getMessage();
    die(); // Terminate script on connection error
}
?>
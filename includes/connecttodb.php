<?php

$host = "localhost";
$dbase = "bims";
$uname = "root";
$pword = "";
$dsn = "mysql:host={$host};dbname={$dbase}; charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $uname, $pword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch(PDOException $err) {
    echo $err->getMessage();
    die(); 
}
?>
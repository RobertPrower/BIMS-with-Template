<?php
declare(strict_types=1);

function get_user(object $pdo, string $username){

    $stmt = $pdo->prepare("SELECT * FROM tbl_username WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $result = $stmt -> fetch(PDO::FETCH_ASSOC);

    return $result;

}
<?php

declare(strict_types=1);


function get_user(object $pdo, string $username){
    $query = "SELECT tbl_username.username_id, tbl_username.`username`, tbl_users.`pword`, tbl_users.depart_no, tbl_users.img_filename
                FROM tbl_username
                JOIN tbl_users ON tbl_users.`username_no` = tbl_username.`username_id`
                WHERE tbl_username.`username` = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt -> execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}


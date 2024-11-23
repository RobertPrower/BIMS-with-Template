<?php

declare(strict_types=1);


function get_user(object $pdo, string $username){
    $query = "SELECT tbl_username.username_id, tbl_username.`username`, tbl_users.`pword`, tbl_users.depart_no, tbl_users.img_filename
                FROM tbl_username
                JOIN tbl_users ON tbl_users.`username_no` = tbl_username.`username_id`
                WHERE BINARY tbl_username.`username` = :username LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt -> execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function mark_as_active(object $pdo, int $user_id, int $whatop){
    if($whatop == 1){
        $query = "UPDATE tbl_users SET isactive = 1 WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt -> execute();
        return true;
    }else if($whatop == 0){
        $query = "UPDATE tbl_users SET isactive = 0 WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt -> execute();
        return true;
    }else{
        return false;
    }

}


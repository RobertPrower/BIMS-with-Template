<?php

declare(strict_types=1);

function get_username(object $pdo, string $username){
    $query = "SELECT username  FROM tbl_username WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt -> execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function record_user($pdo, $username, $password, $fname, $mname, $lname, $suffix, $dept, $img_filename){

    try{
        $pdo->beginTransaction();

        $query="INSERT INTO tbl_username(username) VALUES(?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);

        $query="INSERT INTO tbl_users(pword, depart_no, fname, lname, mname, suffix, img_filename) VALUES(?,?,?,?,?,?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$password, $dept, $fname, $lname, $mname, $suffix, $img_filename]);

        $pdo->commit();

        return true;
    }catch(Exception $e){
        $pdo->rollback();
        return throw new Exception("There is an error on db query: ".$e->getMessage());

    }



}






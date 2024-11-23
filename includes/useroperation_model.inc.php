<?php

declare(strict_types=1);

function get_username(object $pdo, string $username){
    $query = "SELECT username  FROM tbl_username WHERE BINARY username = :username;";
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

function add_audit_trail($pdo, $whatop, $current_user, $user_id){

    if($whatop == "ADD_USER"){
        try{
            $pdo ->beginTransaction();
            $audit_query = "UPDATE tbl_users_audit_trail SET created_by=?, created_dt = CURRENT_TIMESTAMP WHERE user_at_id=?";
            $stmt = $pdo->prepare($audit_query);
            $stmt->execute([$current_user, $user_id]);
            $pdo->commit();
            return true;

        }catch(Exception $e){
            $pdo->rollback();
            return throw new Exception("There is an error on db query: ".$e->getMessage());

        }
    }else if($whatop == "DELETE_USER"){

        try{
            $pdo ->beginTransaction();
            $audit_query = "UPDATE tbl_users_audit_trail SET deleted_by=?, deleted_dt = CURRENT_TIMESTAMP WHERE user_at_id=?";
            $stmt = $pdo->prepare($audit_query);
            $stmt->execute([$current_user, $user_id]);
            $pdo->commit();
            return true;

        }catch(Exception $e){
            $pdo->rollback();
            return throw new Exception("There is an error on db query: ".$e->getMessage());

        }
    
    }else if($whatop == "RECOVER_USER"){

        try{
            $pdo ->beginTransaction();
            $audit_query = "UPDATE tbl_users_audit_trail SET deleted_by=?, deleted_dt = CURRENT_TIMESTAMP WHERE user_at_id=?";
            $stmt = $pdo->prepare($audit_query);
            $stmt->execute([$current_user, $user_id]);
            $pdo->commit();
            return true;

        }catch(Exception $e){
            $pdo->rollback();
            return throw new Exception("There is an error on db query: ".$e->getMessage());

        }
    
    }else if($whatop =="EDIT_USER"){

        try{
            $pdo ->beginTransaction();
            $audit_query = "UPDATE tbl_users_audit_trail SET last_edited_by=?, last_edited_dt = CURRENT_TIMESTAMP WHERE user_at_id=?";
            $stmt = $pdo->prepare($audit_query);
            $stmt->execute([$current_user, $user_id]);
            $pdo->commit();
            return true;

        }catch(Exception $e){
            $pdo->rollback();
            return throw new Exception("There is an error on db query: ".$e->getMessage());

        }

    }

}

function delete_restore_action($pdo, $whatop, $current_user){
      
    if($whatop=="DELETE_USER"){
        $marker = 1;
    }else{
        $marker = 0;
    }
    $deletequery="UPDATE tbl_users SET isdeleted=? WHERE user_id=?";
    $stmt=$pdo->prepare($deletequery);
    $stmt->execute([$current_user]);
}

function search($pdo, $search, $start_from,$is_deleted){
    $searchquery ="CALL SearchUsers(?,?,?)";
    $stmt = $pdo->prepare($searchquery);
    $stmt->execute([$search, $start_from,$is_deleted]);
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}






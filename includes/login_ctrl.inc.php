<?php 

declare(strict_types=1);

function is_input_empty(string $username,string $password){
    if (empty($username) || empty($password)) {
        return true;
    }else{
        return false;
    }
}

function is_username_wrong(array|false $result){
    
    return $result === false;

}

function is_password_wrong(string $pwd, string $hashedPwd){
    
    return !password_verify($pwd, $hashedPwd);
  
}


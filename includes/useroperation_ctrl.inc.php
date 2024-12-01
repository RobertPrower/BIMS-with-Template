<?php

declare(strict_types=1);

// function is_input_empty(string $uname, string $password, string $fullname, string $lastname){

//     if(empty($uname) || empty($password) || empty($fullname) || empty($lastname)){
//         return true;
//     }else{
//         return false;
//     }
// }

function check_pword_match($pword, $pword2){
    if($pword == $pword2){
        return true;
    }else{
        return false;
    }
}
function is_username_taken($pdo, string $username){

    if(get_username($pdo,$username)){
        return true;
    }else{
        return false;
    }

}




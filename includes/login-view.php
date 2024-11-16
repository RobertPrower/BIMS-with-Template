<?php

declare(strict_types=1);

function check_login_errors(){
    if(isset($_SESSION["error_login"])){

        $errors = $_SESSION["errors_signup"];

        foreach($errors as $key => $error){
            echo '<p>'.$error.'</p>';
        }
        unset($_SESSION['errors_login']);
    }else if(isset($_GET['login']) && $_GET['login'] === "success"){

        

    }
};



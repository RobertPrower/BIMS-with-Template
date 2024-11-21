<?php 

declare(strict_types=1);

function check_login_errors(){

    if(isset($_SESSION["errors_login"])){
        $errors = $_SESSION["errors_login"];
        
        echo "<br>";

        foreach($errors as $error){
            echo '<div class="d-flex justify-content-center align-item-center mb-4"><span class="badge rounded-pill text-bg-danger">' .$error.'</span></div>';
        }

        unset($_SESSION['errors_login']);
    }
}
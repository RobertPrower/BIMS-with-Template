<?php 

if(!isset($_SESSION['user_id'])){

    header('Location: login.php?error=not_logged_in');

}

$departmentno = $_SESSION["depart_no"];

if($departmentno == 1){
    $dept = "Clearance";
}else if($departmentno ==2){
    $dept = "Secretariant";
}else if($departmentno ==3){
    $dept = "Lupon";
}else if($departmentno ==4){
    $dept = "Admin";
}


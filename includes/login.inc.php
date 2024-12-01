<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        require_once 'connecttodb.php';
        require_once 'login_model.inc.php';
        require_once 'login_ctrl.inc.php';

        session_start();

        $username = htmlspecialchars(trim($_POST["username"] ?? ''), ENT_QUOTES, 'UTF-8');
        $pword = htmlspecialchars(trim($_POST["pword"] ?? ''), ENT_QUOTES, 'UTF-8');
        $ip_add = $_SERVER['REMOTE_ADDR'];

        $errors = [];

        if (is_input_empty($username, $pword)) {
            $errors["empty_input"] = "Fill all the fields.";
        }

        try {
            $result = get_user($pdo, $username);
        } catch (Exception $e) {
            $errors["username"] = $e->getMessage();
        }
        
        if (empty($errors)) {
            $lockout_data = is_locked_out($pdo, $ip_add, $username);
            if ($lockout_data['locked']) {
                $remaining_time = (strtotime($lockout_data['lockout_until']) - time()) / 60;
                $errors["lockout"] = "You are locked out. Try again in " . ceil($remaining_time) . " minutes.";
            } elseif (!$result || is_username_wrong($result)) {
                $errors["wrong_username"] = "Username or Password is Incorrect!";
            } elseif (is_password_wrong($pword, $result["pword"])) {
                $errors["wrong_password"] = "Username or Password is Incorrect!";
                log_failed_attempt($pdo, $ip_add, $username);
            }
        }

        if(empty($errors)){
            try{
                reset_lockout($pdo, $ip_add, $username);
            }catch(Exception $e){

                $errors['reset_lock'] = "DB errror";

            }
        }
        
        if (!empty($errors)) {
            $_SESSION["errors_login"] = $errors;
            session_write_close();
            header("Location: ../login.php");
            exit();
        }

        session_regenerate_id(true);

        $_SESSION["user_id"] = $result["username_id"];
        $_SESSION["username"] = $result["username"];
        $_SESSION["depart_no"] = $result["depart_no"];
        $_SESSION["profile_pic"] = $result["img_filename"];
        $_SESSION["last_regeneration"] = time();

        if (!mark_as_active($pdo, $result['username_id'], 1)) {
            throw new Exception("Failed to mark user as active.");
        }

        $pdo = null;
        header("Location: ../index.php?login=success");
        exit();

    } catch (PDOException $e) {
        die(json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]));
    } catch (Exception $e) {
        die(json_encode(["success" => false, "message" => $e->getMessage()]));
    }
       
} else {
    header("Location: ../login.php");
    exit();
}
?>
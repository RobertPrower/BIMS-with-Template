<?php
// In your POST request handler
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        require_once 'connecttodb.php';
        require_once 'login_model.inc.php';
        require_once 'login_ctrl.inc.php';

        $username = trim($_POST["username"] ?? '');
        $pword = trim($_POST["pword"] ?? '');
       
        // Error Handles
        $errors = [];
    
        if (is_input_empty($username, $pword)) {
            $errors["empty_input"] = "Fill all the fields";
        }

        $result = get_user($pdo, $username);

        if (is_username_wrong($result)) {
            $errors["wrong_username"] = "Incorrect Login Info";
        }

        if (!is_username_wrong($result) && is_password_wrong($pword, $result["pword"])) {
            $errors["wrong_password"] = "Password is incorrect";
        }

       // require_once 'config.php';

        session_start();
    
        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            session_write_close();  // Ensure session data is saved before redirect
            header("Location: ../login.php");
            die();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["username_id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["username_id"];
        $_SESSION["username"] = htmlspecialchars($result["username"]);
        $_SESSION["depart_no"] = $result["depart_no"];
        $_SESSION["profile_pic"]=$result["img_filename"];
        $_SESSION["last_regeneration"] = time();

        header("Location: ../index.php?login=success");
        $pdo = null;
        $stmt = null;

        die();

    } catch (PDOException $e) {
        die(json_encode(["success" => false, "message" => "Operation Failed: " . $e->getMessage()]));
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
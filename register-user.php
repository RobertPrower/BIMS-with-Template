<?php

include "connecttodb.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password before storing in DB
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL statement for inserting new user
    $stmt = $pdo->prepare("INSERT INTO tbl_user_signin (username, password, role) VALUES (:username, :password, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':role', $role);
    $stmt->execute();

    echo "Registration Successful!";

    // if ($stmt->execute()) {
    //     echo "User successfully registered!";
    // } else {
    //     echo "Error: " . $stmt->error;
    // }

    // $stmt->close();
    // $conn->close();
}
?>
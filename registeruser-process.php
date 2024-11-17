<?php

include("connecttodb.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password before storing in DB
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL statement for inserting new user
    $sql = "INSERT INTO tbl_user_signin (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $hashed_password, $role); // s = string

    if ($stmt->execute()) {
        echo "User successfully registered!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
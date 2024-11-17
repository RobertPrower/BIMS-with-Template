<?php

if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Admin, user, or secretariat

    // Password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL to insert the user into the db
    $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if($stmt) {
        // Bind parameters to prevent SQL Injection
        mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $role);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Registration successful!";
            header("Location: signin.php");
            exit;
        } else {
            echo "Error: Could not execute query.";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Could not prepare query.";
    }
}

?>
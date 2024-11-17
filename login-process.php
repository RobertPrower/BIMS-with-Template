<?php

session_start();
include('connecttodb.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize the input
    $username = mysqli_real_escape_string($conn, $username);

    // SQL statement to fetch user details based on the username
    $sql = "SELECT * FROM tbl_user_signin WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // s = string
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    
}
<?php

session_start();
require 'includes/connecttodb.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: signin.php");
  exit();
}

$user_role = $_SESSION['user_role'];

if ($user_role != 'admin' && $user_role != 'secretariat' && $user_role != 'user') {
  echo "Access Denied.";
  exit();
}

// Fetch and display user data
$stmt = $pdo->prepare("SELECT & FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?php

require_once('includes/connecttodb.php');
session_start();

// Check the user role and set permissions
function hasPermission($requiredRole)
{
  return $_SESSION['role_name'] === $requiredRole;
}

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT u.user_id, u.username, r.role_name
          FROM users u
          JOIN roles r ON u.role_id = r.role_id
          WHERE u.username = ?";

$stmt = $pdo->prepare($query);
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
  $_SESSION['user_id'] = $user['user_id'];
  $_SESSION['username'] = $user['username'];
  $_SESSION['role_name'] = $user['role_name'];

  header("Location: dashboard.php");

} else {
  echo "Invalid log-in credentials.";
}

if (hasPermission('Admin')) {
  // Show edit and delete buttons
  echo '<button>Edit</button>';
  echo '<button>Delete</button>';
} elseif (hasPermission('Secretariat')) {
  // Only viewing permissions
  echo "You have view-only permissions.";
}

?>
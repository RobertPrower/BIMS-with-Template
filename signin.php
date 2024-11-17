<?php 
// require_once 'includes/config.php';
// require_once 'includes/login-view.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BIMS | Log In</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/Brgy177.png" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">
</head>

<!-- Hindi ko alam saan ilalagay bert nyahaha :( -->

<?php
  
  session_start();
  if (isset($_SESSION['username'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      // Prepare and bind parameters to prevent SQL Injection
      $query = "SELECT * FROM user_signin WHERE username = ?";
      $stmt = mysqli_prepare($conn, query);

      if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username); // "s" means string paramater
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // If a user with that username exists..
        if ($user = mysqli_fetch_assoc($result)) {
          // Verifying the password
          if (password_verify($password, $user['password'])) {
            // If correct then start session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'admin') {
              header("Location: admin.php");
            } elseif ($user['role'] == 'users') {
              header("Location: users.php");
            } elseif ($user['role'] == 'secretariat') {
              header("Location: secretariat.php");
            } else {
              header("Location: signin.php");
            }
              exit;
          } else {
            // Invalid password
              echo "Invalid username or password.";
          }
        } else {
            // User does not exist
              echo "User does not exist."
        }
          mysqli_stmt_close($stmt);
          }
        }


        // This checks if user is logged in
        if (!isset($_SESSION['user_id'])) {
          header("Location: signin.php");
          exit;
        }

        // Checks if user has the appropriate role
        if ($_SESSION['role'] == 'admin') {
          echo "<h1> Admin Dashboard </h1>";
          echo "<p>Welcome, " . $_SESSION['username'] . "!</p>";
          // Have access to view/edit/delete (Admins only)
        } elseif ($_SESSION['role'] == 'secretariat') {----------------
          echo "<h1>Secretariat Dashboard</h1>";
          echo "<p> Welcome, " . $_SESSION['username'] . "!</p>";
        } elseif ($_SESSION['role'] == 'user') {
          echo "<h1>User Dashboard</h1>";
          echo "<p> Welcome, " . $_SESSION['username'] . "!</p>";
        } else {
          // Unauthorized access..
          echo "Access Denied.";
          exit;
        } 

?>

<body class="login_background">
  <div class="layer"></div>
<main class="page-center">
  <article class="sign-up">
    <div class="imgcontainer">
      <img src="img/Brgy177.png" alt="Avatar" class="img" width="200" height="200">
    </div>
    <h1 class="sign-up__title">Welcome back!</h1>
    <p class="sign-up__subtitle">Sign in to your account to continue</p>
      <form class="sign-up-form form" action="includes/login.php" method="POST">
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="floatingInput" name="username" placeholder="name@example.com" required>
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
          <label for="floatingPassword">Password</label>
        </div>
        <!-- <a class="link-info forget-link" href="##">Forgot your password?</a> -->
        <br>
        <label class="form-checkbox-wrapper">
          <input class="form-checkbox" type="checkbox">
          <span class="form-checkbox-label">Remember me next time</span>
        </label>
        <button class="form-btn primary-default-btn transparent-btn">Sign in</button>
      </form>
  </article>
</main>
<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
</body>

</html>
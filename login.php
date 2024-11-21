<?php

require_once 'includes/login_view.inc.php';
require_once 'includes/config.php';

if(isset($_SESSION['user_id'])){

  header("Location: index.php");

}


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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">
</head>

<body class="login_background">
  <div class="layer"></div>
  <main class="page-center">
    <article class="sign-up">
      <div class="imgcontainer">
        <img src="img/Brgy177.png" alt="Avatar" class="img" width="200" height="200">
      </div>
      <h1 class="sign-up__title">Welcome back!</h1>
      <p class="sign-up__subtitle">Sign in to your account to continue</p>
      <form class="sign-up-form form" action="includes/login.inc.php" method="POST">
        <div class="form-floating mb-3">
          <input type="text" class="form-control is_invalid" id="floatingInput" name="username" placeholder="name@example.com"
            required>
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" name="pword" placeholder="Password"
            required>
          <label for="floatingPassword">Password</label>
        </div>
        <!-- <a class="link-info forget-link" href="##">Forgot your password?</a> -->

        <?php check_login_errors();
        
        if(isset($_GET['error']) && $_GET['error'] === "not_logged_in"){

          echo '<br><div class="d-flex justify-content-center align-item-center mb-4"><span class="badge rounded-pill text-bg-danger">Please Sign In First!</span></div>';

        
        }?>

        <label class="form-checkbox-wrapper">
          <input class="form-checkbox" type="checkbox">
          <span class="form-checkbox-label">Remember me next time</span>
        </label>


        <button class="form-btn primary-default-btn transparent-btn">Sign in</button>
      </form>
    </article>
  </main>
  <!-- Chart library -->
   <script src="js/sweetalert2.min.js"></script>
  <script src="./plugins/chart.min.js"></script>
  <!-- Icons library -->
  <script src="plugins/feather.min.js"></script>
  <!-- Custom scripts -->
  <script src="js/script.js"></script>
</body>

</html>
<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="CSS/loginstyle.css">
        <script src="bootstrap.js"></script>

    <title>Barangay 177 - BIMS</title>
    </head>
<body>
<?php
session_start(); // Start the session

// Check if an error occurred
if (isset($_GET['error']) && $_GET['error'] == 1) {
    echo '<script> alert("Username or password incorrect"); </script>';
}
?>
<main>
  <form action="connecttologin.php" method="post">
  
  <div class="imgcontainer">
    <img src="img_avatar2.png" alt="Avatar" class="img">
    

  </div>

  <div class ="syslabel">
  
  <label><b>Barangay Information Management System </b></label>

  </div>


  <div class="container">
    
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
        
    <button type="submit" value="login"> Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
   
  </div>

  

  
  </form>
</main>    
</body>
</html>
<?php
require_once('includes/connecttodb.php');
require_once 'includes/config.php';
require_once 'includes/enforce_login.php';

if ($_SESSION['depart_no'] == 4|| $_SESSION['depart_no'] == 5 || $_SESSION['depart_no'] == 3) {
    
}else{
    header('Location: index.php');
    exit;
}  

$logoquery = "SELECT `filename` FROM `certificate-img` WHERE purpose = 'Barangay Logo'";
$logostmt = $pdo->prepare($logoquery);
$logostmt->execute();
$logo = $logostmt->fetchColumn();
$pdo = null; // Close DB

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blotters | BIMS</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/logos/<?php echo $logo; ?>" type="image/x-icon">
    <!-- Custom styles -->
    <link href="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.css" rel="stylesheet">
    <link href="css/sweetalert2.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <div class="layer"></div>
    <!-- ! Body -->
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">
        <!-- ! Sidebar -->

        <?php
        include("includes/sidebar.php");
        ?>

        <div class="main-wrapper">

            <!-- ! Main nav/Header -->
            <?php require_once("includes/header.php") ?>
            <!-- ! Main -->
            <main>
                <div class="container">
                    <div class="container p-3">
                        <h2 class="main-title">Manage Blotter Schedule</h2>
                        <div class="row pb-3">
                            <div class="container col-md-12">    
                                <?php 
                                
                                require_once 'includes/blotterviewmodal.php';
                                require_once 'includes/residentviewform.php';
                                require_once 'includes/nonresidentviewform.php';
                                
                                ?>                          
                              <div class="form-check form-switch my-2">
                                  <input class="form-check-input" type="checkbox" id="showpastdates">
                                  <label class="form-check-label" for="showpastdates">Show Past Schedules</label>
                              </div>
                            </div>
                        </div>

                        <div class="calendar-container">
                            <div class="" id="calendar">
                            
                            </div>
                        </div>
                           
                    </div>
            </main>

            <!-- ! Footer -->
            <?php require_once("includes/footer.php") ?>

        </div>
    </div>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.11/dist/js/tempus-dominus.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha256-BRqBN7dYgABqtY9Hd4ynE+1slnEw+roEPFzQ7TRRfcg=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.11/dist/js/jQuery-provider.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="js/sweetalert2.min.js"></script>
    <script src="js/blotters-schedule.js"></script>
    <script src="js/residentviewmodal.js"></script>
    <script src="js/nonresidentviewmodal.js"></script>
    <script src="js/selectresnonresmodal.js"></script>


    <!-- Icons library -->
    <script src="plugins/feather.min.js"></script>
    <!-- Custom scripts -->
    <script src="js/script.js"></script>
    <script src="js/sidebar.js"></script>



</body>

</html>
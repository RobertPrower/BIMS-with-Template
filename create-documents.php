<?php 
    require_once('includes/connecttodb.php');
    $logoquery = "SELECT `filename` FROM `certificate-img` WHERE purpose = 'Barangay Logo'";
    $logostmt = $pdo->prepare($logoquery);
    $logostmt -> execute();
    $logo = $logostmt -> fetchColumn(); 

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Certificates</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="img/logos/<?php echo $logo; ?>" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/create-documents.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!--JavaScript-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
  <div class="layer"></div>
<!-- ! Body -->
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">
  <!-- ! Sidebar -->

  <?php
  include ("includes/sidebar.php");
  ?>

  <div class="main-wrapper">
    <!-- ! Main nav -->

    <?php require_once("includes/header.php")?>

    <!-- ! Main -->
    <main class="main users chart-page" id="skip-target">
      <div class="container">
        <h2 class="main-title">Create Certificates</h2>
        <div class="row container">
          <style>

              .btn-for-docu:hover {
                background-color: #CED8FF;
                opacity: 50;
                padding: 0.5rem 1rem;
                border: solid;
                border-color: black;
                border-radius: 20px;
                cursor: pointer;
                transition: background-color 0.2s ease;
                
              }
          </style>

          <div class="col-md-6 col-xl-3">
            <a class="stat-cards-item btn-for-docu">
              <div class="stat-cards-icon primary" id="btnBrgyIDreq">
                <i data-feather="bar-chart-2" aria-hidden="true">
                </i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Barangay ID request</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-xl-3">
            <a class="stat-cards-item btn-for-docu">
              <div class="stat-cards-icon warning">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Barangay Clearances</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-xl-3">
            <a class="stat-cards-item btn-for-docu" href="create-certificate-of-residency.php">
              <div class="stat-cards-icon purple">
                <i data-feather="home" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Residency</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-xl-3">
            <a href="create-certificate-of-good-moral.php" class="btn-for-docu stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Indigency</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-xl-3">
            <a href="create-certificate-of-good-moral.php" class="btn-for-docu stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Good Moral</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-xl-3">
            <a href="create-certificate-of-good-moral.php" class="btn-for-docu stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Oath of Undertaking</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-xl-3">
            <a href="create-certificate-of-good-moral.php" class="btn-for-docu stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">First-Time-Job-Seeker</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-xl-3">
            <a href="certificate-settings.php" class="btn-for-docu stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Settings</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </a>
          </div>
        </div>
      </div>
      
    </main>

    <!-- ! Footer -->
  <?php require_once("includes/footer.php");
      $pdo = null;
      ?>
  </div>
</div>
<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
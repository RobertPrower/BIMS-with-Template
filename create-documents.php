<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link rel="stylesheet" href="./css/style.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
        <h2 class="main-title">Create Documents</h2>
        <div class="row container">
          <style>

              .btn-for-docu:hover {
                background-color: #C0C0C0;
                color: #fff;
                padding: 0.5rem 1rem;
                border: solid;
                border-color: black;
                border-radius: 20px;
                cursor: pointer;
                transition: background-color 0.2s ease;
                transform: rotateY(260deg);
                transition: transform 0.2s ease;
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
            <a class="stat-cards-item btn-for-docu">
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
            <article class="stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">New First-Time-Job-Seeker</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Good Moral</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </article>
          </div>
        </div>
      </div>
    </main>

    <!-- ! Footer -->
  <?php require_once("includes/footer.php")?>
  </div>
</div>
<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
</body>

</html>
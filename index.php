<?php
    require_once('includes/connecttodb.php');
    require_once 'includes/config.php';
    require_once 'includes/enforce_login.php' ;

    echo $departmentno;

    $logoquery = "SELECT `filename` FROM `certificate-img` WHERE purpose = 'Barangay Logo'";
    $logostmt = $pdo->prepare($logoquery);
    $logostmt -> execute();
    $logo = $logostmt -> fetchColumn(); 

    $sqlquery="SELECT COUNT(*) AS total FROM `tbl_docu_request`";
    $stmt= $pdo->prepare($sqlquery);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalcert=[];

    foreach($result as $total){

      $totalcert[] = $total['total'];

    }

    $sqlquery="SELECT COUNT(*) AS total FROM resident";
    $stmt= $pdo->prepare($sqlquery);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalresident=[];

    foreach($result as $total){

      $totalresident[] = $total['total'];

    }

    $query = "SELECT COUNT(*) AS total_users FROM tbl_users";
    $result = $pdo->query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $total_users = $row['total_users'];

    $countcertformonth = "SELECT COUNT(*)
      FROM (
          SELECT * 
          FROM vw_all_documents 
          WHERE MONTH(date_issued) = MONTH(CURDATE())
      ) AS subquery;
      )";
    $stmt = $pdo->prepare($countcertformonth);
    $stmt->execute();
    $totalcertforthemonth= $stmt->fetchColumn();

    $countpermitsformonth = "SELECT COUNT(*)
      FROM (
          SELECT * 
          FROM vw_all_documents 
          WHERE document_desc = 'Business Permits'
            OR document_desc = 'Building Permits' 
            OR document_desc = 'Fencing Permits' 
            OR document_desc = 'Excavation Permits' 
            OR document_desc = 'Tricycle Pedicab Regulatory Services'
      ) AS subquery;
      ";
    $stmt = $pdo->prepare($countpermitsformonth);
    $stmt->execute();
    $totalpermitsforthemonth= $stmt->fetchColumn();

    $countnonres = "SELECT COUNT(*)
      FROM (
          SELECT * 
          FROM non_resident
      ) AS subquery;
      ";
    $stmt = $pdo->prepare($countnonres);
    $stmt->execute();
    $totalnonres= $stmt->fetchColumn();

    $countblotters = "SELECT COUNT(*)
      FROM (
          SELECT * 
          FROM tbl_blotters
      ) AS subquery;
      ";
    $stmt = $pdo->prepare($countblotters);
    $stmt->execute();
    $totalblotters= $stmt->fetchColumn();

    $pdo = null;

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="img/logos/<?php echo $logo; ?>" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.min.css">
  <link rel="stylesheet" href="./css/sweetalert2.min.css">
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
        <h2 class="main-title">Dashboard</h2>
        <div class="row container">

          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon primary">
                <i data-feather="bar-chart-2" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num"><?php echo $totalcert[0];?></p>
                <p class="stat-cards-info__title">Total certificates</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon primary">
                <i data-feather="bar-chart-2" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num"><?php echo $totalcertforthemonth ?>
                <p class="stat-cards-info__title">Total certificates</p>
                <p class="stat-cards-info__title">for the month</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon warning">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num"><?php echo $totalpermitsforthemonth?></p>
                <p class="stat-cards-info__title">Total Permits</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="home" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num"><?php echo $totalresident[0];?></p>
                <p class="stat-cards-info__title">Total Residents</p>
                <p class="stat-cards-info__progress"></p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num"><?php echo $totalnonres?></p>
                <p class="stat-cards-info__title">Total Non Residents</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="user" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num"><?php echo $totalblotters ?></p>
                <p class="stat-cards-info__title">Total Blotters</p>
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
                <p class="stat-cards-info__num"><?php echo $total_users; ?></p>
                <p class="stat-cards-info__title">Total Users</p>
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

<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/sweetalert2.min.js"></script>
<script src="js/logout.js"></script>
<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
<script src="js/sidebar.js"></script>


</body>

</html>
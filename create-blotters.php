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
  <title>Create Blotter</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="img/logos/<?php echo $logo; ?>" type="image/x-icon">
  <!-- Custom styles -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/create-documents.css">
  <link rel="stylesheet" href="css/sweetalert2.min.css">

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
        <!-- ! Main nav/Header -->
        <?php require_once("includes/header.php")?>
        <!-- ! Main -->
        <main>

        <div class="container">
            <div class="container p-3">
            <h2 class="main-title">Create Blotter</h2>
                <?php require('includes/selectresidentmodal.php'); require('includes/selectnonresidentmodal.php');?> 

                <div class="col-md-12 d-flex align-items-center justify-content-between">
                    <b>Step 1: Select Complainant Person Record</b>
                    <div class="d-flex">
                        <button class="btn btn-primary mx-2 SelectResidentBtn" id="SelectResidentComplainant" data-whatparty="complainant">Select Resident</button>
                        <button class="btn btn-warning SelectNonResidentBtn" id="SelectNonResidentComplainant" data-whatparty="complainant">Select Non-Resident</button>
                    </div>
                </div>

                <div class="col-md-12 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;">
                    <div class="card-header">
                        Reporting Person/Complainant Details
                                         
                    </div>

                    <div class="text-center row">

                    <input type="text" class="form-control" id="checkresident" hidden>
                    <input type="text" class="form-control" id="id_to_record" hidden>

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="text" class="form-control" id="fname" name="firstname" placeholder="Enter First Name Here" required disabled/>
                        <label for="fname">First Name</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="text" class="form-control" id="mname" name="middlename" placeholder="Enter Middle Name Here" disabled/>
                        <label for="mname">Middle Name</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-2">
                        <input type="text" class="form-control" id="lname" name="lastname" placeholder="Enter Last Name Here" required disabled/>
                        <label for="lname">Last Name</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-2">
                        <input type="text" class="form-control" id="suffix" name="lastname" placeholder="Enter Last Name Here" required disabled/>
                        <label for="lname">Suffix</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-12">
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter Subdvision Here" disabled/>
                        <label for="subd">Complete Address</label>
                    </div>

                    
                    </div>
                </div>

                <div class="col-md-12 d-flex align-items-center justify-content-between">
                    <b>Step 2: Select Respondent Person Record</b>
                    <div class="d-flex">
                        <button class="btn btn-primary mx-2 SelectResidentBtnRes" id="SelectResident" data-whatparty="respondent">Select Resident</button>
                        <button class="btn btn-warning SelectNonResidentBtnRes" id="SelectNonResident" data-whatparty="respondent">Select Non-Resident</button>
                    </div>
                </div>

                <div class="col-md-12 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;">
                    <div class="card-header">
                        Respondent/Offender Details
                                         
                    </div>

                    <div class="text-center row">

                    <input type="text" class="form-control" id="checkresidentres" name="resident_no" hidden>
                    <input type="text" class="form-control" id="id_to_recordres" name="resident_no" hidden>

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="text" class="form-control" id="fnameres" name="firstname" placeholder="Enter First Name Here" required disabled/>
                        <label for="fname">First Name</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="text" class="form-control" id="mnameres" name="middlename" placeholder="Enter Middle Name Here" disabled/>
                        <label for="mname">Middle Name</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-2">
                        <input type="text" class="form-control" id="lnameres" name="lastname" placeholder="Enter Last Name Here" required disabled/>
                        <label for="lname">Last Name</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-2">
                        <input type="text" class="form-control" id="suffixres" name="lastname" placeholder="Enter Last Name Here" required disabled/>
                        <label for="lname">Suffix</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-12">
                        <input type="text" class="form-control" id="addressres" name="address" placeholder="Enter Subdvision Here" disabled/>
                        <label for="subd">Complete Address</label>
                    </div>

                    
                    </div>
                </div>

          <div class="col-md-12 d-flex justify-content-end">

          <br>

          <button type="submit" id="generate_certificate" class="btn btn-success float-right"> Add Blotter </button> 
          </div>
                
            </div>
        </div>
      </main>
    
    <!-- ! Footer -->
  <?php require_once("includes/footer.php")?>
    </div>
</div>

<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/sweetalert2.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.js"></script>


<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
<script src="js/sidebar.js"></script>
<script src="js/create-blotters.js"></script>


</body>

</html>
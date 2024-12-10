<?php 
    require_once('includes/connecttodb.php');
    require_once 'includes/config.php';
    require_once 'includes/enforce_login.php';

    if($departmentno == 3){
        header("Location: index.php");
    }

    $logoquery = "SELECT `filename` FROM `certificate-img` WHERE purpose = 'Barangay Logo'";
    $logostmt = $pdo->prepare($logoquery);
    $logostmt -> execute();
    $logo = $logostmt -> fetchColumn(); 

    $pdo = null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BIMS | Manage Residents</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/logos/<?php echo $logo; ?>" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/v/dt/dt-2.1.8/datatables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./css/style.min.css">
  <link rel="stylesheet" href="./css/sweetalert2.min.css">

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
                    <h2 class="main-title">Generate Reports</h2>
                    <div class="row pb-3">
                        <div class="col-md-6">
                            <!-- Buttons -->
                            <div class="d-flex justify-content-start" style="padding-left: 15px;">

                                <div class="form-floating mx-2">
                                        <select class="form-select" id="certselect" aria-label="Floating label select example">
                                            <option selected value="*">All Certificate</option>
                                            <option value="Certificate of Residency">Residency</option>
                                            <option value="Certificate of Indigency">Indigency</option>
                                            <option value="Certificate of Good Moral">Good Moral</option>
                                            <option value="First Time Job Seekers">FTJS</option>
                                            <option value="Business Permits">Bussiness Permits</option>
                                            <option value="Building Permits">Building Permits</option>
                                            <option value="Fencing Permit">Fencing Permit</option>
                                            <option value="Excavation Permit">Excavation Permit</option>
                                            <option value="Tricycle Pedicab Regulatory Services">TPRS</option>

                                        </select>
                                    <label for="certselect">Certificate Type</label>
                                </div>


                            </div>
                        </div>

                        <div class="container col-md-6">
                            <div class="row">
                            <!-- Search Box -->
                                 
                                    <div class="form-floating col-md-5">
                                        <input type="text" class="form-control" id="start_date" name="start_date" placeholder=""/>
                                        <label for="start_date">Start Date</label>
                                    </div>

                                    <div class="form-floating col-md-5">
                                        <input type="text" class="form-control" id="end_date" name="end_date" placeholder=""/>
                                        <label for="end_date">End Date</label>
                                    </div>

                                    <div class="form-floating col-md-2 mb-2">
                                        <button type="button" class="btn btn-primary btn-large" id="sortbtn">Sort</button>
                                    </div>


                            </div>
                        </div>
                    
                        
                    </div>

                    <div class="">
                        <style>
                            .dataTables_wrapper .dataTables_paginate {
                                float: right;
                            }
                        </style>
                        <!-- users-table table-wrapper -->
                        <table class="tablehover ResidentTable" id="ResidentTable" style="scale: 98%;">
                                <thead>
                                <tr class="users-table-info">
                    
                                    <!-- <th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th> -->
                                    <th style="width: 8%"class="text-center resident_id">Request ID</th> 
                                    <th style="width: 8%;"class="text-center">Date Requested</th>
                                    <th style="width: 8%;"class="text-center">Expiration Date</th>
                                    <th style="width: 8%;"class="text-center">Residency Status</th>
                                    <th style="width: 15%;" class="text-center">Full Name</th>
                                    <th style="width: 15%;" class="text-center">Address</th>
                                    <th style="width: 10%;" class="text-center">Document Description</th>
                                    <th style="width: 10%;" class="text-center">Purpose</th>
                                    <th style="width: 10%;" class="text-center">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            
                            </table>
                            <!-- </tbody> -->
                        </table>
                        <!-- End of Table -->
                    </div>
                

                <!-- Pagination Controls -->
                <nav aria-label="Page navigation" id="pagenav">
                        <ul class="pagination main-pagination justify-content-end">
                        
                        <!-- To be filled by AJAX -->
                        
                        </ul>
                    </nav>

                 
                </div>  
            </div>
        </main>
    
    <!-- ! Footer -->
  <?php require_once("includes/footer.php")?>
    </div>
</div>


<script src="js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>

<!-- JSZip (required for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>

<!-- PDFMake (required for PDF export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.min.js"></script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/sweetalert2.min.js"></script>
<script src="js/generatereports.js"></script>
<script src="js/sidebar.js"></script>



<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
</body>

</html>
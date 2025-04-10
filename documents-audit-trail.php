<?php 
    require_once('includes/connecttodb.php');
    require_once 'includes/config.php';
    require_once 'includes/enforce_login.php';

    if($departmentno == 1 || $departmentno == 2 || $departmentno == 3){
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
   integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" 
  integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" 
  referrerpolicy="no-referrer" />
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
                    <h2 class="main-title">Documents Audit Trail</h2>
                    <div class="row pb-3">
                        <div class="col-md-8">
                            <!-- Buttons -->
                            <div class="d-flex justify-content-start" style="padding-left: 15px;">

                                    <div class="search-wrapper col-md-3">
                                                            
                                        <button type="submit" class="btn-sm btn-light" data-feather="calendar" aria-hidden="true" required></button>
                                        <input type="text" class="form-control me-2" id="start_date" name="search" placeholder="Start Date">
                                            
                                    </div>

                                    <div class="search-wrapper col-md-3">
                                        
                                        <button type="submit" class="btn-sm btn-light" data-feather="calendar" aria-hidden="true" required></button>
                                        <input type="text" class="form-control me-2" id="end_date" name="search" placeholder="End Date">
                                            
                                    </div>
                                  
                                    <div class="mx-3 col-md-2.5">
                                        
                                        <button type="button" class="btn-md btn-success btn" aria-hidden="true" id="apply_filters">Apply Filters</button>
                                            
                                    </div>
                                    <div class="col-md-2.5">
                                        
                                        <button type="button" class="btn-md btn-info btn" aria-hidden="true" id="clear_filters">Clear Filters</button>
                                            
                                    </div>
                                                    
                                    <div class="modal fade" id="ViewDocumentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Document</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="EditDocumentModalForm">
                                            <div class="modal-body">
                                                <div class="container">

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
                                                        <input type="text" class="form-control" id="fullname" name="expiration" disabled/>
                                                        <label for="fullname">Fullname</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
                                                        <input type="text" class="form-control" id="certificate_type" name="expiration" disabled/>
                                                        <label for="certificate_type">Certificate Type</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
                                                        <input type="date" class="form-control" id="expiration" name="expiration" disabled/>
                                                        <label for="expiration">Expiration</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
                                                        <input type="text" class="form-control" id="presented_id" name="presented_id" aria-label="Floating label select example" 
                                                        aria-required="true" disabled/>

                                                        <label for="presented_id">Presented ID</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
                                                        <input type="text" class="form-control" id="id_num" name="id_num" disabled/>
                                                        <label for="id_num">ID number</label>
                                                    </div>

                                                    <div id="is_deleted_con" hidden>
                                                        <div class="form-floating mt-3 mb-3 col-md-12">
                                                            <select class="form-select" id="is_deleted" name="presented_id" aria-label="Floating label select example" 
                                                            aria-required="true" disabled>
                                                                <option value="1">YES</option>
                                                                <option value="0">NO</option>
                                                                
                                                            </select>
                                                            <label for="is_deleted">Is Deleted?</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-target="#DocumentDetailsModal" data-bs-toggle="modal" >Close</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>

                        <div class="container col-md-3">
                            
                            <div class="row">
                            <!-- Search Box -->
                                <div class="search-wrapper">
                                                        
                                <button type="submit" class="btn-sm btn-light" data-feather="search" aria-hidden="true" required></button>
                                <input type="text" class="form-control me-2" id="searchbox" name="search" placeholder="Search...">
                                    
                                </div>
                            </div>
                        </div>
                    
                        
                    </div>

                    <div class="users-table table-wrapper">
                        <!-- users-table table-wrapper -->
                        <table class="users-table table-striped" id="ResidentAuditTrailTable" style="width:100%">
                            <thead>
                            <tr>
                
                                <!--th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th--> 
                                <th style="width: 2%"class="text-center resident_id" hidden>ID</th> 
                                <th style="width: 10%;"class="text-center">Date Recorded</th>
                                <th style="width: 15%;"class="text-center"> User Image</th>
                                <th style="width: 15%;" class="text-center">Full Name</th>
                                <th style="width: 15%;" class="text-center">User Name</th>
                                <th style="width: 15%;" class="text-center">Department</th>
                                <th style="width: 15%;" class="text-center">Operation</th>
                                <th style="width: 2%;" class="text-center">View Changes</th>
                            </tr>
                            </thead>

                            <tbody id="ResidentAuditTrailTableBody">
                            <!-- Table Body -->
                            
                                <!-- To be filled by the AJAX -->

                            </tbody> 
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
<!--Scripts Must be Always On the Top -->
<script src="js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" 
integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous"
 referrerpolicy="no-referrer"></script>
<script src="js/sweetalert2.min.js"></script>
<script src="js/documentsaudittrail.js"> </script>
<script src="js/sidebar.js"></script>
<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
</body>

</html>
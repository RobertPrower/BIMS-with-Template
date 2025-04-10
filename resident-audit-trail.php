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
   integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <h2 class="main-title">Residents Audit Trail</h2>
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
                                                    
                                <div class="modal fade" id="ViewResidentModal" name="add" tabindex="-1" aria-labelledby="EditResidentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="View    ResidentModalLabel">View Resident Status</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <!-- Edit form -->
                                            <form action="#" id="EditResidentModalForm" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                            
                                                    <div class="row">
                                                        <div class="mt-3" style="width: 270px">
                                                        
                                                            <!--For the container of the camera and Picture-->
                                                            <div class="col card" id="imageForm" style="border-radius: 15px; height: 400px">
                                                                <div class="text-center">
                                                                    <div class="mt-3 mb-4">

                                                                    <!-- Hidden Text Box to Store the resident_id value and current page -->
                                                               
                                                                        <div id="cameraFeedWrapper" class="camera-frame" style="width: 200px; height: 200px; display: none;">
                                                                            <div id="editcameraFeed"></div>
                                                                        </div>

                                                                        <!-- Preview image container (shown initially) -->
                                                                        <div id="imagePreviewWrapper" class="camera-frame" style="width: 200px; height: 200px;">
                                                                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                                                            class="rounded-circle img-fluid" id="imagePreview" style="width: 200px; height: 200px;" />
                                                                        </div>

                                                                        <div class= "mt-2 mb-2 text-center">
                                                                           
                                                                            <br><br>
                                                                            <span class="badge" id="delete_badge"><h6 id="delete_status"></h6><h6>Delete Status</h6></span>

                                                                        </div>

                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-9 card mt-3 " style="border-radius: 10px;" style="padding: 10px;">
                                                            <div class="text-center row">

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="fname" name="fname" disabled>
                                                                    <label for="fname">First Name</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="mname" name="mname" disabled>
                                                                    <label for="mname">Middle Name</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-3">
                                                                    <input type="text" class="form-control" id="lname" name="lname" disabled>
                                                                    <label for="lname">Last Name</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-1">
                                                                    <input type="text" class="form-control" id="suffix" name="suffix" style="width:50px" disabled>
                                                                    <label for="suffix">Suffix</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="house_no" name="house_no" disabled>
                                                                    <label for="house_no">House No. (Blk no, Lot no, Unit no)</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="street" name="street" disabled>
                                                                    <label for="street">Street</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <select class="form-select" id="subd" name="subd" aria-label="Floating label select example" disabled>
                                                                        <option value="">Not Applicable</option>
                                                                        <option value="Almar Subd">Almar Subd</option>
                                                                        <option value="Caritas Village">Caritas Village</option>
                                                                        <option value="Capitol Parkland">Capitol Parkland</option>
                                                                        <option value="Cassel Spring Subd">Cassel Spring Subd</option>
                                                                        <option value="Christina Homes">Christina Homes</option>
                                                                        <option value="Cielito Homes">Cielito Homes</option>
                                                                        <option value="Del Rey Ville 2 Subd">Del Rey Ville 2</option>
                                                                        <option value="Kassel Villas">Kassel Villas</option>
                                                                        <option value="Lilleville Subd">Lilleville Subd</option>
                                                                        <option value="Maligay Park">Maligaya Park</option>
                                                                        <option value="Maria Luisa Subd">Maria Luisa Subd</option>
                                                                        <option value="North Matrix Villge 1">North Matrix Village 1</option>
                                                                        <option value="North Matrix Ville">North Matrix Ville</option>
                                                                        <option value="North Triangle">North Triangle</option>
                                                                    </select>
                                                                    <label for="subd">Subdivision</label>
                                                                </div>
                                                            
                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <select class="form-select" id="sex" name="sex" aria-label="Floating label select example" disabled>
                                                                        <option hidden selected>Select Sex</option>
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                        
                                                                    </select>
                                                                    <label for="sex">Sex</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <select class="form-select" id="marital_status" name="marital_status" aria-label="Floating label select example" disabled>
                                                                        <option hidden selected>Select Marital Status</option>
                                                                        <option value="Single">Single</option>
                                                                        <option value="Married">Married</option>
                                                                        <option value="Widow">Widow/Widower</option>
                                                                        <option value="Annul">Annul</option>
                                                                    </select>
                                                                    <label for="marital_status">Marital Status</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="birth_date"name="birth_date" disabled>
                                                                    <label for="birth_place">Birth Date</label>
                                                                </div> 

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="Text" class="form-control" id="birth_place" name="birth_place" disabled>
                                                                    <label for="birth_place">Birth Place</label>
                                                                </div> 

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="number" maxlength="11" class="form-control" id="cp_number" name="cellphone_number" disabled>
                                                                    <label for="cp_number">Phone Number</label>
                                                                </div> 

                                                                <div class="form-floating mt-3 mb-3 col-md-2">
                                                                    <select class="form-select" id="is_a_voter" name="is_a_voter" aria-label="Floating label select example" disabled>
                                                                        <option hidden selected>Select Option</option>
                                                                        <option value="1">YES</option>
                                                                        <option value="0">NO</option>
                                                                    
                                                                    </select>
                                                                    <label for="isavoter">Is a Voter?</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-2">
                                                                    <input type="number" maxlength="4" class="form-control" id="resident_since" name="rsince" disabled>
                                                                    <label for="resident_since">Resident Since</label>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/sweetalert2.min.js"></script>
<script src="js/residentaudittrail.js"> </script>
<script src="js/sidebar.js"></script>



<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
</body>

</html>
<?php 
    require_once('includes/connecttodb.php');
    require_once 'includes/config.php';
    require_once 'includes/enforce_login.php';

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
  <link rel="stylesheet" href="./css/style.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <h2 class="main-title">Manage Residents</h2>
                    <div class="row pb-3">
                        <div class="col-md-8">
                            <!-- Buttons -->
                            <div class="d-flex justify-content-start" style="padding-left: 15px;">
                            
                                <!-- Button to trigger modal -->
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#AddResidentModal">New Resident</button>
                                <?php
                                if($dept ==="Admin"){
                                    echo '<div class="form-check form-switch my-2">
                                        <input class="form-check-input" type="checkbox" id="showdeletedentries">
                                        <label class="form-check-label" for="showdeletedentries">Show deleted entries</label>
                                    </div>';
                                }

                                ?>

                               <!-- New Resident Modal -->
                               
                                <div class="modal fade" id="AddResidentModal" name="add" tabindex="-1" aria-labelledby="addBlotterModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addBlotterModalLabel">New Resident</h5>
                                                <button type="button" class="btn-close btnClose" data-bs-dismiss="modal" id="closeButton" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Add Resident Form -->
                                                <form action="includes/addresident.php" id="AddResidentModalForm" enctype="multipart/form-data" method="POST">    
                                                    <div class="row">
                                                        <div class="mt-3" style="width: 270px">
                                                        
                                                            <!--For the container of the camera and Picture-->
                                                            <div class="col card" style="border-radius: 15px; height: 400px">
                                                                <div class="text-center">
                                                                    <div class="mt-3 mb-4">

                                                                        <div id="cameraFeedWrapper" class="camera-frame cameraFeedWrapper" style="width: 200px; height: 200px; display: none;">
                                                                            <div id="cameraFeed"></div>
                                                                        </div>

                                                                        <!-- Preview image container (shown initially) -->
                                                                        <div id="imagePreviewWrapper" class="camera-frame imagePreviewWrapper" style="width: 200px; height: 200px;">
                                                                            <img src="includes/img/blank-profile.webp" id="imagePreview" class="imagePreview" alt="Profile Image" />
                                                                        </div>
                                                                    </div>

                                                                        <button type="button" id="openCamera" class="btn btn-primary btn-lg col-md-12">Open Camera</button>
                                                                    
                                                                    <div class="form-floating mt-3 mb-3 col-md-13">
                                                                        <input type="file" class="form-control" id="imagefile" name="image_file" placeholder="Upload Picture" require>
                                                                        <label for="floatingInput">Upload Image</label>
                                                                    </div>  


                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-9 card mt-3 " style="border-radius: 10px;" style="padding: 10px;">
                                                            <div class="text-center row">

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name Here" required>
                                                                    <label for="fname">First Name</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="mname" name="mname" placeholder="Enter Middle Name Here">
                                                                    <label for="mname">Middle Name</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-3">
                                                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name Here" required>
                                                                    <label for="lname">Last Name</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-1">
                                                                    <input type="text" class="form-control" id="suffix" name="suffix" style="width:50px" placeholder="Enter Suffix Here">
                                                                    <label for="suffix">Suffix</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="house_no" name="house_no" placeholder="Enter House No Here" required>
                                                                    <label for="house_no">House No. (Blk no, Lot no, Unit no)</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="street" name="street" placeholder="Enter Street Here" required>
                                                                    <label for="street">Street</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <select class="form-select" id="subd" name="subd" aria-label="Floating label select example" required>
                                                                        <option hidden selected>Select</option>
                                                                        <option value="-">Not Applicable</option>
                                                                        <option value="Almar Subd">Almar Subd</option>
                                                                        <option value="Caritas">Caritas Subd</option>
                                                                        <option value="Capitol Parkland Subd">Capitol Parkland Subd</option>
                                                                        <option value="Cassel Spring Subd">Castle Spring Subd</option>
                                                                        <option value="Christina Homes">Christina Homes Subd</option>
                                                                        <option value="Cielito Homes">Cielito Homes Subd</option>
                                                                        <option value="Del Rey Ville 2">Del Rey Ville 2 Subd</option>
                                                                        <option value="Kassel Villas">Kassel Villas Subd</option>
                                                                        <option value="Lilleville Subd">Lilleville Subd</option>
                                                                        <option value="Maligay Park">Maligaya Park Subd</option>
                                                                        <option value="Maria Luisa Subd">Maria Luisa Subd</option>
                                                                        <option value="North Matrix Villge 1">North Matrix Village 1 Subd</option>
                                                                        <option value="North Matrix Ville">North Matrix Ville Subd</option>
                                                                        <option value="North Triangle">North Triangle Subd</option>
                                                                    </select>
                                                                    <label for="subd">Subdivision</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <select class="form-select" id="sex" name="sex" aria-label="Floating label select example" required>
                                                                        <option hidden selected>Select</option>
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                    </select>
                                                                    <label for="sex">Sex</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <select class="form-select" id="marital_status" name="marital_status" aria-label="Floating label select example" required>
                                                                        <option hidden selected>Select</option>
                                                                        <option value="Single">Single</option>
                                                                        <option value="Married">Married</option>
                                                                        <option value="Widow">Widow/Widower</option>
                                                                        <option value="Annul">Annul</option>
                                                                    </select>
                                                                    <label for="marital_status">Marital Status</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="birth_date" name="birth_date" placeholder="" required>
                                                                    <label for="birth_date">Birth Date</label>
                                                                </div> 

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="Text" class="form-control" id="birth_place" name="birth_place" placeholder="Enter Birth Place Here"required>
                                                                    <label for="birth_place">Birth Place</label>
                                                                </div> 

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="number" class="form-control" id="cellphone_number" name="cellphone_number" placeholder="Enter Phone Number Here" maxlength="11" required >
                                                                    <label for="cellphone_number">Phone Number</label>
                                                                </div> 

                                                                <div class="form-floating mt-3 mb-3 col-md-2">
                                                                    <select class="form-select" id="isavoter" name="is_a_voter" aria-label="Floating label select example" required>
                                                                        <option hidden selected>Select</option>
                                                                        <option value="1">YES</option>
                                                                        <option value="0">NO</option>
                                                                    </select>
                                                                    <label for="isavoter">Is a Voter</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-2">
                                                                    <input type="number" maxlength="4" class="form-control" id="resident_since" name="rsince" placeholder="Enter Birth Place Here"required>
                                                                <label for="resident_since">Resident Since</label>
                                                                </div> 

                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="modal-footer">
                                                        <button type="button" id="clearButton" class="btn btn-warning">Clear</button>
                                                        <button type="button" id="closeButton" class="btn btn-secondary btnClose" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" id="addButton" name="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- End of Add Resident Modal -->
                                <!-- Edit Resident Modal -->
                                <div class="modal fade" id="EditResidentModal" name="add" tabindex="-1" aria-labelledby="EditResidentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="EditResidentModalLabel">Edit Resident</h5>
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
                                                                        <input hidden type="text" id="resident_id" name="resident_id" />
                                                                        <input hidden type="text" id="pageno" name="pageno" />
                                                                        <input hidden type="text" id="isfromcamcheck" name="isfromcamcheck" disabled/>


                                                                        <div id="editcameraFeedWrapper" class="camera-frame" style="width: 200px; height: 200px; display: none;">
                                                                            <div id="editcameraFeed"></div>
                                                                        </div>

                                                                        <!-- Preview image container (shown initially) -->
                                                                        <div id="editimagePreviewWrapper" class="camera-frame" style="width: 200px; height: 200px;">
                                                                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                                                            class="rounded-circle img-fluid" id="editimagePreview" style="width: 200px; height: 200px;" />
                                                                        </div>

                                                                    </div>
                                                                        <button type="button" id="editopenCamera" class="btn btn-primary btn-lg col-md-12 editopenCamera" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Please capture a image.">Open Camera</button>
                                                                        
                                                                        <style>
                                                                            /* Default tooltip styling */
                                                                            .tooltip-inner {
                                                                            background-color: #000; /* Default background color */
                                                                            }

                                                                            /* Custom class for red background */
                                                                            .tooltip-red .tooltip-inner {
                                                                            background-color: red !important; /* Force red background */
                                                                            }
                                                                        </style>
                                                                    <div class="form-floating mt-3 mb-3 col-md-13">
                                                                        <input type="file" class="form-control" id="editimagefile" name="image_file" placeholder="Upload Picture">
                                                                        <label for="floatingInput">Upload Image</label>
                                                                
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-9 card mt-3 " style="border-radius: 10px;" style="padding: 10px;">
                                                            <div class="text-center row">

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="fname" name="fname" required>
                                                                    <label for="fname">First Name</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="mname" name="mname" >
                                                                    <label for="mname">Middle Name</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-3">
                                                                    <input type="text" class="form-control" id="lname" name="lname" required>
                                                                    <label for="lname">Last Name</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-1">
                                                                    <input type="text" class="form-control" id="suffix" name="suffix" style="width:50px">
                                                                    <label for="suffix">Suffix</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="house_no" name="house_no" required>
                                                                    <label for="house_no">House No. (Blk no, Lot no, Unit no)</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="street" name="street" required>
                                                                    <label for="street">Street</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <select class="form-select" id="subd" name="subd" aria-label="Floating label select example">
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
                                                                    <select class="form-select" id="sex" name="sex" aria-label="Floating label select example" required>
                                                                        <option hidden selected>Select Sex</option>
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                        
                                                                    </select>
                                                                    <label for="sex">Sex</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <select class="form-select" id="marital_status" name="marital_status" aria-label="Floating label select example" required>
                                                                        <option hidden selected>Select Marital Status</option>
                                                                        <option value="Single">Single</option>
                                                                        <option value="Married">Married</option>
                                                                        <option value="Widow">Widow/Widower</option>
                                                                        <option value="Annul">Annul</option>
                                                                    </select>
                                                                    <label for="marital_status">Marital Status</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="text" class="form-control" id="birth_date"name="birth_date" required>
                                                                    <label for="birth_place">Birth Date</label>
                                                                </div> 

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="Text" class="form-control" id="birth_place" name="birth_place" required>
                                                                    <label for="birth_place">Birth Place</label>
                                                                </div> 

                                                                <div class="form-floating mt-3 mb-3 col-md-4">
                                                                    <input type="number" maxlength="11" class="form-control" id="cp_number" name="cellphone_number"  required>
                                                                    <label for="cp_number">Phone Number</label>
                                                                </div> 

                                                                <div class="form-floating mt-3 mb-3 col-md-2">
                                                                    <select class="form-select" id="marital_status" name="is_a_voter" aria-label="Floating label select example" required>
                                                                        <option hidden selected>Select Option</option>
                                                                        <option value="1">YES</option>
                                                                        <option value="0">NO</option>
                                                                    
                                                                    </select>
                                                                    <label for="isavoter">Is a Voter?</label>
                                                                </div>

                                                                <div class="form-floating mt-3 mb-3 col-md-2">
                                                                    <input type="number" maxlength="4" class="form-control" id="resident_since" name="rsince" required>
                                                                    <label for="resident_since">Resident Since</label>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveButton" class="btn btn-primary" data-id="' . $row['resident_id'] . '" >Save</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <!--End Resident Modal -->
                                <?php 
                                require_once("includes/residentviewform.php");
                                ?>

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
                        <table class="users-table table-striped" id="ResidentTable" style="width:100%">
                            <thead>
                            <tr>
                
                                <!--th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th--> 
                                <th style="width: 2%"class="text-center resident_id" hidden>ID</th> 
                                <th style="width: 10%;"class="text-center">Date Recorded</th>
                                <th style="width: 15%;" class="text-center">Full Name</th>
                                <th style="width: 15%;" class="text-center">Address</th>
                                <th style="width: 5%;" class="text-center">Resident Since</th>
                                <th style="width: 10%;" class="text-center">Sex</th>
                                <th style="width: 10%;" class="text-center">Marital Status</th>
                                <th style="width: 10%;" class="text-center">Birth Date</th>
                                <th style="width: 10%;" class="text-center">Birth Place</th>
                                <th style="width: 10%;" class="text-center">Phone Number</th>
                                <th style="width: 10%;" class="text-center">Is a Voter</th>
                                <th style="width: 10%;" class="text-center">Action</th>
                            </tr>
                            </thead>

                            <tbody id="ResidentTableBody">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="js/webcam.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/sweetalert2.min.js"></script>
<script src="js/residentviewmodal.js"></script>
<script src="js/residentaction.js"> </script>
<script src="js/sidebar.js"></script>
<script src="js/camerafunction.js"></script>
<script src="js/logout.js"></script>
<script src="js/limitfileresanddisplayimg.js"></script>
<script src="js/LimitFileUploadAndDisplayImgForEdit.js"></script>
<script src="js/limitfileresanddisplayimg.js"></script>



<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
</body>

</html>
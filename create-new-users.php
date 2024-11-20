<?php 
    require_once('includes/connecttodb.php');
    $logoquery = "SELECT `filename` FROM `certificate-img` WHERE purpose = 'Barangay Logo'";
    $logostmt = $pdo->prepare($logoquery);
    $logostmt -> execute();
    $logo = $logostmt -> fetchColumn(); 

    require_once 'includes/config.php';
    require_once 'includes/signup_view.inc.php';

    $pdo = null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Certificate of Indigency</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="img/logos/<?php echo $logo; ?>" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/create-documents.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css">

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

    <?php 
    require_once("includes/header.php");
    require("includes/documentdisplaymodal.php");
    
    ?>

    <!-- ! Main -->

    <?php 
    
    require_once("includes/selectresidentmodal.php");
    
    ?>
    <main class="main users chart-page" id="skip-target">
      <div class="container">
        <h2 class="main-title">Create New Users</h2>
        <div class="row container">
          <style>

              .btn-for-docu:hover {
                background-color: #B7C0EE;
                opacity: 50;  
                padding: 0.5rem 1rem;
                border: solid;  
                border-color: black;
                border-radius: 20px;
                cursor: pointer;
                transition: background-color 0.2s ease;
                
              }
          </style>
              
          
            <!-- Wrap both modals inside one form -->
            <form id="UserSignup" action="includes/signup.inc.php" enctype="multipart/form-data" method="POST">
              <!-- First Modal: User Details -->
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

                                                  <script src="js/limitfileresanddisplayimg.js"></script>

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

              <!-- Second Modal: Username and Password -->
              <div class="modal fade" id="usernamepwd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Username and Password</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <div class="form-floating mb-3">
                                  <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                  <label for="username">Username</label>
                              </div>
                              <div class="form-floating">
                                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                  <label for="password">Password</label>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#AddUserModal">Back</button>
                              <!-- Submit Button: triggers form submission -->
                              <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                      </div>
                  </div>
              </div>
            </form>
        </div>
      </div>
    </main>

    <!-- ! Footer -->
  <?php require_once("includes/footer.php");
      ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!--JavaScript-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.all.min.js"></script>
<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<!-- <script>-->
<script src="js/create-document.js"></script>
<script src="js/script.js"></script>
<script src="js/sidebar.js"></script>
<script src="js/create-new-users.js"></script>
</body>

</html>
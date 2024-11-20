<?php 
    require_once('includes/connecttodb.php');
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

  <title>Users | BIMS</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/logos/<?php echo $logo; ?>" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">
  <link rel="stylesheet" href="./css/sweetalert2.min.css">
  <!--link rel="stylesheet" href="./css/blottertablestyle.css"-->
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
                    <h2 class="main-title">Manage Users</h2>
                    <div class="row pb-3">
                        <div class="col-md-8">
                            <!-- Buttons -->
                            <div class="d-flex justify-content-start" style="padding-left: 15px;">
                            
                                <!-- Button to trigger modal -->
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#AddUserModal">New User</button>
                                
                                <div class="form-check form-switch my-2">
                                    <input class="form-check-input" type="checkbox" id="showdeletedentries">
                                    <label class="form-check-label" for="showdeletedentries">Show deleted users</label>
                                </div>

                            <!-- New Blotter Modal -->
                          <form id="UserSignup" action="includes/addresident.php" enctype="multipart/form-data" method="POST">
                            <div class="modal fade" id="AddUserModal" name="add" tabindex="-1" aria-labelledby="addBlotterModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addBlotterModalLabel">New User</h5>
                                            <button type="button" class="btn-close btnClose" data-bs-dismiss="modal" id="closeButton" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Camera and Picture Container -->
                                                <div class="" style="width: 270px">
                                                    <div class="col card" style="border-radius: 15px; height: 400px">
                                                        <div class="text-center">
                                                            <div class="mt-3 mb-4">
                                                                <div id="cameraFeedWrapper" class="camera-frame cameraFeedWrapper" style="width: 200px; height: 200px; display: none;">
                                                                    <div id="cameraFeed"></div>
                                                                </div>
                                                                <div id="imagePreviewWrapper" class="camera-frame imagePreviewWrapper" style="width: 200px; height: 200px;">
                                                                    <img src="includes/img/blank-profile.webp" id="imagePreview" class="imagePreview" alt="Profile Image" />
                                                                </div>
                                                            </div>
                                                            <button type="button" id="openCamera" class="btn btn-primary btn-lg col-md-12">Open Camera</button>
                                                            <div class="form-floating mt-3 mb-3">
                                                                <input type="file" class="form-control" id="imagefile" name="image_file" placeholder="Upload Picture" required>
                                                                <label for="floatingInput">Upload Image</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- User Details Inputs -->
                                                <div class="col card" style="border-radius: 10px; padding: 10px; width: 150px;">
                                                    <div class="text-center row">
                                                        <div class="form-floating mt-2 mb-2">
                                                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name Here" required>
                                                            <label for="fname">First Name</label>
                                                        </div>
                                                        <div class="form-floating mt-2 mb-2">
                                                            <input type="text" class="form-control" id="mname" name="mname" placeholder="Enter Middle Name Here">
                                                            <label for="mname">Middle Name</label>
                                                        </div>
                                                        <div class="form-floating mt-2 mb-2">
                                                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name Here" required>
                                                            <label for="lname">Last Name</label>
                                                        </div>
                                                        <div class="form-floating mt-2 mb-2">
                                                            <input type="text" class="form-control" id="suffix" name="suffix" placeholder="Enter Suffix Here">
                                                            <label for="suffix">Suffix</label>
                                                        </div>
                                                        <div class="form-floating mt-2 mb-2">
                                                            <select class="form-select" id="department" name="department" required>
                                                                <option hidden selected>Select</option>
                                                                <option value="1">Clearance</option>
                                                                <option value="2">Secretariat Dept</option>
                                                                <option value="3">Lupon</option>
                                                                <option value="4">Admin</option>
                                                            </select>
                                                            <label for="department">Department</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="clearButton" class="btn btn-warning">Clear</button>
                                                <button type="button" id="nextButton" data-bs-target="#usernamepwd" data-bs-toggle="modal" class="btn btn-primary">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Second Modal for Username and Password -->
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
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                                <label for="password">Password</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" id="confirm_password" name="password" placeholder="Confirm Password" required>
                                                <label for="password">Confirm Password</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#AddUserModal">Back</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </form>


                                <!-- End of Users Modal -->
                             
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
                                <th style="width: 10%;"class="text-center">Date Created</th>
                                <th style="width: 15%;" class="text-center">Full Name</th>
                                <th style="width: 10%;" class="text-center">Last Login</th>
                                <th style="width: 10%;" class="text-center">Status</th>
                                <th style="width: 10%;" class="text-center">Action</th>
                            </tr>
                            </thead>

                            <tbody id="UsersTableBody">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="js/webcam.min.js"></script>
<script src="js/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
<script src="js/limitfileresanddisplayimg.js"></script>
<script src="js/users.js"></script>
</body>

</html>
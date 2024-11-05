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
  <title>Blotters | BIMS</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="img/logos/<?php echo $logo; ?>" type="image/x-icon">
  <!-- Custom styles -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.min.css">

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
        <!-- Modal -->
        <div class="modal fade" id="ViewBlotterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">View Blotter</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Complainant and Respondent Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Other Complainants</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Other Respondents</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false">Case Details</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="container m-4">
                                <div class="row">

                                    <div class="col-md-2 card m-3 p-3  d-flex justify-content-center align-items-center" style="border-radius: 10px;padding: 10px;object-fit: contain; max-width: 100%; max-height: 100%">
                                        
                                        <img src="includes/img/blank-profile.webp" id="ComplainantImg" width="200" height="200" style="object-fit: contain; max-width: 100%; max-height: 100%;"/>
                                        
                                    </div>

                                    <div class="col-md-9 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;">
                                        <div class="card-header">
                                            Reporting Person/Complainant Details
                                                            
                                        </div>

                                        <div class="text-center row">

                                            <input type="text" class="form-control" id="checkresident" hidden/>
                                            <input type="text" class="form-control" id="id_to_record" hidden/>

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

                                </div>
                            </div>

                            <div class="container m-4">
                                <div class="row">

                                    <div class="col-md-2 card m-3 p-3  d-flex justify-content-center align-items-center" style="border-radius: 10px;padding: 10px;object-fit: contain; max-width: 100%; max-height: 100%">
                                        
                                        <img src="includes/img/blank-profile.webp" id="ComplainantImg" width="200" height="200" style="object-fit: contain; max-width: 100%; max-height: 100%;"/>
                                        
                                    </div>

                                    <div class="col-md-9 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;">
                                        <div class="card-header">
                                            Reporting Person/Complainant Details
                                                            
                                        </div>

                                        <div class="text-center row">

                                            <input type="text" class="form-control" id="checkresident" hidden/>
                                            <input type="text" class="form-control" id="id_to_record" hidden/>

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

                                </div>
                            </div>

                        </div> 
                        <!-- End of first tab -->
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                              <div class="col-md-12">
                                <br>
                                <div class="row text-center">
                                    
                                        <h3>Other Complainants</h3>
                                    
                                   
                                </div>

                                <br>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                        <th scope="col" hidden>#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Fullname</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="ResidentComplainant">
                                    
                                    
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <!-- End of second tab -->
                        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                              <div class="col-md-12">
                                <br>
                                <div class="row text-center">
                                    
                                        <h3>Other Respondents</h3>
                                    
                                   
                                </div>

                                <br>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                        <th scope="col" hidden>#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Fullname</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="ResidentComplainant">
                                    
                                    
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- ! Main nav/Header -->
        <?php require_once("includes/header.php")?>
        <!-- ! Main -->
        <main>
        <div class="container">
                <div class="container p-3">
                <h2 class="main-title">Manage Blotters</h2>
                    <div class="row pb-3">
                        <div class="col-md-8">
                            <!-- Buttons -->
                            <div class="d-flex justify-content-start" style="padding-left: 15px;">
                               
                                <!-- Button to trigger modal -->
                                <a href="create-blotters.php" class="btn btn-primary me-2">Add Blotter</a>

                            </div>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ViewBlotterModal">
                                Launch demo modal
                            </button>
                        </div>
                        <div class="container col-md-3">
                            <div class="row">
                            <!-- Search Box -->
                            <div class="search-wrapper">
                                <i data-feather="search" aria-hidden="true" required></i>
                                <input type="text" placeholder="Enter keywords ..." required>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="users-table table-wrapper">
                    <table class="posts-table" id="BlotterTable">
                        <thead>
                        <tr class="users-table-info">
            
                            <!--th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th--> 
                            <th style="width: 2%"class="text-center" hidden>ID</th> 
                            <th style="width: 5%;"class="text-center">Blotter Type</th>
                            <th style="width: 10%;"class="text-center">Date Reported</th>
                            <th style="width: 10%;" class="text-center">Date of Incident</th>
                            <th style="width: 10%;" class="text-center">Title</th>
                            <th style="width: 10%;" class="text-center">Complainant Name</th>
                            <th style="width: 10%;" class="text-center">Respondent Name</th>
                            <th style="width: 10%;" class="text-center">Report Status</th>
                            <th style="width: 5%;" class=" col-span-3">Blotter Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                    
                        </tbody>
                    
                        
                        </tbody>
                    </table>
                </div>
        </div>
      </main>
    
    <!-- ! Footer -->
  <?php require_once("includes/footer.php")?>
    </div>
</div>

<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/blotters.js"></script>

<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
<script src="js/sidebar.js"></script>

</body>

</html>
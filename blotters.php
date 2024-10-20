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
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addBlotterModal">Add Blotter</button>
                                
                                <!-- Form to collect the details -->
                                <form id="BlotterFormData">
                                    <!-- Add Blotter Modal -->
                                    <div class="modal fade" id="addBlotterModal" tabindex="-1" aria-labelledby="addBlotterModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addBlotterModalLabel">Add Blotter</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="mt-3" style="width: 270px">

                                                    <div class="col card" style="border-radius: 15px; height: 400px">
                                                        <div class="text-center">
                                                            <div class="mt-3 mb-4">
                                                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                                                class="rounded-circle img-fluid" style="width: 200px;" />
                                                            </div>
                                                                <button type="button" class="btn btn-primary btn-lg col-md-12">Open Camera</button>


                                                            <div class="form-floating mt-3 mb-3 col-md-13">
                                                                <input type="file" class="form-control" id="floatingInput" placeholder="Upload Picture">
                                                                <label for="floatingInput">Upload Image</label>
                                                            </div>  
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-9 card mt-3 " style="border-radius: 10px;" style="padding: 10px;">
                                                    <div class="text-center row">

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                            <label for="floatingInput">First Name</label>
                                                        </div>

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                            <label for="floatingInput">Middle Name</label>
                                                        </div>

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                            <label for="floatingInput">Last Name</label>
                                                        </div>

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                            <label for="floatingInput">House No. (Blk no, Lot no, Unit no)</label>
                                                        </div>

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                            <label for="floatingInput">Street</label>
                                                        </div>

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                            <label for="floatingInput">Subdivision</label>
                                                        </div>

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                                <select class="form-select" id="sex" name="sex" aria-label="Floating label select example" required>
                                                                    <option hidden selected>Select Sex</option>
                                                                    <option value="Male">Male</option>
                                                                    <option value="Female">Female</option>
                                                                </select>
                                                                <label for="sex">Sex</label>
                                                        </div>

                                                        <div class="mt-3 mb-3 col-md-4">
                                                            <select class="form-select" aria-label="Default select example" Style="Height: 58px">
                                                            <option hidden selected>Select Marital Status</option>
                                                            <option value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                            <option value="Widowed">Widowed</option>
                                                            <option value="Annul">Annul</option>
                                                            
                                                            </select>
                                                        </div>

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                            <input type="Date" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                            <label for="floatingInput">Birth Date</label>
                                                        </div> 

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                            <input type="Text" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                            <label for="floatingInput">Birth Place</label>
                                                        </div> 

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                            <input type="" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                            <label for="floatingInput">Cellphone Number</label>
                                                        </div> 

                                                        <div class="mt-3 mb-3 col-md-4">
                                                            <select class="form-select" aria-label="Default select example" Style="Height: 58px">
                                                            <option hidden selected>Is a Voter?</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                            </select>
                                                        </div>                                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="closeButton" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" id="addButton" name="submit" class="btn btn-primary">Save</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- End of Add Blotter Modal -->
                                </form>

                            </div>
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
                    <table class="posts-table">
                        <thead>
                        <tr class="users-table-info">
            
                            <!--th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th--> 
                            <th style="width: 2%"class="text-center">ID</th> 
                            <th style="width: 10%;"class="text-center">Date Reported</th>
                            <th style="width: 10%;" class="text-center">Complainant Name</th>
                            <th style="width: 10%;" class="text-center">Complainant Address</th>
                            <th style="width: 10%;" class="text-center">Respondent Name</th>
                            <th style="width: 10%;" class="text-center">Respondent Address</th>
                            <th style="width: 10%;" class="text-center">Report Status</th>
                            <th style="width: 10%;" class="text-center">Date of Incident</th>
                            <th style="width: 10%;" class=" col-span-3">Blotter Action</th>
                        </tr>
                        </thead>
                        <tbody id="BlotterTable">
                        
                    
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

<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
<script src="js/sidebar.js"></script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BIMS | Manage Non-Residents</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/Brgy177.png" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">


  <!--Scripts Must be Always On the Top -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="js/webcam.min.js"></script>

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
                    <h2 class="main-title">Manage Non-Residents</h2>
                    <div class="row pb-3">
                        <div class="col-md-8">
                            <!-- Buttons -->
                            <div class="d-flex justify-content-start" style="padding-left: 15px;">
                            
                                <!-- Button to trigger modal -->
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#AddResidentModal">Add Resident</button>
                                
                                <div class="form-check form-switch my-2">
                                    <input class="form-check-input" type="checkbox" id="showdeletedentries">
                                    <label class="form-check-label" for="showdeletedentries">Show deleted entries</label>
                                </div>

                                <!-- Modal on a spepare file -->
                                <?php require_once('includes/residentaddmodal.php'); ?>
                            
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
                <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                        
                        <!-- Previous Button -->
                        
                            <li class="page-item">
                                <a class="page-link" href="#">Previous</a>
                            </li>
                        

                            <!-- Page Numbers -->
                            
                                <li class="page-item">
                                    <a class="page-link" href="#" data-page=""></a>
                                </li>
                        

                            <!-- Next Button -->
                        
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            
                        </ul>
                    </nav>

                    <?php 
                    require_once("includes/residentviewform.php");
                    require_once("includes/residenteditform.php");
                    ?>
                </div>  
            </div>
        </main>
    
    <!-- ! Footer -->
  <?php require_once("includes/footer.php")?>
    </div>
</div>
        
<script src="js/nonresidentaction.js"> </script>
<script src="js/camerafunction.js"></script>

<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
</body>

</html>
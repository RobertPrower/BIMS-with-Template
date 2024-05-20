<?php 
    include_once("includes/residentsearchfunction.php");

 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BIMS | Manage Residents</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">

  




  <!--Scripts Must be Always On the Top -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
  <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>





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
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#AddResidentModal">Add Resident</button>
                                <!-- Add Blotter Modal -->
                               
                                <div class="modal fade" id="AddResidentModal" name="add" tabindex="-1" aria-labelledby="addBlotterModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addBlotterModalLabel">Add Resident</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your form elements here for adding a resident -->
                                        <!-- Example form -->
                                 <form action="includes/addresident.php" id="AddResidentModalForm" enctype="multipart/form-data" method="POST">    
                                            <div class="row">
                                                <div class="mt-3" style="width: 270px">
                                                
                                                    <!--For the container of the camera and Picture-->
                                                    <div class="col card" style="border-radius: 15px; height: 400px">
                                                        <div class="text-center">
                                                            <div class="mt-3 mb-4">
                                                                <!--input type="hidden" name="MAX_FILE_SIZE" value="1048576"-->
                                                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                                                class="rounded-circle img-fluid" id="imagePreview" style="width: 200px;" />
                                                            </div>
                                                                <button type="button" class="btn btn-primary btn-lg col-md-12">Open Camera</button>

                                                            <div class="form-floating mt-3 mb-3 col-md-13">
                                                                <input type="file" class="form-control" id="imagefile" name="image_file" placeholder="Upload Picture" require>
                                                                <label for="floatingInput">Upload Image</label>
                                                                <script src="js/limitfileresanddisplayimg.js"> </script>
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
                                                            <input type="text" class="form-control" id="subd" name="subd" placeholder="Enter Subdvision Here">
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
                                                            <input type="Date" class="form-control" id="birth_date" name="birth_date" required>
                                                            <label for="birth_place">Birth Date</label>
                                                        </div> 

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                            <input type="Text" class="form-control" id="birth_place" name="birth_place" placeholder="Enter Birth Place Here"required>
                                                            <label for="birth_place">Birth Place</label>
                                                        </div> 

                                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                                            <input type="" class="form-control" id="cellphone_number" name="cellphone_number" placeholder="Enter Phone Number Here" required >
                                                            <label for="cellphone_number">Phone Number</label>
                                                        </div> 

                                                        <div class="form-floating mt-3 mb-3 col-md-2">
                                                            <select class="form-select" id="isavoter" name="is_a_voter" aria-label="Floating label select example" required>
                                                                <option hidden selected>YES/NO</option>
                                                                <option value="1">YES</option>
                                                                <option value="0">NO</option>
                                                            </select>
                                                            <label for="isavoter">Is a Voter</label>
                                                        </div>

                                                        <div class="form-floating mt-3 mb-3 col-md-2">
                                                            <input type="Text" class="form-control" id="resident_since" name="resident_since" placeholder="Enter Birth Place Here"required>
                                                        <label for="resident_since">Resident Since</label>
                                                        </div> 

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="closeButton" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" id="addButton" name="submit" class="btn btn-primary">Save</button>

                                            <script src="js/reseteditresidentformwhenclose.js">  </script>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </form>
                                
                                <!-- End of Add Blotter Modal -->
                              
                            </div>
                        </div>
                        <div class="container col-md-3">
                            <div class="row">
                            <!-- Search Box -->
                            <div class="search-wrapper">
                           
                                <form action="residents.php" method="GET" class="d-flex">
                                    <button type="submit" class="btn-sm btn-light" data-feather="search" aria-hidden="true" required><img src="icons/search.png" alt="Search Icon"></img></button>
                                    <input type="text" class="form-control me-2" name="search" placeholder="Search...">
                                   
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <!-- users-table table-wrapper -->
                    <table class="stripe ResidentTable" id="ResidentTable" style="width:100%">
                        <thead>
                        <tr>
            
                            <!--th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th--> 
                            <th style="width: 2%"class="text-center resident_id">ID</th> 
                            <th style="width: 10%;"class="text-center">Date Recorded</th>
                            <th style="width: 10%;" class="text-center">Full Name</th>
                            <th style="width: 10%;" class="text-center">Address</th>
                            <th style="width: 10%;" class="text-center">Sex</th>
                            <th style="width: 10%;" class="text-center">Marital Status</th>
                            <th style="width: 10%;" class="text-center">Birth Date</th>
                            <th style="width: 10%;" class="text-center">Birth Place</th>
                            <th style="width: 10%;" class="text-center">Phone Number</th>
                            <th style="width: 10%;" class="text-center">Is a Voter</th>
                            <th style="width: 10%;" class="text-center col-span-3">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        
                        <?php
                            
                        //To Populate table rows with user data
                        foreach ($result as $row) {
                            echo "<tr>";
                            //echo '<td><input type="checkbox" class="check-all"></td>';
                            echo "<td>{$row['resident_id']}</td>";
                            echo "<td>{$row['date_recorded']}</td>";
                            echo "<td>{$row['last_name']}, {$row['first_name']} {$row['middle_name']} {$row['suffix']}</td>";
                            echo "<td>{$row['house_number']}, {$row['street_name']}, {$row['subdivision']}</td>";
                            echo "<td>{$row['sex']}</td>";
                            echo "<td>{$row['marital_status']}</td>";
                            echo "<td>{$row['birth_date']}</td>";
                            echo "<td>{$row['birth_place']}</td>";

                              //Prevent "0" From appearing in Cellphone Number

                              if($row['cellphone_number']== "0"){
                                echo "<td> </td> ";
                            } else{
                                echo "<td>{$row['cellphone_number']}</td>";
                            }
                            
                            if($row['is_a_voter'] == 1){
                            echo "<td>YES</td>";
                            }else{
                            echo "<td>NO</td>";
                            }


                            //For the view button
                            echo "<td style='width: 15%;'><div class='btn-group text-center'>";

                            echo "<form method='GET' action='#'>";
                            echo '<button href="#" class="btn btn-primary mx-1 viewResidentButton" 
                            data-id="' . $row['resident_id'] . '"
                            data-first-name="' . htmlspecialchars($row['first_name'], ENT_QUOTES) . '"
                            data-middle-name="' . htmlspecialchars($row['middle_name'], ENT_QUOTES) . '"
                            data-last-name="' . htmlspecialchars($row['last_name'], ENT_QUOTES) . '"
                            data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
                            data-house-no="' . htmlspecialchars($row['house_number'], ENT_QUOTES) . '"
                            data-street-name="' . htmlspecialchars($row['street_name'], ENT_QUOTES) . '"
                            data-subdivision="' . htmlspecialchars($row['subdivision'], ENT_QUOTES) . '"
                            data-sex="' . htmlspecialchars($row['sex'], ENT_QUOTES) . '"
                            data-marital-status="' . htmlspecialchars($row['marital_status'], ENT_QUOTES) . '"
                            data-birth-date="' . htmlspecialchars($row['birth_date'], ENT_QUOTES) . '"
                            data-birth-place="' . htmlspecialchars($row['birth_place'], ENT_QUOTES) . '"
                            data-phone-number="' . htmlspecialchars($row['cellphone_number'], ENT_QUOTES) . '"
                            data-isa-voter="' . htmlspecialchars($row['is_a_voter'], ENT_QUOTES) . '"
                            data-rsince="' . htmlspecialchars($row['resident_since'], ENT_QUOTES) . '"
                            data-bs-toggle="modal" data-bs-target="#ViewResidentModal">View</button>';
                            echo "</form>";
                            
                            
                            

                            //For the edit button
                           
                            echo "<form method='GET' action='#'>";

                            echo '<button href="#" class="btn btn-success mx-1 editResidentButton" 
                            data-id="' . $row['resident_id'] . '"
                            data-first-name="' . htmlspecialchars($row['first_name'], ENT_QUOTES) . '"
                            data-middle-name="' . htmlspecialchars($row['middle_name'], ENT_QUOTES) . '"
                            data-last-name="' . htmlspecialchars($row['last_name'], ENT_QUOTES) . '"
                            data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
                            data-house-no="' . htmlspecialchars($row['house_number'], ENT_QUOTES) . '"
                            data-street-name="' . htmlspecialchars($row['street_name'], ENT_QUOTES) . '"
                            data-subdivision="' . htmlspecialchars($row['subdivision'], ENT_QUOTES) . '"
                            data-sex="' . htmlspecialchars($row['sex'], ENT_QUOTES) . '"
                            data-marital-status="' . htmlspecialchars($row['marital_status'], ENT_QUOTES) . '"
                            data-birth-date="' . htmlspecialchars($row['birth_date'], ENT_QUOTES) . '"
                            data-birth-place="' . htmlspecialchars($row['birth_place'], ENT_QUOTES) . '"
                            data-phone-number="' . htmlspecialchars($row['cellphone_number'], ENT_QUOTES) . '"
                            data-isa-voter="' . htmlspecialchars($row['is_a_voter'], ENT_QUOTES) . '"
                            data-residentsince="' . htmlspecialchars($row['resident_since'], ENT_QUOTES) . '"
                            data-bs-toggle="modal" data-bs-target="#EditResidentModal">Edit</button>';

                            echo "</form>";
                           


                            // For the Delete Button
                            

                            echo "<form method='POST' action='#'>";
                            //echo "<input type='hidden' id='resident_id' name='delete_resident_id' value='""'>";
                            echo '<button type="submit" class="Delete_Button btn btn-danger mx-1" data-resident_id="' . $row['resident_id'] . '">Delete</button>';
                            echo "</form>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";

                        }
                        ?>
                        </tbody>

                        <script>
                            $(document).ready(function() {
                                $('#ResidentTable').DataTable();
                            });
                        </script>
                    
                        
                        <!-- </tbody> -->

                    
                </table><!-- End of Table -->
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

<script src="js/deleteresidentaction.js"> </script>
<script src="js/populateresidenteditmodal.js"> </script>

<script src="js/populateresidentviewmodal.js"> </script>
        
<script src="js/editresidentaction.js"> </script>

<script src="js/addresidentaction.js"> </script>

<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
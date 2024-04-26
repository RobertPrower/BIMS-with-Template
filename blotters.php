<?php 
    include_once("includes/blottersearchfunction.php");

    if (isset($_GET['success']) && $_GET['success'] === "deleted") {
        echo "<script>alert('Record deleted successfully.')</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elegant Dashboard | Dashboard</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">
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
                <h2 class="main-title">Manage Blotters</h2>
                    <div class="row pb-3">
                        <div class="col-md-8">
                            <!-- Buttons -->
                            <div class="d-flex justify-content-start" style="padding-left: 15px;">
                               
                                <!-- Button to trigger modal -->
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addBlotterModal">Add Blotter</button>
                                <!-- Add Blotter Modal -->
                                <div class="modal fade" id="addBlotterModal" tabindex="-1" aria-labelledby="addBlotterModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="addBlotterModalLabel">Add Blotter</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <!-- Add your form elements here for adding a blotter -->
                                        <!-- Example form -->
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
                                            
                                            <script src="js/.js"> </script>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- End of Add Blotter Modal -->
                              

                                <!--button type="button" class="btn btn-primary me-2">Edit Blotter</button-->
                                <!--button type="button" class="btn btn-primary me-2">View Blotter</button-->
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
                            <th style="width: 10%;" class="text-center">Complainant Cellphone Number</th>
                            <th style="width: 10%;" class="text-center">Respondent Name</th>
                            <th style="width: 10%;" class="text-center">Respondent Address</th>
                            <th style="width: 10%;" class="text-center">Respondent Cellphone Number</th>
                            <th style="width: 10%;" class="text-center">Report Status</th>
                            <th style="width: 10%;" class="text-center">Date of Incident</th>
                            <th style="width: 10%;" class=" col-span-3">Blotter Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        
                        <?php
                            
                        //To Populate table rows with user data
                        foreach ($result as $row) {
                            echo "<tr>";
                            //echo '<td><input type="checkbox" class="check-all"></td>';
                            echo "<td>{$row['blotter_id']}</td>";
                            echo "<td>{$row['reported_date']}</td>";
                            echo "<td>{$row['complainant_lname']}, {$row['complainant_fname']} {$row['complainant_mname']}</td>";
                            echo "<td>{$row['complainant_address']}</td>";

                            //Prevent "0" From appearing in Complainant Cellphone Number

                            if($row['complainant_contact_num']== "0"){
                                echo "<td> </td> ";
                            } else{
                                echo "<td>{$row['complainant_contact_num']}</td>";
                            }

                            //To prevent "," from appearing in the Respondent Name Column
                            
                            if(empty($row['respondent_lname']) && empty($row['respondent_fname'])){
                                    echo "<td> </td> ";
                                } else{
                                echo  "<td> {$row['respondent_lname']}, {$row['respondent_fname']} {$row['respondent_mname']}</td>";
                                }

                            echo "<td>{$row['respondent_address']}</td>";

                            //To prevent "0" from appearing in the Respondent Cellphone Number Column
                            
                            if($row['respondent_contact_num']== "0"){
                                echo "<td> </td> ";
                            } else{
                                echo "<td>{$row['respondent_contact_num']}</td>";
                            }

                            //To display the status theam 
                            
                            if($row['report_status'] === 'Ongoing'){       
                                
                                echo "<td class='d-flex justify-content-center'><div class='pt-5 pb-5'><span class='badge-pending'>{$row['report_status']}</span></div></td>";
                            
                            }elseif($row['report_status'] === 'Settled'){

                                echo "<td class='d-flex justify-content-center'><div class='pt-5 pb-5'><span class='badge-success'>{$row['report_status']}</span></div></td>";

                            }else{

                                echo "<td class='d-flex justify-content-center'><div class='pt-5 pb-5'><span class='badge-trashed'>{$row['report_status']}</span></div></td>";
                            }

                            echo "<td>{$row['date_of_incident']}</td>";

                            //For the view button
                            echo "<td style='width: 15%;'><div class='btn-group text-center'>";


                            echo "<form method='GET' action='viewandeditblotter.php'>";
                            echo "<input type='hidden' name='id' value='" . $row['blotter_id'] . "'>";
                            echo "<button type='submit' id='viewandeditblotter' class='btn btn-primary mx-1'>View</button>";
                            echo "</form>";

                            //For the edit button

                                echo "<form method='GET' action='viewandeditblotter.php'>";
                                echo "<input type='hidden' name='id' value='" . $row['blotter_id'] . "'>";
                                echo "<button type='submit' id='viewandeditblotter' class='btn btn-success mx-1'>Edit</button>";
                                echo "</form>";

                                // For the Delete Button 

                                echo "<form method='post' action='include/deleteblotterbtn.php' onsubmit='return confirmDelete();'>";
                                echo "<input type='hidden' name='delete_blotter_id' value='" . $row['blotter_id'] . "'>";
                                echo "<button type='submit' id='showdeletealert' name='deletebtn' class='btn btn-danger mx-1'>Delete</button>";
                                echo "</form>";
                                echo "</div>";
                                echo "</td>";
                            echo "</tr>";
                        }
                        ?>
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

<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
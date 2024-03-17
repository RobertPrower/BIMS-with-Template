<?php 
    include_once("includes/residentsearchfunction.php");

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
  <title>BIMS | Manage Residents</title>
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
                <h2 class="main-title">Manage Residents</h2>
                    <div class="row pb-3">
                        <div class="col-md-8">
                            <!-- Buttons -->
                            <div class="d-flex justify-content-start" style="padding-left: 15px;">
                               
                                <!-- Button to trigger modal -->
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addBlotterModal">Add Resident</button>
                                <!-- Add Blotter Modal -->
                                <form action="includes/addresident.php" method="POST" enctype="multipart/form-data">
                                <div class="modal fade" id="addBlotterModal" name="add" tabindex="-1" aria-labelledby="addBlotterModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addBlotterModalLabel">Add Resident</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <!-- Add your form elements here for adding a resident -->
                                        <!-- Example form -->
                                        
                                        <div class="row">
                                            <div class="mt-3" style="width: 270px">
                                            
                                                <!--For the container of the camera and Picture-->
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
                                                        <input type="text" class="form-control" id="floatingInput" name="fname">
                                                        <label for="floatingInput">First Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="floatingInput" name="mname">
                                                        <label for="floatingInput">Middle Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="floatingInput" name="lname">
                                                        <label for="floatingInput">Last Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="floatingInput" name="house_no">
                                                        <label for="floatingInput">House No. (Blk no, Lot no, Unit no)</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="floatingInput" name="street">
                                                        <label for="floatingInput">Street</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="floatingInput" name="subd">
                                                        <label for="floatingInput">Subdivision</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="floatingInput" name="sex">
                                                        <label for="floatingInput">Sex</label>
                                                    </div>

                                                    <div class="mt-3 mb-3 col-md-4">
                                                        <select class="form-select" aria-label="Default select example" Style="Height: 58px" name="marital_status">
                                                        <option hidden selected>Select Marital Status</option>
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Widowed">Widowed</option>
                                                        <option value="Annul">Annul</option>
                                                        
                                                        </select>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="Date" class="form-control" id="floatingInput" name="birth_date">
                                                        <label for="floatingInput">Birth Date</label>
                                                    </div> 

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="Text" class="form-control" id="floatingInput" name="birth_place">
                                                        <label for="floatingInput">Birth Place</label>
                                                    </div> 

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="" class="form-control" id="floatingInput" name="cellphone_number">
                                                        <label for="floatingInput">Cellphone Number</label>
                                                    </div> 

                                                    <div class="mt-3 mb-3 col-md-4">
                                                        <select class="form-select" name="is_a_voter" aria-label="Is a Voter" Style="Height: 58px">
                                                        <option hidden selected>Is a Voter?</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                        </select>
                                                    </div>
                                                


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
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
                            <th style="width: 10%;"class="text-center">Date Recorded</th>
                            <th style="width: 10%;" class="text-center">Full Name</th>
                            <th style="width: 10%;" class="text-center">Address</th>
                            <th style="width: 10%;" class="text-center">Sex</th>
                            <th style="width: 10%;" class="text-center">Marital Status</th>
                            <th style="width: 10%;" class="text-center">Birth Date</th>
                            <th style="width: 10%;" class="text-center">Birth Place</th>
                            <th style="width: 10%;" class="text-center">Phone Number</th>
                            <th style="width: 10%;" class="text-center">Is a Voter</th>
                            <th style="width: 10%;" class=" col-span-3">Action</th>
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
                            echo "<td>{$row['last_name']}, {$row['first_name']} {$row['middle_name']}</td>";
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
                            
                            if($row['is_a_voter'] === "1"){
                            echo "<td>YES</td>";
                            }else{
                            echo "<td>NO</td>";
                            }


                            //For the view button
                            echo "<td style='width: 15%;'><div class='btn-group text-center'>";

                            echo "<form method='GET' action='viewandeditblotter.php'>";
                            echo "<input type='hidden' name='id' value='" . $row['resident_id'] . "'>";
                            echo "<button type='submit' id='viewandeditblotter' class='btn btn-primary mx-1'>View</button>";
                            echo "</form>";

                            //For the edit button

                                echo "<form method='GET' action='viewandeditblotter.php'>";
                                echo "<input type='hidden' name='id' value='" . $row['resident_id'] . "'>";
                                echo "<button type='submit' id='viewandeditblotter' class='btn btn-success mx-1'>Edit</button>";
                                echo "</form>";

                                // For the Delete Button 

                                echo "<form method='post' action='include/deleteblotterbtn.php' onsubmit='return confirmDelete();'>";
                                echo "<input type='hidden' name='delete_blotter_id' value='" . $row['resident_id'] . "'>";
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
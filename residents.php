<?php 
    include_once("includes/residentsearchfunction.php");// SQL Query for the table and search
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BIMS | Manage Residents</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/Brgy177.png" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css"> -->

  <!--Scripts Must be Always On the Top -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
  <script> src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"</script> -->





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
                                <!-- Modal on a spepare file -->
                                <?php require_once('includes/addresidentmodal.php'); ?>
                              
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

                <div class="users-table table-wrapper">
                    <!-- users-table table-wrapper -->
                    <table class="users-table table-wrapper" id="ResidentTable" style="width:100%">
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
                        <tbody>
                        
                        
                        <?php
                            
                        //To Populate table rows with user data
                        foreach ($result as $row) {
                            //echo '<td><input type="checkbox" class="check-all"></td>';
                            echo "  <tr>
                                    <td hidden>{$row['resident_id']}</td>
                                    <td>{$row['date_recorded']}</td>
                                    <td>{$row['last_name']}, {$row['first_name']} {$row['middle_name']} {$row['suffix']}</td>
                                    <td>{$row['house_num']}, {$row['street']}, {$row['subdivision']}</td>
                                    <td class='text-center'>{$row['resident_since']}
                                    <td>{$row['sex']}</td>
                                    <td>{$row['marital_status']}</td>
                                    <td>{$row['birth_date']}</td>
                                    <td>{$row['birth_place']}</td>
                                    <td class='text-center'>{$row['cellphone_num']}</td>";
                            
                            if($row['is_a_voter'] == 1){
                            echo "<td>YES</td>";
                            }else{
                            echo "<td>NO</td>";
                            }

                            echo "<td style='width: 35%;'><div class='btn-group text-center'>";
                            
                             //For the view button
                            echo '
                            <button href="#" class="btn btn-primary mx-1 viewResidentButton" id="vbutton"
                            data-id="' . $row['resident_id'] . '"
                            data-first-name="' . htmlspecialchars($row['first_name'], ENT_QUOTES) . '"
                            data-middle-name="' . htmlspecialchars($row['middle_name'], ENT_QUOTES) . '"
                            data-last-name="' . htmlspecialchars($row['last_name'], ENT_QUOTES) . '"
                            data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
                            data-house-no="' . htmlspecialchars($row['house_num'], ENT_QUOTES) . '"
                            data-street-name="' . htmlspecialchars($row['street'], ENT_QUOTES) . '"
                            data-subdivision="' . htmlspecialchars($row['subdivision'], ENT_QUOTES) . '"
                            data-sex="' . htmlspecialchars($row['sex'], ENT_QUOTES) . '"
                            data-marital-status="' . htmlspecialchars($row['marital_status'], ENT_QUOTES) . '"
                            data-birth-date="' . htmlspecialchars($row['birth_date'], ENT_QUOTES) . '"
                            data-birth-place="' . htmlspecialchars($row['birth_place'], ENT_QUOTES) . '"
                            data-phone-number="' . htmlspecialchars($row['cellphone_num'], ENT_QUOTES) . '"
                            data-isa-voter="' . htmlspecialchars($row['is_a_voter'], ENT_QUOTES) . '"
                            data-rsince="' . htmlspecialchars($row['resident_since'], ENT_QUOTES) . '"
                            data-bs-toggle="modal" data-bs-target="#ViewResidentModal">View</button>';

                            // //For the edit button
                            echo '<button href="#" class="btn btn-success mx-1 editResidentButton" 
                            data-id="' . $row['resident_id'] . '"
                            data-first-name="' . htmlspecialchars($row['first_name'], ENT_QUOTES) . '"
                            data-middle-name="' . htmlspecialchars($row['middle_name'], ENT_QUOTES) . '"
                            data-last-name="' . htmlspecialchars($row['last_name'], ENT_QUOTES) . '"
                            data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
                            data-house-no="' . htmlspecialchars($row['house_num'], ENT_QUOTES) . '"
                            data-street-name="' . htmlspecialchars($row['street'], ENT_QUOTES) . '"
                            data-subdivision="' . htmlspecialchars($row['subdivision'], ENT_QUOTES) . '"
                            data-sex="' . htmlspecialchars($row['sex'], ENT_QUOTES) . '"
                            data-marital-status="' . htmlspecialchars($row['marital_status'], ENT_QUOTES) . '"
                            data-birth-date="' . htmlspecialchars($row['birth_date'], ENT_QUOTES) . '"
                            data-birth-place="' . htmlspecialchars($row['birth_place'], ENT_QUOTES) . '"
                            data-phone-number="' . htmlspecialchars($row['cellphone_num'], ENT_QUOTES) . '"
                            data-isa-voter="' . htmlspecialchars($row['is_a_voter'], ENT_QUOTES) . '"
                            data-residentsince="' . htmlspecialchars($row['resident_since'], ENT_QUOTES) . '"
                            data-bs-toggle="modal" data-bs-target="#EditResidentModal">Edit</button>';

                            // For the Delete Button

                            // 
                            echo '
                            <button type="submit" class="Delete_Button btn btn-danger mx-1" id="deletebutton" data-resident_id="' . $row['resident_id'] . '">Delete</button>
                            
                            </div>
                            </td>
                            </tr>';

                        }
                        ?>
                        </tbody> 
                        <!-- </tbody> -->
                    </table>
                    <!-- End of Table -->
                <!-- </div> -->

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
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

<script src="js/populateresidenteditmodal.js"> </script>

<script src="js/populateresidentviewmodal.js"> </script>
        
<script src="js/residentaction.js"> </script>

<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
</body>

</html>
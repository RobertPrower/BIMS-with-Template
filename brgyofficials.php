<?php 
    include_once("includes/connecttodb.php");

    $stmt = $pdo->query("SELECT * FROM brgy_officials");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Officials</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">
  <!--JavaScript-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                <h2 class="main-title">Manage Barangay Officials</h2>
                    <div class="row pb-3">
                        <div class="col-md-8">
                            <!-- Buttons -->
                            <div class="d-flex justify-content-start" style="padding-left: 15px;">
                               
                                <!-- Button to trigger modal -->
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" 
                                data-bs-target="#AddOfficialModal">Add Official</button>
                                <?php 
                                
                                include_once('includes/addbrgyofficialsform.php');
                                include_once('includes/editbrgyofficial.php');
                                
                                ?>
                 
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
                            
                            <th style="width: 10%;"class="text-center">Photo</th>
                            <th style="width: 10%;" class="text-center">Full Name</th>
                            <th style="width: 10%;" class="text-center">Position</th>
                            <th style="width: 10%;"class="text-center">Date Last Edited</th>
                            <th style="width: 10%;"class="text-center">Action</th>
                           
                        </tr>
                        </thead>
                        <tbody>
                        
                        
                        <?php
                            
                        //To Populate table rows with user data
                        foreach ($result as $row) {
                            echo "<tr>";
                            //echo '<td><input type="checkbox" class="check-all"></td>';
                            
                            echo "<td></td>";
                            echo "<td>{$row['official_name']}</td>";
                            echo "<td>{$row['official_position']}</td>";
                            echo "<td>{$row['date_last_edited']}</td>";

                        //For the edit button
                            echo "<td>";
                            
                            echo '<button type="button" class="btn btn-success me-2 editOfficialBtn mx-1" data-modal-title="Edit Official" 
                            data-official-id="' . $row['id'] . '" data-official-fullname="' . $row['official_name'] . '" data-official-position="' . $row['official_position'] .'" 
                            data-bs-toggle="modal" data-bs-target="#EditOfficialModal" id="EditOfficialBtn">Edit Official</button>';
                           
                            echo '<button type="button" class="btn btn-danger" data-official-id = "' . $row['id'] . '" id="DeleteOfficialbtn">Delete</button>';
                            echo "</td>";

                        
                        }
                        ?>
                        </tbody>
                        
                        <script >
                          $(document).on('click', '#DeleteOfficialbtn', function() {
                            var official_id = $(this).data('official-id');
                            $.ajax({
                                url: 'includes/deleteofficialaction.php',
                                type: 'POST',
                                dataType: 'json',
                                data: { id: official_id },
                                contentType: 'application/x-www-form-urlencoded', 
                                success: function(response) {
                                    alert("Official Successfully Deleted");
                                    console.log('Server response:', response);
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log('Error:', textStatus, errorThrown);
                                }
                            });
                        });

                        </script>
                        
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

<script src="js/populateofficialtotheeditmodal.js"></script>

<script src="js/addeditofficial.js"> </script>

<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
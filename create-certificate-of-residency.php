<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Documents</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/create-documents.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

  <!--JavaScript-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
    
    ?>

    <!-- ! Main -->

    <?php 
    
    require_once("includes/selectresidentmodal.php");
    
    ?>
    <main class="main users chart-page" id="skip-target">
      <div class="container">
        <h2 class="main-title">Create Certificate of Residency</h2>
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

          <div class="col-md-12">

            <h5>Step 1: Select Resident</h6>

            <br>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectresident"> Select Resident </button> 

          </div>

              <br><br>
            
          <div class="col-md-12 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;">
          <form action="generate-residency.php" method="POST" id="certificatedetails">
            <div class="text-center row">

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <input type="text" class="form-control" id="fname" name="firstname" placeholder="Enter First Name Here" required >
                  <label for="fname">First Name</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <input type="text" class="form-control" id="mname" name="middlename" placeholder="Enter Middle Name Here" >
                  <label for="mname">Middle Name</label>
                  <input type="text" class="form-control" id="resident_id" name="resident_no" required  hidden>

              </div>

              <div class="form-floating mt-3 mb-3 col-md-3">
                  <input type="text" class="form-control" id="lname" name="lastname" placeholder="Enter Last Name Here" required >
                  <label for="lname">Last Name</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-1">
                  <input type="text" class="form-control" id="suffix" name="suffix" style="width:50px" placeholder="Enter Suffix Here" >
                  <label for="suffix">Suffix</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-12">
                  <input type="text" class="form-control" id="subd" name="address" placeholder="Enter Subdvision Here" >
                  <label for="subd">Complete Address</label>
              </div>

              
              <div class="form-floating mt-3 mb-3 col-md-2">
                  <input type="Text" class="form-control" id="resident_since" name="r_since" placeholder="Enter Birth Place Here" required>
                  <label for="birth_place">Resident Since</label>
              </div> 

                  
              <div class="form-floating mt-3 mb-3 col-md-3">
                  <select class="form-select" id="isavoter" name="presented_id" aria-label="Floating label select example" required aria-required="true">
                      <option hidden value="">Select Option</option>
                      <option value="National ID">National ID</option>
                      <option value="Postal ID">Postal ID</option>
                      <option value="Driver's License">Driver's License</option>
                      <option value="PRC ID">PRC ID</option>
                      <option value="SSS ID">SSS ID</option>
                      <option value="GSIS ID">GSIS ID</option>
                      <option value="UMID ID">UMID ID</option>
                      <option value="Senior ID">Senior ID</option>
                      <option value="PWD ID">PWD ID</option>
                      <option value="Solo Parent ID">Solo Parent ID</option>
                      <option value="Voter's ID">Voters ID/Certification</option>
                      <option value="LTOPF ID">LTOPF License</option>
                      <option value="Police ID">Barangay ID</option>
                      <option value="Police ID">Police ID</option>
                      <option value="School ID">School ID</option>
                      <option value="Passport">Passport</option>
                      <option value="NBI Clearance">NBI Clearance</option>
                      <option value="Seafarers Record Book">Seafarers Record Book</option>


                  </select>
                  <label for="isavoter">Presented ID</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-2">
                  <input type="text" class="form-control" id="IDnum" name="IDnum" placeholder="Enter Birth Place Here" required>
                  <label for="IDnum">ID Number</label>
              </div> 

              <div class="form-floating mt-3 mb-3 col-md-3">
                  <select class="form-select" id="isavoter" name="purpose" aria-label="Floating label select example" required>
                      <option hidden value="">Select Option</option>
                      <option value="Verification Purposes">Verification Purposes</option>

                  </select>
                  <label for="isavoter">Purpose</label>
              </div>
              
            </div>
          </div>

          <div class="col-md-12 d-flex justify-content-end">

          <br>

          <button type="submit" class="btn btn-success float-right"> Generate Certificate </button> 
          </div>
          </form>



          
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
<!-- <script>
$('#selectresident').on('shown.bs.modal', function () {
    $('#ResidentTable').DataTable();     
});
</script> -->


<script>
    $(document).ready(function() {

      var selectedRowId = null;
      // Initialize DataTable when the modal is shown
      $('#selectresident').on('shown.bs.modal', function() {
        $('#ResidentTable').DataTable();
      });

      // Event listener for row click
      $(document).on('click', '#ResidentTable tbody tr', function() {
        $(this).toggleClass("selected").siblings().removeClass("selected");
        var residentid = $(this).find(".resident_id").text();
        selectedRowId = $(this).find(".resident_id").text();

        if (residentid) {
          // Make an AJAX request to fetch resident details
          $.ajax({
            url: 'includes/fetch_resident_details.php', // PHP script to fetch resident details
            type: 'POST',
            data:  { id: residentid },
            success: function(response) {
              // Parse the JSON response
              var data = JSON.parse(response);

              // Populate the form fields on the main page
              $('#fname').val(data.first_name);
              $('#mname').val(data.middle_name);
              $('#lname').val(data.last_name);
              $('#suffix').val(data.suffix);
              $('#subd').val(data.address +" "+ "Caloocan City");
              $('#resident_since').val(data.resident_since);
              $('#resident_id').val(residentid);


              // Close the modal
              $('#selectresident').modal('hide');
            },
            error: function(xhr, status, error) {
              console.error('Error fetching resident details:', error);
            }
          });
        } else {
          alert('Please select a resident.');
        }
      });

    });
  </script>



<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
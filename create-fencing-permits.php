<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Documents</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="img/Brgy177.png" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/create-documents.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css">
  <!--JavaScript-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 
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
    require_once("includes/selectnonresidentmodal.php");
    require_once("includes/documentdisplaymodal.php");   
    ?>


    <main class="main users chart-page" id="skip-target">
      <div class="container">
        <h2 class="main-title">Create Fencing Permits</h2>
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
            <button class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#selectnonresident"> Select Non-Resident </button> 
 

          </div>

              <br><br>
            
          <div class="col-md-12 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;">
          <form action="generate-residency.php" method="POST" id="certificatedetails">
            <div class="text-center row">

              <input type="text" class="form-control" id="checkresident" name="resident_no" hidden>
              <input type="text" class="form-control" id="id_to_record" name="resident_no" hidden>

              <br>
              <label style="text-align: left;">Personal Details of the Requestee</label>

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

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <select class="form-select" id="presented_id" name="presented_id" aria-label="Floating label select example" required aria-required="true">
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
                  <label for="presented_id">Presented ID</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <input type="text" class="form-control" id="IDnum" name="IDnum" placeholder="Enter Birth Place Here" required>
                  <label for="IDnum">ID Number</label>
              </div> 

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <select class="form-select" id="purpose" name="purpose" aria-label="Floating label select example" required>
                      <option hidden value="">Select Option</option>
                      <option value="Residencial">Residencial</option>
                      <option value="Commercial">Commercial</option>
                  </select>
                  <label for="purpose">Purpose</label>
              </div>

              <label style="text-align: left;">Address For The Building</label>

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <input type="text" class="form-control" id="house_no" name="house_no" placeholder="Enter Subdvision Here"/>
                  <label for="street">House No</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <input type="text" class="form-control" id="street" name="street" placeholder="Enter Subdvision Here"/>
                  <label for="street">Street</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <select class="form-select" id="subd" name="subd" aria-label="Floating label select example">
                      <option value="">Not Applicable</option>
                      <option value="Almar Subd">Almar Subd</option>
                      <option value="Caritas Village">Caritas Village</option>
                      <option value="Capitol Parkland">Capitol Parkland</option>
                      <option value="Cassel Spring Subd">Cassel Spring Subd</option>
                      <option value="Christina Homes">Christina Homes</option>
                      <option value="Cielito Homes">Cielito Homes</option>
                      <option value="Del Rey Ville 2 Subd">Del Rey Ville 2</option>
                      <option value="Kassel Villas">Kassel Villas</option>
                      <option value="Lilleville Subd">Lilleville Subd</option>
                      <option value="Maligay Park">Maligaya Park</option>
                      <option value="Maria Luisa Subd">Maria Luisa Subd</option>
                      <option value="North Matrix Villge 1">North Matrix Village 1</option>
                      <option value="North Matrix Ville">North Matrix Ville</option>
                      <option value="North Triangle">North Triangle</option>
                  </select>
                  <label for="subd">Subdivision</label>
              </div>
              
            </div>
          </div>

          <div class="col-md-12 d-flex justify-content-end">

          <br>

          <button type="submit" id="generate_certificate" class="btn btn-success float-right"> Generate Certificate </button> 
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
<script src="plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/create-permits.js"></script>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.all.min.js"></script></head>

</body>

</html>
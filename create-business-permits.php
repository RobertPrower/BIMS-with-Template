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
    require("includes/documentdisplaymodal.php");
    
    ?>

    <!-- ! Main -->

    <?php 
    
    require_once("includes/selectresidentmodal.php");
    require_once("includes/selectnonresidentmodal.php");
    
    ?>
    <main class="main users chart-page" id="skip-target">
      <div class="container">
        <h2 class="main-title">Create Business Permit</h2>
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

            <h5>Step 1: Select Resident or Non-Resident</h6>

            <br>

            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#selectresident"> Select Resident </button> 
            <button class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#selectnonresident"> Select Non-Resident </button> 

          </div>

              <br><br>
            
          <div class="col-md-12 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;">
          <form action="#" method="POST" id="certificatedetails">
            <div class="text-center row">

              <input type="text" class="form-control" id="checkresident" name="resident_no" hidden>
              <input type="text" class="form-control" id="res_id" name="resident_no" hidden>
              <input type="text" class="form-control" id="nonres_id" name="nresident_no" hidden>

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <input type="text" class="form-control" id="fname" name="firstname" placeholder="Enter First Name Here" required disabled>
                  <label for="fname">First Name</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <input type="text" class="form-control" id="mname" name="middlename" placeholder="Enter Middle Name Here" disabled>
                  <label for="mname">Middle Name</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-3">
                  <input type="text" class="form-control" id="lname" name="lastname" placeholder="Enter Last Name Here" required disabled>
                  <label for="lname">Last Name</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-1">
                  <input type="text" class="form-control" id="suffix" name="suffix" style="width:50px" placeholder="Enter Suffix Here" disabled>
                  <label for="suffix">Suffix</label>
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
                  <label for="isavoter">Presented ID</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <input type="text" class="form-control" id="IDnum" name="IDnum" placeholder="Enter Birth Place Here" required>
                  <label for="IDnum">ID Number</label>
              </div> 
              
              <div class="form-floating mt-3 mb-3 col-md-4">
                  <input type="text" class="form-control" id="business_name" name="business_name" placeholder="Enter Subdvision Here">
                  <label for="business_name">Business Name</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-4">
                  <input type="text" class="form-control" id="business_hnum" name="business_hnum" placeholder="Enter Subdvision Here">
                  <label for="address">Bld/House No.</label>
              </div>
                  
              <div class="form-floating mt-3 mb-3 col-md-4">
                  <input type="text" class="form-control" id="business_street" name="business_street" placeholder="Enter Subdvision Here">
                  <label for="address">Street</label>
              </div>

              <div class="form-floating mt-3 mb-3 col-md-4">
                <select class="form-select" id="business_subd" name="business_subd" aria-label="Floating label select example">
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
                <label for="business_subd">Subdivision</label>
              </div>

              <div class="d-flex justify-content-center">
                <div class="form-floating mt-3 mb-3 col-md-4">
                    <select class="form-select" id="business_type" name="business_type" aria-label="Floating label select example" required>
                        <option hidden value="">Select Option</option>
                        <option value="Sari-Sari Store">Sari-Sari Store</option>
                        <option value="Barber Shop">Barber Shop</option>
                        <option value="Salon">Salon</option>
                        <option value="Water Refilling Station">Water Refilling Station</option>
                        <option value="Meat Shop">Meat Shop</option>
                        <option value="Hardware">Hardware</option>
                        <option value="Grocery">Grocery</option>
                        <option value="Vape Shop">Vape Shop</option>
                        <option value="Electronic Shop">Electronic Shop</option>
                        <option value="Electronic Repair Shop">Electronic Repair Shop</option>
                        <option value="Fruit and Vegtables Stand">Fruit and Vegtables Stand </option>
                        <option value="Fruit Stand">Fruit Stand</option>
                        <option value="Vegtable Stand">Vegtable Stand</option>
                        <option value="Vending Machine">Vending Machine</option>
                        <option value="Bakery">Bakery</option>
                        <option value="Drug Store">Drug Store</option>
                        <option value="Pet shop">Pet Shop</option>
                        <option value="Food Stall">Food Stall</option>
                        <option value="Milktea Shop">Milktea Shop</option>
                        <option value="Factory">Factory</option>
                        <option value="Others">Others</option>

                    </select>
                    <label for="business_type">Type of Business</label>
                </div>

                <div class="form-floating mt-3 mb-3 col-md-4">
                    <input type="text" class="form-control" id="otherbusiness_type" name="IDnum" placeholder="" disabled>
                    <label for="other_business_type">Other Business Type</label>
                </div> 
              </div>
       
              
            </div>
          </div>

          <div class="col-md-12 d-flex justify-content-end">

          <br>

          <button type="submit" id="generate_certificate"class="btn btn-success float-right"> Generate Certificate </button> 
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
<!-- <script>-->
<script src="js/create-business-permit.js"></script>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
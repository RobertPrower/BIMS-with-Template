<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Certificate Setings | BIMS</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
                <h2 class="main-title">Manage Certificate Settings</h2>
                    <div class="row pb-3">
                      <div class="col-md-3 card">
                        <div class="text-center">
                          <form id="ChangeCityLogoForm" enctype="multipart/form-data">
                            <div class="mt-3 mb-4">
                                <h4>Change City Logo</h4>
                                <br>
                                <!--input type="hidden" name="MAX_FILE_SIZE" value="1048576"-->
                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                class="img-fluid" id="imagePreview" style="width: 200px;" />
                            </div>

                            <div class="form-floating mt-3 mb-3 col-md-13">
                                <input type="file" class="form-control" id="imagefile" name="city_logo" placeholder="Upload Picture" require>
                                <label for="floatingInput">Upload Image</label>
                                <script src="js/limitfileresanddisplayimg.js"> </script>          
                            </div>  
                            <button type="submit" class="btn btn-success btn-lg">Update</button> 
                          </form>

                            <script> 
                                $(document).ready(function () {
                                  // Attach event listener to form submission
                                  $("#ChangeCityLogoForm").submit(function (event) {
                                    // Prevent the default form submission behavior
                                    event.preventDefault();

                                    // Collect form data using FormData
                                    var formData = new FormData(this);

                                    // Send AJAX request
                                    $.ajax({
                                      url: "includes/updatecitylogo.php",
                                      type: "POST",
                                      data: formData,
                                      dataType: "JSON",
                                      contentType: false, 
                                      processData: false, 
                                      success: function (response) {
                                        swal({
                                          title: "Add Entry",
                                          text: "Entry Added Sucessfully!",
                                          icon: "success",
                                          button: "Close",
                                        });

                                      },
                                      error: function (xhr, status, error) {

                                        // Handle error response
                                        console.error("Error saving data:", error);
                                        // Optionally, display an error message to the user
                                        
                                        swal({
                                          icon: "error",
                                          title: "Oops...",
                                          text: "Something went wrong!",
                                        });
                                      },
                                    });
                                  });
                                });


                            </script>

                        </div>
                      </div>

                      <div class="col-md-3 card">
                        <div class="text-center">
                          <form id="ChangeBrgyLogoForm">
                            <div class="mt-3 mb-4">
                                <h4>Change City Barangay Logo</h4>
                                <br>
                                <!--input type="hidden" name="MAX_FILE_SIZE" value="1048576"-->
                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                class="img-fluid" id="imagePreview" style="width: 200px;" />
                            </div>

                            <div class="form-floating mt-3 mb-3 col-md-13">
                                <input type="file" class="form-control" id="imagefile" name="brgy_logo" placeholder="Upload Picture" require>
                                <label for="floatingInput">Upload Image</label>
                                <script src="js/limitfileresanddisplayimg.js"> </script>
                                <br>
                                <button type="submit" class="btn btn-success btn-lg">Update</button> 
                            </div>  

                            <script> 
                                $(document).ready(function () {
                                  // Attach event listener to form submission
                                  $("#ChangeBrgyLogoForm").submit(function (event) {
                                    // Prevent the default form submission behavior
                                    event.preventDefault();

                                    // Collect form data using FormData
                                    var formData = new FormData(this);

                                    // Send AJAX request
                                    $.ajax({
                                      url: "includes/updatebrgylogo.php",
                                      type: "POST",
                                      data: formData,
                                      dataType: "JSON",
                                      contentType: false, 
                                      processData: false, 
                                      success: function (response) {
                                        swal({
                                          title: "Add Entry",
                                          text: "Entry Added Sucessfully!",
                                          icon: "success",
                                          button: "Close",
                                        });

                                      },
                                      error: function (xhr, status, error) {

                                        // Handle error response
                                        console.error("Error saving data:", error);
                                        // Optionally, display an error message to the user
                                        
                                        swal({
                                          icon: "error",
                                          title: "Oops...",
                                          text: "Something went wrong!",
                                        });
                                      },
                                    });
                                  });
                                });


                            </script>
                          </form>
                                
                        </div>
                      </div>

                      <div class="col-md-3 card">
                        <div class="text-center">
                          <form id="ChangeGovLogoForm">
                            <div class="mt-3 mb-4">
                                <h4>Change Government Logo</h4>
                                <br>
                                <!--input type="hidden" name="MAX_FILE_SIZE" value="1048576"-->
                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                class="img-fluid" id="imagePreview" style="width: 200px;" />
                            </div>

                            <div class="form-floating mt-3 mb-3">
                                <input type="file" class="form-control" id="imagefile" name="gov_logo" placeholder="Upload Picture" require>
                                <label for="floatingInput">Upload Image</label>
                                <script src="js/limitfileresanddisplayimg.js"> </script>
                                <br>
                                <button type="submit" class="btn btn-success btn-lg">Update</button> 
                            </div>  
                          </form>

                            <script> 
                                $(document).ready(function () {
                                  // Attach event listener to form submission
                                  $("#ChangeGovLogoForm").submit(function (event) {
                                    // Prevent the default form submission behavior
                                    event.preventDefault();

                                    // Collect form data using FormData
                                    var formData = new FormData(this);

                                    // Send AJAX request
                                    $.ajax({
                                      url: "includes/updategovlogo.php",
                                      type: "POST",
                                      data: formData,
                                      dataType: "JSON",
                                      contentType: false, 
                                      processData: false, 
                                      success: function (response) {
                                        swal({
                                          title: "Add Entry",
                                          text: "Entry Added Sucessfully!",
                                          icon: "success",
                                          button: "Close",
                                        });

                                      },
                                      error: function (xhr, status, error) {

                                        // Handle error response
                                        console.error("Error saving data:", error);
                                        // Optionally, display an error message to the user
                                        
                                        swal({
                                          icon: "error",
                                          title: "Oops...",
                                          text: "Something went wrong!",
                                        });
                                      },
                                    });
                                  });
                                });


                            </script>

                           

                        </div>
                      </div>

                      <div class="col-md-3 card">
                        <div class="text-center">
                          <form id="ChangeWatermarkForm">
                            <div class="mt-3 mb-4">
                                <h4>Change Watermark</h4>
                                <br>
                                <!--input type="hidden" name="MAX_FILE_SIZE" value="1048576"-->
                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                class="img-fluid" id="imagePreview" style="width: 200px;" />
                            </div>

                            <div class="form-floating mt-3 mb-3">
                                <input type="file" class="form-control" id="imagefile" name="watermark" placeholder="Upload Picture" require>
                                <label for="floatingInput">Upload Image</label>
                                <script src="js/limitfileresanddisplayimg.js"> </script>
                                <br>
                                <button type="submit" class="btn btn-success btn-lg">Update</button> 
                            </div>  
                          </form>

                            <script> 
                                $(document).ready(function () {
                                  // Attach event listener to form submission
                                  $("#ChangeWatermarkForm").submit(function (event) {
                                    // Prevent the default form submission behavior
                                    event.preventDefault();

                                    // Collect form data using FormData
                                    var formData = new FormData(this);

                                    // Send AJAX request
                                    $.ajax({
                                      url: "includes/updatewatermark.php",
                                      type: "POST",
                                      data: formData,
                                      dataType: "JSON",
                                      contentType: false, 
                                      processData: false, 
                                      success: function (response) {
                                        swal({
                                          title: "Add Entry",
                                          text: "Entry Added Sucessfully!",
                                          icon: "success",
                                          button: "Close",
                                        });

                                      },
                                      error: function (xhr, status, error) {

                                        // Handle error response
                                        console.error("Error saving data:", error);
                                        // Optionally, display an error message to the user
                                        
                                        swal({
                                          icon: "error",
                                          title: "Oops...",
                                          text: "Something went wrong!",
                                        });
                                      },
                                    });
                                  });
                                });


                            </script>

                           

                        </div>
                      </div>
                    </div>
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
</body>

</html>
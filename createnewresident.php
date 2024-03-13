<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BIMS</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="./css/style.min.css">

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
      <?php

      include ("includes/header.php");

      ?>
    <div class="container">
    <form action="include/addresidentbtn.php" method="POST" enctype="multipart/form-data">
        <div class="form first" style="height: 850px">
            <div class="row">
                <span class="title"><h2>Create New Resident</h2></span>

                <div class="card col-md-9 p-4 mt-4 " style="border-radius: 20px;">
                    <div class=" text-center row">

                          <div class="form-floating mt-4 mb-3 col-md-4">
                            <input type="text" class="form-control" id="floatingInput">
                            <label for="floatingInput">First Name</label>
                          </div>

                          <div class="form-floating mt-4 mb-3 col-md-4">
                            <input type="text" class="form-control" id="floatingInput">
                            <label for="floatingInput">Middle Name</label>
                          </div>

                          <div class="form-floating mt-4 mb-3 col-md-4">
                            <input type="text" class="form-control" id="floatingInput">
                            <label for="floatingInput">Last Name</label>
                          </div>

                          <div class="form-floating mt-4 mb-3 col-md-4">
                            <input type="text" class="form-control" id="floatingInput" >
                            <label for="floatingInput">House No. (Blk no, Lot no, Unit no)</label>
                          </div>

                          <div class="form-floating mt-4 mb-3 col-md-4">
                            <input type="text" class="form-control" id="floatingInput" >
                            <label for="floatingInput">Street</label>
                          </div>

                          <div class="form-floating mt-4 mb-3 col-md-4">
                            <input type="text" class="form-control" id="floatingInput" >
                            <label for="floatingInput">Subdivision</label>
                          </div>

                          <div class="mt-3 mb-3 col-md-4">
                            <select class="form-select" aria-label="Default select example" Style="Height: 58px">
                              <option hidden selected>Sex</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
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
                            <input type="Date" class="form-control" id="floatingInput">
                            <label for="floatingInput">Birth Date</label>
                          </div> 

                          <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="Text" class="form-control" id="floatingInput">
                            <label for="floatingInput">Birth Place</label>
                          </div> 

                          <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="" class="form-control" id="floatingInput">
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

                <div class="justify-content-md-end col-md-3 mt-3 row-md-3">

                  <div class="card" style="border-radius: 20px; height: 300 px">
                      <div class="card-body text-center">
                          <div class="mt-3 mb-4">
                              <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                              class="rounded-circle img-fluid" style="width: 100px;" />
                            <div class="form-floating mt-3 mb-3 col-md-12">
                              <input type="file" class="form-control" id="floatingInput" placeholder="Upload Picture">
                              <label for="floatingInput">Upload Image</label>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>

                
                
                </div><!--End of Fields -->
            </div><!-- End of Personal Details -->
        </div> <!-- End of First Form> -->
    </form>
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
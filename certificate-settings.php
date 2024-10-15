<?php 
    require_once("includes/connecttodb.php");

    $logoquery = "SELECT * FROM `certificate-img`";
    $logostmt = $pdo->prepare($logoquery);
    $logostmt->execute();
    $logorecords = $logostmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($logorecords as $logo){

      $brgylogo[] = $logo['filename'];

    }

    $brgyofficialsquery="SELECT * FROM brgy_officials";
    $brgyofficialsstmt = $pdo->prepare($brgyofficialsquery);
    $brgyofficialsstmt->execute();
    $brgyofficialsrecords = $brgyofficialsstmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($brgyofficialsrecords as $officials){
      $brgyofficials[] = $officials['official_name'];
    }

    $brgykagawadquery = "SELECT * FROM kagawad";
    $brgykagawadstmt = $pdo->prepare($brgykagawadquery);
    $brgykagawadstmt->execute();
    $brgykagawadrecords = $brgykagawadstmt->fetchAll(PDO::FETCH_ASSOC);

    $brgydetailsquery = "SELECT * FROM brgy_details";
    $brgydetailstmt = $pdo->prepare($brgydetailsquery);
    $brgydetailstmt->execute();
    $brgydetailsraw = $brgydetailstmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($brgydetailsraw as $brgydetailsarray){
      $brgy_name[] = $brgydetailsarray['brgy_name'];
      $brgy_address[] = $brgydetailsarray['address'];
      $brgy_tel_num[] = $brgydetailsarray['tel_num'];
      $brgy_cel_num[] = $brgydetailsarray['cp_num'];
      $brgy_email[] = $brgydetailsarray['email'];
      $brgy_sona[] = $brgydetailsarray['sona'];
      $brgy_district[] = $brgydetailsarray['district'];


    }

    $pdo = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Certificate Setings | BIMS</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="img/Brgy177.png" type="image/x-icon">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">
  <link rel="stylesheet" href="./css/changelogo.css">
  <link rel="stylesheet" href="./css/sweetalert2.min.css">


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
                  <h4>Change Logo</h4>
                  <br>

                  <div class="row pb-3">
                    <div class="col-xl-3">
                          <!-- Profile picture card-->
                          <div class="card mb-4 mb-xl-0">
                              <div class="card-header">Administration Logo</div>
                                <div class="card-body text-center">
                                    <!-- Profile picture image-->
                                    <img class="img-account-profile rounded-circle mb-2" src="img/<?php echo $brgylogo[0]; ?>" alt="">
                                    <!-- Profile picture help block-->
                                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                    <!-- Profile picture upload button-->
                                    <button class="btn btn-primary" type="button">Upload new image</button>
                                </div>
                          </div>
                      </div>

                      <div class="col-xl-3">
                          <!-- Profile picture card-->
                          <div class="card mb-4 mb-xl-0">
                              <div class="card-header">City Logo</div>
                                <div class="card-body text-center">
                                    <!-- Profile picture image-->
                                    <img class="img-account-profile rounded-circle mb-2" src="img/<?php echo $brgylogo[1]; ?>" alt="">
                                    <!-- Profile picture help block-->
                                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                    <!-- Profile picture upload button-->
                                    <button class="btn btn-primary" type="button">Upload new image</button>
                                </div>
                          </div>
                      </div>

                      <div class="col-xl-3">
                          <!-- Profile picture card-->
                          <div class="card mb-4 mb-xl-0">
                              <div class="card-header">Brgy Logo</div>
                                <div class="card-body text-center">
                                    <!-- Profile picture image-->
                                    <img class="img-account-profile rounded-circle mb-2" src="img/<?php echo $brgylogo[3]; ?>" alt="">
                                    <!-- Profile picture help block-->
                                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                    <!-- Profile picture upload button-->
                                    <button class="btn btn-primary" type="button">Upload new image</button>
                                </div>
                          </div>
                      </div>

                      <div class="col-xl-3  ">
                          <!-- Profile picture card-->
                          <div class="card mb-4 mb-xl-0">
                              <div class="card-header">Watermark</div>
                                <div class="card-body text-center">
                                    <!-- Profile picture image-->
                                    <img class="img-account-profile rounded-circle mb-2" src="img/<?php echo $brgylogo[4]; ?>" alt="">
                                    <!-- Profile picture help block-->
                                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                    <!-- Profile picture upload button-->
                                    <button class="btn btn-primary" type="button">Upload new image</button>
                                </div>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                    <div class="col-6">
                      <div class="card">
                        <div class="card-body">
                            <div>
                                <div class="row">
                                  <div class="col-10">
                                    <h4 class="card-title mb-4">Barangay Details</h4> 
                                  </div>
                                  <div class="col-1">
                                  <button class="btn btn-success" id="EditBrgyDetailsBtn" data-bs-toggle="modal"  data-bs-target="#EditBrgyDetails"
                                   data-brgyname="<?php echo $brgy_name[0]?>" data-brgyaddress="<?php echo $brgy_address[0]?>" data-sona="<?php echo $brgy_sona[0] ?>" data-district="<?php echo $brgy_district[0] ?>"
                                    data-brgytelnum="<?php echo $brgy_tel_num[0]?>" data-brgycpnum="<?php echo $brgy_cel_num[0]?>" 
                                    data-brgyemail="<?php echo $brgy_email[0]?>"> Edit</button>
                                  </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Barangay Name</th>
                                                <td id="barangay_name">
                                                  <?php  
                                                  foreach($brgydetailsraw as $details){
                                                    if(isset($details['brgy_name'])){
                                                      echo $details['brgy_name'];
                                                    };

                                                  } ?>
                                                </td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Barangay Sona</th>
                                                <td id="barangay_sona">
                                                  <?php  
                                                  foreach($brgydetailsraw as $details){
                                                    if(isset($details['sona'])){
                                                      echo $details['sona'];
                                                    };

                                                  } ?>
                                                </td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Barangay District</th>
                                                <td id="barangay_district">
                                                  <?php  
                                                  foreach($brgydetailsraw as $details){
                                                    if(isset($details['district'])){
                                                      echo $details['district'];
                                                    };

                                                  } ?>
                                                </td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Barangay Address</th>
                                                <td id="barangay_address">
                                                <?php  
                                                  foreach($brgydetailsraw as $details){
                                                    if(isset($details['address'])){
                                                      echo $details['address'];
                                                    };

                                                  } ?>
                                                </td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Baranagy Cellphone Number</th>
                                                <td id="barangay_cellnum"> <?php  
                                                  foreach($brgydetailsraw as $details){
                                                    if(isset($details['cp_num'])){
                                                      echo $details['cp_num'];
                                                    };

                                                  } ?></tr></td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Barangay Telephone Number</th>
                                                <td id="barangay_telnum">
                                                <?php  
                                                  foreach($brgydetailsraw as $details){
                                                    if(isset($details['tel_num'])){
                                                      echo $details['tel_num'];
                                                    };

                                                  } ?>
                                                </td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Barangay Email</th>
                                                <td id="barangay_email"> <?php  
                                                  foreach($brgydetailsraw as $details){
                                                    if(isset($details['email'])){
                                                      echo $details['email'];
                                                    };

                                                  } ?></td>
                                            </tr><!-- end tr -->
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div>
                            </div>
                        </div><!-- end card body -->
                      </div><!-- end card -->
                    </div>

                    <div class="col-6">
                      <div class="card">
                        <div class="card-body">
                            <div>
                                <div class="row">
                                  <div class="col-10">
                                    <h4 class="card-title mb-4">Barangay Officials</h4> 
                                  </div>
                                  <div class="col-1">
                                  <button class="btn btn-success" id="EditBrgyOfficialsBtn"  data-bs-toggle="modal"  data-bs-target="#EditBrgyOfficials" data-punong_brgy="<?php echo $brgyofficials[0]?>"
                                  data-brgy_sec="<?php echo $brgyofficials[2]?>" data-brgy_sk="<?php echo $brgyofficials[1]?>"> Edit</button>
                                  </div>
                                </div> 

                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Punong Barangay</th>
                                                <td id="punong_brgy"><?php echo $brgyofficials[0]?></td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Barangay Secretary</th>
                                                <td id="brgy_sec"><?php echo $brgyofficials[2]?></td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Barangay SK Chairman</th>
                                                <td id="brgy_sk"><?php echo $brgyofficials[1]?></td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Barangay Kagawads </th>
                                                <td id="brgy_kagawads"><?php 
                                                  foreach ($brgykagawadrecords as $kagawad){
                                                    $kagawadname[] = $kagawad['official_name'];
                                                  }

                                                  echo implode(', ',$kagawadname);

                                                
                                                ?></td>
                                            </tr><!-- end tr -->
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div>
                            </div>
                        </div><!-- end card body -->
                      </div><!-- end card -->
                    </div>

                    <!-- Edit Barangay Details -->
                    <div class="modal fade" id="EditBrgyOfficials" tabindex="-1" aria-labelledby="EditBrgyOfficialsLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="EditBrgyOfficialsLabel">Edit Barangay Officials</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                          <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Barangay Officials</button>
                              <button class="nav-link" id="nav-kagawad-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Manage Barangay Kagawad</button>
                            </div>
                          </nav>
                            <div class="tab-content" id="nav-tabContent">
                              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                <div class="form-floating my-3">
                                  <input type="text" class="form-control" id="punong_barangay" placeholder=""/>
                                  <label for="punong_barangay">Punong Barangay</label>
                                </div>
                                <div class="form-floating mb-3">
                                  <input type="text" class="form-control" id="brgy_secretary" placeholder=""/>
                                  <label for="brgy_secretary">Barangay Secretary</label>
                                </div>
                                <div class="form-floating mb-3">
                                  <input type="text" class="form-control" id="brgy_skchair" placeholder=""/>
                                  <label for="brgy_skchair">Barangay SK Chairperson</label>
                                </div>
                                <div class="d-flex justify-content-end">
                                  <button type="button" class="btn btn-primary psskbtnsave">Save changes</button>
                                </div>
                              </div>
                              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0" id="kagawadtable">
                                        <tbody>
                                            
                              
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal fade" id="EditBrgyDetails" tabindex="-1" aria-labelledby="EditBrgyDetailsLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="EditBrgyDetailsLabel">Edit Barangay Details</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="#" id="brgydetailsform">                        
                          <div class="modal-body">
                                              
                                <div class="form-floating my-3">
                                  <input type="text" class="form-control" id="brgy_name" name="brgy_name" placeholder=""/>
                                  <label for="brgy_name">Brgy Name</label>
                                </div>
                                <div class="form-floating my-3">
                                  <input type="text" class="form-control" id="brgy_sona" name="brgy_sona" placeholder=""/>
                                  <label for="brgy_sona">Brgy Sona</label>
                                </div>
                                <div class="form-floating my-3">
                                  <input type="text" class="form-control" id="brgy_district" name="brgy_district" placeholder=""/>
                                  <label for="brgy_district">Brgy District</label>
                                </div>
                                <div class="form-floating mb-3">
                                  <input type="text" class="form-control" id="brgy_address" name="brgy_address" placeholder=""/>
                                  <label for="brgy_address">Barangay Address</label>
                                </div>
                                <div class="form-floating mb-3">
                                  <input type="text" class="form-control" id="brgy_celnum" name="brgy_celnum" placeholder=""/>
                                  <label for="brgy_cellnum">Barangay Cel Number</label>
                                </div>
                                <div class="form-floating mb-3">
                                  <input type="text" class="form-control" id="brgy_telnum" name="brgy_telnum" placeholder=""/>
                                  <label for="brgy_tellnum">Barangay Tel Number</label>
                                </div>
                                <div class="form-floating mb-3">
                                  <input type="text" class="form-control" id="brgy_email" name="brgy_email" placeholder=""/>
                                  <label for="brgy_email">Barangay Email</label>
                                </div>
                                <div class="d-flex justify-content-end">
                                  <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                             
                            </div>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <div>
                  </div>
                </div>

                
               
        </div>
        </main>
    
    <!-- ! Footer -->
      <?php require_once("includes/footer.php")?>
    </div>
</div>
<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/sweetalert2.min.js"></script>
<script src="js/brgysettings.js"></script>
<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
</body>

</html>
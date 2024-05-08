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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

    <?php require_once("includes/header.php")?>

    <!-- ! Main -->
    <main class="main users chart-page" id="skip-target">
      <div class="container">
        <h2 class="main-title">Create Documents</h2>
        <div class="row container">
          <style>

              .btn-for-docu:hover {
                background-color: #CED8FF;
                opacity: 50;
                padding: 0.5rem 1rem;
                border: solid;
                border-color: black;
                border-radius: 20px;
                cursor: pointer;
                transition: background-color 0.2s ease;
                
              }
          </style>

          <div class="col-md-6 col-xl-3">
            <a class="stat-cards-item btn-for-docu">
              <div class="stat-cards-icon primary" id="btnBrgyIDreq">
                <i data-feather="bar-chart-2" aria-hidden="true">
                </i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Barangay ID request</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-xl-3">
            <a class="stat-cards-item btn-for-docu">
              <div class="stat-cards-icon warning">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Barangay Clearances</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-xl-3">
            <a class="stat-cards-item btn-for-docu" data-bs-toggle="modal" data-bs-target="#certificate-of-residency">
              <div class="stat-cards-icon purple">
                <i data-feather="home" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Residency</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </a>
          </div>

          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">New First-Time-Job-Seeker</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </article>
          </div>

          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon purple">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">Good Moral</p>
                <p class="stat-cards-info__progress">
                </p>
              </div>
            </article>
          </div>
        </div>
      </div>
      <!-- Modal Content For certificate-of-residency -->
      <div class="modal fade" id="certificate-of-residency" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Create a Certificate of Residency</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Select Resident</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Fill up the form</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button>
                  </li>
              </ul>
                <div class="tab-content" id="myTabContent">

                  <!-- 1st Tab Content-->

                  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                    <!-- Table Content -->
                
                    <div class="content pt-2">
                      <div class="users-table table-wrapper">
                      <table class="tablehover ResidentTable" id="ResidentTable" style="scale: 98%;">
                          <thead>
                          <tr class="users-table-info">
              
                              <!-- <th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th> -->
                              <th style="width:  1%;"class="text-center resident_id">ID</th> 
                              <th style="width: 15%;"class="text-center">Date Recorded</th>
                              <th style="width: 15%;" class="text-center">Full Name</th>
                              <th style="width: 20%;" class="text-center">Address</th>
                              <th style="width: 5%;" class="text-center">Sex</th>
                              <th style="width: 8%;" class="text-center">Marital Status</th>
                              <th style="width: 20%;" class="text-center">Birth Date</th>
                              <th style="width: 25%;" class="text-center">Birth Place</th>
                              <th style="width: 10%;" class="text-center">Phone Number</th>
                              <th style="width: 1%;" class="text-center">Is a Voter</th>
                          </tr>
                          </thead>
                          <tbody>
                          
                          
                          <?php

                          require_once('includes/residentsearchfunction.php');
                              
                          //To Populate table rows with user data
                          foreach ($result as $row) {
                              echo "<tr class='text-center'>";
                              // echo '<td><input type="checkbox" class="check-all"></td>';
                              echo "<td class='resident_id'>{$row['resident_id']}</td>";
                              echo "<td>{$row['date_recorded']}</td>";
                              echo "<td>{$row['last_name']}, {$row['first_name']} {$row['middle_name']} {$row['suffix']}</td>";
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
                              
                              if($row['is_a_voter'] == 1){
                              echo "<td>YES</td>";
                              }else{
                              echo "<td>NO</td>";
                              }
                          }
                          ?>
                          </tbody>
                      
                          
                          <!-- </tbody> -->

                      
                      </table>
                      <!-- End of Table -->
                      </div>
                    </div>
                    

                  </div>
                  <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">...</div>
                  <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
                  <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="nextbtn">Next</button>
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
<script>
$('#certificate-of-residency').on('shown.bs.modal', function () {
    $('#ResidentTable').DataTable();     
});
</script>

<script>
$("table tr").click(function(){
    $(this).toggleClass("selected").siblings().removeClass("selected");
      var id = $(this).find(".resident_id").text(); 
      var table = $('#ResidentTable').DataTable();

      console.log(id);

     table.on('search.dt', function() {
    $('table tr.selected').removeClass('selected');
    });
});
</script>



<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
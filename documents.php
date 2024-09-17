<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BIMS | Requested Documents</title>
  
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/Brgy177.png" type="image/x-icon">

  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">

    <!--JavaScript-->
  <script src="js/jquery-3.7.1.min.js"></script>
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
        <!-- ! Main nav/Header -->
        <?php require_once("includes/header.php")?>
        <!-- ! Main -->
        <main>
          <div class="container">
              <div class="container p-3">
                  <h2 class="main-title">Manage Documents</h2>
                  <div class="row pb-3">
                      <div class="col-md-8">
                          <!-- Buttons -->
                          <div class="d-flex justify-content-start" style="padding-left: 15px;">
                          
                              <!-- Button to trigger modal -->
                              <a type="button" class="btn btn-primary me-2" href="create-documents.php">New Certificate</a>
                              
                              <div class="form-check form-switch my-2">
                                  <input class="form-check-input" type="checkbox" id="showdeletedentries">
                                  <label class="form-check-label" for="showdeletedentries">Show deleted entries</label>
                              </div>

                                <?php 
                                
                                include_once'includes/residentviewform.php';
                                require_once'includes/documentdetailsmodal.php';

                                
                                ?>

                                <!-- Modal For the edit-->
                                <div class="modal fade" id="EditDocumentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Document</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="EditDocumentModalForm">
                                            <div class="modal-body">
                                                <div class="container">

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
                                                        <input type="text" hidden class="form-control" id="requestid" name="request_id"/>
                                                        <input type="date" class="form-control" id="expiration" name="expiration"/>
                                                        <label for="expiration">Expiration</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
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

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
                                                        <input type="text" class="form-control" id="id_num" name="id_num"/>
                                                        <label for="id_num">ID number</label>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-target="#DocumentDetailsModal" data-bs-toggle="modal" >Close</button>
                                                <button id="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for the Certificate of residency -->
                                <div class="modal fade" id="RegenerateResidencyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form >
                                        <div class="modal-body">
                                            <input hidden id="fname" name="firstname">
                                            <input hidden id="lname" name="lastname">
                                            <input hidden id="mname" name="middlename">
                                            <input hidden id="suffix" name="suffix">
                                            <input hidden id="address" name="address">
                                            <input hidden id="age" name="age">
                                            <input hidden id="presentedid" name="presented_id">
                                            <input hidden id="IDnum" name="IDnum">
                                            <input hidden id="r_since" name="r_since">




                                            <iframe id="generatepdf" src=""></iframe>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>

                          
                          </div>
                      </div>

                      <div class="container col-md-3">
                          <div class="row">
                          <!-- Search Box -->
                              <div class="search-wrapper">
                                                        
                              <button type="submit" class="btn-sm btn-light" data-feather="search" aria-hidden="true" required></button>
                              <input type="text" class="form-control me-2" id="searchbox" name="search" placeholder="Search...">
                                  
                              </div>
                          </div>
                      </div>
                  
                      
                  </div>

                  <div class="users-table table-wrapper">
                      <!-- users-table table-wrapper -->
                      <table class="users-table table-wrapper" id="DocumentsTable" style="width:100%">
                          <thead>
                          <tr>
              
                              <!--th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th--> 
                              <th style="width: 8%"class="text-center resident_id">Request ID</th> 
                              <th style="width: 8%;"class="text-center">Date Requested</th>
                              <th style="width: 8%;"class="text-center">Expiration Date</th>
                              <th style="width: 8%;"class="text-center">Residency Status</th>
                              <th style="width: 15%;" class="text-center">Full Name</th>
                              <th style="width: 15%;" class="text-center">Address</th>
                              <th style="width: 10%;" class="text-center">Document Description</th>
                              <th style="width: 10%;" class="text-center">Purpose</th>
                              <th style="width: 10%;" class="text-center">Status</th>
                              <th style="width: 5%;" class="text-center">Action</th>

                          </tr>
                          </thead>

                          <tbody id="DocumentsTableBody">
                          <!-- Table Body -->
                          
                              <!-- To be filled by the AJAX -->

                          </tbody> 
                          <!-- </tbody> -->
                      </table>
                      <!-- End of Table -->
                  </div>
                

                <!-- Pagination Controls -->
                <nav aria-label="Page navigation">
                      <ul class="pagination justify-content-end">
                      
                      <!-- Previous Button -->
                      
                          <li class="page-item">
                              <a class="page-link" href="#">Previous</a>
                          </li>
                      

                          <!-- Page Numbers -->
                          
                              <li class="page-item">
                                  <a class="page-link" href="#" data-page=""></a>
                              </li>
                        

                          <!-- Next Button -->
                        
                              <li class="page-item">
                                  <a class="page-link" href="#">Next</a>
                              </li>
                          
                      </ul>
                </nav>
              </div>
          </div>
        </main>
    
    <!-- ! Footer -->
  <?php require_once("includes/footer.php")?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
<script src="js/documents.js"></script>
<script src="js/sidebar.js"></script>

</body>

</html>
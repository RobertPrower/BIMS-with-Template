<?php 
    require_once('includes/connecttodb.php');
    require_once 'includes/config.php';
    require_once 'includes/enforce_login.php';
    
    $logoquery = "SELECT `filename` FROM `certificate-img` WHERE purpose = 'Barangay Logo'";
    $logostmt = $pdo->prepare($logoquery);
    $logostmt -> execute();
    $logo = $logostmt -> fetchColumn(); 

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Blotter</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="img/logos/<?php echo $logo; ?>" type="image/x-icon">
  <!-- Custom styles -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">
  <link rel="stylesheet" href="css/sweetalert2.min.css">
  <!-- <link rel="stylesheet" href="css/changelogo.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />



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
            <h2 class="main-title">Create Blotter</h2>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-start" style="padding-left: 15px;">
                    
                        <!-- Button to trigger modal -->
                        <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#AddResidentModal">New Resident</button>
                        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#AddNonResidentModal" id="AddNonResidentBtn">New Non Resident</button>    

                    </div>
                    <?php 
                        require_once 'includes/residentaddform.php';
                        require_once 'includes/residentviewform.php';
                        require_once 'includes/nonresidentaddform.php';
                        require_once 'includes/nonresidentviewform.php';
                        require('includes/selectresidentmodal.php');
                        require('includes/selectnonresidentmodal.php');
                        require('includes/schedulemodal.php');
                    ?> 
                    
                    <div class="col-md-12 d-flex align-items-center justify-content-between">
                        <b>Step 1: Select Complainant Person Record</b>
                        <div class="d-flex">
                            <button class="btn btn-primary mx-2 SelectResidentBtn" id="SelectResidentComplainant" data-whatparty="complainant">Select Resident</button>
                            <button class="btn btn-warning SelectNonResidentBtn" id="SelectNonResidentComplainant" data-whatparty="complainant">Select Non-Resident</button>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-2 card m-3 p-3  d-flex justify-content-center align-items-center" style="border-radius: 10px;padding: 10px;object-fit: contain; max-width: 100%; max-height: 100%">
                            
                            <img src="includes/img/blank-profile.webp" id="ComplainantImg" width="200" height="200" style="object-fit: contain; max-width: 100%; max-height: 100%;"/>
                            
                        </div>

                        <div class="col-md-9 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;">
                            <div class="card-header">
                                Reporting Person/Complainant Details
                                                
                            </div>

                            <div class="text-center row">

                                <input type="text" class="form-control" id="checkresident" hidden/>
                                <input type="text" class="form-control" id="id_to_record" hidden/>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="f_name" name="firstname" placeholder="Enter First Name Here" required disabled/>
                                    <label for="fname">First Name</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="m_name" name="middlename" placeholder="Enter Middle Name Here" disabled/>
                                    <label for="mname">Middle Name</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-2">
                                    <input type="text" class="form-control" id="l_name" name="lastname" placeholder="Enter Last Name Here" required disabled/>
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
                            
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 d-flex align-items-center justify-content-between">
                        <b>Step 2: Select Respondent Person Record</b>
                        <div class="d-flex">
                            <button class="btn btn-primary mx-2 respondent SelectResidentBtnRes" id="SelectResidentRes" data-whatparty="respondent">Select Resident</button>
                            <button class="btn btn-warning respondent SelectNonResidentBtnRes" id="SelectNonResidentRes" data-whatparty="respondent">Select Non-Resident</button>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-2 card m-3 p-3 d-flex justify-content-center align-items-center" style="border-radius: 10px;padding: 10px;object-fit: contain; max-width: 100%; max-height: 100%">
                            
                            <img src="includes/img/blank-profile.webp" id="RespondentImg" width="200" height="200" style="object-fit: contain; max-width: 100%; max-height: 100%"/>
                            
                        </div>

                        <div class="col-md-9 card m-4" style="border-radius: 10px;" style="padding: 10px;">
                            <div class="card-header">
                                Respondent/Offender Details
                                                
                            </div>

                            <div class="text-center row">

                            <input type="text" class="form-control" id="checkresidentres" name="resident_no" hidden/>
                            <input type="text" class="form-control" id="id_to_recordres" name="resident_no" hidden/>

                            <div class="form-floating mt-3 mb-3 col-md-4">
                                <input type="text" class="form-control" id="fnameres" name="firstname" placeholder="Enter First Name Here" required disabled/>
                                <label for="fname">First Name</label>
                            </div>

                            <div class="form-floating mt-3 mb-3 col-md-4">
                                <input type="text" class="form-control" id="mnameres" name="middlename" placeholder="Enter Middle Name Here" disabled/>
                                <label for="mname">Middle Name</label>
                            </div>

                            <div class="form-floating mt-3 mb-3 col-md-2">
                                <input type="text" class="form-control" id="lnameres" name="lastname" placeholder="Enter Last Name Here" required disabled/>
                                <label for="lname">Last Name</label>
                            </div>

                            <div class="form-floating mt-3 mb-3 col-md-2">
                                <input type="text" class="form-control" id="suffixres" name="lastname" placeholder="Enter Last Name Here" required disabled/>
                                <label for="lname">Suffix</label>
                            </div>

                            <div class="form-floating mt-3 mb-3 col-md-12">
                                <input type="text" class="form-control" id="addressres" name="address" placeholder="Enter Subdvision Here" disabled/>
                                <label for="subd">Complete Address</label>
                            </div>

                            
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 d-flex align-items-center justify-content-between">
                        <b>Step 3: Select Other Person Involved (If Applicable)</b>
                    </div>

                    <div class="col-md-12 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;">
                        <div class="card-header">
                        Other Person Involved (Max of 5 Persons per Complainat and Respondent)
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <br>
                                <div class="row">
                                    <div class="col-md-6 text-center">
                                        <h5>Other Resident Complainants</h5>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <button class="btn btn-primary mx-2 AddOtherPartyBtn" data-whatparty="othercomplainant" data-whatbtn="SelectResidentComplainant" disabled>Add</button>
                                    </div>
                                </div>

                                <br>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                        <th scope="col" hidden>#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Fullname</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ResidentComplainant">
                                    
                                    
                                    </tbody>
                                </table>

                            </div>

                            <div class="col-md-6">
                                <br>
                                <div class="row">
                                    <div class="col-md-7">
                                        <h5>Other Non-Resident Complainants</h5>
                                    </div>
                                    <div class="col-md-5 d-flex justify-content-end">
                                        <button class="btn btn-primary mx-2 AddOtherPartyBtn" data-whatparty="othercomplainant" data-whatbtn="SelectNonResidentComplainant" disabled>Add</button>
                                    </div>
                                </div>
                                <br>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                        <th scope="col" hidden></th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Fullname</th>
                                        </tr>
                                    </thead>
                                    <tbody id="NonResComplainant">
                                    
                                    
                                    </tbody>
                                </table>

                            </div>

                            <div class="col-md-6">
                                <br>
                                <div class="row">
                                    <div class="col-md-6 text-center">
                                        <h5>Other Resident Respondents</h5>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <button class="btn btn-primary mx-2 AddOtherPartyBtn" data-whatparty="otherrespondent" data-whatbtn="SelectResidentComplainant" disabled>Add</button>
                                    </div>
                                </div>
                                <br>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col" hidden>#</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Fullname</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ResidentRespondent">
                                    
                                
                                    </tbody>
                                </table>

                            </div>

                            <div class="col-md-6">
                                <br>
                                <div class="row">
                                    <div class="col-md-7 text-center">
                                        <h5>Other Non-Resident Respondents</h5>
                                    </div>
                                    <div class="col-md-64 d-flex justify-content-end">
                                        <button class="btn btn-primary mx-2 AddOtherPartyBtn" data-whatparty="otherrespondent" data-whatbtn="SelectOtherNonResRespondent" disabled>Add</button>
                                    </div>
                                </div>
                                <br>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                        <th scope="col" hidden>#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Fullname</th>
                                        </tr>
                                    </thead>
                                    <tbody id="NonResRespondent">
                                    
                                    </tbody>
                                </table>

                            </div>
                        
                        </div>
                    
                    </div>

                

                    <div class="col-md-12 d-flex align-items-center justify-content-between">
                        <b>Step 4: Select Available Schedule</b>
                        <div class="d-flex">
                            <button class="btn btn-primary mx-2" id="pick_schedule_btn">Pick Schedule</button>
                        </div>
                    </div>
                <form id="blotter_form">

                    <div class="col-md-12 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;">
                        <div class="card-header">
                        Schedule of the Mediation      
                        </div>

                        <div class="text-center row">
                            <div class="form-floating mt-3 mb-3 col-md-2">
                                <input type="date" class="form-control" id="schedule_date" name="schedule_date" placeholder="" disabled/>
                                <label for="subd">Mediation Date</label>
                            </div>
                            <div class="form-floating mt-3 mb-3 col-md-2">
                                <input type="time" class="form-control" id="schedule_starttime" name="schedule_date" placeholder="" disabled/>
                                <label for="subd">Mediation Start Time</label>
                            </div>
                            <div class="form-floating mt-3 mb-3 col-md-2">
                                <input type="time" class="form-control" id="schedule_endtime" name="schedule_time" placeholder="" disabled/>
                                <label for="subd">Mediation End Time</label>
                            </div>
                            <div class="form-floating mt-3 mb-3 col-md-2">
                            
                                <input type="color" class="form-control" id="schedule_color" name="schedule_color">
                                <label for="schedule_color">Schedule Color</label>

                            </div>
                            <div class="form-floating mt-3 mb-3 col-md-4">
                            <select class="form-select" id="mediator_name" aria-label="Floating label select example" require>
                                <option value="" selected hidden>Select Mediator</option>
                            
                            </select>
                            <label for="mediator_name">Mediator</label>
                        </div>
                        </div>

                    
                    </div>

                    <div class="col-md-12 d-flex align-items-center justify-content-between">
                        <b>Step 5: Fill Blotter Details</b>
                    </div>

                    <div class="col-md-12 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;">
                        <div class="card-header">
                            Details of the Incident
                                            
                        </div>

                        <div class="text-center row">

                        <input type="text" class="form-control" id="checkresidentres" name="resident_no" hidden/>
                        <input type="text" class="form-control" id="id_to_recordres" name="resident_no" hidden/>

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="text" class="form-control" id="incident_date" name="incident_date" placeholder="Enter First Name Here" required/>
                            <label for="fname">Incident Date and Time</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="text" class="form-control" id="incident_location" name="incident_location" placeholder="Enter Middle Name Here" required/>
                            <label for="mname">Location of the Incident</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <select class="form-select" id="blotter_type" name="blotter_type" aria-label="Floating label select example" required>
                                <option value="" selected hidden>Select</option>
                                <option value="0">Blotter</option>
                                <option value="1">Incident</option>
                            </select>
                            <label for="blotter_type">Blotter Type</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="text" class="form-control" id="incident_desc" name="incident_desc" placeholder="Enter Subdvision Here" required/>
                            <label for="subd">Description of the Incident</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="file" class="form-control" id="blotter_evidence" name="blotter_evidencefile" placeholder="Enter Subdvision Here" required/>
                            <label for="subd">Upload Image Evidence</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="file" class="form-control" id="blotter_filecontext" name="blotter_contextfile" placeholder="Enter Subdvision Here" required/>
                            <label for="subd">Upload Image Evidence</label>
                        </div>

                        <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="case_context" name="case_context" style="height: 500px; border: 1.5px solid black;"></textarea>
                            <label for="floatingTextarea">Context of the Case</label>
                        </div>

                        
                        </div>

                    
                    </div>

                    <div class="col-md-12 d-flex justify-content-end">

                        <br>

                        <button type="submit" id="AddBlotterBtn" class="btn btn-success float-right"> Add Blotter </button> 
                    </div>
                </form>
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

<script src="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.11/dist/js/tempus-dominus.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha256-BRqBN7dYgABqtY9Hd4ynE+1slnEw+roEPFzQ7TRRfcg=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.11/dist/js/jQuery-provider.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
<script src="js/sidebar.js"></script>
<script src="js/residentviewmodal.js"></script>
<script src="js/nonresidentaction.js"></script>
<script src="js/create-blotters.js"></script>
<script src="js/selectresnonresmodal.js"></script>
<script src="js/schedulemodal.js"></script>
<script src="js/camerafunction.js"></script>
<!-- <script src="js/limitfileresanddisplayimg.js"></script>
<script src="js/LimitFileUploadAndDisplayImgForEdit.js"></script>
<script src="js/limitfileresanddisplayimg.js"></script> -->
<!-- <script src="js/displayimagedata.js"></script> -->



</body>

</html>
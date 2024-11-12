<?php
require_once('includes/connecttodb.php');
$logoquery = "SELECT `filename` FROM `certificate-img` WHERE purpose = 'Barangay Logo'";
$logostmt = $pdo->prepare($logoquery);
$logostmt->execute();
$logo = $logostmt->fetchColumn();

function hasPermission($requiredRole) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $requiredRole;
}

if (hasPermission('admin')) {

}

// $_SESSION['user_role'] = $user['role']; // Set user dept

// if ($_SESSION['user_role'] !='admin' || !$_SESSION['user_role'] != 'blotter') {
//     echo "Access denied!";
//     exit;
// }       

$pdo = null; // Close DB

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blotters | BIMS</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/logos/<?php echo $logo; ?>" type="image/x-icon">
    <!-- Custom styles -->
    <link href="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.css" rel="stylesheet">
    <link href="css/sweetalert2.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">


    <script src="js/jquery-3.7.1.min.js"></script>


</head>

<body>
    <div class="layer"></div>
    <!-- ! Body -->
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">
        <!-- ! Sidebar -->

        <?php
        include("includes/sidebar.php");
        ?>

        <div class="main-wrapper">
            <!-- Modal -->

            <div class="modal fade" id="ViewBlotterModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">View Blotter</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active complainant_respondent_tab"
                                        id="complainant_respondent_tab" data-bs-toggle="tab"
                                        data-bs-target="#home-tab-pane" type="button" role="tab"
                                        aria-controls="home-tab-pane" aria-selected="true">Complainant and Respondent
                                        Details</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link other_complainants_tab" id="other_complainants_tab"
                                        data-bs-toggle="tab" data-bs-target="#complainants_tab_pane" type="button"
                                        role="tab" aria-controls="profile-tab-pane" aria-selected="false">Other
                                        Complainants</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link other_respondents_tab" id="other_respondents_tab"
                                        data-bs-toggle="tab" data-bs-target="#respondents_tab_pane" type="button"
                                        role="tab" aria-controls="contact-tab-pane" aria-selected="false">Other
                                        Respondents</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link case_details_tab" id="case_details_tab" data-bs-toggle="tab"
                                        data-bs-target="#casedetails_tab_pane" type="button" role="tab"
                                        aria-controls="disabled-tab-pane" aria-selected="false">Case Details</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link evidence_tab" id="evidence_tab" data-bs-toggle="tab"
                                        data-bs-target="#evidence_tab_pane" type="button" role="tab"
                                        aria-controls="disabled-tab-pane" aria-selected="false">Evidence</button>
                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                    aria-labelledby="home-tab" tabindex="0">
                                    <div class="container mx-2">
                                        <div class="row">

                                            <div class="col-md-2 card m-3 p-3  d-flex justify-content-center align-items-center"
                                                style="border-radius: 10px;padding: 10px;object-fit: contain; max-width: 100%; max-height: 100%">

                                                <img src="includes/img/blank-profile.webp" id="ComplainantImg"
                                                    width="200" height="200"
                                                    style="object-fit: contain; max-width: 100%; max-height: 100%;" />
                                                <h5 id="display_complainant_status"></h5>
                                            </div>

                                            <div class="col-md-9 card m-4 px-3" style="border-radius: 10px;"
                                                style="padding: 10px;" id="ComplainantCard">
                                                <div
                                                    class="card-header d-flex justify-content-between align-items-center">
                                                    <h6>Reporting Person/Complainant Details</h6>
                                                    <button type="button" class="btn btn-primary btn-sm complainantbtn"
                                                        data-id="" data-status="" id="viewResorNonResfromBlot">View
                                                        Details</button>
                                                </div>

                                                <div class="text-center row">

                                                    <input type="text" class="form-control" id="complainant_status"
                                                        hidden />
                                                    <input type="text" class="form-control" id="complainant_id"
                                                        hidden />
                                                    <input type="text" class="form-control" id="respondent_status"
                                                        hidden />
                                                    <input type="text" class="form-control" id="respondent_id" hidden />
                                                    <input type="text" class="form-control" id="blotter_id" hidden />

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="fname"
                                                            name="firstname" placeholder="Enter First Name Here"
                                                            required disabled />
                                                        <label for="fname">First Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="mname"
                                                            name="middlename" placeholder="Enter Middle Name Here"
                                                            disabled />
                                                        <label for="mname">Middle Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-2">
                                                        <input type="text" class="form-control" id="lname"
                                                            name="lastname" placeholder="Enter Last Name Here" required
                                                            disabled />
                                                        <label for="lname">Last Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-2">
                                                        <input type="text" class="form-control" id="suffix"
                                                            name="lastname" placeholder="Enter Last Name Here" required
                                                            disabled />
                                                        <label for="lname">Suffix</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
                                                        <input type="text" class="form-control" id="address"
                                                            name="address" placeholder="Enter Subdvision Here"
                                                            disabled />
                                                        <label for="subd">Complete Address</label>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="container mx-2">
                                        <div class="row">

                                            <div class="col-md-2 card m-3 p-3  d-flex justify-content-center align-items-center"
                                                style="border-radius: 10px;padding: 10px;object-fit: contain; max-width: 100%; max-height: 100%"
                                                id="RespondentCard">

                                                <img src="includes/img/blank-profile.webp" id="RespondentImg"
                                                    width="200" height="200"
                                                    style="object-fit: contain; max-width: 100%; max-height: 100%;" />
                                                <h5 id="display_respondent_status"></h5>
                                            </div>

                                            <div class="col-md-9 card m-4 px-3" style="border-radius: 10px;"
                                                style="padding: 10px;">
                                                <div
                                                    class="card-header d-flex justify-content-between align-items-center">
                                                    <h6>Respondent Details</h6>
                                                    <button type="button" class="btn btn-primary btn-sm respondentbtn"
                                                        data-id="" data-status="" id="viewResorNonResfromBlot">View
                                                        Details</button>
                                                </div>

                                                <div class="text-center row">

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="fname_res"
                                                            name="firstname" placeholder="Enter First Name Here"
                                                            required disabled />
                                                        <label for="fname">First Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="mname_res"
                                                            name="middlename" placeholder="Enter Middle Name Here"
                                                            disabled />
                                                        <label for="mname">Middle Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-2">
                                                        <input type="text" class="form-control" id="lname_res"
                                                            name="lastname" placeholder="Enter Last Name Here" required
                                                            disabled />
                                                        <label for="lname">Last Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-2">
                                                        <input type="text" class="form-control" id="suffix_res"
                                                            name="lastname" placeholder="Enter Last Name Here" required
                                                            disabled />
                                                        <label for="lname">Suffix</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
                                                        <input type="text" class="form-control" id="address_res"
                                                            name="address" placeholder="Enter Subdvision Here"
                                                            disabled />
                                                        <label for="subd">Complete Address</label>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!-- End of first tab -->
                                <div class="tab-pane fade" id="complainants_tab_pane" role="tabpanel"
                                    aria-labelledby="profile-tab" tabindex="0">
                                    <div class="table-wrapper otherparty users-table ">
                                        <BR>
                                        <table class="otherpartytable text-center">
                                            <thead class="post-table">
                                                <tr class="users-table-info">
                                                    <th hidden>#</th>
                                                    <th>Image</th>
                                                    <th>Fullname</th>
                                                    <th>Status</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody id="Complainant">

                                                <!-- To be filled by AJAX -->
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <!-- End of second tab -->
                                <div class="tab-pane fade" id="respondents_tab_pane" role="tabpanel"
                                    aria-labelledby="contact-tab" tabindex="0">
                                    <div class="col-md-12">
                                        <br>
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col" hidden>#</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Fullname</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody id="Respondent">


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <!-- End of Third tab -->
                                <div class="tab-pane fade" id="casedetails_tab_pane" role="tabpanel"
                                    aria-labelledby="disabled-tab" tabindex="0">
                                    <div class="row">
                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="date" class="form-control" id="schedule_date"
                                                name="schedule_date" placeholder="" disabled />
                                            <label for="subd">Mediation Date</label>
                                        </div>
                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="time" class="form-control" id="schedule_starttime"
                                                name="schedule_date" placeholder="" disabled />
                                            <label for="subd">Mediation Start Time</label>
                                        </div>
                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="time" class="form-control" id="schedule_endtime"
                                                name="schedule_time" placeholder="" disabled />
                                            <label for="subd">Mediation End Time</label>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="text" class="form-control" id="mediator" placeholder=""
                                                disabled />
                                            <label for="subd">Mediator</label>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="text" class="form-control" id="incident_date"
                                                name="incident_date" placeholder="Enter First Name Here" disabled />
                                            <label for="fname">Incident Date and Time</label>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="text" class="form-control" id="incident_location"
                                                name="incident_location" placeholder="Enter Middle Name Here"
                                                disabled />
                                            <label for="mname">Location of the Incident</label>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <select class="form-select" id="blotter_type" name="blotter_type"
                                                aria-label="Floating label select example" disabled>
                                                <option value="" selected hidden>Select Blotter Type</option>
                                                <option value="0">Blotter</option>
                                                <option value="1">Incident</option>
                                            </select>
                                            <label for="blotter_type">Blotter Type</label>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="text" class="form-control" id="incident_desc"
                                                name="incident_desc" placeholder="Enter Subdvision Here" disabled />
                                            <label for="subd">Description of the Incident</label>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="text" class="form-control" id="resolution_date"
                                                name="incident_desc" placeholder="Enter Subdvision Here" disabled />
                                            <label for="subd">Date of Resolution</label>
                                        </div>


                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a comment here"
                                                id="case_context" name="case_context"
                                                style="height: 500px; border: 1.5px solid black;" disabled></textarea>
                                            <label for="floatingTextarea">Context of the Case</label>
                                        </div>

                                    </div>
                                </div>
                                <!-- End of fourth tab -->
                                <div class="tab-pane fade" id="evidence_tab_pane" role="tabpanel"
                                    aria-labelledby="disabled-tab" tabindex="0">
                                    <br>
                                    <div class="card">
                                        <div class="row m-3">
                                            <div
                                                class="col d-flex flex-column justify-content-center align-items-center">
                                                <h5 class="text-center">Evidence:</h5>
                                                <img src="" id="evidence_img" width="300" height="300" />
                                            </div>
                                            <div
                                                class="col d-flex flex-column justify-content-center align-items-center">
                                                <h5 class="text-center">Blotter Context:</h5>
                                                <img src="" id="blotter_img" width="300" height="300" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- End of the fifth tab -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="EditBlotterModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Blotter</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active complainant_respondent_tab"
                                        id="complainant_respondent_tab" data-bs-toggle="tab" 
                                        data-bs-target="#home-tab-pane2" type="button" role="tab"
                                        aria-controls="home-tab-pane" aria-selected="true">Complainant and Respondent
                                        Details
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="other_complainants_tab" data-bs-toggle="tab" 
                                        data-bs-target="#complainants_tab_pane2" type="button" role="tab"
                                        aria-controls="profile-tab-pane" aria-selected="false">Other
                                        Complainants
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="other_respondents_tab" data-bs-toggle="tab"
                                        data-bs-target="#respondents_tab_pane2" type="button" role="tab"
                                        aria-controls="contact-tab-pane" aria-selected="false">Other
                                        Respondents
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link case_details_tab" id="case_details_tab" data-bs-toggle="tab"
                                        data-bs-target="#casedetails_tab_pane2" type="button" role="tab"
                                        aria-controls="disabled-tab-pane" aria-selected="false">Case Details
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link evidence_tab" id="evidence_tab" data-bs-toggle="tab"
                                        data-bs-target="#evidence_tab_pane2" type="button" role="tab"
                                        aria-controls="disabled-tab-pane" aria-selected="false">Evidence</button>
                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home-tab-pane2" role="tabpanel"
                                    aria-labelledby="home-tab" tabindex="0">
                                    <div class="container mx-2">
                                        <div class="row">

                                            <div class="col-md-2 card m-3 p-3  d-flex justify-content-center align-items-center" style="border-radius: 10px;padding: 10px;object-fit: contain; max-width: 100%; max-height: 100%">

                                                <img src="includes/img/blank-profile.webp" id="ComplainantImg"
                                                    width="200" height="200"
                                                    style="object-fit: contain; max-width: 100%; max-height: 100%;" />
                                                <h5 id="display_complainant_status"></h5>
                                            </div>

                                            <div class="col-md-9 card m-4 px-3" style="border-radius: 10px;" style="padding: 10px;" id="ComplainantCard">
                                                <div
                                                    class="card-header d-flex justify-content-between align-items-center">
                                                    <h6>Reporting Person/Complainant Details</h6>
                                                    <div class="d-flex gap-2 ms-auto">
                                                        <button type="button"
                                                            class="btn btn-success btn-sm editpersonbtn" data-id=""
                                                            data-whatbutton="SelectResidentComplainant"
                                                            data-whatparty="complainant" id="edit_main_complainant">Edit
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="text-center row">

                                                    <input type="text" class="form-control" name="main_complainant_status" id="complainant_status" hidden/>
                                                    <input type="text" class="form-control" name="main_complainantid" id="complainant_id" hidden/>
                                                    <input type="text" class="form-control" name="main_respondent_status" id="respondent_status" hidden/>
                                                    <input type="text" class="form-control" name="main_respondentid" id="respondent_id" hidden/>
                                                    <input type="text" class="form-control" name="blotter_id" id="blotter_id" hidden/>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="fname"
                                                            name="firstname" placeholder="Enter First Name Here"
                                                            required disabled />
                                                        <label for="fname">First Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="mname"
                                                            name="middlename" placeholder="Enter Middle Name Here"
                                                            disabled />
                                                        <label for="mname">Middle Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-2">
                                                        <input type="text" class="form-control" id="lname"
                                                            name="lastname" placeholder="Enter Last Name Here" required
                                                            disabled />
                                                        <label for="lname">Last Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-2">
                                                        <input type="text" class="form-control" id="suffix"
                                                            name="lastname" placeholder="Enter Last Name Here" required
                                                            disabled />
                                                        <label for="lname">Suffix</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
                                                        <input type="text" class="form-control" id="address"
                                                            name="address" placeholder="Enter Subdvision Here"
                                                            disabled />
                                                        <label for="subd">Complete Address</label>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="container mx-2">
                                        <div class="row">

                                            <div class="col-md-2 card m-3 p-3  d-flex justify-content-center align-items-center"
                                                style="border-radius: 10px;padding: 10px;object-fit: contain; max-width: 100%; max-height: 100%"
                                                id="RespondentCard">

                                                <img src="includes/img/blank-profile.webp" id="RespondentImg"
                                                    width="200" height="200"
                                                    style="object-fit: contain; max-width: 100%; max-height: 100%;" />
                                                <h5 id="display_respondent_status"></h5>
                                            </div>

                                            <div class="col-md-9 card m-4 px-3" style="border-radius: 10px;"
                                                style="padding: 10px;">
                                                <div
                                                    class="card-header d-flex justify-content-between align-items-center">
                                                    <h6>Respondent Details</h6>
                                                    <div class="d-flex gap-2 ms-auto">
                                                        <button type="button"
                                                            class="btn btn-success btn-sm editpersonbtn" data-id=""
                                                            data-button="SelectResidentRes" data-whatparty="respondent"
                                                            id="edit_main_respondent">Edit
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="text-center row">

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="fname_res"
                                                            name="firstname" placeholder="Enter First Name Here"
                                                            required disabled />
                                                        <label for="fname">First Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-4">
                                                        <input type="text" class="form-control" id="mname_res"
                                                            name="middlename" placeholder="Enter Middle Name Here"
                                                            disabled />
                                                        <label for="mname">Middle Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-2">
                                                        <input type="text" class="form-control" id="lname_res"
                                                            name="lastname" placeholder="Enter Last Name Here" required
                                                            disabled />
                                                        <label for="lname">Last Name</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-2">
                                                        <input type="text" class="form-control" id="suffix_res"
                                                            name="lastname" placeholder="Enter Last Name Here" required
                                                            disabled />
                                                        <label for="lname">Suffix</label>
                                                    </div>

                                                    <div class="form-floating mt-3 mb-3 col-md-12">
                                                        <input type="text" class="form-control" id="address_res"
                                                            name="address" placeholder="Enter Subdvision Here"
                                                            disabled />
                                                        <label for="subd">Complete Address</label>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!-- End of first tab -->
                                <div class="tab-pane fade" id="complainants_tab_pane2" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                        
                                            <div>Add or Remove Complainants (Max of 5 persons)</div>

                                            <!-- Button on the right side -->
                                            <div class="d-flex justify-content-end">
                                                <button type="button" class="btn btn-primary btn-sm my-2 mx-2 AddResidentComplainant"  
                                                            data-whatbutton="SelectResidentComplainant"
                                                            data-whatparty="othercomplainant">Add Resident</button>
                                                <button type="button" class="btn btn-success btn-sm my-2 AddResidentComplainant" data-whatbutton="SelectNonResComplainant"
                                                            data-whatparty="othercomplainant">Add Non Resident</button>
                                            </div>
                                        </div>
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col" hidden>#</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Fullname</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody id="Complainant">


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <!-- End of second tab -->
                                <div class="tab-pane fade" id="respondents_tab_pane2" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                        
                                            <div>Add or Remove Respondents (Max of 5 persons)</div>

                                            <!-- Button on the right side -->
                                            <div class="d-flex justify-content-end">
                                                <button type="button" class="btn btn-primary btn-sm my-2 mx-2 AddResidentRespondent" data-whatbutton="SelectResidentRes" data-whatparty="otherrespondent">Add Resident</button>
                                                <button type="button" class="btn btn-success btn-sm my-2 AddResidentRespondent" data-whatbutton="SelectNonResidentRes" data-whatparty="otherrespondent">Add Non Resident</button>
                                            </div>
                                        </div>
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col" hidden>#</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Fullname</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody id="Respondent">


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <!-- End of Third tab -->
                                <div class="tab-pane fade" id="casedetails_tab_pane2" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-md-12 d-flex my-2 align-items-center justify-content-between">
                                            <b>Select Available Schedule</b>
                                            <div class="d-flex">
                                                <button class="btn btn-primary mx-2" id="pick_schedule_btn">Pick Schedule</button>
                                            </div>
                                        </div>
                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="date" class="form-control" id="schedule_date"
                                                name="schedule_date" placeholder="" disabled />
                                            <label for="subd">Mediation Date</label>
                                        </div>
                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="time" class="form-control" id="schedule_starttime"
                                                name="schedule_date" placeholder="" disabled />
                                            <label for="subd">Mediation Start Time</label>
                                        </div>
                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="time" class="form-control" id="schedule_endtime"
                                                name="schedule_time" placeholder="" disabled />
                                            <label for="subd">Mediation End Time</label>
                                        </div>

                                        <div class="col-md-12 d-flex my-2 align-items-center justify-content-between">
                                            <b>Blotter Details</b>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="text" class="form-control" id="mediator" placeholder=""
                                                 />
                                            <label for="subd">Mediator</label>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="text" class="form-control" id="incident_date"
                                                name="incident_date" placeholder="Enter First Name Here"  />
                                            <label for="fname">Incident Date and Time</label>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="text" class="form-control" id="incident_location"
                                                name="incident_location" placeholder="Enter Middle Name Here"
                                                 />
                                            <label for="mname">Location of the Incident</label>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <select class="form-select" id="blotter_type" name="blotter_type"
                                                aria-label="Floating label select example" >
                                                <option value="" selected hidden>Select Blotter Type</option>
                                                <option value="0">Blotter</option>
                                                <option value="1">Incident</option>
                                            </select>
                                            <label for="blotter_type">Blotter Type</label>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="text" class="form-control" id="incident_desc"
                                                name="incident_desc" placeholder="Enter Subdvision Here"  />
                                            <label for="subd">Description of the Incident</label>
                                        </div>

                                        <div class="form-floating mt-3 mb-3 col-md-4">
                                            <input type="text" class="form-control" id="resolution_date"
                                                name="incident_desc" placeholder="Enter Subdvision Here"  />
                                            <label for="subd">Date of Resolution</label>
                                        </div>


                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a comment here"
                                                id="case_context" name="case_context"
                                                style="height: 500px; border: 1.5px solid black;" ></textarea>
                                            <label for="floatingTextarea">Context of the Case</label>
                                        </div>

                                    </div>
                                </div>
                                <!-- End of fourth tab -->
                                <div class="tab-pane fade" id="evidence_tab_pane2" role="tabpanel" aria-labelledby="evidence-tab-pane2" tabindex="0">
                                    <br>
                                    <div class="card">
                                        <div class="row m-3">
                                            <div
                                                class="col d-flex flex-column justify-content-center align-items-center">
                                                <h5 class="text-center">Evidence:</h5>
                                                <img src="" id="evidence_img" width="300" height="300" />
                                            </div>
                                            <div
                                                class="col d-flex flex-column justify-content-center align-items-center">
                                                <h5 class="text-center">Blotter Context:</h5>
                                                <img src="" id="blotter_img" width="300" height="300" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- End of the fifth tab -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                require('includes/selectresidentmodal.php');
                require('includes/selectnonresidentmodal.php');
                require_once('includes/residentviewform.php');
                require_once ('includes/nonresidentviewform.php');
                require_once('includes/schedulemodal.php');
            ?>

            <!-- ! Main nav/Header -->
            <?php require_once("includes/header.php") ?>
            <!-- ! Main -->
            <main>
                <div class="container">
                    <div class="container p-3">
                        <h2 class="main-title">Manage Blotters</h2>
                        <div class="row pb-3">
                            <div class="col-md-8">
                                <!-- Buttons -->
                                <div class="d-flex justify-content-start" style="padding-left: 15px;">

                                    <!-- Button to trigger modal -->
                                    <a href="create-blotters.php" class="btn btn-primary me-2">Add Blotter</a>

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
                            <table class="posts-table" id="BlotterTable">
                                <thead>
                                    <tr class="users-table-info">

                                        <!--th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th-->
                                        <th style="width: 2%" class="text-center" hidden>ID</th>
                                        <th style="width: 5%;" class="text-center">Blotter Type</th>
                                        <th style="width: 10%;" class="text-center">Date Reported</th>
                                        <th style="width: 10%;" class="text-center">Date of Incident</th>
                                        <th style="width: 10%;" class="text-center">Title</th>
                                        <th style="width: 10%;" class="text-center">Complainant Name</th>
                                        <th style="width: 10%;" class="text-center">Respondent Name</th>
                                        <th style="width: 10%;" class="text-center">Report Status</th>
                                        <th style="width: 5%;" class=" col-span-3">Blotter Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>


                                </tbody>
                            </table>
                        </div>
                    </div>
            </main>

            <!-- ! Footer -->
            <?php require_once("includes/footer.php") ?>

        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.11/dist/js/tempus-dominus.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha256-BRqBN7dYgABqtY9Hd4ynE+1slnEw+roEPFzQ7TRRfcg=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.11/dist/js/jQuery-provider.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="js/sweetalert2.min.js"></script>
    <script src="js/blotters.js"></script>
    <script src="js/residentviewmodal.js"></script>
    <script src="js/nonresidentviewmodal.js"></script>
    <script src="js/selectresnonresmodal.js"></script>
    <script src="js/schedulemodal.js"></script>


    <!-- Icons library -->
    <script src="plugins/feather.min.js"></script>
    <!-- Custom scripts -->
    <script src="js/script.js"></script>
    <script src="js/sidebar.js"></script>



</body>

</html>
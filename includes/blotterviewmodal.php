
<div class="modal fade" id="ViewBlotterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                                    <div class="card-header d-flex justify-content-between align-items-center">
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
                    <div class="tab-pane fade" id="complainants_tab_pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
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
                                <tbody id="Complainant">


                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- End of second tab -->
                    <div class="tab-pane fade" id="respondents_tab_pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
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
                            <div class="form-floating mt-3 mb-3 col-md-3">
                                <input type="date" class="form-control" id="schedule_date"
                                    name="schedule_date" placeholder="" disabled />
                                <label for="subd">Mediation Date</label>
                            </div>
                            <div class="form-floating mt-3 mb-3 col-md-3">
                                <input type="time" class="form-control" id="schedule_starttime"
                                    name="schedule_date" placeholder="" disabled />
                                <label for="subd">Mediation Start Time</label>
                            </div>
                            <div class="form-floating mt-3 mb-3 col-md-3">
                                <input type="time" class="form-control" id="schedule_endtime"
                                    name="schedule_time" placeholder="" disabled />
                                <label for="subd">Mediation End Time</label>
                            </div>

                            <div class="form-floating mt-3 mb-3 col-md-3">
                                    <select class="form-select" id="mediator_name_view" name="mediator_name"
                                        aria-label="Floating label select example" disabled>
                                        <option value="" hidden>Select Mediator Name</option>
                                    </select>
                                    <label for="blotter_type">Mediator Name</label>
                                </div>

                            <div class="form-floating mt-3 mb-3 col-md-3">
                                <input type="text" class="form-control" id="incident_date"
                                    name="incident_date" placeholder="Enter First Name Here" disabled />
                                <label for="fname">Incident Date and Time</label>
                            </div>

                            <div class="form-floating mt-3 mb-3 col-md-3">
                                <input type="text" class="form-control" id="incident_location"
                                    name="incident_location" placeholder="Enter Middle Name Here"
                                    disabled />
                                <label for="mname">Location of the Incident</label>
                            </div>

                            <div class="form-floating mt-3 mb-3 col-md-2">
                                <select class="form-select" id="blotter_type" name="blotter_type"
                                    aria-label="Floating label select example" disabled>
                                    <option value="" selected hidden>Select Type</option>
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

                            <div class="form-floating mt-3 mb-3 col-md-3">
                                <input type="text" class="form-control" id="resolution_date"
                                    name="resolution_date" placeholder="Enter Subdvision Here" disabled />
                                <label for="subd">Date of Resolution</label>
                            </div>

                            <div class="form-floating mt-3 mb-3 col-md-3">
                                <select class="form-select" id="blotter_status" name="blotter_type"
                                    aria-label="Floating label select example" disabled>
                                    <option value="0">Ongoing</option>
                                    <option value="1">Resolved</option>
                                    <option value="2">File to Action</option>
                                </select>
                                <label for="blotter_status">Blotter Status</label>
                            </div>

                            <div class="form-floating mt-3 mb-3 col-md-6">
                                <input type="text" class="form-control" id="remarks"
                                    name="remarks" placeholder="Enter Subdvision Here" disabled />
                                <label for="remarks">Remarks</label>
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

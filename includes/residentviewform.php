<!-- View Resident Modal -->
<form action="#" id="viewResidentForm" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="ViewResidentModal" name="add" tabindex="-1" aria-labelledby="EditResidentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditResidentModalLabel">View Resident Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Edit form -->

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Profile</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Requested Documents</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Blotters Involved</button>
                        </div>
                    </nav>
                        <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        <div class="row">
                        <div class="mt-3" style="width: 270px">

                        
                            <!--For the container of the camera and Picture-->
                            <div class="col card" style="border-radius: 15px; height: 400px">
                                <div class="text-center">
                                    <div class="mt-3 mb-4">
                                        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                        class="rounded-circle img-fluid" id="viewimagePreview" style="width: 200px; height: 200px;" />

                                        <script src="js/displayimageonviewmodal.js"> </script>
                                    </div>
                
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 card mt-3 " style="border-radius: 10px;" style="padding: 10px;">
                            <div class="text-center row">

                                <input hidden type="text" id="resident_id" name="resident_id" />


                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="fname" name="fname" disabled>
                                    <label for="floatingInput">First Name</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="mname" name="mname" disabled >
                                    <label for="floatingInput">Middle Name</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-3">
                                    <input type="text" class="form-control" id="lname" name="lname" disabled>
                                    <label for="floatingInput">Last Name</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-1">
                                    <input type="text" class="form-control" id="suffix" name="suffix" style="width:50px" disabled>
                                    <label for="floatingInput">Suffix</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="house_no" name="house_no" disabled>
                                    <label for="floatingInput">House No. (Blk no, Lot no, Unit no)</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="street" name="street" disabled>
                                    <label for="floatingInput">Street</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="subd" name="subd" disabled>
                                    <label for="floatingInput">Subdivision</label>
                                </div>
                            
                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <select class="form-select" id="sex" name="sex" aria-label="Floating label select example" disabled>
                                        <option hidden selected>Select Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        
                                    </select>
                                    <label for="sex">Sex</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <select class="form-select" id="marital_status" name="marital_status" aria-label="Floating label select example" disabled>
                                        <option hidden selected>Select Marital Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widow">Widow/Widower</option>
                                        <option value="Annul">Annul</option>
                                    </select>
                                    <label for="marital_status">Marital Status</label>
                                </div>


                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="Date" class="form-control" id="floatingInput" id="birth_date"name="birth_date" disabled>
                                    <label for="floatingInput">Birth Date</label>
                                </div> 

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="Text" class="form-control" id="floatingInput" id="birth_place" name="birth_place" disabled>
                                    <label for="floatingInput">Birth Place</label>
                                </div> 

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="floatingInput" id="cp_number" name="cp_number" disabled>
                                    <label for="floatingInput">Phone Number</label>
                                </div> 

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <select class="form-select" id="marital_status" name="is_a_voter" aria-label="Floating label select example" disabled>
                                        <option hidden selected>Select Option</option>
                                        <option value="1">YES</option>
                                        <option value="0">NO</option>
                                    
                                    </select>
                                    <label for="isavoter">Is a Voter?</label>
                                </div>

                            </div>
                        </div>
                    </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">...</div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">...</div>
                        </div>
                   
                </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>
</form>


       


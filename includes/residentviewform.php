<!-- View Resident Modal -->
<form action="#" id="viewResidentForm">
    <div class="modal fade" id="ViewResidentModal" name="add" tabindex="-1" aria-labelledby="EditResidentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ViewResidentModalLabel">View Resident</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link show" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#profile-tab" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Profile</button>
                            <button class="nav-link" id="nav-clearance-tab" data-bs-toggle="tab" data-bs-target="#clearance-tab" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Requested Documents</button>
                            <button class="nav-link" id="nav-blotters-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Blotters Involved</button>
                        </div>
                    </nav>
                        <!------------------------------------------------------------------------------------------------------------>
                                                <!-- Profile Tab Content -->
                        <!-------------------------------------------------------------------------------------------------------------->
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade active show" id="profile-tab" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                <div class="row">

                                     <!--For the container of the camera and Picture-->

                                    <div class="mt-3" style="width: 270px">
                                       
                                        <div class="col card" style="border-radius: 15px; height: 400px">
                                            <div class="text-center">
                                                <div class="mt-3 mb-4">
                                                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                                    class="rounded-circle img-fluid" id="viewimagePreview" style="width: 200px; height: 200px;" />

                                                    <script src="js/displayimagedata.js"></script>
                                                </div>
                            
                                            </div>

                                            
                                            <div class= "mt-2 mb-2 text-center">
                                                    <span class="badge text-bg-primary"><h5 id="noofcerts"></h5><h6>No. of Requested <br> Certificates</h6></span>
                                                    <br><br>
                                                    <span class="badge text-bg-danger"><h4 id="">With Hit</h4><h5>Blotter Status</h6></span>

                                            </div>
                            
                                            
                                        </div>
                                    </div>

                                    <!-- Profile Form -->

                                    <div class="col-md-9 card mt-3 " style="border-radius: 10px;" style="padding: 10px;">
                                        <div class="text-center row">

                                            <input hidden type="text" id="viewresident_id" name="resident_id" />


                                            <div class="form-floating mt-3 mb-3 col-md-4">
                                                <input type="text" class="form-control" id="fname" name="fname" disabled/>
                                                <label for="floatingInput">First Name</label>
                                            </div>

                                            <div class="form-floating mt-3 mb-3 col-md-4">
                                                <input type="text" class="form-control" id="mname" name="mname" disabled/>
                                                <label for="floatingInput">Middle Name</label>
                                            </div>

                                            <div class="form-floating mt-3 mb-3 col-md-3">
                                                <input type="text" class="form-control" id="lname" name="lname" disabled/>
                                                <label for="floatingInput">Last Name</label>
                                            </div>

                                            <div class="form-floating mt-3 mb-3 col-md-1">
                                                <input type="text" class="form-control" id="suffix" name="suffix" style="width:50px" disabled/>
                                                <label for="floatingInput">Suffix</label>
                                            </div>

                                            <div class="form-floating mt-3 mb-3 col-md-4">
                                                <input type="text" class="form-control" id="house_no" name="house_no" disabled/>
                                                <label for="floatingInput">House No. (Blk no, Lot no, Unit no)</label>
                                            </div>

                                            <div class="form-floating mt-3 mb-3 col-md-4">
                                                <input type="text" class="form-control" id="street" name="street" disabled/>
                                                <label for="floatingInput">Street</label>
                                            </div>

                                            <div class="form-floating mt-3 mb-3 col-md-4">
                                                <select class="form-select" id="subd" name="subd" aria-label="Floating label select example" disabled>
                                                    <option value="">Not Applicable</option>
                                                    <option value="Almar Subd">Almar Subd</option>
                                                    <option value="Caritas Village">Caritas Village</option>
                                                    <option value="Capitol Parkland">Capitol Parkland</option>
                                                    <option value="Cassel Spring Subd">Castle Spring Subd</option>
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
                                                <label for="subd">Subdivision</label>
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
                                                <input type="Date" class="form-control" id="birth_date"name="birth_date" disabled>
                                                <label for="floatingInput">Birth Date</label>
                                            </div> 

                                            <div class="form-floating mt-3 mb-3 col-md-4">
                                                <input type="Text" class="form-control" id="birth_place" name="birth_place" disabled>
                                                <label for="floatingInput">Birth Place</label>
                                            </div> 

                                            <div class="form-floating mt-3 mb-3 col-md-4">
                                                <input type="text" class="form-control" id="cp_number" name="cellphone_number" disabled>
                                                <label for="floatingInput">Phone Number</label>
                                            </div> 

                                            <div class="form-floating mt-3 mb-3 col-md-2">
                                                <select class="form-select" id="is_a_voter" name="is_a_voter" aria-label="Floating label select example" disabled>
                                                    <option hidden selected>Select Option</option>
                                                    <option value="1">YES</option>
                                                    <option value="0">NO</option>
                                                
                                                </select>
                                                <label for="isavoter">Is a Voter?</label>
                                            </div>

                                            <div class="form-floating mt-3 mb-3 col-md-2">
                                                <input type="text" class="form-control" id="rsince" name="rsince" disabled>
                                                <label for="floatingInput">Resident Since</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <!------------------------------------------------------------------------------------------------------------>
                                                <!-- Clearance Tab Content -->
                     <!-------------------------------------------------------------------------------------------------------------->
                        <div class="tab-content" id="nav-tabContent">    
                            <div class="tab-pane fade" id="clearance-tab" role="tabpanel" aria-labelledby="nav-clearance-tab" tabindex="0">
                            
                                <div class="users-table table-wrapper">

                                    <table class="users-table table-wrapper my-4" id="ResidentRequestTable">
                                        <thead>
                                            <tr class="users-table-info">
                                                
                                                <th style="width: 8%;" class="text-center">Request ID
                                                </th>

                                                <th style="width: 10%;" class="text-center">Date Requested
                                                </th>

                                                <th style="width: 10%;" class="text-center">Expiry Date
                                                </th>

                                                <th style="width: 15%;" class="text-center">Certificate Description
                                                </th>

                                                <th style="width: 10%;" class="text-center">Purpose
                                                </th>

                                                <th style="width: 5%;" class="text-center">Age
                                                </th>

                                                <th style="width: 10%;" class="text-center">Presented ID
                                                </th>

                                                <th style="width: 10%;" class="text-center">ID Number
                                                </th>

                                                <th style="width: 10%;" class="text-center">Status
                                                
                                                </th>
                                                
                                            </tr>
                                        </thead>

                                        <tbody>
                                        
                                        <!-- To be filled by AJAX request to Server -->
                                            
                                        </tbody>
                                        
                                    </table>

                                </div>

                            </div>
                        </div>

                    <!------------------------------------------------------------------------------------------------------------>
                                                <!-- Blotters Tab Content -->
                     <!-------------------------------------------------------------------------------------------------------------->
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                                <!-- For the Blotter table to be placed here --> ...
                            </div>
                        </div>
                    
                   
                </div>
                <div class="modal-footer">
                    <button hidden id="backbtntodocu" type="button" class="btn btn-primary" data-bs-target="#ViewDocumentModal">Back</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>

                
            </div>
        </div>
    </div>
</form>


       


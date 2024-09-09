<!-- Edit Blotter Modal -->
<div class="modal fade" id="EditResidentModal" name="add" tabindex="-1" aria-labelledby="EditResidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditResidentModalLabel">Edit Resident</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Edit form -->
            <form action="#" id="EditResidentModalForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
            
                    <div class="row">
                        <div class="mt-3" style="width: 270px">
                        
                            <!--For the container of the camera and Picture-->
                            <div class="col card" id="imageForm" style="border-radius: 15px; height: 400px">
                                <div class="text-center">
                                    <div class="mt-3 mb-4">

                                    <!-- Hidden Text Box to Store the resident_id value and current page -->
                                        <input hidden type="text" id="resident_id" name="resident_id" />
                                        <input hidden type="text" id="pageno" name="pageno" />

                                        <div id="editcameraFeedWrapper" class="camera-frame" style="width: 200px; height: 200px; display: none;">
                                            <div id="editcameraFeed"></div>
                                        </div>

                                        <!-- Preview image container (shown initially) -->
                                        <div id="editimagePreviewWrapper" class="camera-frame" style="width: 200px; height: 200px;">
                                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                            class="rounded-circle img-fluid" id="editimagePreview" style="width: 200px; height: 200px;" />
                                        </div>

                                    </div>
                                        <button type="button" id="editopenCamera" class="btn btn-primary btn-lg col-md-12">Open Camera</button>

                                    <div class="form-floating mt-3 mb-3 col-md-13">
                                        <input type="file" class="form-control" id="editimagefile" name="image_file" placeholder="Upload Picture">
                                        <label for="floatingInput">Upload Image</label>
                                    
                                        <script src="js/LimitFileUploadAndDisplayImgForEdit.js"></script>

                                    </div>  
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 card mt-3 " style="border-radius: 10px;" style="padding: 10px;">
                            <div class="text-center row">

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="fname" name="fname" required>
                                    <label for="fname">First Name</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="mname" name="mname" >
                                    <label for="mname">Middle Name</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-3">
                                    <input type="text" class="form-control" id="lname" name="lname" required>
                                    <label for="lname">Last Name</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-1">
                                    <input type="text" class="form-control" id="suffix" name="suffix" style="width:50px">
                                    <label for="suffix">Suffix</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="house_no" name="house_no" required>
                                    <label for="house_no">House No. (Blk no, Lot no, Unit no)</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="street" name="street" required>
                                    <label for="street">Street</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <select class="form-select" id="subd" name="subd" aria-label="Floating label select example">
                                        <option value="">Not Applicable</option>
                                        <option value="Almar Subd">Almar Subd</option>
                                        <option value="Caritas Village">Caritas Village</option>
                                        <option value="Capitol Parkland">Capitol Parkland</option>
                                        <option value="Cassel Spring Subd">Cassel Spring Subd</option>
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
                                    <select class="form-select" id="sex" name="sex" aria-label="Floating label select example" required>
                                        <option hidden selected>Select Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        
                                    </select>
                                    <label for="sex">Sex</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <select class="form-select" id="marital_status" name="marital_status" aria-label="Floating label select example" required>
                                        <option hidden selected>Select Marital Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widow">Widow/Widower</option>
                                        <option value="Annul">Annul</option>
                                    </select>
                                    <label for="marital_status">Marital Status</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="Date" class="form-control" id="birth_date"name="birth_date" required>
                                    <label for="birth_place">Birth Date</label>
                                </div> 

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="Text" class="form-control" id="birth_place" name="birth_place" required>
                                    <label for="birth_place">Birth Place</label>
                                </div> 

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="number" maxlength="11" class="form-control" id="cp_number" name="cellphone_number"  required>
                                    <label for="cp_number">Phone Number</label>
                                </div> 

                                <div class="form-floating mt-3 mb-3 col-md-2">
                                    <select class="form-select" id="marital_status" name="is_a_voter" aria-label="Floating label select example" required>
                                        <option hidden selected>Select Option</option>
                                        <option value="1">YES</option>
                                        <option value="0">NO</option>
                                    
                                    </select>
                                    <label for="isavoter">Is a Voter?</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-2">
                                    <input type="number" maxlength="4" class="form-control" id="resident_since" name="rsince" required>
                                    <label for="resident_since">Resident Since</label>
                                </div>

                            </div>
                        </div>
                    </div>
                
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="saveButton" class="btn btn-primary" data-id="' . $row['resident_id'] . '" >Save</button>
                </div>
            </form>

        </div>
    </div>
</div>



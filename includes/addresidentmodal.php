<!-- Add Blotter Modal -->
                               
<div class="modal fade" id="AddResidentModal" name="add" tabindex="-1" aria-labelledby="addBlotterModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addBlotterModalLabel">Add Resident</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <!-- Add your form elements here for adding a resident -->
        <!-- Example form -->
    <form action="includes/addresident.php" id="AddResidentModalForm" enctype="multipart/form-data" method="POST">    
            <div class="row">
                <div class="mt-3" style="width: 270px">
                
                    <!--For the container of the camera and Picture-->
                    <div class="col card" style="border-radius: 15px; height: 400px">
                        <div class="text-center">
                            <div class="mt-3 mb-4">
                                <!--input type="hidden" name="MAX_FILE_SIZE" value="1048576"-->
                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                class="rounded-circle img-fluid" id="imagePreview" style="width: 200px;" />
                            </div>
                                <button type="button" class="btn btn-primary btn-lg col-md-12">Open Camera</button>

                            <div class="form-floating mt-3 mb-3 col-md-13">
                                <input type="file" class="form-control" id="imagefile" name="image_file" placeholder="Upload Picture" require>
                                <label for="floatingInput">Upload Image</label>
                                <script src="js/limitfileresanddisplayimg.js"> </script>
                            </div>  

                        </div>
                    </div>
                </div>

                <div class="col-md-9 card mt-3 " style="border-radius: 10px;" style="padding: 10px;">
                    <div class="text-center row">

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name Here" required>
                            <label for="fname">First Name</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="text" class="form-control" id="mname" name="mname" placeholder="Enter Middle Name Here">
                            <label for="mname">Middle Name</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-3">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name Here" required>
                            <label for="lname">Last Name</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-1">
                            <input type="text" class="form-control" id="suffix" name="suffix" style="width:50px" placeholder="Enter Suffix Here">
                            <label for="suffix">Suffix</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="text" class="form-control" id="house_no" name="house_no" placeholder="Enter House No Here" required>
                            <label for="house_no">House No. (Blk no, Lot no, Unit no)</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="text" class="form-control" id="street" name="street" placeholder="Enter Street Here" required>
                            <label for="street">Street</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <select class="form-select" id="subd" name="subd" aria-label="Floating label select example" required>
                                <option hidden selected>Select</option>
                                <option value="-">Not Applicable</option>
                                <option value="Almar Subd">Almar Subd</option>
                                <option value="Caritas">Caritas Subd</option>
                                <option value="Capitol Parkland Subd">Capitol Parkland Subd</option>
                                <option value="Cassel Spring Subd">Cassel Spring Subd</option>
                                <option value="Christina Homes">Christina Homes Subd</option>
                                <option value="Cielito Homes">Cielito Homes Subd</option>
                                <option value="Del Rey Ville 2">Del Rey Ville 2 Subd</option>
                                <option value="Kassel Villas">Kassel Villas Subd</option>
                                <option value="Lilleville Subd">Lilleville Subd</option>
                                <option value="Maligay Park">Maligaya Park Subd</option>
                                <option value="Cassel Spring">Maria Luisa Subd</option>
                                <option value="North Matrix Villge 1">North Matrix Village 1 Subd</option>
                                <option value="North Matrix Ville">North Matrix Ville Subd</option>
                                <option value="North Triangle">North Triangle Subd</option>
                            </select>
                            <label for="subd">Subdivision</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <select class="form-select" id="sex" name="sex" aria-label="Floating label select example" required>
                                <option hidden selected>Select</option>
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
                            <input type="Date" class="form-control" id="birth_date" name="birth_date" required>
                            <label for="birth_date">Birth Date</label>
                        </div> 

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="Text" class="form-control" id="birth_place" name="birth_place" placeholder="Enter Birth Place Here"required>
                            <label for="birth_place">Birth Place</label>
                        </div> 

                        <div class="form-floating mt-3 mb-3 col-md-4">
                            <input type="number" class="form-control" id="cellphone_number" name="cellphone_number" placeholder="Enter Phone Number Here" maxlength="11" required >
                            <label for="cellphone_number">Phone Number</label>
                        </div> 

                        <div class="form-floating mt-3 mb-3 col-md-2">
                            <select class="form-select" id="isavoter" name="is_a_voter" aria-label="Floating label select example" required>
                                <option hidden selected>YES/NO</option>
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                            <label for="isavoter">Is a Voter</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-2">
                            <input type="number" maxlength="4" class="form-control" id="resident_since" name="resident_since" placeholder="Enter Birth Place Here"required>
                        <label for="resident_since">Resident Since</label>
                        </div> 

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="closeButton" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" id="addButton" name="submit" class="btn btn-primary">Save</button>

            <script src="js/reseteditresidentformwhenclose.js">  </script>
        </div>
        </div>
    </div>
    </div>
</form>

<!-- End of Add Resident Modal -->
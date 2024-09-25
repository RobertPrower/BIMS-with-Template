<!-- Edit Blotter Modal -->
<div class="modal fade EditNonResidentModal" id="EditNonResidentModal" name="add" tabindex="-1" aria-labelledby="EditNonResidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditNonResidentModalLabel">Edit Resident</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Edit form -->
            <form action="" id="EditNonResidentModalForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
            
                    <div class="row">
                        <div class="mt-3" style="width: 270px">
                        
                            <!--For the container of the camera and Picture-->
                            <div class="col card" id="imageForm" style="border-radius: 15px; height: 455px">
                                <div class="text-center">
                                    <div class="mt-3 mb-4">

                                    <!-- Hidden Text Box to Store the resident_id value and current page -->
                                        <input hidden type="text" id="nresident_id" name="nresident_id" />
                                        <input hidden type="text" id="pageno" name="pageno" />
                                        <input hidden type="text" id="isfromcamcheck" name="isfromcamcheck" disabled/>


                                        <div id="editcameraFeedWrapper" class="camera-frame" style="width: 200px; height: 200px; display: none;">
                                            <div id="editcameraFeed"></div>
                                        </div>

                                        <!-- Preview image container (shown initially) -->
                                        <div id="editimagePreviewWrapper" class="camera-frame" style="width: 200px; height: 200px;">
                                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                            class="rounded-circle img-fluid" id="editimagePreview" style="width: 200px; height: 200px;" />
                                        </div>

                                    </div>
                                        <button type="button" id="editopenCamera" class="btn btn-primary btn-lg col-md-12 editopenCamera" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Please capture a image.">Open Camera</button>
                                        
                                        <style>
                                            /* Default tooltip styling */
                                            .tooltip-inner {
                                            background-color: #000; /* Default background color */
                                            }

                                            /* Custom class for red background */
                                            .tooltip-red .tooltip-inner {
                                            background-color: red !important; /* Force red background */
                                            }
                                        </style>
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
                                    <label for="house_no">Blk no, Lot no, Unit no</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="street" name="street" placeholder="Enter Street Here" required>
                                    <label for="street">Street</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="subd" name="subd" placeholder="Enter Subdivision Here" required>
                                    <label for="subd">Subdivision</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="district_brgy" name="district_brgy" placeholder="Enter Subdivision Here" required>
                                    <label for="district_brgy">District or Brgy</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter Subdivision Here" required>
                                    <label for="city">City</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="province" name="province" placeholder="Enter Subdivision Here" required>
                                    <label for="province">Province</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Enter Subdivision Here" required>
                                    <label for="zipcode">Zipcode</label>
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
                                    <input type="text" class="form-control" id="birth_date" name="birth_date" required>
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



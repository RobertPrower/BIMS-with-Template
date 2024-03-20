  <!-- VIEW EDIT AND DELETE MODALS -->



                <!-- Add Blotter Modal -->
                <form action="includes/editresident.php" method="POST" enctype="multipart/form-data">
                <div class="modal fade" id="EditResidentModal" name="add" tabindex="-1" aria-labelledby="EditResidentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditResidentModalLabel">Edit Resident</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    <!-- Edit form -->
                
                    <div class="row">
                        <div class="mt-3" style="width: 270px">
                        
                            <!--For the container of the camera and Picture-->
                            <div class="col card" style="border-radius: 15px; height: 400px">
                                <div class="text-center">
                                    <div class="mt-3 mb-4">
                                        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                        class="rounded-circle img-fluid" style="width: 200px; height: 200px;" />
                                    </div>
                                        <button type="button" class="btn btn-primary btn-lg col-md-12">Open Camera</button>


                                    <div class="form-floating mt-3 mb-3 col-md-13">
                                        <input type="file" class="form-control" id="floatingInput" placeholder="Upload Picture">
                                        <label for="floatingInput">Upload Image</label>
                                    </div>  
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 card mt-3 " style="border-radius: 10px;" style="padding: 10px;">
                            <div class="text-center row">

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="floatingInput" name="fname" value="<?php echo $row['first_name']?>" required>
                                    <label for="floatingInput">First Name</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="floatingInput" name="mname" value="<?php echo $row['middle_name'] ?>">
                                    <label for="floatingInput">Middle Name</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="floatingInput" name="lname" value="<?php echo $row['last_name'] ?>" required>
                                    <label for="floatingInput">Last Name</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="floatingInput" name="house_no" value="<?php echo $row['house_number'] ?>" required>
                                    <label for="floatingInput">House No. (Blk no, Lot no, Unit no)</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="floatingInput" name="street" value="<?php echo $row['street_name'] ?>" required>
                                    <label for="floatingInput">Street</label>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="text" class="form-control" id="floatingInput" name="subd" value="<?php echo $row['subdivision'] ?>"required>
                                    <label for="floatingInput">Subdivision</label>
                                </div>
                            
                                <div class="mt-3 mb-3 col-md-4">
                                <select class="form-select" aria-label="Default select example" Style="Height: 58px" name="sex">
                                <option value="Male" <?php echo isSelectedSex('Male', $row['sex']); ?>>Male</option>
                                <option value="Female" <?php echo isSelectedSex('Female', $row['sex']); ?>>Female</option>
                                </select>
                                </div>

                                <div class="mt-3 mb-3 col-md-4">
                                <select class="form-select" aria-label="Default select example" Style="Height: 58px" name="marital_status">
                                    <option hidden selected>Select Marital Status</option>
                                    <option value="Single" <?php echo isSelectedMaritalStatus('Single', $row['marital_status']); ?>>Single</option>
                                    <option value="Married" <?php echo isSelectedMaritalStatus('Married', $row['marital_status']); ?>>Married</option>
                                    <option value="Widowed" <?php echo isSelectedMaritalStatus('Widowed', $row['marital_status']); ?>>Widow/Widower</option>
                                    <option value="Annul" <?php echo isSelectedMaritalStatus('Annul', $row['marital_status']); ?>>Annul</option>
                                </select>
                                </div>

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="Date" class="form-control" id="floatingInput" name="birth_date" value="<?php echo $row['birth_date'] ?>" required>
                                    <label for="floatingInput">Birth Date</label>
                                </div> 

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="Text" class="form-control" id="floatingInput" name="birth_place" value="<?php echo $row['birth_place'] ?>" required>
                                    <label for="floatingInput">Birth Place</label>
                                </div> 

                                <div class="form-floating mt-3 mb-3 col-md-4">
                                    <input type="" class="form-control" id="floatingInput" name="cellphone_number" value="<?php echo $row['cellphone_number'] ?>" required>
                                    <label for="floatingInput">Phone Number</label>
                                </div> 

                                <div class="mt-3 mb-3 col-md-4">
                                <select class="form-select" aria-label="Default select example" Style="Height: 58px" name="marital_status">
                                    <option value="Widowed" <?php echo isSelectedISAVoter('1', $row['is_a_voter']); ?>>Yes</option>
                                    <option value="Annul" <?php echo isSelectedIsAVoter('0', $row['is_a_voter']); ?>>No</option>
                                </select>
                                </div>

                            
                            


                            </div>
                        </div>
                    </div>
                </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                </div>
                </div>
                </form>

            </div>
<?php
        // Check and set selected options for sex dropdown
        function isSelectedSex($value, $selected) {
            return ($value === $selected) ? 'selected' : '';
        }

        // Check and set selected options for marital status dropdown
        function isSelectedMaritalStatus($value, $selected) {
            return ($value === $selected) ? 'selected' : '';
        }

        function isSelectedIsAVoter($value, $selected) {
            return ($value === $selected) ? 'selected' : '';
        }
?>
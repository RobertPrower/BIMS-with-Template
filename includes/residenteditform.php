<!-- VIEW EDIT AND DELETE MODALS -->



    <!-- Add Blotter Modal -->
    <form action="#" id="EditResidentModalForm" method="POST" enctype="multipart/form-data">
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
                <div class="col card" id="imageForm" style="border-radius: 15px; height: 400px">
                    <div class="text-center">
                        <div class="mt-3 mb-4">

                           <!-- Hidden Text Box to Store the resident_id value -->
                            <input hidden type="text" id="resident_id" name="resident_id" />

                            <img id="imagePreview"
                            class="rounded-circle img-fluid" style="width: 200px; height: 200px;" />

                            <script src="js/displayimagedata.js"> </script>
                        </div>
                            <button type="button" class="btn btn-primary btn-lg col-md-12">Open Camera</button>


                        <div class="form-floating mt-3 mb-3 col-md-13">
                            <input type="file" class="form-control" id="fileupload" name="image_file" placeholder="Upload Picture">
                            <label for="floatingInput">Upload Image</label>
                        </div>  
                    </div>
                </div>
            </div>

            <div class="col-md-9 card mt-3 " style="border-radius: 10px;" style="padding: 10px;">
                <div class="text-center row">

                 


                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="text" class="form-control" id="fname" name="fname" required>
                        <label for="floatingInput">First Name</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="text" class="form-control" id="mname" name="mname" >
                        <label for="floatingInput">Middle Name</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="text" class="form-control" id="lname" name="lname" required>
                        <label for="floatingInput">Last Name</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="text" class="form-control" id="house_no" name="house_no" required>
                        <label for="floatingInput">House No. (Blk no, Lot no, Unit no)</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="text" class="form-control" id="street" name="street" required>
                        <label for="floatingInput">Street</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="text" class="form-control" id="subd" name="subd" required>
                        <label for="floatingInput">Subdivision</label>
                    </div>
                
                    <div class="mt-3 mb-3 col-md-4">
                    <select class="form-select" aria-label="Default select example" Style="Height: 58px" id="sex" name="sex">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    </select>
                    </div>

                    <div class="mt-3 mb-3 col-md-4">
                    <select class="form-select" aria-label="Default select example" Style="Height: 58px" id="marital_status" name="marital_status">
                        <option hidden selected>Select Marital Status</option>
                        <option value="Single" >Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widow/Widower</option>
                        <option value="Annul">Annul</option>
                    </select>
                    </div>

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="Date" class="form-control" id="birth_date"name="birth_date" required>
                        <label for="floatingInput">Birth Date</label>
                    </div> 

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="Text" class="form-control" id="birth_place" name="birth_place" required>
                        <label for="floatingInput">Birth Place</label>
                    </div> 

                    <div class="form-floating mt-3 mb-3 col-md-4">
                        <input type="text" class="form-control" id="cp_number" name="cp_number"  required>
                        <label for="floatingInput">Phone Number</label>
                    </div> 

                    <div class="mt-3 mb-3 col-md-4">
                    <select class="form-select" aria-label="Default select example" Style="Height: 58px" id="is_a_voter" name="is_a_voter">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    </div>

                </div>
            </div>
        </div>
    </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="saveButton" class="btn btn-primary" data-id="' . $row['resident_id'] . '" >Save</button>
        </div>
    </div>
    </div>
    </div>
    </form>

</div>




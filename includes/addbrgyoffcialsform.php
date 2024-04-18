<!-- Add Blotter Modal -->
<div class="modal fade" id="addOfficialModal" tabindex="-1" aria-labelledby="addOfficialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
        <h5 id="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <!-- Add your form elements here for adding a blotter -->
        <!-- Example form -->
        <div class="row">
            <div class="mt-3" style="width: 600px">

                <div class="col card" style="border-radius: 15px; height: 500px">
                    <div class="text-center">
                        <div class="mt-3 mb-4">
                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                            class="rounded-circle img-fluid" style="width: 200px;" />
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-12">
                            <input type="file" class="form-control" name="fileupload" id="floatingInput" placeholder="Upload Picture">
                            <label for="floatingInput">Upload Image</label>
                        </div>  

                        <div class="form-floating mt-3 mb-3 col-md-12">
                        <input type="text" class="form-control" name="fullname" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Full Name</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-12">
                            <input type="text" class="form-control" name="position" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Position</label>
                        </div>

                    </div>
                </div>
            </div>

            
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Add</button>
        </div>
    </div>
    </div>
</div>
<!-- End of Add Blotter Modal -->
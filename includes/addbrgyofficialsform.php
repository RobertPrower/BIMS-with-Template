<!-- Add Official Modal -->
<form action="#" id="AddOfficialModalForm" method="POST" enctype="multipart/form-data">
<div class="modal fade" id="AddOfficialModal" tabindex="-1" aria-labelledby="addOfficialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
        <h5 id="modal-title">Add Official</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        
        <div class="row">
            <div class="mt-3" style="width: 600px">

            <input hidden type="text" class="form-control" name="official_id" id="official_id">


                <div class="col card" style="border-radius: 15px; height: 500px">
                    <div class="text-center">
                        <div class="mt-3 mb-4">
                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                            class="rounded-circle img-fluid" style="width: 200px;" />
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-12">
                            <!-- <input type="file" class="form-control" name="fileupload" id="floatingInput" placeholder="Upload Picture"> -->
                            <!-- <label for="floatingInput">Upload Image</label> -->
                        </div>  

                        <div class="form-floating mt-3 mb-3 col-md-12">
                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="name@example.com">
                        <label for="floatingInput">Full Name</label>
                        </div>

                        <div class="form-floating mt-3 mb-3 col-md-12">
                            <input type="text" class="form-control" name="position" id="position" placeholder="name@example.com">
                            <label for="floatingInput">Position</label>
                        </div>

                    </div>
                </div>
            </div>

            
        </div>
        </div>
        <div class="modal-footer">
        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="AddOfficialBtn" class="btn btn-primary addOfficialbtnsubmit">Add</button>
        </div>

        <script>
                $('#AddOfficialModalForm').submit(function(){
                    event.preventDefault();
                
                    var formData = new FormData(this);
                
                    console.log(formData);
                
                    $.ajax({
                    
                        url: 'includes/addofficialsaction.php',
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            swal({
                            title: "Success!",
                            text: "Official Added Successfully",
                            icon: "success",
                            });
                        console.log('Server response:', response);
                        },
                        error: function(jqXHR, textStatus, errorThrown){
                        console.log('Error:', textStatus, errorThrown);
                        }
  
                    });
    
            });

  



        </script>


    </div>
    </div>
</div>

</form>
<!-- End of Add Official Modal -->
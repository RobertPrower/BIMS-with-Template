$('#imagefile, #editimagefile').on('change', function() {
    var fileInput = this; // store reference to file input
    var file = this.files[0];
    var imageType = /image.*/;
    var validExtensions = ['png', 'jpg', 'jpeg']; 
    var isEdit = $("#EditResidentModal").hasClass("show");
    var oldImageSrc = (isEdit) ? $('#editimagePreview').attr('src') : $('#imagePreview').attr('src'); 

    if (!file.type.match(imageType)) {
        swal({
            icon: "error",
            title: "Oops... The uploaded file is not a image!",
            text: "Please upload a vaild image file!",
        });

        if(isEdit){
            $('#editimagePreview').attr('src', oldImageSrc);
        }else{
            $('#imagePreview').attr('src', oldImageSrc);
        }

        $(fileInput).val(''); // use stored reference
        return;
    }//Pass to the next check

    var extension = file.name.split('.').pop().toLowerCase();
    if(validExtensions.indexOf(extension) == -1) {
        swal({
            icon: "error",
            title: "Oops... Invalid extension!",
            text: "Only png, jpg, and jpeg are allowed.",
        });

        if(isEdit){
            $('#editimagePreview').attr('src', oldImageSrc);
        }else{
            $('#imagePreview').attr('src', oldImageSrc);
        }
        $(fileInput).val(''); // use stored reference
        return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        var img = new Image();
        img.onload = function() {
            if(img.width > 200 || img.height > 200) {
                swal({
                    icon: "error",
                    title: "Oops... Image Size is too large",
                    text: "Please upload an image with dimensions not exceeding 200x200 pixels.",
                });
                 if(isEdit){
                    $('#editimagePreview').attr('src', oldImageSrc);
                }else{
                    $('#imagePreview').attr('src', oldImageSrc);
                }
                $(fileInput).val(''); // use stored reference
                return;
            }
            // If the image is valid, update the preview image source
            if(isEdit){
                $('#editimagePreview').attr('src', reader.result);
            }else{
                $('#imagePreview').attr('src', reader.result);
            }
        }
        img.src = reader.result;
    }
    reader.readAsDataURL(file);
});

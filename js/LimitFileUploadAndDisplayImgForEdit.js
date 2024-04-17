$('#editimagefile').on('change', function() {
    var fileInput = this; // store reference to file input
    var file = this.files[0];
    var imageType = /image.*/;
    var validExtensions = ['png', 'jpg', 'jpeg', 'gif']; 
    var oldImageSrc = $('#editimagePreview').attr('src'); 

    if (!file.type.match(imageType)) {
        swal({
            icon: "error",
            title: "Oops... The uploaded file is not a image!",
            text: "Please upload a vaild image file!",
        });
        $('#editimagePreview').attr('src', oldImageSrc);
        $(fileInput).val(''); // use stored reference
        return;
    }

    var extension = file.name.split('.').pop().toLowerCase();
    if(validExtensions.indexOf(extension) == -1) {
        swal({
            icon: "error",
            title: "Oops... Invalid extension!",
            text: "Only png, jpg, jpeg and gif are allowed.",
        });
        $('#editimagePreview').attr('src', oldImageSrc);
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
                $('#editimagePreview').attr('src', oldImageSrc);
                $(fileInput).val(''); // use stored reference
                return;
            }
            // If the image is valid, update the preview image source
            $('#editimagePreview').attr('src', reader.result);
        }
        img.src = reader.result;
    }
    reader.readAsDataURL(file);
});

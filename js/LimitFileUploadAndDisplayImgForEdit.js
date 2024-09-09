$('#editimagefile').on('change', function() {
    var fileInput = this; // store reference to file input
    var file = this.files[0];
    var imageType = /image.*/;
    var validExtensions = ['png', 'jpg', 'jpeg']; 
    var oldImageSrc = $('#editimagePreview').attr('src'); 

    //Check if the file is vaild image
    if (!file.type.match(imageType)) {
        swal({
            icon: "error",
            title: "Oops... The uploaded file is not a image!",
            text: "Please upload a vaild image file!",
        });
        $('#editimagePreview').attr('src', oldImageSrc);//Brings back the old No profile picture
        $(fileInput).val(''); //Empties the file upload input box
        return;
    }
    //Lower case the file extension
    var extension = file.name.split('.').pop().toLowerCase();
    //check if the image is has vaild extension
    if(validExtensions.indexOf(extension) == -1) {
        swal({
            icon: "error",
            title: "Oops... Invalid extension!",
            text: "Only png, jpg, jpeg and gif are allowed.",
        });
        $('#editimagePreview').attr('src', oldImageSrc);//Brings back the old No profile picture
        $(fileInput).val('');  //Empties the file upload input box
        return;
    }

    //Reads the Image
    var reader = new FileReader();
    reader.onload = function(e) {
        var img = new Image();
        img.onload = function() {
            //Check if the image is 200 x 200 px
            if(img.width > 200 || img.height > 200) {
                swal({
                    icon: "error",
                    title: "Oops... Image Size is too large",
                    text: "Please upload an image with dimensions not exceeding 200x200 pixels.",
                });
                $('#editimagePreview').attr('src', oldImageSrc);//Brings back the old No profile picture
                $(fileInput).val('');  //Empties the file upload input box
                return;
            }
            // If the image is valid, update the preview image source
            $('#editimagePreview').attr('src', reader.result);
        }
        img.src = reader.result;
    }
    reader.readAsDataURL(file);
});

$('#imagefile').change(function() {
    var file = this.files[0];
    var reader = new FileReader();
    reader.onloadend = function() {
        var img = new Image();
        img.src=reader.result;
        img.onload=function(){
            if(img.naturalWidth <= 200 && img.naturalHeight <= 200){
              $('#imagePreview').attr('src', reader.result);

            }else{
                swal({
                    icon: "error",
                    title: "Oops... Image Size is too large",
                    text: "Please Upload 200x200 pixels of image only.",
                });
            }
        }
    }
    reader.readAsDataURL(file);
});
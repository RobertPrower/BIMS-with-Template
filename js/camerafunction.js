$(document).ready(function() {
    var isCameraOpen = false;

    $('#openCamera, #editopenCamera').click(function() {
        var isEdit = $("#EditResidentModal").hasClass("show");

        if (!isCameraOpen) {
            // Initialize the webcam feed using Webcam.js
            Webcam.set({
                width: 200,
                height: 200,
                dest_width: 1280,
                dest_height: 720,
                crop_width: 720,
                crop_height: 720,
                image_format: 'jpeg',
                jpeg_quality: 100
            });

            if(isEdit){
                Webcam.attach('#editcameraFeed'); // Attach the webcam to the camera feed div
  
                // Show the camera feed and hide the preview image
                $('#editcameraFeedWrapper').show();
                $('#editimagePreviewWrapper').hide();
                $('#editimagefile').prop('disabled',true)

                // Change button text and style
                $('#editopenCamera').text('Capture').removeClass('btn-primary').addClass('btn-success');
                isCameraOpen = true;
    
                $("#editimagePreview").attr("disabled");
                $("#isfromcamcheck").prop("disabled", true);

            }else{
                Webcam.attach('#cameraFeed'); // Attach the webcam to the camera feed div
  
                // Show the camera feed and hide the preview image
                $('#cameraFeedWrapper').show();
                $('#imagePreviewWrapper').hide();
                $('#imagefile').prop('disabled',true)

                // Change button text and style
                $('#openCamera').text('Capture').removeClass('btn-primary').addClass('btn-success');
                isCameraOpen = true;
    
                $("#imagePreview").attr("disabled");
            
            }

        }else{
            if(isEdit){
                // Capture the image from the webcam
                Webcam.snap(function(data_uri) {
                // Stop the webcam
                Webcam.reset();
    
                // Display the captured image in the preview section
                $('#editimagePreview').attr('src', data_uri);
                                
                // Show the preview image and hide the camera feed
                $('#editimagePreviewWrapper').show();
                $('#editcameraFeedWrapper').hide();
    
                // Reset the button text and style
                $('#editopenCamera').text('Open Camera').removeClass('btn-success').addClass('btn-primary');
                $('#editimagefile').prop('disabled',false)
                $("#editimagefile").val('');  
                
                $("#isfromcamcheck").prop("disabled", false);
                $('#isfromcamcheck').val(data_uri);
                isCameraOpen = false;
                });

              
            }else{
                // Capture the image from the webcam
                Webcam.snap(function(data_uri) {
                // Stop the webcam
                Webcam.reset();
    
                // Display the captured image in the preview section
                $('#imagePreview').attr('src', data_uri);

                // Show the preview image and hide the camera feed
                $('#imagePreviewWrapper').show();
                $('#cameraFeedWrapper').hide();
    
                // Reset the button text and style
                $('#openCamera').text('Open Camera').removeClass('btn-success').addClass('btn-primary');
                $('#imagefile').prop('disabled',false)
                $("#imagefile").val('');  
                isCameraOpen = false;
                });
            }
        }
    });
});

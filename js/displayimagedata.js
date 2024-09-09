$(document).ready(function () {
  // Delegate the click event to the document or a static ancestor
  $(document).on("click", " .editResidentButton, .viewResidentButton", function () {
    var residentId = $(this).data("id");
    var clickedButton = $(this);
    $.ajax({
      url: "includes/GetImageData.php",
      type: "GET",
      data: { id: residentId },
      dataType: "json",
      success: function (response) {
        // Variables to collect the response of the server
        var imageFilename = response.imageData;
        var match = imageFilename.match("capture");
        var correctimagepath = "includes/img/resident_img/" + imageFilename;
        
        var isEdit = clickedButton.hasClass("editResidentButton");
        console.log(isEdit);

        if(isEdit){
          // Display image
          $("#editimagePreview").attr("src", correctimagepath);
          console.log("Edit picture has been load");
          console.log(correctimagepath);

        }else{
          // Display image
          $("#viewimagePreview").attr("src", correctimagepath);
          console.log("View image has been loaded");
        }

        
      },
      error: function (xhr, status, error) {
        console.error("Error fetching metadata:", error);
      },
    });
  });

//   $(document).on("click", ".viewResidentButton", function () {
//     var residentId = $(this).data("id");
//     console.log(residentId);
//     $.ajax({
//       url: "includes/GetImageData.php",
//       type: "GET",
//       data: { id: residentId },
//       dataType: "json",
//       success: function (response) {
//         // Variables to collect the response of the server
//         var imageFilename = response.imageData;
//         var match = imageFilename.match("capture");
//         if(match){
//           var correctimagepath = "includes/img/resident_img/capture/" + imageFilename;
//         }else{
//           var correctimagepath = "includes/img/resident_img/" + imageFilename;
//         }
//         // Display image
//         $("#viewimagePreview").attr("src", correctimagepath);

//         console.log(correctimagepath);
//       },
//       error: function (xhr, status, error) {
//         console.error("Error fetching metadata:", error);
//       },
//     });
//   });
 });

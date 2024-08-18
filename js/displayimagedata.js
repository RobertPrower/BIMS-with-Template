// $(document).ready(function () {
//   $(".editResidentButton").click(function () {
//     var residentId = $(this).data("id");
//     $.ajax({
//       url: "includes/GetImageData.php",
//       type: "GET",
//       data: { id: residentId },
//       dataType: "json",
//       success: function (response) {
//         // Variables to collect the response of the server
//         var imagePath = response.imageData;
//         var correctimagepath = "includes/" + imagePath;
//         var imageSize = response.imageSize;
//         var imageHeight = response.imageHeight;

//         // Display image
//         $("#editimagePreview").attr("src", correctimagepath);

//         console.log(imagePath);
//       },
//       error: function (xhr, status, error) {
//         console.error("Error fetching metadata:", error);
//       },
//     });
//   });
// });

$(document).ready(function () {
  // Delegate the click event to the document or a static ancestor
  $(document).on("click", ".editResidentButton", function () {
    var residentId = $(this).data("id");
    $.ajax({
      url: "includes/GetImageData.php",
      type: "GET",
      data: { id: residentId },
      dataType: "json",
      success: function (response) {
        // Variables to collect the response of the server
        var imagePath = response.imageData;
        var correctimagepath = "includes/" + imagePath;
        var imageSize = response.imageSize;
        var imageHeight = response.imageHeight;

        // Display image
        $("#editimagePreview").attr("src", correctimagepath);

        console.log(imagePath);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching metadata:", error);
      },
    });
  });
});

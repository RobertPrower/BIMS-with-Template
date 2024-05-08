$(document).ready(function () {
$(".viewResidentButton").click(function () {
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

        // Display image
        $("#viewimagePreview").attr("src", correctimagepath);

        console.log(imagePath);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching metadata:", error);
      },
    });
  });
});
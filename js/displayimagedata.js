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
        var imageFilename = response.imageData;
        var correctimagepath = "includes/img/resident_img/" + imageFilename;
        var imageSize = response.imageSize;
        var imageHeight = response.imageHeight;

        // Display image
        $("#editimagePreview").attr("src", correctimagepath);

        console.log(correctimagepath);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching metadata:", error);
      },
    });
  });
});

$(document).ready(function () {
  $(document).on("click", ".viewResidentButton", function () {
    var residentId = $(this).data("id");
    console.log(residentId);
    $.ajax({
      url: "includes/GetImageData.php",
      type: "GET",
      data: { id: residentId },
      dataType: "json",
      success: function (response) {
        // Variables to collect the response of the server
        var imageFilename = response.imageData;
        var correctimagepath = "includes/img/resident_img/" + imageFilename;

        // Display image
        $("#viewimagePreview").attr("src", correctimagepath);

        console.log(correctimagepath);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching metadata:", error);
      },
    });
  });
});

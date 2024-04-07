$(document).ready(function () {
  // Attach event listener to form submission
  $("#AddResidentModalForm").submit(function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    // Collect form data using FormData
    var formData = new FormData(this);

    // Send AJAX request
    $.ajax({
      url: "includes/addresident.php",
      type: "POST",
      data: formData,
      dataType: "json",
      contentType: false, // Ensure proper content type for FormData
      processData: false, // Prevent jQuery from processing the data
      success: function (response) {
        // Handle success response
        console.log("Data saved successfully:", response);

        $("#AddResidentModal").modal("hide");
        swal({
          title: "Add Entry",
          text: "Entry Added Sucessfully!",
          icon: "success",
          button: "Close",
        });
      },
      error: function (xhr, status, error) {
        // Handle error response
        console.error("Error saving data:", error);
        // Optionally, display an error message to the user
      },
    });
  });
});

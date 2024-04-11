$(document).ready(function () {
  // Attach event listener to form submission
  $("#EditResidentModalForm").submit(function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    // Collect form data using FormData
    var formData = new FormData(this);

    // Send AJAX request
    $.ajax({
      url: "includes/editresident.php",
      type: "POST",
      data: formData,
      dataType: "json",
      contentType: false, 
      processData: false, 
      success: function (response) {
        // Handle success response
        console.log("Data saved successfully:", response);
        
       if (response.success){
        $("#EditResidentModal").modal("hide");
          swal({
            title: "Edit Entry",
            text: "Entry Edited Sucessfully!",
            icon: "success",
            button: "Close",
          });
       }else{
        $("#EditResidentModal").modal("hide");
          swal({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
        });
       }// END of if 
       
      },
      error: function (xhr, status, error) {
        // Handle error response
        console.error("Error saving data:", error);
        // Optionally, display an error message to the user
        $("#EditResidentModal").modal("hide");
        swal({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
        });
      },
    });
  });
});

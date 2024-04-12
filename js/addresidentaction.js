function RefreshTable(){
  $.ajax({
      url: 'includes/FetchDataForTableRefresh.php',
      type: 'GET', 
      success: function(data){
          $('#ResidentTable').html(data);
      }
  });
}

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
      dataType: "JSON",
      contentType: false, 
      processData: false, 
      success: function (response) {
        // Handle success response
        console.log("Data saved successfully:", response);

        if (response.success){
          $("#AddResidentModal").modal("hide");
            swal({
              title: "Add Entry",
              text: "Entry Added Sucessfully!",
              icon: "success",
              button: "Close",
            });

            RefreshTable();
         }else{
          $("#AddResidentModal").modal("hide");
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
        $("#AddResidentModal").modal("hide");
        swal({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
        });
      },
    });
    //console.log(formData);
  });
});

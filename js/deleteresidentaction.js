/*$(document).on("click", ".Delete_Button", function (event) {
  function reloadTable() {
    $.ajax({
      url: "includes/residenttableautoreload.php",
      type: "POST",
      data: { operation: "delete" },
      dataType: "HTML",
      success: function (data) {
        $("#ResidentTable tbody").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      },
    });
  }

  // Prevent the default click action
  event.preventDefault();

  // Get the resident ID from the data attribute
  var residentId = $(this).data("resident_id");

  // Show confirmation dialog using SweetAlert
  swal({
    title: "Are you sure?",
    text: "Once deleted, you will not be able to recover this entry!",
    icon: "warning",
    buttons: ["Cancel", "Delete"],
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      // Send AJAX request to delete resident
      $.ajax({
        url: "includes/deleteresidentbtn.php",
        type: "POST",
        data: { resident_id: residentId },
        dataType: "json",
        success: function (response) {
          // Handle success response
          console.log("Data deleted successfully:", response);
          swal("Record Has Been Deleted", {
            icon: "success",
          });

          reloadTable();
        },
        error: function (xhr, status, error) {
          // Handle error response
          console.error("Error deleting data:", error);
          // Display an error message to the user using SweetAlert
          swal("Error!", "Failed to delete the entry.", "error");
        },
      });
    } else {
      // User clicked the cancel button
      swal("Entry not deleted!", {
        icon: "info",
      });
    }
  });
});*/

$(document).ready(function () {
  // Use event delegation to handle clicks on dynamically loaded delete buttons
  $("#ResidentTable").on("click", ".Delete_Button", function (event) {
    event.preventDefault();

    // Get the resident ID from the data attribute
    var residentId = $(this).data("resident_id");

    // Show confirmation dialog using SweetAlert
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this entry!",
      icon: "warning",
      buttons: ["Cancel", "Delete"],
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        // Send AJAX request to delete resident
        $.ajax({
          url: "includes/deleteresidentbtn.php",
          type: "POST",
          data: { resident_id: residentId },
          dataType: "json",
          success: function (response) {
            // Handle success response
            console.log("Data deleted successfully:", response);
            swal("Record Has Been Deleted", {
              icon: "success",
            });

            reloadTable();
          },
          error: function (xhr, status, error) {
            // Handle error response
            console.error("Error deleting data:", error);
            // Display an error message to the user using SweetAlert
            swal("Error!", "Failed to delete the entry.", "error");
          },
        });
      } else {
        // User clicked the cancel button
        swal("Entry not deleted!", {
          icon: "info",
        });
      }
    });
  });

  function reloadTable() {
    $.ajax({
      url: "includes/residenttableautoreload.php",
      type: "POST",
      data: { operation: "delete" },
      dataType: "HTML",
      success: function (data) {
        $("#ResidentTable tbody").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      },
    });
  }
});

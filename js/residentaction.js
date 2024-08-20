$(document).ready(function () {
  function reloadTable() {
    $.ajax({
      url: "includes/residenttableautoreload.php",
      type: "POST",
      data: { operation: "add" },
      dataType: "HTML",
      success: function (data) {
        $("#ResidentTable tbody").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      },
    });
  }

  //For Adding Resident
  $("#AddResidentModalForm").submit(function (event) {
    event.preventDefault();

    var formData = new FormData(this);

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

        if (response.success) {
          $("#AddResidentModal").modal("hide");
          swal({
            title: "Add Entry",
            text: "Entry Added Sucessfully!",
            icon: "success",
            button: "Close",
          });

          reloadTable();
        } else {
          $("#AddResidentModal").modal("hide");
          swal({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
        } // END of if
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
  });

  //For Deleting Resident
  $(document).ready(function () {
    $("#ResidentTable").on("click", "#deletebutton", function (event) {
      event.preventDefault();

      var residentId = $(this).data("id");
      console.log(residentId);

      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this entry!",
        icon: "warning",
        buttons: ["Cancel", "Delete"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "includes/deleteresidentbtn.php",
            type: "POST",
            data: { resident_id: residentId },
            dataType: "json",
            success: function (response) {
              console.log("Data deleted successfully:", response);
              swal("Record Has Been Deleted", { icon: "success" });
              reloadTable();
            },
            error: function (xhr, status, error) {
              console.error("Error deleting data:", error);
              swal("Error!", "Failed to delete the entry.", "error");
            },
          });
        } else {
          swal("Entry not deleted!", { icon: "info" });
        }
      });
    });

    // Function to reload the table
    function reloadTable() {
      $.ajax({
        url: "includes/residenttableautoreload.php",
        type: "POST",
        data: { operation: "view" },
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

  //For Editing Resident Entry
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

        if (response.success) {
          $("#EditResidentModal").modal("hide");
          swal({
            title: "Edit Entry",
            text: "Entry Edited Sucessfully!",
            icon: "success",
            button: "Close",
          });

          reloadTable();
        } else {
          $("#EditResidentModal").modal("hide");
          swal({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
        } // END of if
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

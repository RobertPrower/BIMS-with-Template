$(document).ready(function () {
  function reloadTable() {
    $.ajax({
      url: "includes/residenttableautoreload.php",
      type: "POST",
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
    formData.append("operation","ADD");

    $.ajax({
      url: "includes/residentoperation.php",
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
    $("#ResidentTable").on("click", "#deletebutton", function (event) {
      event.preventDefault();

      var residentId = $(this).data("resident_id");
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
            url: "includes/residentoperation.php",
            type: "POST",
            data: { resident_id: residentId, operation: "DELETE"},
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

  //For Editing Resident Entry
  $("#EditResidentModalForm").submit(function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    // Collect form data using FormData
    var formData = new FormData(this);
    //For the PHP operation IF statement
    formData.append("operation","EDIT");

    // Send AJAX request
    $.ajax({
      url: "includes/residentoperation.php",
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

//For the pagination

$(document).ready(function() {
  function loadPage(page) {
      $.ajax({
          url: 'includes/residentpagination.php',
          type: 'GET',
          data: { page: page },
          dataType: 'json',
          success: function(response) {
              var items = response.items;
              var totalPages = response.total_pages;
              var currentPage = response.current_page;

              // Clear previous content
              $('#data-container').empty();
              $('#pagination-controls').empty();

              // Append items to the container
              $.each(items, function(index, item) {
                  $('#data-container').append('<div class="item"><h3>' + item.name + '</h3><p>' + item.description + '</p></div>');
              });

              // Create pagination controls
              if (currentPage > 1) {
                  $('#pagination-controls').append('<a href="#" data-page="' + (currentPage - 1) + '">Previous</a>');
              }
              
              for (var i = 1; i <= totalPages; i++) {
                  $('#pagination-controls').append('<a href="#" data-page="' + i + '"' + (i === currentPage ? ' class="active"' : '') + '>' + i + '</a>');
              }
              
              if (currentPage < totalPages) {
                  $('#pagination-controls').append('<a href="#" data-page="' + (currentPage + 1) + '">Next</a>');
              }
          }
      });
  }

  // Load initial page
  loadPage(1);

  // Handle pagination link clicks
  $(document).on('click', '#pagination-controls a', function(e) {
      e.preventDefault();
      var page = $(this).data('page');
      loadPage(page);
  });
});

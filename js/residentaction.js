$(document).ready(function () {

  reloadTable();

  function reloadTable(page) {
    $.ajax({
      url: "includes/residenttableautoreload.php",
      type: "POST",
      data: {pageno: page},
      dataType: "HTML",
      success: function (data) {
        $("#ResidentTable tbody").html(data);
        updatePaginationControls(page);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      },
    });
  }

  function updatePaginationControls(currentPage){
    var operation = "PAGINATION";
    $.ajax({
      url: "includes/residentoperation.php",
      type: "POST",
      data: {pageno: currentPage, operation: operation},
      dataType: "HTML",
      success: function (data) {
        $(".pagination").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error updating pagination data:", error);
      },
    });
  }
  //For pagination controls and make it dynamic
  $(document).on('click', '.page-link', function(e) {
    e.preventDefault();
    
    var page = $(this).data('page'); 
    var operation = "PAGINATION";
    
    console.log('Operation:', operation);
    console.log('Page:', page);

    $('.pagination .page-item').removeClass('active');
    $(this).parent().addClass('active');
    

    $.ajax({
        url: 'includes/residentoperation.php',  
        type: 'POST',
        data: { pageno: page, operation: operation},
        success: function(response) {
            $('#ResidentTableBody').html(response);  
            reloadTable(page)
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error); 
        }
    });
  });

  //For the search box
  $('#searchbox').on("keyup", function(){
    let query = $(this).val();

    if (query.length >2){
      $.ajax({
        url: "includes/residentoperation.php",
        type: "POST",
        data: {search: query, operation: "SEARCH"},
        success: function(data){
          $('#ResidentTableBody').html(data);
      },
      error: function(xhr, status, error) {
          console.error('AJAX Error:', status, error);
      }
      });
    }else{
      $("ResidentTableBody").html(""); 
    }
  });

  //For Adding Resident
  $("#AddResidentModalForm").submit(function (event) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("operation","ADD");

    var page = $(this).data('pageno');
    console.log(page);

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

          reloadTable(page);
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
      var page = $(this).data("page");
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
              reloadTable(page);
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

    const textbox = document.getElementById('pageno');
    const page = textbox.value;
    console.log("Page Number: " + page);

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

          reloadTable(page);
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


$(document).ready(function () {
  //loads the table
  reloadTable();

  //For the Bootstrap Tooltips to load
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );

  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  $("input[name='birth_date']").datepicker({
    format: "mm/dd/yyyy",
    autoclose: true,
  });

  $("#AddResidentModal").on("hidden.bs.modal", function () {
    $("#birth_date").val(""); // Clear the input
  });

  $("#EditResidentModal").on("hidden.bs.modal", function () {
    $("#birth_date").val(""); // Clear the input
  });

  //For the tooltip to be triggered manually via Jquery
  $("#editopenCamera").tooltip({
    trigger: "manual",
  });

  //To Reload the page
  function reloadTable(page) {
    $.ajax({
      url: "includes/residenttableautoreload.php",
      type: "POST",
      data: { pageno: page },
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

  //Reload the table of the Deleted Entries
  function reloadDeletedEntries(page) {
    $.ajax({
      url: "includes/residentoperation.php",
      type: "POST",
      data: { pageno: page, operation: "SHOW_DELETED" },
      dataType: "HTML",
      success: function (data) {
        $("#ResidentTable tbody").html(data);
        updateDeletedPaginationControls(page);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      },
    });
  }

  //Update the pagination controls every operation
  function updatePaginationControls(currentPage) {
    $.ajax({
      url: "includes/residentoperation.php",
      type: "POST",
      data: { pageno: currentPage, operation: "PAGINATION" },
      dataType: "HTML",
      success: function (data) {
        $(".pagination").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error updating pagination data:", error);
      },
    });
  }

  //Update the pagination controls every search
  function updateSearchPaginationControls(query, currentPage) {
    $.ajax({
      url: "includes/residentsearch.php",
      type: "POST",
      data: {
        search: query,
        pageno: currentPage,
        operation: "SEARCH_PAGINATION",
      },
      success: function (data) {
        $(".pagination").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error updating search pagination data:", error);
      },
    });
  }

  //Update the pagination controls every flipped of the show deleted entries switch
  function updateDeletedPaginationControls(currentPage) {
    $.ajax({
      url: "includes/residentoperation.php",
      type: "POST",
      data: { pageno: currentPage, operation: "PAGINATION_FOR_DEL_REC" },
      success: function (data) {
        $(".pagination").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error updating pagination data:", error);
      },
    });
  }

  //Function to search for entries
  function fetchResults(query, page = 1) {
    if ($("#showdeletedentries").is(":checked")) {
      console.log("Deleted Entries switch has been on");
      $.ajax({
        url: "includes/residentsearch.php",
        type: "POST",
        data: { search: query, page: page, operation: "DELETED_SEARCH" },
        success: function (data) {
          $("#ResidentTableBody").html(data);
          updateDeletedPaginationControls(page);
        },
        error: function (xhr, status, error) {
          console.error("Error fetching search results:", error);
        },
      });
    } else {
      console.log("Deleted Entries switch has been off");
      $.ajax({
        url: "includes/residentsearch.php",
        type: "POST",
        data: { search: query, page: page, operation: "SEARCH" },
        success: function (data) {
          $("#ResidentTableBody").html(data);
          updateSearchPaginationControls(query, page);
        },
        error: function (xhr, status, error) {
          console.error("Error fetching search results:", error);
        },
      });
    }
  }

  //For the search box
  $("#searchbox").on("keyup", function () {
    let query = $(this).val();

    if (query.length > 2) {
      //Fetch the results by the fetchResults function above
      fetchResults(query);
    } else {
      if ($("#showdeletedentries").is(":checked")) {
        //If query is less than 2 character just reload the table
        reloadDeletedEntries(1);
      } else {
        reloadTable();
      }
    }
  });

  //Show the deleted records when the switch is flipped
  $("#showdeletedentries").click(function () {
    let query = $("#searchbox").val(); // Get the current search query
    if ($(this).is(":checked")) {
      console.log("Checkbox ON - Show Deleted Entries");
      reloadDeletedEntries(1); // Reload deleted entries
    } else {
      console.log("Checkbox OFF - Hide Deleted Entries");
      reloadTable(1); // Reload all entries
    }
  });

  //For pagination control function and make it dynamic
  $(document).on("click", ".page-link", function (e) {
    e.preventDefault();

    var page = $(this).data("page");
    console.log("Page:", page);

    $(".pagination .page-item").removeClass("active");
    $(this).parent().addClass("active");

    if ($("#showdeletedentries").is(":checked")) {
      reloadDeletedEntries(page);
      updateDeletedPaginationControls(page);
    } else {
      reloadTable(page);
      updatePaginationControls(page);
    }
  });

  //For Adding Resident
  $("#AddResidentModalForm").submit(function (event) {
    event.preventDefault();

    var captureImageData = $("#imagePreview").attr("src");
    console.log(captureImageData);

    var formData = new FormData(this);
    formData.append("operation", "ADD");
    formData.append("captureImageData", captureImageData);

    var page = $(this).data("pageno");
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

  //For Recovering Resident entries
  $("#ResidentTable").on("click", "#undodeletebutton", function (event) {
    event.preventDefault();

    var residentId = $(this).data("resident_id");
    console.log(residentId);
    var page = $(this).data("page");
    swal({
      title: "Are you sure?",
      text: "The record will be recovered.",
      icon: "warning",
      buttons: ["Cancel", "Recovered"],
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: "includes/residentoperation.php",
          type: "POST",
          data: { resident_id: residentId, operation: "UNDO_DELETE" },
          dataType: "json",
          success: function (response) {
            console.log("Data recovered successfully:", response);
            swal("Record Has Been Restored", { icon: "success" });
            reloadDeletedEntries(page);
          },
          error: function (xhr, status, error) {
            console.error("Error deleting data:", error);
            swal("Error!", "Failed to recovered the entry.", "error");
          },
        });
      } else {
        swal("Entry not recovered!", { icon: "info" });
      }
    });
  });

  $("#ResidentTable").on("click", "#deletebutton", function (event) {
    event.preventDefault();

    var currentSearch = $("#searchbox").val();
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
          data: { resident_id: residentId, operation: "DELETE" },
          dataType: "json",
          success: function (response) {
            console.log("Data deleted successfully:", response);
            swal("Record Has Been Deleted", { icon: "success" });
            //If the modal was fired from a search make sure still the same page
            if (currentSearch) {
              fetchResults(currentSearch, page);
            } else {
              //If not just reload the page
              reloadTable(page);
            }
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
    var currentSearch = $("#searchbox").val();

    //For the PHP operation IF statement
    formData.append("operation", "EDIT");

    const textbox = document.getElementById("pageno");
    const page = textbox.value;

    var capturecameracheck = $("#editopenCamera").text();
    console.log(capturecameracheck);

    console.log("Page Number: " + page);

    switch (capturecameracheck) {
      case "Capture":
        $("#editopenCamera").tooltip("toggle");

        if ($(".editopenCamera").hasClass("show")) {
          $(".editopenCamera").addClass("tooltip-red");
        } else {
          $(".editopenCamera").removeClass("tooltip-red");
        }
        break;
      default:
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
              //If the modal was fired from a search make sure still the same page
              if (currentSearch) {
                fetchResults(currentSearch, page);
              } else {
                //If not just reload the page
                reloadTable(page);
              }
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
    }
  });

  //For reseting the Add Resident Form everytime you click the close or X button
  $(".btnClose, #clearButton").on("click", function () {
    console.log("Close Button is click");
    var form = document.getElementById("AddResidentModalForm");
    form.reset();

    var imagePreview = document.getElementById("imagePreview");
    imagePreview.src = "includes/img/blank-profile.webp";

    if ($("imagefile").prop("disabled", true)) {
      console.log("The File upload has been reset!");
      $("#imagefile").prop("disabled", false);
    } else {
      alert("This block of code should not be executed!!");
    }
  });

  //Prevent the captured image from being send incase the modal has been close and reopen
  $("#AddResidentModal #EditResidentModal").hasClass("show", function () {
    $("#isfromcamcheck").prop("disabled", true);
  });

 //For populating the View and Edit Modal Combined into one event
  $(document).on(
    "click",
    ".editResidentButton, .viewResidentButton",
    function (event) {
      event.preventDefault();

      // Get common data attributes
      var resident_id = $(this).data("id");
      var first_name = $(this).data("first-name");
      var middle_name = $(this).data("middle-name");
      var last_name = $(this).data("last-name");
      var suffix = $(this).data("suffix");
      var house_no = $(this).data("house-no");
      var street_name = $(this).data("street-name");
      var subdivision = $(this).data("subdivision");
      var sex = $(this).data("sex");
      var marital_status = $(this).data("marital-status");
      var birth_date = $(this).data("birth-date");
      var birthplace = $(this).data("birth-place");
      var phone_number = $(this).data("phone-number");
      var is_a_voter = $(this).data("isa-voter");
      var resident_since = $(this).data("rsince");

      // Determine if this is for 'edit' or 'view'
      var isEdit = $(this).hasClass("editResidentButton");

      // Modal ID based on the button clicked (Edit or View)
      var modalId = isEdit ? "#EditResidentModal" : "#ViewResidentModal";

      // Populate the common fields in the modal
      $(modalId + ' input[name="resident_id"]').val(resident_id);
      $(modalId + ' input[name="fname"]').val(first_name);
      $(modalId + ' input[name="mname"]').val(middle_name);
      $(modalId + ' input[name="lname"]').val(last_name);
      $(modalId + ' input[name="suffix"]').val(suffix);
      $(modalId + ' input[name="house_no"]').val(house_no);
      $(modalId + ' input[name="street"]').val(street_name);
      $(modalId + ' select[name="subd"]').val(subdivision);
      $(modalId + ' select[name="sex"]').val(sex);
      $(modalId + ' select[name="marital_status"]').val(marital_status);
      $(modalId + ' input[name="birth_date"]').val(birth_date);
      $(modalId + ' input[name="birth_place"]').val(birthplace);
      $(modalId + ' input[name="cellphone_number"]').val(phone_number);
      $(modalId + ' select[name="is_a_voter"]').val(is_a_voter);
      $(modalId + ' input[name="rsince"]').val(resident_since);

      // Specific logic for editing
      if (isEdit) {
        var page = $(this).data("pageno");
        $(modalId + ' input[name="pageno"]').val(page);
        $(modalId).modal("show"); // Show the Edit modal

        // Specific logic for viewing
      } else {
        // Make the profile tab the default tab when the view button is clicked
        $("#nav-home-tab").tab("show");
        $(modalId).modal("show"); // Show the View modal
        //For counting certificates requested
        $.ajax({
          type: "post",
          url: "includes/residentoperation.php",
          data: {operation: "COUNT_RES_CERT", resident_id: resident_id},
          dataType: "json",
          success: function (response) {
            console.log(response)
  
            $("#noofcerts").text(response);
            
          }
        });
      }
    }
  );

  //AJAX request for the clearance tab and table of the modal
  $(document).on("click", "#nav-clearance-tab", function () {
    var resident_id = $("#viewresident_id").val();

    console.log(resident_id);

    $.ajax({
      url: "includes/get-resident-docu-request.php",
      type: "POST",
      data: { resident_id: resident_id },
      dataType: "HTML",
      success: function (data) {
        $("#ResidentRequestTable tbody").html(data);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      },
    });
  });
});

$(document).ready(function () {
  reloadTable(1);

  function reloadTable(page) {
    $.ajax({
      url: "includes/documentsoperation.php",
      type: "POST",
      data: { pageno: page, OPERATION: "TABLE_LOAD"},
      dataType: "HTML",
      success: function (data) {
        $("#DocumentsTableBody").html(data);
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
        url: "includes/documentsoperation.php",
        type: "POST",
        data: { pageno: page, OPERATION: "SHOW_DELETED" },
        dataType: "HTML",
        success: function (data) {
          $("#DocumentsTableBody").html(data);
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
        url: "includes/documentsoperation.php",
        type: "POST",
        data: { pageno: currentPage, OPERATION: "PAGINATION" },
        dataType: "HTML",
        success: function (data) {
          $(".pagination").html(data);

        //Prevent the pagination from showing when the entries is less than 10 entries
        var noofpageitems = $(".page-item").length;
        switch(noofpageitems){
          case 1 :
            $("#pagenav").prop("hidden", true);
          break;
          default:
            $("#pagenav").prop("hidden", false);
        }


        },
        error: function (xhr, status, error) {
          console.error("Error updating pagination data:", error);
        },
      });
    }
  
    //Update the pagination controls every search
    function updateSearchPaginationControls(query, currentPage) {
      $.ajax({
        url: "includes/documentssearch.php",
        type: "POST",
        data: {
          search: query,
          pageno: currentPage,
          OPERATION: "SEARCH_PAGINATION",
        },
        success: function (data) {
          $(".pagination").html(data);

          //Prevent the pagination from showing when the entries is less than 10 entries
          var noofpageitems = $(".page-item").length;
          switch(noofpageitems){
            case 1 :
              $("#pagenav").prop("hidden", true);
            break;
            default:
              $("#pagenav").prop("hidden", false);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error updating search pagination data:", error);
        },
      });
    }
  
    //Update the pagination controls every flipped of the show deleted entries switch
    function updateDeletedPaginationControls(currentPage) {
      $.ajax({
        url: "includes/documentsoperation.php",
        type: "POST",
        data: { pageno: currentPage, OPERATION: "PAGINATION_FOR_DEL_REC" },
        success: function (data) {
          $(".pagination").html(data);
          //Prevent the pagination from showing when the entries is less than 10 entries
        var noofpageitems = $(".page-item").length;
        switch(noofpageitems){
          case 1 :
            $("#pagenav").prop("hidden", true);
          break;
          default:
            $("#pagenav").prop("hidden", false);
        }
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
          url: "includes/documentssearch.php",
          type: "POST",
          data: { search: query, page: page, OPERATION: "DELETED_SEARCH" },
          success: function (data) {
            $("#DocumentsTableBody").html(data);
            updateDeletedPaginationControls(page);
          },
          error: function (xhr, status, error) {
            console.error("Error fetching search results:", error);
          },
        });
      } else {
        console.log("Deleted Entries switch has been off");
        $.ajax({
          url: "includes/documentssearch.php",
          type: "POST",
          data: { search: query, page: page, operation: "SEARCH" },
          success: function (data) {
            $("#DocumentsTableBody").html(data);
            updateSearchPaginationControls(query, page);
          },
          error: function (xhr, status, error) {
            console.error("Error fetching search results:", error);
          },
        });
      }
    }
  
    //For the search box
    $("#searchbox").on("keydown", function () {
      let query = $(this).val();
  
      if (query.length >= 1) {
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

  //For populating the DocumentsViewModal
  $(document).on("click", ".viewDocumentsButton", function (event) {
    event.preventDefault();

    var request_id = $(this).data("id");
    var resident_id = $(this).data("resident_id");
    var date_requested = $(this).data("date-requested");
    var expiration = $(this).data("expiration-date");
    var first_name = $(this).data("first-name");
    var middle_name = $(this).data("middle-name");
    var last_name = $(this).data("last-name");
    var suffix = $(this).data("suffix");
    var house_no = $(this).data("house-no");
    var street_name = $(this).data("street-name");
    var subdivision = $(this).data("subdivision");
    var sex = $(this).data("sex");
    var age = $(this).data("age");
    var docu_type = $(this).data("docu-desc");
    var presented_id = $(this).data("presented-id");
    var ID_number = $(this).data("id_num");
    var purpose = $(this).data("purpose");
    var agency = $(this).data("agency");
    var status = $(this).data("status");
    var date_edited = $(this).data("last-edited");
    var date_deleted = $(this).data("last-deleted");

    $("#Request_ID").html("<b>Request ID:  </b>" + request_id);
    $("#Date_issued").html("<b>Date Issued:  </b>" + date_requested);
    $("#Expiration_Date").html("<b>Expiration Date:  </b>" + expiration);
    $("#Fullname").html(
      "<b>Fullname:  </b>" +
        first_name +
        " " +
        middle_name +
        " " +
        last_name +
        " " +
        suffix
    );
    $("#Address").html(
      "<b>Address:</b> " +
        house_no +
        " " +
        street_name +
        " " +
        subdivision +
        " Camarin Caloocan City"
    );
    $("#Sex").html("<b>Sex: </b>" + sex);
    $("#Age").html("<b>Age (Upon Request): </b>" + age + " Years Old");
    $("#Document_Desc").html("<b>Document Description:  </b>" + docu_type);
    $("#Presented_ID").html("<b>Presented ID:  </b>" + presented_id);
    $("#ID_num").html("<b>ID Number:  </b>" + ID_number);
    $("#Purpose").html("<b>Purpose:  </b>" + purpose);
    $("#resident_id").val(resident_id);
    $("#request_id").val(request_id);
    $("#status").val(status);
    $("#retrevePDF").attr("data-cert_type",docu_type);
    $("#certiticate_type").val(docu_type);

    //For populating data attributes for edit
    $("#editDocumentbtn").attr("data-request_id", request_id);
    $("#editDocumentbtn").attr("data-expiration", expiration);
    $("#editDocumentbtn").attr("data-presentedid", presented_id);
    $("#editDocumentbtn").attr("data-id_num", ID_number);

    //Hide the deleted date when nothing to show
    if (date_deleted == "") {
      $(".deleted_date").prop("hidden", true);
      console.log("Date Deleted is null");
    } else {
      $(".deleted_date").prop("hidden", false);
      $("#Deleted_date").html("<b>Last Edited:  </b>" + date_deleted);
    }

    //Hide the last edited date when nothing to show
    if (date_edited === "") {
      $(".last_edited").prop("hidden", true);
      console.log("Date Edited is null");
    } else {
      $(".last_edited").prop("hidden", false);
      $("#Last_Edited").html("<b>Last Edited Date:  </b>" + date_edited);
    }

    if(agency !== undefined || null){
      $(".agency").prop("hidden", false);
    }

    if(docu_type == "Business Permits"){

      $.ajax({
        type: "POST",
        url: "includes/documentsoperation.php",
        data: {OPERATION: "FETCH_BUSINESS_PERMIT", request_id: request_id },
        dataType: "JSON",
        success: function (response) {

          var data = response[0];
          var business_name = data.store_name;
          var business_address = data.address;
          var business_type = data.type_of_buss;

          $(".Business_name,  .Business_address, .Business_type").prop("hidden", false);
          $("#Business_name").html("<b>Business Name:  </b>" + business_name);
          $("#Business_address").html("<b>Business Address:  </b>" + business_address);
          $("#Business_type").html("<b>Business Type:  </b>" + business_type);
    
          
        }, error: function (xhr, status, error) {
          alert("Business Details Not Fetch!! Check your code.");
        }
      });

    
    }

    //For the status display on the table
    switch (status) {
      case 0:
        $("#Status").html(
          "<b>Status: </b>" + "<b style='color: green';>ACTIVE</b>"
        );
        break;
      case 1:
        $("#Status").html(
          "<b>Status: </b>" + "<b style='color: grey';>EXPIRED</b>"
        );
        break;
      case 2:
        $("#Status").html(
          "<b>Status: </b>" + "<b style='color: red';>REVOKED</b>"
        );
        break;
      default:
        $("#Status").html("<b>Status: </b>" + "<b>Unknown Status</b>");
    }

    //For the revoke button change depending to the status
    switch (status) {
      case 2:
        $("#revokebtn").removeClass("btn-danger");
        $("#revokebtn").addClass("btn-warning").text("Restore");
        break;
      case 0:
        $("#revokebtn").removeClass("btn-warning");
        $("#revokebtn").addClass("btn-danger").text("Revoke");

        break;
      case 1:
        $("#revokebtn").prop("hidden", true);
        $("#revokebtn").addClass("btn-warning").text("Restore");

        break;
      default:
    }
  });

  //To populate the Edit Document Modal
  $("#editDocumentbtn").click(function (e) {
    e.preventDefault();

    var expiration = $(this).data("expiration");
    var id_num = $(this).data("id_num");
    var presented_id = $(this).data("presentedid");
    var reqid = $(this).data("request_id");
    console.log(reqid);

    $("#expiration").val(expiration);
    $("#presented_id").val(presented_id);
    $("#id_num").val(id_num);
    $("#requestid").val(reqid);
  });

  //Edit function of the document
  $("#EditDocumentModalForm").submit(function (e) {
    e.preventDefault();

    var formdata = new FormData(this);
    formdata.append("OPERATION", "EDIT");

    $.ajax({
      url: "includes/documentsoperation.php",
      method: "POST",
      dataType: "JSON",
      processData: false,
      contentType: false,
      data: formdata,
      success: function (response) {
        // Check the response from the server
        if (response.success) {
          // Hide modal
          $("#EditDocumentModal").modal("hide");
          reloadTable();

          // Show success alert
          swal({
            title: "Edit Document",
            text: "Document Edited Successfully!",
            icon: "success",
            button: "Close",
          });
        } else {
          // Hide modal
          $("#EditDocumentModal").modal("hide");
          reloadTable();

          // Show error alert
          swal({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
        }
      },
      error: function (xhr, status, error) {
        // Hide modal
        $("#EditDocumentModal").modal("hide");
        reloadTable();
        // Show error alert
        swal({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
        });

        // Log error for debugging
        console.error(xhr.responseText);
      },
    });
  });

  $("#retrevePDF").click(function () {
    var request_id = $("#request_id").val();
    var certificate_type = $("#certiticate_type").val();

    $.ajax({
        url: "includes/documentsoperation.php",
        type: "POST",
        dataType: "json",
        data: {
          OPERATION: "FETCH_FILENAME",
          request_id: request_id
        },
        success: function (response) {
          var data = response[0];
          var file = data.pdffile;
          
          switch(certificate_type){
            case "Business Permits":
              var filename = "documents/business_permits/"+file;
            break;
            case "Certificate of Residency":
              var filename = "documents/certificate_of_residency/"+file;
            break;
            case "Certificate of Good Moral":
              var filename = "documents/certificate_of_good_moral/"+file;
            break;  
            case "Certificate of Indigency":
              var filename = "documents/certificate_of_indigency/"+file;
            break;
            default:
              var filename = "unknown file name";
          }

          // Show the modal
          console.log("Fetching file from:", filename); // Log the filename

          // Clear and set the new src for iframe
          $("#generatepdf").attr("src", ""); // Clear the previous source
          $("#generatepdf").attr("src", filename + "?t=" + new Date().getTime()); // Append timestamp
          $("#pdfModal").modal("show"); // Show the modal after setting the src
        },
        error: function (xhr, status, error) {
          console.error("Error generating PDF:", error);
        },
      });
  });

  //For populate the view resident from docu modal
  $(document).on("click", "#viewResidentfromDocu", function () {
    var residentid = $("#resident_id").val();
    $("#nav-home-tab").tab("show");

    $.ajax({
      url: "includes/fetchresidentdetails.php",
      type: "POST",
      data: { id: residentid },
      dataType: "JSON",
      success: function (response) {
        var imagepath = "includes/img/resident_img/" + response.img_filename;

        $("#viewresident_id").val(response.resident_id);
        $("#fname").val(response.first_name);
        $("#mname").val(response.middle_name);
        $("#lname").val(response.last_name);
        $("#house_no").val(response.house_num);
        $("#street").val(response.street);
        $("#subd").val(response.subdivision);
        $("#sex").val(response.sex);
        $("#marital_status").val(response.marital_status);
        $("#birth_date").val(response.birth_date);
        $("#birth_place").val(response.birth_place);
        $("#cp_number").val(response.cellphone_num);
        $("#is_a_voter").val(response.is_a_voter);
        $("#rsince").val(response.resident_since);
        $("#viewimagePreview").prop("src", imagepath);
        $("#backbtntodocu").prop("hidden", false);

        //For counting certificates requested
        $.ajax({
          type: "post",
          url: "includes/residentoperation.php",
          data: { operation: "COUNT_RES_CERT", resident_id: response.resident_id },
          dataType: "json",
          success: function (response) {
            console.log(response);

            $("#noofcerts").text(response);
          },
        });
      },
      error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      },
    });
  });

  //For the back button on the resident view modal
  $(document).on("click", "#backbtntodocu", function () {
    $(this).prop("hidden", true);

    $("#ViewResidentModal").modal("hide");
    $("#DocumentDetailsModal").modal("show");
  });

  //AJAX request for the clearance tab and table of the modal
  $(document).on("click", "#nav-clearance-tab", function () {
    var resident_id = $("#resident_id").val();

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

  //For the function of the revoke or restore button
  $("#revokebtn").click(function (e) {
    e.preventDefault();

    var request_id = $("#request_id").val();
    var status = $("#status").val();

    if (status == "2") {
      swal({
        title: "Are you sure?",
        text: "Restoring the certificate will continue it's validity.",
        icon: "warning",
        buttons: ["Cancel", "Yes"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "includes/documentsoperation.php",
            type: "POST",
            data: { OPERATION: "RESTORE", request_id: request_id },
            success: function () {
              swal("The certificate has been RESTORED!", {
                icon: "success",
              });

              $("#DocumentDetailsModal").modal("hide");
              reloadTable();
            },
            error: function (xhr, status, error) {
              swal("Error!", "Failed to restore the entry.", "error");
            },
          });
        } else {
          swal("The certificate is not RESTORED!.");
        }
      });
    } else {
      console.log(request_id, status);
      swal({
        title: "Are you sure?",
        text: "Revoking the certificate VOIDS a certificate validity",
        icon: "warning",
        buttons: ["Cancel", "Yes"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "includes/documentsoperation.php",
            type: "POST",
            data: { OPERATION: "REVOKE", request_id: request_id },
            success: function () {
              swal("The certificate has been REVOKED!", {
                icon: "success",
              });

              reloadTable();
              $("#DocumentDetailsModal").modal("hide");
            },
            error: function (xhr, status, error) {
              swal("Error!", "Failed to revoke the entry.", "error");
            },
          });
        } else {
          swal("The certificate is not revoked");
        }
      });
    }
  });

  //For the delete button
  $(document).on("click",'#deletebutton',function () {
    var request_id = $(this).data("request_id");
    console.log("Delete button has been click")
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this entry!",
      icon: "warning",
      buttons: ["Cancel", "Delete"],
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: "includes/documentsoperation.php",
          type: "POST",
          data: { request_id: request_id, OPERATION: "DELETE_ENTRY" },
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

  $(document).on("click", "#undodeletebutton", function (event) {
    event.preventDefault();

    var request_id = $(this).data("request_id");
    console.log(request_id);
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
          url: "includes/documentsoperation.php",
          type: "POST",
          data: { request_id: request_id, OPERATION: "UNDO_DELETE" },
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

  $('#ScanqrModal').on('shown.bs.modal', function () {
    console.log('The modal is now fully shown.');
    let barcodeBuffer = '';
    let timeout = null;

    $("#scannedcode").focus();

    $("#scannedcode").on('keydown', function(e) {
        // If Enter key is pressed, handle barcode input
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent default form submission or behavior
            $('#searchbox').val(barcodeBuffer); 
            $('#ScanqrModal').modal('hide');
            $(this).val("");
            fetchResults(barcodeBuffer);
            barcodeBuffer = ''; // Clear the buffer after processing



        } else {
            // Append characters to the buffer, ignoring shift, control, etc.
            if (e.key.length === 1) { // Check if it's a single character key
                barcodeBuffer += e.key;
            }
        }

        // Clear the timeout for the barcode buffer
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            barcodeBuffer = ''; // Clear buffer after timeout
        }, 200);
    });

    const $input = $('#scannedcode');

    // Keep the input focused when clicked away
    $(document).on('click', function(e) {
        // Check if the click target is not the input
        if (!$(e.target).is($input)) {
            // Re-focus the input
            $input.focus();
        }
    });

    // Focus on the scanned code input when the window is focused or clicked
    $(window).on('focus click', function() {
        $('#scannedcode').focus(); // Changed to the correct ID
    });
  });


});

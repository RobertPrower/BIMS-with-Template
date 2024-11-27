$(document).ready(function () {

  reloadTable();

  //For the Bootstrap Tooltips to load
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

  //For the tooltip to be triggered manually via Jquery
  $('#editopenCamera').tooltip({
    trigger: 'manual' 
  });
  
  $('input[name="birth_date"]').datepicker({
    format: 'yyyy-mm-dd',  
    autoclose: true,       
  });

  // If required, re-initialize datepicker when modal is opened
  $('.AddNonResidentModal').on('shown.bs.modal', function () {
    $('#birth_date').datepicker('update');
  });

  //To Reload the page
  function reloadTable(page) {
    $.ajax({
      url: "includes/nonresidentoperation.php",
      type: "POST",
      data: {pageno: page, operation: "FETCH_TABLE"},
      dataType: "HTML",
      success: function (data) {
        $("#NonResidentTable tbody").html(data);
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
      url: "includes/nonresidentoperation.php",
      type: "POST",
      data: {pageno: page, operation: "SHOW_DELETED"},
      dataType: "HTML",
      success: function (data) {
        $("#NonResidentTable tbody").html(data);
        updateDeletedPaginationControls(page);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      },
    });
  }

  //Update the pagination controls every operation
  function updatePaginationControls(currentPage){
    $.ajax({
      url: "includes/nonresidentoperation.php",
      type: "POST",
      data: {pageno: currentPage, operation: "PAGINATION"},
      dataType: "HTML",
      success: function (data) {
        $(".main-pagination").html(data);
                
        //Prevent the pagination from showing when the entries is less than 10
        var noofpageitems = $(".pagination-control").length;
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
        url: "includes/nonresidentoperation.php",
        type: "POST",
        data: { search: query, pageno: currentPage, operation: "SEARCH_PAGINATION" },
        success: function (data) {
            $(".pagination").html(data);
            //Prevent the pagination from showing when the entries is less than 10
            var noofpageitems = $(".pagination-control").length;
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
        url:"includes/nonresidentoperation.php",
        type: "POST",
        data: {pageno: currentPage, operation: "PAGINATION_FOR_DEL_REC"},
        success: function (data){
          $(".main-pagination").html(data);
          //Prevent the pagination from showing when the entries is less than 10
          var noofpageitems = $(".pagination-control").length;
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
        }
      });
  }

  //Function to search for entries
  function fetchResults(query, page = 1) {
    if ($("#showdeletedentries").is(":checked")) {
        console.log("Deleted Entries switch has been on");
        $.ajax({
            url: "includes/nonresidentoperation.php",
            type: "POST",
            data: { search: query, page: page, operation: "DELETED_SEARCH" },
            success: function (data) {
                $("#NonResidentTableBody").html(data);
                updateDeletedPaginationControls(page);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching search results:", error);
            }
        });
    } else {
        console.log("Deleted Entries switch has been off");
        $.ajax({
            url: "includes/nonresidentoperation.php",
            type: "POST",
            data: { search: query, page: page, operation: "SEARCH" },
            success: function (data) {
                $("#NonResidentTableBody").html(data);
                updateSearchPaginationControls(query, page);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching search results:", error);
            }
        });
    }
  }

  function count_nonres_cert(nresident_id){
      $.ajax({
        type: "post",
        url: "includes/nonresidentoperation.php",
        data: { operation: "COUNT_RES_CERT", nresident_id: nresident_id },
        dataType: "json",
        success: function (response) {
          console.log(response);

          $("#noofcerts").text(response);
        },
      });
  }

  function check_hit(nresident_id){
    $.ajax({
      type: "post",
      url: "includes/nonresidentoperation.php",
      data: { operation: "CHECK_HIT", nresident_id: nresident_id },
      dataType: "json",
      success: function (response) {
        console.log(response);

        if(response.success == "clear"){
          $("#with_hit").text("None");
          $("#blotter_badge").removeClass("text-bg-danger");
          $("#blotter_badge").removeClass("text-bg-success");
          $("#blotter_badge").addClass("text-bg-success");

        }else if(response.success == "hit"){
          $("#with_hit").text("With Hit");
          $("#blotter_badge").removeClass("text-bg-danger") 
          $("#blotter_badge").removeClass("text-bg-success");
          $("#blotter_badge").addClass("text-bg-danger");

        }else{
          alert("Server replys failed ")
        }
      }, error: function (xhr, status, error) {
        console.error("Error fetching data:", error);
      },
    });

  }

  //For the search box
  $('#searchbox').on("keyup", function(){
    let query = $(this).val();

    if (query.length >2){

      //Fetch the results by the fetchResults function above
      fetchResults(query);

    }else{
      if ($("#showdeletedentries").is(":checked")){  
        //If query is less than 2 character just reload the table
        reloadDeletedEntries(1);
      } else{
        reloadTable();
      }
    }
  });

  //Show the deleted records when the switch is flipped
  $("#showdeletedentries").click(function() {
    let query = $('#searchbox').val();  // Get the current search query
    if ($(this).is(":checked")) {
        console.log("Checkbox ON - Show Deleted Entries");
        reloadDeletedEntries(1);  // Reload deleted entries
    } else {
        console.log("Checkbox OFF - Hide Deleted Entries");
        reloadTable(1);  // Reload all entries
    }
});

  //For pagination control function and make it dynamic
  $(document).on('click', '.pagination-control', function(e) {
    e.preventDefault();
    
    var page = $(this).data('page');     
    console.log('Page:', page);

    $('.main-pagination .pagination-control').removeClass('active');
    $(this).parent().addClass('active');
    
    if ($("#showdeletedentries").is(":checked")){
      reloadDeletedEntries(page);
      updateDeletedPaginationControls(page)
    }else{
      reloadTable(page);
      updatePaginationControls(page)
    }
  });

  //For Adding Resident
  $("#AddNonResidentModalForm").submit(function (event) {
    event.preventDefault();

    var captureImageData = $('#imagePreview').attr("src");
    console.log(captureImageData);

    var formData = new FormData(this);
    formData.append("operation", "ADD");
    formData.append("captureImageData", captureImageData);

    var page = $(this).data('pageno');
    console.log(page);

    $.ajax({
        url: "includes/nonresidentoperation.php",
        type: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        success: function (response) {
            // Handle success response
            console.log("Data saved successfully:", response);

            if (response.success === true) {
                $("#AddNonResidentModal").modal("hide");
                Swal.fire({
                    title: "Add Entry",
                    text: "Entry Added Successfully!",
                    icon: "success",
                    button: "Close",
                });
                reloadTable(page);
            }else if(response.success === "entry_match") {

                $("#AddNonResidentModal").modal("hide");

                Swal.fire({
                  title: "Duplicate entry detected.",
                  text: "Do you want to view the duplicate record?",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Yes"
                }).then((result) => {
                  if (result.isConfirmed) {
                    console.log(response.data.nresident_id)
                      $("#ViewNonResidentModal").modal("show");

                      var correctimagepath = "includes/img/non_resident_img/" + response.data.img_filename 

                      $("#viewimagePreview").attr("src", correctimagepath);
                      console.log("Existing Record View Pic has been loaded");
                      console.log(correctimagepath);

                      $('#nav-home-tab').tab('show');

                      // Populate the fields in the modal
                      $('#ViewNonResidentModal input[name="nresident_id"]').val(response.data.nresident_id);
                      $('#ViewNonResidentModal input[name="fname"]').val(response.data.first_name);
                      $('#ViewNonResidentModal input[name="mname"]').val(response.data.middle_name);
                      $('#ViewNonResidentModal input[name="lname"]').val(response.data.last_name);
                      $('#ViewNonResidentModal input[name="suffix"]').val(response.data.suffix);
                      $('#ViewNonResidentModal input[name="house_no"]').val(response.data.house_num);
                      $('#ViewNonResidentModal input[name="street"]').val(response.data.street);
                      $('#ViewNonResidentModal input[name="subd"]').val(response.data.subdivision);
                      $('#ViewNonResidentModal input[name="district_brgy"]').val(response.data.district_brgy);
                      $('#ViewNonResidentModal input[name="city"]').val(response.data.city);
                      $('#ViewNonResidentModal input[name="province"]').val(response.data.province);
                      $('#ViewNonResidentModal input[name="zipcode"]').val(response.data.zipcode);
                      $('#ViewNonResidentModal select[name="sex"]').val(response.data.sex);
                      $('#ViewNonResidentModal select[name="marital_status"]').val(response.data.marital_status);
                      $('#ViewNonResidentModal input[name="birth_date"]').val(response.data.birth_date);
                      $('#ViewNonResidentModal input[name="birth_place"]').val(response.data.birth_place);
                      $('#ViewNonResidentModal input[name="cellphone_number"]').val(response.data.cellphone_num);

                      count_nonres_cert(response.data.nresident_id);
                      check_hit(response.data.nresident_id);
                      
                  } else if (response.success == false){
                    $("#AddNonResidentModal").modal("hide");
                    console.log("Server error: "+response.message)
                    Swal.fire({
                      icon: "error",
                      title: "Error",
                      text: "Server Replys Failed! Error: "+ response.message,
                    });
                } 
                });
               
            } // End of if
        },
        error: function (xhr, status, error) {
            // Handle error response
            console.error("Error saving data:", error);
            $("#AddNonResidentModal").modal("hide");
            Swal.fire({
                icon: "error",
                title: "AJAX error",
                text: "Something went wrong!",
            });
        },
    });
});


  //For Recovering Resident entries
    $("#NonResidentTable").on("click", "#undodeletebutton", function (event) {
      event.preventDefault();

      var nresidentId = $(this).data("nresident_id");
      console.log(nresidentId);
      var page = $(this).data("page");
      Swal.fire({
        title: "Are you sure?",
        text: "You are about to recover the entry.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "includes/nonresidentoperation.php",
            type: "POST",
            data: { nresident_id: nresidentId, operation: "UNDO_DELETE"},
            dataType: "json",
            success: function (response) {
              if(response.success == true){
                console.log("Data recovered successfully:", response);
                Swal.fire({
                  title: "Record Recovered!",
                  text: "Entry has been recovered successfully.",
                  icon: "success"
                });
                reloadDeletedEntries(page);
              }else{
                Swal.fire({
                  title: "Server replies failed",
                  text: response.message,
                  icon: "error"
                });              
              }

            },
            error: function (xhr, status, error) {
              console.error("Error deleting data:", error);
              Swal.fire({
                icon: "error",
                title: "AJAX error",
                text: "Something went wrong!",
            });
            },
          });
        
        }
      });

    });

    $("#NonResidentTable").on("click", "#deletebutton", function (event) {
      event.preventDefault();

      var currentSearch = $("#searchbox").val();
      var nresidentId = $(this).data("nresident_id");
      console.log(nresidentId);
      var page = $(this).data("page");

      Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete an entry.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "includes/nonresidentoperation.php",
            type: "POST",
            data: { nresident_id: nresidentId, operation: "DELETE"},
            dataType: "json",
            success: function (response) {
              console.log("Data deleted successfully:", response);

              if(response.success){
                  Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                  });             
                  
                  //If the modal was fired from a search make sure still the same page
                  if(currentSearch){
                    fetchResults(currentSearch, page)
                  }else{ //If not just reload the page
                    reloadTable(page);
                  }
              }else{
                  Swal.fire({
                    title: "The record was not Deleted!",
                    text: "Server replies failed",
                    icon: "error"
                  });
              }
            },
            error: function (xhr, status, error) {
              console.error("Error deleting data:", error);
              Swal.fire({
                title: "AJAX error",
                text: "The record was not deleted!",
                icon: "error"
              });            
            },
          });
          
        }
      });
    });

  //For Editing Resident Entry
  $("#EditNonResidentModalForm").submit(function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();
    console.log("Edit modal has been triggered");

    // Collect form data using FormData
    var formData = new FormData(this);
    var currentSearch = $("#searchbox").val();

    //For the PHP operation IF statement
    formData.append("operation","EDIT");

    const textbox = document.getElementById('pageno');
    const page = textbox.value;

    var capturecameracheck = $("#editopenCamera").text();
    console.log(capturecameracheck);


    console.log("Page Number: " + page);


    switch(capturecameracheck){
      case 'Capture' :
        $("#editopenCamera").tooltip('toggle');

        if ($('.editopenCamera').hasClass('show')) {
          $('.editopenCamera').addClass('tooltip-red');
        } else {
          $('.editopenCamera').removeClass('tooltip-red');
        }
      break;
      default:

         // Send AJAX request
         $.ajax({
          url: "includes/nonresidentoperation.php",
          type: "POST",
          data: formData,
          dataType: "json",
          contentType: false,
          processData: false,
          success: function (response) {
            // Handle success response
            console.log("Data saved successfully:", response);

            if (response.success) {
                $("#EditNonResidentModal").modal("hide");
                Swal.fire({
                  title: "Record has been edited.",
                  text: "Your record has been edited!",
                  icon: "success"
                });
                //If the modal was fired from a search make sure still the same page
                if(currentSearch){
                  fetchResults(currentSearch, page)
                }else{ //If not just reload the page
                  reloadTable(page);
                }
            } else {
                $("#EditNonResidentModal").modal("hide");
                Swal.fire({
                  icon: "error",
                  title: "Server replies failed",
                  text: response.message,
                });
            } // END of if
          },
          error: function (xhr, status, error) {
            console.error("Error saving data:", error);

            $("#EditNonResidentModal").modal("hide");
            Swal.fire({
              icon: "error",
              title: "AJAX error",
              text: "Something went wrong!",
            });
          },
        });
      
    }
  });

  //For reseting the Add Non Resident Form everytime you click the close or X button
  $(".btnClose, #clearButton").on("click", function(){
    console.log("Close Button is click")
    var form = document.getElementById('AddNonResidentModalForm');
    form.reset();

    var imagePreview = document.getElementById('imagePreview');
    imagePreview.src = 'includes/img/blank-profile.webp';

    if($('imagefile').prop('disabled', true)){
      console.log("The File upload has been reset!")
      $('#imagefile').prop('disabled',false)
    }else{
      alert('This block of code should not be executed!!')
    }
  })

  // //For populating the View and Edit Modal Combined into one event
  $(document).on("click", ".editNonResidentButton, .viewNonResidentButton", function (event) {
    event.preventDefault();

    console.log("View or Edit Modal has been triggered");

    // Get common data attributes
    var nresident_id = $(this).data("id");
    var first_name = $(this).data("first-name");
    var middle_name = $(this).data("middle-name");
    var last_name = $(this).data("last-name");
    var suffix = $(this).data("suffix");
    var house_no = $(this).data("house-no");
    var street_name = $(this).data("street-name");
    var subdivision = $(this).data("subdivision");
    var district_brgy = $(this).data("district-brgy");
    var city = $(this).data("city");
    var province = $(this).data("province");
    var zipcode = $(this).data("zipcode");
    var sex = $(this).data("sex");
    var marital_status = $(this).data("marital_status");
    var birth_date = $(this).data("birth-date");
    var birthplace = $(this).data("birth-place");
    var phone_number = $(this).data("contact-num");

    console.log(nresident_id);

    // Determine if this is for 'edit' or 'view'
    var isEdit = $(this).hasClass("editNonResidentButton");

    // Modal ID based on the button clicked (Edit or View)
    var modalId = isEdit ? "#EditNonResidentModal" : "#ViewNonResidentModal";

    // Populate the common fields in the modal
    $(modalId + ' input[id="viewnonresident_id"]').val(nresident_id);
    $(modalId + ' input[name="fname"]').val(first_name);
    $(modalId + ' input[name="mname"]').val(middle_name);
    $(modalId + ' input[name="lname"]').val(last_name);
    $(modalId + ' input[name="suffix"]').val(suffix);
    $(modalId + ' input[name="house_no"]').val(house_no);
    $(modalId + ' input[name="street"]').val(street_name);
    $(modalId + ' input[name="subd"]').val(subdivision);
    $(modalId + ' input[name="district_brgy"]').val(district_brgy);
    $(modalId + ' input[name="city"]').val(city);
    $(modalId + ' input[name="province"]').val(province);
    $(modalId + ' input[name="zipcode"]').val(zipcode);
    $(modalId + ' select[name="sex"]').val(sex);
    $(modalId + ' select[name="marital_status"]').val(marital_status);
    $(modalId + ' input[name="birth_date"]').val(birth_date);
    $(modalId + ' input[name="birth_place"]').val(birthplace);
    $(modalId + ' input[name="cellphone_number"]').val(phone_number);

    // Specific logic for editing
    if (isEdit) {
        var page = $(this).data('pageno');
        $(modalId + ' input[id="nresident_id"]').val(nresident_id);
        $(modalId + ' input[name="pageno"]').val(page);
        $(modalId).modal("show"); // Show the Edit modal

    // Specific logic for viewing
    } else {
      // Make the profile tab the default tab when the view button is clicked
      $('#nav-home-tab').tab('show');
      $(modalId).modal("show"); // Show the View modal

      check_hit(nresident_id);
      count_nonres_cert(nresident_id);

    }

    //To fetch the image from the database
    var clickedButton = $(this);
    $.ajax({
      url: "includes/nonresidentoperation.php",
      type: "POST",
      data: { id: nresident_id, operation:"GET_IMAGE" },
      dataType: "json",
      success: function (response) {
        // Variables to collect the response of the server
        var imageFilename = response.imageData;
        var match = imageFilename.match("capture");
        var correctimagepath = "includes/img/non_resident_img/" + imageFilename;
        
        var isEdit = clickedButton.hasClass("editNonResidentButton");
        console.log(isEdit);

        if(isEdit){
          // Display image
          $("#editimagePreview").attr("src", correctimagepath);
          console.log("Edit picture has been load");
          console.log(correctimagepath);

        }else{
          // Display image
          $("#viewimagePreview").attr("src", correctimagepath);
          console.log("View image has been loaded");
        }

        
      },
      error: function (xhr, status, error) {
        console.error("Error fetching metadata:", error);
      },
    });

  });
 

});


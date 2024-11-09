$(document).ready(function () {

  reloadTable();

  //To Reload the page
  function reloadTable(page) {
    $.ajax({
      url: "includes/blottersoperation.php",
      type: "POST",
      data: { pageno: page, operation: "FETCH_MAIN_TABLE"},
      dataType: "HTML",
      success: function (data) {
        $("#BlotterTable tbody").html(data);
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
     url: "includes/blottersoperation.php",
      type: "POST",
      data: { pageno: page, operation: "SHOW_DELETED" },
      dataType: "HTML",
      success: function (data) {
        $("#BlotterTable tbody").html(data);
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
     url: "includes/blottersoperation.php",
      type: "POST",
      data: { pageno: currentPage, operation: "PAGINATION" },
      dataType: "HTML",
      success: function (data) {
        $(".main-pagination").html(data);
        var noofpageitems = $(".pagination-control").length;
        console.log(noofpageitems);
        //Prevent the pagination from showing when the entries is less than 10
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
     url: "includes/blottersoperation.php",
      type: "POST",
      data: {
        search: query,
        pageno: currentPage,
        operation: "SEARCH_PAGINATION",
      },
      success: function (data) {
        $(".main-pagination").html(data);

        //Prevent the pagination from showing when the entries is less than 10 entries
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
  function updateDeletedPaginationControls(currentPage, query) {
    $.ajax({
     url: "includes/blottersoperation.php",
      type: "POST",
      data: { pageno: currentPage, search: query, operation: "PAGINATION_FOR_DEL_REC" },
      success: function (data) {
        $(".pagination").html(data);
        //Prevent the pagination from showing when the entries is less than 10 entries
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

  //Function to search for entries
  function fetchResults(query, page = 1) {
    if ($("#showdeletedentries").is(":checked")) {
      console.log("Deleted Entries switch has been on");
      $.ajax({
       url: "includes/blottersoperation.php",
        type: "POST",
        data: { search: query, page: page, operation: "DELETED_SEARCH" },
        success: function (data) {
          $("#BlotterTableBody").html(data);
          updateDeletedPaginationControls(page, query);
        },
        error: function (xhr, status, error) {
          console.error("Error fetching search results:", error);
        },
      });
    } else {
      console.log("Deleted Entries switch has been off");
      $.ajax({
       url: "includes/blottersoperation.php",
        type: "POST",
        data: { search: query, page: page, operation: "SEARCH" },
        success: function (data) {
          $("#BlotterTableBody").html(data);
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

    if (query.length > 0) {
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
  $(document).on("click", ".pagination-control", function (e) {
    e.preventDefault();

    var page = $(this).data("page");
    console.log("Page:", page);

    $(".main-pagination .pagination-control").removeClass("active");
    $(this).parent().addClass("active");

    if ($("#showdeletedentries").is(":checked")) {
      reloadDeletedEntries(page);
      updateDeletedPaginationControls(page);
    } else {
      reloadTable(page);
      updatePaginationControls(page);
    }
  });

  $(document).on("click",".viewbtn, .editbtn",function(e){
    e.preventDefault();
    var operation = $(this).data('whatoperation');

    var whatmodal = (operation == "view")? '#ViewBlotterModal': '#EditBlotterModal';
    $('.complainant_respondent_tab').tab('show');

    var complainant_first_name = $(this).data('complainant_first_name');
    var complainant_middle_name = $(this).data('complainant_middle_name');
    var complainant_last_name = $(this).data('complainant_last_name');
    var complainant_suffix = $(this).data('complainant_suffix');

    var respondent_first_name = $(this).data('respondent_first_name');
    var respondent_middle_name = $(this).data('respondent_middle_name');
    var respondent_last_name = $(this).data('respondent_last_name');
    var respondent_suffix = $(this).data('respondent_suffix');

    var complainant_address = $(this).data('complainant_address');
    var respondent_address = $(this).data('respondent_address');
    var complainant_filename = $(this).data('complainant_filename');
    var respondent_filename = $(this).data('respondent_filename');
    var blotter_id = $(this).data('blotter_id');
    var complainant_no = $(this).data('complainant_no');
    var respondent_no = $(this).data('respondent_no');
    var complainant_status = $(this).data('complainant_status');
    var respondent_status = $(this).data('respondent_status');


    $(whatmodal+' [id="fname"]').val(complainant_first_name);
    $(whatmodal+' [id="mname"]').val(complainant_middle_name); 
    $(whatmodal+' [id="lname"]').val(complainant_last_name);
    $(whatmodal+' [id="suffix"]').val(complainant_suffix);
    $(whatmodal+' [id="address"]').val(complainant_address);

    $(whatmodal + " #fname_res").val(respondent_first_name);
    $(whatmodal + ' #mname_res').val(respondent_middle_name);
    $(whatmodal + ' #lname_res').val(respondent_last_name);
    $(whatmodal + ' #suffix_res').val(respondent_suffix);
    $(whatmodal + ' [id="address_res"]').val(respondent_address);

    $(whatmodal+' [id="blotter_id"]').val(blotter_id);
    $(whatmodal+' [id="complainant_id"]').val(complainant_no);
    $(whatmodal+' [id="respondent_id"]').val(respondent_no);
    $(whatmodal+' [id="respondent_status"]').val(respondent_status);
    $(whatmodal+' [id="complainant_status"').val(complainant_status);
    $(whatmodal+' [id="respondent_status"]').val(respondent_status);
    $(whatmodal+' [id="display_complainant_status"]').text(complainant_status);
    $(whatmodal+' [id="display_respondent_status"]').text(respondent_status);

    $(whatmodal+' .complainantbtn').attr('data-id',complainant_no);
    $(whatmodal+' .respondentbtn').attr('data-id',respondent_no);
    $(whatmodal+' .respondentbtn').attr('data-status',respondent_status);
    $(whatmodal+' .complainantbtn').attr('data-status',complainant_status);

    if (whatmodal == "#EditBlotterModal") {
      $('#edit_main_complainant').attr('data-id',complainant_no);
      $('#edit_main_respondent').attr('data-id',respondent_no);
     
    }

    if(complainant_status == "Resident"){
      $(whatmodal+' [id="ComplainantImg"]').attr("src", "includes/img/resident_img/"+complainant_filename);
    }else{
      $(whatmodal+' [id="ComplainantImg"]').attr("src", "includes/img/non_resident_img/"+complainant_filename);
    }

    if(respondent_status == "Resident"){
      $(whatmodal+' [id="RespondentImg"]').attr("src", "includes/img/resident_img/"+respondent_filename);
    }else{
      $(whatmodal+' [id="RespondentImg"]').attr("src", "includes/img/non_resident_img/"+respondent_filename);
    }

  })

  $(".other_complainants_tab").click(function (e) { 
    var whatmodal = $("#ViewBlotterModal").hasClass('show')? "#ViewBlotterModal": "#EditBlotterModal";
    console.log(whatmodal)
    e.preventDefault();
    var blotter_id = $(whatmodal + ' [id="blotter_id"]').val();
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_OTHER_COMPLAINANTS_MODAL", blotter_id, blotter_id},
      dataType: "HTML",
      success: function (response) {

        $(whatmodal + ' [id="Complainant"]').html(response);
        
      },error: function(xhr, status, error) {
        console.error('Error fetching other complainants details:', error);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!"
        });
      }
    });
    
  });


  $(".other_respondents_tab").click(function (e) { 
    var whatmodal = $("#ViewBlotterModal").hasClass('show')? "#ViewBlotterModal": "#EditBlotterModal";
    var blotter_id = $(whatmodal + ' [id="blotter_id"]').val();
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_OTHER_RESPONDENTS_MODAL", blotter_id: blotter_id},
      dataType: "HTML",
      success: function (response) {

        $(whatmodal + ' [id="Respondent"]').html(response);
        
      },error: function(xhr, status, error) {
        console.error('Error fetching other respondents details:', error);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!"
        });
      }
    });
    
  });

  $(document).on("click",".case_details_tab",function (e) { 
    e.preventDefault();
    var whatmodal = $("#ViewBlotterModal").hasClass('show')? "#ViewBlotterModal": "#EditBlotterModal";
    var blotter_id = $(whatmodal + ' [id="blotter_id"]').val();
    console.log("case details has been press")
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_OTHER_CASE_DETAILS_MODAL", blotter_id: blotter_id},
      dataType: "JSON",
      success: function (response) {
        var data = response.data[0]

        if(response.success == true){
          $(whatmodal + ' [id="schedule_date"]').val(data.mediation_date);
          $(whatmodal + ' [id="schedule_starttime"]').val(data.mediation_starttime);
          $(whatmodal + ' [id="schedule_endtime"]').val(data.mediation_endtime);
          $(whatmodal + ' [id="incident_date"]').val(data.incident_dt);
          $(whatmodal + ' [id="incident_location"]').val(data.location_of_incident);
          $(whatmodal + ' [id="blotter_type"]').val(data.blotter_type);
          $(whatmodal + ' [id="incident_desc"]').val(data.desc_incident);
          $(whatmodal + ' [id="case_context"]').val(data.statemnt);
          $(whatmodal + ' [id="mediator"]').val(data.mediator_name);
          
          if(!data.date_of_resolution == null){

            $("#resolution_date").val(data.date_of_resolution);

          }else{
            $("#resolution_date").val("N/A");

          }
        }else{
          console.log("Server Error: "+response.message)
        }

      },error: function(xhr, status, error) {
        console.error('Error fetching case details:', error);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!"
        });
      }
    });
    
  });

  $(document).on("click",".evidence_tab",function () {
    var whatmodal = $("#ViewBlotterModal").hasClass('show')? "#ViewBlotterModal": "#EditBlotterModal";
    var blotter_id = $(whatmodal + ' [id="blotter_id"]').val();

    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_MODAL_IMG", blotter_id: blotter_id},
      dataType: "JSON",
      success: function (response) {
        var data = response.data[0];
        if(response.success == true){
          $(whatmodal + ' [id="evidence_img"]').attr("src","includes/img/blotter_evidence/"+data.blotter_evidencefile);
          $(whatmodal + ' [id="blotter_img"]').attr("src","includes/img/blotter_context/"+data.blotter_contextfile);
        }else{
          console.log("Server replied failed: "+responde.message)
        }
      },error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      }
    });
    
  });


  $(document).on("click", "#viewResorNonResfromBlot", function () {
    var residentid = $(this).data('id');
    var resident_status = $(this).data('status');

    if(resident_status == "Resident"){

      $("#DocumentDetailsModal, #ViewBlotterModal").modal('hide');
      $("#ViewResidentModal").modal('show');
      $("#nav-home-tab").tab("show");


      $.ajax({
        url: "includes/modaloperation.php",
        type: "POST",
        data: { resident_id: residentid, operation: "FETCH-RESIDENT-DETAILS" },
        dataType: "JSON",
        success: function (data) {
          var response = data[0];
          var imagepath = "includes/img/resident_img/" + response.img_filename;

          $('#ViewResidentModal [id="viewresident_id"]').val(response.resident_id);
          $('#ViewResidentModal [id="fname"]').val(response.first_name);
          $('#ViewResidentModal [id="mname"]').val(response.middle_name);
          $('#ViewResidentModal [id="lname"]').val(response.last_name);
          $('#ViewResidentModal [id="suffix"]').val(response.suffix);
          $('#ViewResidentModal [id="house_no"]').val(response.house_num);
          $('#ViewResidentModal [id="street"]').val(response.street);
          $('#ViewResidentModal [id="subd"]').val(response.subdivision);
          $('#ViewResidentModal [id="sex"]').val(response.sex);
          $('#ViewResidentModal [id="marital_status]"').val(response.marital_status);
          $('#ViewResidentModal [id="birth_date"]').val(response.birth_date);
          $('#ViewResidentModal [id="birth_place"]').val(response.birth_place);
          $('#ViewResidentModal [id="cp_number"]').val(response.cellphone_num);
          $('#ViewResidentModal [id="is_a_voter"]').val(response.is_a_voter);
          $('#ViewResidentModal [id="rsince"]').val(response.resident_since);
          $('#ViewResidentModal [id="viewimagePreview"]').prop("src", imagepath);
          $('#ViewResidentModal [id="backbtntodocu"]').prop("hidden", false);

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
    }else if(resident_status == "Non-Resident"){

      $("#DocumentDetailsModal,#ViewBlotterModal").modal('hide');
      $("#ViewNonResidentModal").modal('show');
      $("#ViewNonResidentModal [id='nav-home-tab']").tab("show");

      $.ajax({
        url: "includes/modaloperation.php",
        type: "POST",
        data: { nresident_id: residentid, operation: "FETCH-NON-RESIDENT-DETAILS" },
        dataType: "JSON",
        success: function (data) {

          var response = data[0];
          var imagepath = "includes/img/non_resident_img/" + response.img_filename;

          $("#ViewNonResidentModal [id='viewnonresident_id']").val(response.nresident_id);
          $("#ViewNonResidentModal [id='fname']").val(response.first_name);
          $("#ViewNonResidentModal [id='mname']").val(response.middle_name);
          $("#ViewNonResidentModal [id='lname']").val(response.last_name);
          $("#ViewNonResidentModal [id='house_no']").val(response.house_num);
          $("#ViewNonResidentModal [id='street']").val(response.street);
          $("#ViewNonResidentModal [id='subd']").val(response.subdivision);
          $("#ViewNonResidentModal [id='district_brgy']").val(response.district_brgy);
          $("#city").val(response.city);
          $("#province").val(response.province);
          $("#zipcode").val(response.zipcode);
          $("#ViewNonResidentModal [id='sex']").val(response.sex);
          $("#ViewNonResidentModal [id='marital_status']").val(response.marital_status);
          $("#ViewNonResidentModal [id='birth_date']").val(response.birth_date);
          $("#ViewNonResidentModal [id='birth_place']").val(response.birth_place);
          $("#ViewNonResidentModal [id='cp_number']").val(response.cellphone_num);
          $("#ViewNonResidentModal [id='is_a_voter']").val(response.is_a_voter);
          $("#ViewNonResidentModal [id='rsince']").val(response.resident_since);
          $("#ViewNonResidentModal [id='cellphone_number']").val(response.cellphone_num);
          $("#ViewNonResidentModal #viewimagePreview").prop("src", imagepath);
          $("#nrbackbtntodocu").prop("hidden", false);

          console.log(response.nresident_id);

          //For counting certificates requested
          $.ajax({
            type: "post",
            url: "includes/nonresidentoperation.php",
            data: { operation: "COUNT_RES_CERT", nresident_id: response.nresident_id },
            dataType: "json",
            success: function (response) {
              
              console.log(response[0]);

              $("#ViewNonResidentModal [id='noofcerts']").text(response[0]);
            },
          });
        },
        error: function (xhr, status, error) {
          console.error("Error fetching table data:", error);
        },
      });
    }
  });
  
  $(document).on("click", ".backbtntodocu", function () {
    $(this).prop("hidden", true);

    $("#ViewResidentModal, #ViewNonResidentModal").modal("hide");
    $("#DocumentDetailsModal, #ViewBlotterModal").modal("show");
  });
      // Initialize DataTable when the modal is shown
    $('#selectresident').on('shown.bs.modal', function() {
      console.log("Select Resident has been loaded");
      if (!$.fn.DataTable.isDataTable('#ResidentTable')) {
          $('#ResidentTable').DataTable({
              ajax: {
                  url: 'includes/blottersoperation.php', 
                  dataSrc: '',
                  type: 'POST',
                  data: function(d) {
                      d.operation = "SELECT_RESIDENT_TABLELOAD"; 
                  }
              },
              columns: [
                  { data: 'resident_id', visible: false }, 
                  {
                      data: 'img_filename', 
                      render: function(data, type, row) {
                          return '<img src="includes/img/resident_img/' + data + '" alt="Image" class="img-thumbnail" style="width: 100px; height: 100px;object-fit: cover; max-width: 100%; max-height: 100%;">';
                      },
                      className: "text-center",
                      width: "15%"
                  },
                  { data: 'full_name', className: "text-center", width: "15%" },
                  { data: 'address', className: "text-center" },
                  { data: 'sex', className: "text-center" },
                  { data: 'marital_status', className: "text-center" },
                  { data: 'birth_date', className: "text-center", width:"12%" },
                  { data: 'cellphone_num', className: "text-center" },
                  {
                      data: 'is_a_voter',
                      render: function(data, type, row) {
                          return data == '1' 
                              ? '<img width="30" height="30" src="./img/svg/check-solid.png" style="color: #2cfc62"></img>' 
                              : '<img width="30" height="30" src="./img/svg/xmark-solid.svg" style="opacity: 40%"></img>';
                      },
                      className: "text-center"
                  }
              ],
              responsive: true,
              scrollX: true,
              lengthChange: false,
              autoWidth: false, 
              pageLength: 5      
              
          });
      }
    });

  // Event listener for row click
  $("#edit_main_respondent, #edit_main_complainant").click(function (e) { 
    e.preventDefault();
    var whatbutton = $(this).attr("whatbutton");
    var whatparty = $(this).data("whatparty");

    Swal.fire({
      title: "Choose which type of residency.",
      showDenyButton: true,
      showCancelButton: true,
      icon: "question",
      text: "Please select residency type you what to replace",
      confirmButtonText: "Resident",
      denyButtonText: `Non Resident`
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire("Saved!", "", "success");
      } else if (result.isDenied) {
        Swal.fire("Changes are not saved", "", "info");
      }
    });
      
    });


});


  

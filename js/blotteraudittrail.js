$(document).ready(function () {

    reloadTable(1);
    generatemediatorname();

    $("#start_date, #end_date").datepicker({
      format: "yyyy-mm-dd",
      autoclose: true,
    });

    function reloadTable(page) {
        $.ajax({
        url: "includes/blottersaudittrailoperation.php",
        type: "POST",
        data: { pageno: page, operation: "BLOTTER_FETCH_TABLE"  },
        dataType: "HTML",
        success: function (data) {
            $("#ResidentAuditTrailTable tbody").html(data);
            updatePaginationControls(page);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
        },
        });
    }

    function updatePaginationControls(currentPage) {
        $.ajax({
          url: "includes/blottersaudittrailoperation.php",
          type: "POST",
          data: { pageno: currentPage, operation: "FETCH_BLOTTER_PAGINATION" },
          dataType: "HTML",
          success: function (data) {
            $(".main-pagination").html(data);
          },
          error: function (xhr, status, error) {
            console.error("Error updating pagination data:", error);
          },
        });
      }

        //Function to search for entries
      function fetchResults(query, page) {

        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();

        if(!start_date && !end_date){
          $.ajax({
            url: "includes/blottersaudittrailoperation.php",
            type: "POST",
            data: { search: query, page: page, operation: "BLOTTER_AUDIT_SEARCH" },
            success: function (data) {
              $("#ResidentAuditTrailTable tbody").html(data);
              updateSearchPaginationControlswithFilters(query, page);
            },
            error: function (xhr, status, error) {
              console.error("Error fetching search results:", error);
            },
          });
        }else{
          $.ajax({
            url: "includes/blottersaudittrailoperation.php",
            type: "POST",
            data: { search: query, page: page, operation: "BLOTTER_AUDIT_SEARCH_WITH_FILTERS", start_date: start_date, end_date: end_date},
            success: function (data) {
              $("#ResidentAuditTrailTable tbody").html(data);
              updateSearchPaginationControlswithFilters(query, page, start_date, end_date);
            },
            error: function (xhr, status, error) {
              console.error("Error fetching search results:", error);
            },
          });

        }
    
      }

    
      //Update the pagination controls every search
      function updateSearchPaginationControls(query, currentPage) {
        $.ajax({
          url: "includes/blottersaudittrailoperation.php",
          type: "POST",
          data: {
            search: query,
            pageno: currentPage,
            operation: "SEARCH_PAGINATION",
          },
          success: function (data) {
            $(".main-pagination").html(data);
          },
          error: function (xhr, status, error) {
            console.error("Error updating search pagination data:", error);
          },
        });
    }

    function updateSearchPaginationControlswithFilters(query, currentPage, start_date, end_date) {

      if(start_date && end_date && (query.length !== 0)){
          var data = {
            search: query,
            pageno: currentPage,
            operation: "SEARCH_PAGINATION",
            start_date: start_date,
            end_date: end_date
          }

          console.log("Date filter with search has been triggered")
      }else if(start_date && end_date){
          var data = {
            pageno: currentPage,
            operation: "SEARCH_PAGINATION",
            start_date: start_date,
            end_date: end_date
          }
          console.log("Date filter without search has been triggered")

      }else if(query.length > 0){
          var data = {
            pageno: currentPage,
            operation: "SEARCH_PAGINATION",
            search: query
          }
          console.log("search only has been triggered")


      }else{
        alert("This should not run!");
      }

      $.ajax({
        url: "includes/blottersaudittrailoperation.php",
        type: "POST",
        data: data,
        success: function (data) {
          $(".main-pagination").html(data);         
        },
        error: function (xhr, status, error) {
          console.error("Error updating search pagination data:", error);
        },
      });
  }

      //For the search box
    $("#searchbox").on("keyup", function () {
      let query = $(this).val();

      if (query.length > 0) {

        fetchResults(query);

      } else {
       
          reloadTable();
  
      }
    });

    $("#apply_filters").click(function (e) {
      e.preventDefault();
  
      var start_date = $("#start_date").val();
      var end_date = $("#end_date").val();
  
      if (!start_date || !end_date) {
          Swal.fire({
              title: "Error",
              text: "Please fill the start and end dates.",
              icon: "error"
          });
          return; // Stop further execution
      }
  
      let start = new Date(start_date);
      let end = new Date(end_date);
  
      if (isNaN(start.getTime()) || isNaN(end.getTime())) {
          Swal.fire({
              title: "Error",
              text: "Invalid date values.",
              icon: "error"
          });
          return; // Stop further execution
      }
  
      let previousDate = new Date(start);
      previousDate.setDate(start.getDate() - 1);
  
      if (end.toDateString() === previousDate.toDateString()) {
          Swal.fire({
              title: "Error",
              text: "End date is the previous day of the start date.",
              icon: "error"
          });
          return; // Stop further execution
      }
  
      $.ajax({
          type: "POST",
          url: "includes/blottersaudittrailoperation.php",
          data: { 
              start_date: start_date, 
              end_date: end_date, 
              operation: "BLOTTER_AUDIT_SEARCH_WITH_DATE" 
          },
          dataType: "HTML",
          success: function (response) {
              $("#ResidentAuditTrailTable tbody").html(response);
              updateSearchPaginationControlswithFilters("", 1, start_date, end_date);
          },
          error: function (xhr, status, error) {
              console.error("Error updating search table data:", error);
          }
      });
  });

  $("#clear_filters").click(function (e) { 
    e.preventDefault();

    $("#start_date, #end_date, #searchbox").val('');
    reloadTable(1)
    
  });

  function populatethefirsttab(response){
      
    $('#ViewBlotterModal [id="fname"]').val(response.complainant_first_name);
    $('#ViewBlotterModal [id="mname"]').val(response.complainant_middle_name); 
    $('#ViewBlotterModal [id="lname"]').val(response.complainant_last_name);
    $('#ViewBlotterModal [id="suffix"]').val(response.complainant_suffix);
    $('#ViewBlotterModal [id="address"]').val(response.complainant_address);

    $('#ViewBlotterModal #fname_res').val(response.respondent_first_name);
    $('#ViewBlotterModal #mname_res').val(response.respondent_middle_name);
    $('#ViewBlotterModal #lname_res').val(response.respondent_last_name);
    $('#ViewBlotterModal #suffix_res').val(response.respondent_suffix);
    $('#ViewBlotterModal [id="address_res"]').val(response.respondent_address);

    $('#ViewBlotterModal [id="complainant_id"]').val(response.complainant_no);
    $('#ViewBlotterModal [id="respondent_id"]').val(response.respondent_no);
    $('#ViewBlotterModal [id="respondent_status"]').val(response.respondent_status);
    $('#ViewBlotterModal [id="complainant_status"').val(response.complainant_status);
    $('#ViewBlotterModal [id="respondent_status"]').val(response.respondent_status);
    $('#ViewBlotterModal [id="display_complainant_status"]').text(response.complainant_status);
    $('#ViewBlotterModal [id="display_respondent_status"]').text(response.respondent_status);

    $('#ViewBlotterModal .complainantbtn').attr('data-id',response.complainant_no);
    $('#ViewBlotterModal .respondentbtn').attr('data-id',response.respondent_no);
    $('#ViewBlotterModal .respondentbtn').attr('data-status',response.respondent_status);
    $('#ViewBlotterModal .complainantbtn').attr('data-status',response.complainant_status);
    
    if(response.complainant_status == "Resident"){
      $('#ViewBlotterModal [id="ComplainantImg"]').attr("src", "includes/img/resident_img/"+response.complainant_filename);
    }else{
      $('#ViewBlotterModal [id="ComplainantImg"]').attr("src", "includes/img/non_resident_img/"+response.complainant_filename);
    }

    if(response.respondent_status == "Resident"){
      $('#ViewBlotterModal [id="RespondentImg"]').attr("src", "includes/img/resident_img/"+response.respondent_filename);
    }else{
      $('#ViewBlotterModal [id="RespondentImg"]').attr("src", "includes/img/non_resident_img/"+response.respondent_filename);
    }


  }

  function populateothercomplainantsrespondents(audit_id, oldnew, comporres){

    
    $.ajax({
      type: "POST",
      url: "includes/blottersaudittrailoperation.php",
      data: {operation: "FETCH_OTHER_COMPLAINANTS_RESPONDENTS_MODAL", audit_id, audit_id, oldornew: oldnew, comporres: comporres},
      dataType: "HTML",
      success: function (response) {
        
        if(comporres == 0){
           $('#ViewBlotterModal [id="Complainant"]').html(response);
        }else if(comporres == 1){
          $('#ViewBlotterModal [id="Respondent"]').html(response);
        }
        
      },error: function(xhr, status, error) {
        console.error('Error fetching other complainants details:', error);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!"
        });
      }
    });
   
  }

  function populateotherrespondents(blotter_id){
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_OTHER_RESPONDENTS_MODAL", blotter_id: blotter_id, what_modal: '#ViewBlotterModal'},
      dataType: "HTML",
      success: function (response) {

        $('#ViewBlotterModal [id="Respondent"]').html(response);
        
      },error: function(xhr, status, error) {
          console.error('Error fetching other respondents details:', error);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!"
          });
      }
    });
  }

  function populatedetails(data){
    $('#ViewBlotterModal [id="schedule_date"]').val(data.mediation_date);
    $('#ViewBlotterModal [id="schedule_starttime"]').val(data.mediation_starttime);
    $('#ViewBlotterModal [id="schedule_endtime"]').val(data.mediation_endtime);
    $('#ViewBlotterModal [id="incident_date"]').val(data.incident_dt);
    $('#ViewBlotterModal [id="incident_location"]').val(data.location_of_incident);
    $('#ViewBlotterModal [id="blotter_type"]').val(data.blotter_type);
    $('#ViewBlotterModal [id="incident_desc"]').val(data.desc_incident);
    $('#ViewBlotterModal [id="case_context"]').val(data.statemnt);
    $('#ViewBlotterModal [id="mediator_name_view"]').val(data.mediator_name)
    $('#ViewBlotterModal [id="blotter_status"]').val(data.report_status)
    $('#ViewBlotterModal [id="resolution_date"]').val(data.date_of_resolution)
  }

  function populateimg(blotter_id){
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_MODAL_IMG", blotter_id: blotter_id},
      dataType: "JSON",
      success: function (response) {
        var data = response.data[0];
        if(response.success == true){
          $('#ViewBlotterModal [id="evidence_img"]').attr("src","includes/img/blotter_evidence/"+data.blotter_evidencefile);
          $('#ViewBlotterModal [id="blotter_img"]').attr("src","includes/img/blotter_context/"+data.blotter_contextfile);
        }else{
          console.log("Server replied failed: "+responde.message)
        }
      },error: function (xhr, status, error) {
        console.error("Error fetching table data:", error);
      }
    });
  }

  function determinemediator(mediator_id){
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_MEDIATOR", mediator_name: mediator_id},
      dataType: "JSON",
      success: function (response) {

        var response = response[0]

        var fullname = response.last_name +" "+response.first_name+" "+response.middle_name+" "+response.suffix+" "

        $("#mediator_name").val(fullname);
        
      }
    });
  }

  function populateauditblotterid(audit_id){
    $('#ViewBlotterModal [id="blotter_id"]').val(audit_id);

  }

  function generatemediatorname(){
  
    $.ajax({ 
      url: 'includes/blottersoperation.php', 
      type: 'POST', 
      data: {operation: "FETCH_MEDIATOR_SELECT"},
      dataType: 'json', 
      success: function(data) { 
        data.forEach(function(option) {
        
            $('#mediator_name_view').append($('<option>', 
              { value: option.mediator_id, 
              text: option.mediator_name 
              })); 
        });

        
          
      }, error: function(xhr, status, error){
        console.error('Error fetching options:', error); 
      }
    })
  }

  function populateevidence(data){
    $('#evidence_img').attr("src","includes/img/blotter_evidence/"+data.blotter_evidencefile);
    $('#blotter_img').attr("src","includes/img/blotter_context/"+data.blotter_contextfile);
  }

  function fetch_new_entry(audit_id){
    $.ajax({
      url: "includes/blottersaudittrailoperation.php",
      type: "POST",
      data: { audit_id: audit_id, operation: "FETCH_BLOTTER_DETAILS" },
      dataType: "JSON",
      success: function (data) {
        if (data) {

          var action_data = JSON.parse(data.action_data); 

          console.log(action_data)

          // Now you can access new_blotter_data, new_other_person, old_blotter_data, etc.
          var new_blotter_data = action_data.new_main_comp_res_details;
          var new_other_data = action_data.new_other_data;

          populateauditblotterid(audit_id)
          populatethefirsttab(new_blotter_data)
          populatedetails(new_other_data)
          populateevidence(new_other_data)
          populateothercomplainantsrespondents(audit_id, "new", 0)
          populateothercomplainantsrespondents(audit_id, "new", 1)

          
        } else {
            alert('No new values found for this resident.');
        }
      },error: function (xhr, status, error) {
          console.error("Error fetching table data:", error);
        },
    }); 
  }

  $(document).on("click",".viewOldButton",function (event) {
        event.preventDefault();
        $("#ViewBlotterModal").modal("show")

        var audit_id = $(this).data("id");
  
        $.ajax({
            url: "includes/blottersaudittrailoperation.php",
            type: "POST",
            data: { audit_id: audit_id, operation: "FETCH_BLOTTER_DETAILS" },
            dataType: "JSON",
            success: function (data) {
              if (data) {

                var action_data = JSON.parse(data.action_data); 

                // Now you can access new_blotter_data, new_other_person, old_blotter_data, etc.
                var old_blotter_data = action_data.old_main_comp_res_details;
                var old_other_data = action_data.old_other_data;

                populateauditblotterid(audit_id)
                populatethefirsttab(old_blotter_data)
                populatedetails(old_other_data)
                populateevidence(old_other_data)
                populateothercomplainantsrespondents(audit_id, "old", 0)
                populateothercomplainantsrespondents(audit_id, "old", 1)

                
              } else {
                  alert('No old values found for this resident.');
              }
          },error: function (xhr, status, error) {
              console.error("Error fetching table data:", error);
            },
        });
         
        
      }
    );

    $(document).on("click",".viewNewButton",function (event) {  

        event.preventDefault();
        $("#ViewBlotterModal").modal("show")

        var audit_id = $(this).data("id");
  
        fetch_new_entry(audit_id);
    
    }
    );

    $(document).on("click",".viewNewEntryButton",function (event) {
      event.preventDefault();
        $("#ViewBlotterModal").modal("show")

        var audit_id = $(this).data("id");
  
        fetch_new_entry(audit_id)
    });

    $(document).on("click",".viewRecoverButton, .viewDeleteButton",function (event) {
      event.preventDefault();
      $("#ViewBlotterModal").modal("show")

      var audit_id = $(this).data("id");

      fetch_new_entry(audit_id);

    }
    );

   





});
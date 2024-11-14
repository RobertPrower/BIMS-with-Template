$(document).ready(function () {

  reloadTable();

  console.log("Blotter Script has been loaded")

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
          $("#BlotterTable tbody").html(data);
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
          $("#BlotterTable tbody").html(data);
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

    console.log("Search has been triggred")

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

  var lastmodal //To be used in where the back button in the Resident/Non Resident modal will back 

  var countComplainant =0
  var countRespondent =0

  var resultArrayofOtherResComplainant = []
  var resultArrayofOtherResRespondent = []
  var resultArrayofOtherNonResComplainant = []
  var resultArrayofOtherNonResRespondent = []

  $(document).on("click",".viewbtn, .editbtn",function(e){
    e.preventDefault();
    var operation = $(this).data('whatoperation');

    var whatmodal = (operation == "view")? '#ViewBlotterModal': '#EditBlotterModal';
    lastmodal = whatmodal;
    $('.complainant_respondent_tab').tab('show');

    console.log(operation)
    console.log(whatmodal)

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

    if (whatmodal == "#EditBlotterModal") {
      $('#edit_main_complainant').attr('data-id',complainant_no);
      $('#edit_main_respondent').attr('data-id',respondent_no);

     // Fetching the Complainant Variables
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_COMPLAINANTS_IDS", blotter_id: blotter_id},
      dataType: "JSON",
      success: function (response) {
          console.log("Complainant Response Number: " + response.length);

          if (response.length >= 1) {
              var comp_residentsID = response.filter(function(comp_entry) {
                  return comp_entry.status === "Resident";
              }).map(function(comp_resident) {
                  return comp_resident.id;
              });

              var comp_non_residentsID = response.filter(function(comp_entry) {
                  return comp_entry.status === "Non-Resident";
              }).map(function(comp_non_resident) {
                  return comp_non_resident.id;
              });

              console.log("Complainant ID: " + complainant_no);
              console.log("Respondent ID: " + respondent_no);

              countComplainant = response.length;

              resultArrayofOtherResComplainant = comp_residentsID;
              resultArrayofOtherNonResComplainant = comp_non_residentsID;

              if (complainant_status === "Resident") {
                  resultArrayofOtherResComplainant.push(parseInt(complainant_no, 10));
                  console.log("Main Resident Complainant has been recorded");
              } else if (complainant_status === "Non-Resident") {
                  resultArrayofOtherNonResComplainant.push(parseInt(complainant_no, 10));
                  console.log("Main Non-Resident Complainant has been recorded");
              } else {
                  console.log("Complainant Status is neither Resident nor Non-Resident");
              }

              console.log("Array of Resident Complainant: " + resultArrayofOtherResComplainant);
              console.log("Array of Non-Resident Complainant: " + resultArrayofOtherNonResComplainant);

          } else {
              console.log("AJAX Failed to load the variables for Other Complainants.");
              
            if (complainant_status === "Resident") {
                resultArrayofOtherResComplainant.push(parseInt(complainant_no, 10));
                console.log("Main Resident Complainant has been recorded");
            } else if (complainant_status === "Non-Resident") {
                resultArrayofOtherNonResComplainant.push(parseInt(complainant_no, 10));
                console.log("Main Non-Resident Complainant has been recorded");
            } else {
                console.log("Complainant Status is neither Resident nor Non-Resident");
            }
          }
      },
      error: function(xhr, status, error) {
          console.log("AJAX Error: " + status + " - " + error);
      }
    });

    // Fetching The Respondent Variables
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_RESPONDENTS_IDS", blotter_id: blotter_id},
      dataType: "JSON",
      success: function (response) {
          if (response.length >= 1) {
              var res_residentsID = response.filter(function(res_entry) {
                  return res_entry.status === "Resident";
              }).map(function(resident) {
                  return resident.id;
              });

              var res_non_residentsID = response.filter(function(res_entry) {
                  return res_entry.status === "Non-Resident";
              }).map(function(non_resident) {
                  return non_resident.id;
              });

              countRespondent = response.length;
              console.log("countRespondent has been updated");

              resultArrayofOtherResRespondent = res_residentsID;
              resultArrayofOtherNonResRespondent = res_non_residentsID;

              if (respondent_status === "Resident") {
                  resultArrayofOtherResRespondent.push(parseInt(respondent_no, 10));
                  console.log("Main Resident Respondent has been recorded");
              } else if (respondent_status === "Non-Resident") {
                  resultArrayofOtherNonResRespondent.push(parseInt(respondent_no, 10));
                  console.log("Main Non-Resident Respondent has been recorded");
              } else {
                  console.log("Respondent Status is neither Resident nor Non-Resident");
              }

              console.log("Array of Resident Respondent: " + resultArrayofOtherResRespondent);
              console.log("Array of Non-Resident Respondent: " + resultArrayofOtherNonResRespondent);

          } else {
              console.log("AJAX Failed to load the variables for Other Respondents.");

              if (respondent_status === "Resident") {
                resultArrayofOtherResRespondent.push(parseInt(respondent_no, 10));
                console.log("Main Resident Respondent has been recorded");
                console.log("All Resident Respondent: "+resultArrayofOtherResRespondent)
            } else if (respondent_status === "Non-Resident") {
                resultArrayofOtherNonResRespondent.push(parseInt(respondent_no, 10));
                console.log("Main Non-Resident Respondent has been recorded");
            } else {
                console.log("Respondent Status is neither Resident nor Non-Resident");
            }
          }
      },
      error: function(xhr, status, error) {
          console.log("AJAX Error: " + status + " - " + error);
      }
    });
     
    }else if(whatmodal == "#ViewBlotterModal"){
      $(whatmodal+' .complainantbtn').attr('data-id',complainant_no);
      $(whatmodal+' .respondentbtn').attr('data-id',respondent_no);
      $(whatmodal+' .respondentbtn').attr('data-status',respondent_status);
      $(whatmodal+' .complainantbtn').attr('data-status',complainant_status);
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

    console.log("Array of Resident Complainant: " + resultArrayofOtherResComplainant);
    console.log("Array of Non-Resident Complainant: " + resultArrayofOtherNonResComplainant);
    console.log("Array of Resident Respondent: " + resultArrayofOtherResRespondent);
    console.log("Array of Non-Resident Respondent: " + resultArrayofOtherNonResRespondent);

  })

  function SelectResandNonResModal(whatbutton, whatparty){

    var current_comp_id = $("#EditBlotterModal #complainant_id").val();
    var current_res_id = $("#EditBlotterModal #respondent_id").val();
    var current_comp_status = $("#EditBlotterModal #complainant_status").val();
    var current_res_status = $("#EditBlotterModal #respondent_status").val();

    if (whatbutton === "SelectResidentComplainant" || whatbutton === "SelectResidentRes") {
        $("#selectresident").modal('show');

        // Unbind any previous event handlers to prevent multiple bindings
        $(document).off('click', '.ResidentTable tbody tr');
        
        $(document).on('click', '.ResidentTable tbody tr', function() {
          $(this).toggleClass("selected").siblings().removeClass("selected");

          console.log("Current Comp_id: "+current_comp_id)
          console.log("Current Res_id: "+current_res_id)
          console.log("Current Comp_status: "+current_comp_status)
          console.log("Current Res_status: "+current_res_status)

          var table = $('.ResidentTable').DataTable();
          var rowData = table.row(this).data();
          var residentid = rowData.resident_id; 
          var imagefile = rowData.img_filename;
          console.log(imagefile)

            $.ajax({
                url: 'includes/modaloperation.php', 
                type: 'POST',
                data: { resident_id: residentid, operation: "FETCH_RESIDENT_DETAILS" },
                success: function(response) {
                    var data = JSON.parse(response);

                    if (whatparty === 'respondent') {

                      if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherNonResRespondent.includes(residentid) 
                        || resultArrayofOtherNonResComplainant.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){

                          Swal.fire({
                            icon: 'warning',
                            title: 'The Person is already selected',
                            text: 'Please select other one',
                            confirmButtonText: 'OK'
                          });
  
                      }else{
                       
                          //Remove the currently selected entry to the check varaibles  
                          if(current_res_status === "Resident"){
                            resultArrayofOtherResRespondent = resultArrayofOtherResRespondent.filter(function (item) {
                              return item !== parseInt(current_res_id, 10);
                            });
                          }else if(current_res_status === "Non-Resident"){
                            resultArrayofOtherNonResRespondent = resultArrayofOtherNonResRespondent.filter(function (item) {
                              return item !== parseInt(current_res_id, 10);
                            });
                          }else{
                            alert('There is a problem determining what status of the id to be remove from the check variables.')
                          }

                  
                          $('#EditBlotterModal #fname_res').val(data.first_name);
                          $('#EditBlotterModal #mname_res').val(data.middle_name);
                          $('#EditBlotterModal #lname_res').val(data.last_name);
                          $('#EditBlotterModal #suffix_res').val(data.suffix);
                          $('#EditBlotterModal #address_res').val(data.address + " Camarin Caloocan City");
                          $("#EditBlotterModal #respondent_id").val(residentid);
                          $("#EditBlotterModal #respondent_status").val("Resident");
                          $("#EditBlotterModal #display_respondent_status").text("Resident");
                          $("#EditBlotterModal #RespondentImg").attr("src", "includes/img/resident_img/"+imagefile);
                          resultArrayofOtherResRespondent.push(residentid)
                      }

                    } else if (whatparty === 'complainant') {

                      console.log("Current Comp ID: "+current_comp_id)
                      console.log("Current Res ID: "+current_res_id)
                      console.log("Selected ID :"+residentid)

                      if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherNonResRespondent.includes(residentid) 
                        || resultArrayofOtherNonResComplainant.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){
                      
                          Swal.fire({
                            icon: 'warning',
                            title: 'The Person is already selected',
                            text: 'Please select other one',
                            confirmButtonText: 'OK'
                          });
  
                      }else{
                      
                          if(current_comp_status === "Resident"){
                              resultArrayofOtherResComplainant = resultArrayofOtherResComplainant.filter(function (item) {
                                return item !== parseInt(current_comp_id, 10);
                              });
                          }else if(current_comp_status === "Non-Resident"){
                              resultArrayofOtherNonResComplainant = resultArrayofOtherNonResComplainant.filter(function (item) {
                                return item !== parseInt(current_comp_id, 10);
                              });
                          }

                          $('#EditBlotterModal #fname').val(data.first_name);
                          $('#EditBlotterModal #mname').val(data.middle_name);
                          $('#EditBlotterModal #lname').val(data.last_name);
                          $('#EditBlotterModal #suffix').val(data.suffix);
                          $('#EditBlotterModal #address').val(data.address + " Camarin Caloocan City");
                          $("#EditBlotterModal #complainant_status").val("Resident");
                          $("#EditBlotterModal #complainant_display_status").text("Resident");
                          $('#EditBlotterModal #complainant_id').val(residentid);
                          $("#EditBlotterModal #ComplainantImg").attr("src", "includes/img/resident_img/"+imagefile);
                          resultArrayofOtherResComplainant.push(residentid)
                          }

                    } else if (whatparty == "othercomplainant"){

                        if(countComplainant < 5){
                          console.log("Current Count of Complainant :"+countComplainant)
                            if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherNonResRespondent.includes(residentid) 
                              || resultArrayofOtherNonResComplainant.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){
                              
                              Swal.fire({
                                icon: 'warning',
                                title: 'Entry Already Selected',
                                text: 'This person has already been selected. Please choose another one.',
                                confirmButtonText: 'OK'
                              });  
                              
                            }else{
                             
                              countComplainant++
                              console.log("Added Count: "+countComplainant)
                              $("#NoResult").remove();
                              var newContent = `
                              <tr id="${residentid}" data-status="Resident" data-id="${residentid}">
                              <td hidden>`+residentid+`</td>
                              <td><img src="includes/img/resident_img/${imagefile}" width="100 height="100""></td>
                              <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                              <td>Resident</td>
                               <td>
                                  <button class="btn btn-danger mx-2 removepersons" id="removeOtherComplainants"
                                  data-id="${residentid}"
                                  data-whatbtn="OtherComplainants" data-status="Resident">
                                  Remove
                                  </button>
                              </td>
                              </tr>`;

                              $('#EditBlotterModal #Complainant').append(newContent);
                              resultArrayofOtherResComplainant.push(residentid);
                              
                             
                            }
                            
                       
                        }else{
                            Swal.fire({
                                icon: 'warning',
                                title: 'You reached the maxium allowed entries',
                                text: 'Please remove other complainants to add more.',
                                confirmButtonText: 'OK'
                            });

                        }


                    }else if(whatparty == "otherrespondent"){
                      console.log("Current Count of Respondent :"+countRespondent)

                        if(countRespondent <= 5){
                          console.log("Resident Respondent IDs: "+resultArrayofOtherResRespondent)
                          console.log("NonResident Respondent IDs: "+resultArrayofOtherResRespondent)
                          console.log("ID is: "+residentid)
                           if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherNonResRespondent.includes(residentid) 
                            || resultArrayofOtherNonResComplainant.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){

                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Entry Already Selected',
                                    text: 'This person has already been selected. Please choose another one.',
                                    confirmButtonText: 'OK'
                                });
                                
                           }else{
                               
                                countRespondent++
                                $("#respondents_tab_pane2 #NoResult").remove();
                                var newContent = `
                                <tr id="${residentid}" data-status="Resident" data-id="${residentid}">
                                <td hidden>`+residentid+`</td>
                                <td><img src="includes/img/resident_img/${imagefile}" width="100 height="100"></td>
                                <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                                <td>Resident</td>
                                <td>
                                    <button class="btn btn-danger mx-2 removepersons" id="removeOtherComplainants" data-id="${residentid}"
                                    data-whatbtn="OtherRespondents" data-status="Resident">
                                    Remove
                                    </button>
                                </td>
                                </tr>`;

                                $('#EditBlotterModal #Respondent').append(newContent);
                                resultArrayofOtherResRespondent.push(residentid);
                              
                           }
                        }else{
                            Swal.fire({
                                icon: 'warning',
                                title: 'You reached the maxium allowed entries',
                                text: 'Please remove other respondents to add more.',
                                confirmButtonText: 'OK'
                            });

                        }

                    }else{
                        alert("This should not run")
                    }

                    $('#selectresident').modal('hide');
            
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching resident details:', error);
                }
            });
            
        });

       
    } else {
      //NonResident Block
        $("#selectnonresident").modal('show');
        console.log(whatparty)
        $(document).off('click', '.NonResidentTable tbody tr');

        $(document).on('click', '.NonResidentTable tbody tr', function() {
            $(this).toggleClass("selected").siblings().removeClass("selected");
            
            var table = $('.NonResidentTable').DataTable();
            var rowData = table.row(this).data();
            var residentid = rowData.nresident_id; 
            var imagefile = rowData.img_filename;
           
            $.ajax({
                url: 'includes/modaloperation.php',
                type: 'POST',
                data: { nresident_id: residentid, operation: "FETCH_NON_RESIDENT_DETAILS" },
                success: function(response) {
                    var data = JSON.parse(response);

                    if (whatparty === 'respondent') {
                        if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherNonResRespondent.includes(residentid) 
                          || resultArrayofOtherNonResComplainant.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){
                          
                            Swal.fire({
                              icon: 'warning',
                              title: 'The Person is already selected',
                              text: 'Please select other one',
                              confirmButtonText: 'OK'
                            });

                        }else{
                            //Remove the currently selected entry to the check varaibles  
                            if(current_res_status == "Resident"){
                              resultArrayofOtherResRespondent = resultArrayofOtherResRespondent.filter(function (item) {
                                return item !== parseInt(current_res_id, 10);
                              });
                            }else if(current_res_status = "Non-Resident"){
                              resultArrayofOtherNonResRespondent = resultArrayofOtherNonResRespondent.filter(function (item) {
                                return item !== parseInt(current_res_id, 10);
                              });
                            }

                            $('#EditBlotterModal #fname_res').val(data.first_name);
                            $('#EditBlotterModal #mname_res').val(data.middle_name);
                            $('#EditBlotterModal #lname_res').val(data.last_name);
                            $('#EditBlotterModal #suffix_res').val(data.suffix);
                            $('#EditBlotterModal #address_res').val(data.address);
                            $("#EditBlotterModal #respondent_status").val("Non-Resident");
                            $("#EditBlotterModal #respondent_id").val(residentid);
                            $("#EditBlotterModal #display_respondent_status").text("Non-Resident");
                            $("#EditBlotterModal #RespondentImg").attr("src", "includes/img/non_resident_img/"+imagefile);
                            resultArrayofOtherNonResRespondent.push(residentid)
      
                        }

                    } else if (whatparty === 'complainant') {

                      if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherNonResRespondent.includes(residentid) 
                        || resultArrayofOtherNonResComplainant.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){
                          Swal.fire({
                            icon: 'warning',
                            title: 'The Person is already selected',
                            text: 'Please select other one',
                            confirmButtonText: 'OK'
                          });
                       
                      }else{
                            //Remove the currently selected entry to the check varaibles  
                          if(current_comp_status === "Resident"){
                            resultArrayofOtherResComplainant = resultArrayofOtherResComplainant.filter(function (item) {
                              return item !== parseInt(current_comp_id, 10);
                            });
                          }else if(current_comp_status === "Non-Resident"){
                            resultArrayofOtherNonResComplainant = resultArrayofOtherNonResComplainant.filter(function (item) {
                              return item !== parseInt(current_comp_id, 10);
                            });
                          }

                          $('#EditBlotterModal #fname').val(data.first_name);
                          $('#EditBlotterModal #mname').val(data.middle_name);
                          $('#EditBlotterModal #lname').val(data.last_name);
                          $('#EditBlotterModal #suffix').val(data.suffix);
                          $('#EditBlotterModal #address').val(data.address);
                          $("#EditBlotterModal #complainant_status").val("Non-Resident");
                          $("#EditBlotterModal #display_complainant_status").text("Non-Resident");
                          $('#EditBlotterModal #complainant_id').val(residentid);
                          $("#EditBlotterModal #ComplainantImg").attr("src", "includes/img/non_resident_img/"+imagefile);
                          resultArrayofOtherNonResComplainant.push(residentid)
                        
                      }

                    } else if (whatparty === "othercomplainant"){

                        if(countComplainant < 5){
                            if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherNonResRespondent.includes(residentid) 
                              || resultArrayofOtherNonResComplainant.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){
                                Swal.fire({
                                  icon: 'warning',
                                  title: 'Entry Already Selected',
                                  text: 'This person has already been selected. Please choose another one.',
                                  confirmButtonText: 'OK'
                                });
                                
                            }else{
                                countComplainant+1
                                console.log("Added Respondent Count: "+countRespondent)
                                $("#NoResult").remove();
                                var newContent = `
                                <tr id="${residentid}" data-status="Non-Resident" data-id="${residentid}">
                                <td hidden>`+residentid+`</td>
                                <td><img src="includes/img/non_resident_img/${imagefile}" width="100 height="100""></td>
                                <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                                <td>Non-Resident</td>
                                <td>
                                    <button class="btn btn-danger mx-2 removepersons" id="removeOtherComplainants"
                                    data-id="${residentid}"
                                    data-whatbtn="OtherComplainants" data-status="Non-Resident">
                                    Remove
                                    </button>
                                </td>
                                </tr>`;

                                $('#EditBlotterModal #Complainant').append(newContent);
                                resultArrayofOtherNonResComplainant.push(residentid);
                            }
                        }else{
                            Swal.fire({
                                icon: 'warning',
                                title: 'You reached the maxium allowed entries',
                                text: 'If more people is involved, please use to the other input field.',
                                confirmButtonText: 'OK'
                            });

                        }


                    }else if(whatparty == "otherrespondent"){
                      
                        if(countRespondent < 5){
                            if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherNonResRespondent.includes(residentid) 
                              || resultArrayofOtherNonResComplainant.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){

                              Swal.fire({
                                icon: 'warning',
                                title: 'The person is already selected',
                                text: 'Please select other person.',
                                confirmButtonText: 'OK'
                            });
                            }else{
                              countRespondent++
                              console.log("Added Count: "+countRespondent)
                              $("#NoResult").remove();
                              var newContent = `
                              <tr id="${residentid}" data-status="Non-Resident" data-id="${residentid}">
                              <td hidden>`+residentid+`</td>
                              <td><img src="includes/img/non_resident_img/${imagefile}" width="100 height="100""></td>
                              <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                              <td>Non-Resident</td>
                              <td>
                                  <button class="btn btn-danger mx-2 removepersons" id="removeOtherComplainants"
                                  data-id="${residentid}"
                                  data-whatbtn="OtherRespondents" data-status="Resident">
                                  Remove
                                  </button>
                              </td>
                              </tr>`;
                              $('#EditBlotterModal #Respondent').append(newContent);
                              resultArrayofOtherNonResComplainant.push(residentid);

                            }
                        }else{
                            Swal.fire({
                                icon: 'warning',
                                title: 'You reached the maxium allowed entries',
                                text: 'If more people is involved, please use the other input field.',
                                confirmButtonText: 'OK'
                            });

                        }

                    }

                    $('#selectnonresident').modal('hide');

                },
                error: function(xhr, status, error) {
                    console.error('Error fetching resident details:', error);
                }
            });
            
        });
    }

  }

  $("#EditBlotterModal, #ViewBlotterModal").on('shown.bs.modal', function (e) {

    
    var whatmodal = $("#ViewBlotterModal").hasClass('show')? "#ViewBlotterModal": "#EditBlotterModal";
    console.log(whatmodal)
    e.preventDefault();
    var blotter_id = $(whatmodal + ' [id="blotter_id"]').val();

    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_OTHER_COMPLAINANTS_MODAL", blotter_id, blotter_id, what_modal: whatmodal},
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
      
    $.ajax({
      type: "POST",
      url: "includes/blottersoperation.php",
      data: {operation: "FETCH_OTHER_RESPONDENTS_MODAL", blotter_id: blotter_id, what_modal: whatmodal},
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

  $(document).on("click",".complainantbtn, .respondentbtn, .viewPersonDetails",function () {
  
    console.log("View Person details has been triggered")

    var whatstatusid = ($(this).hasClass("complainantbtn"))? "#complainant_id": "#respondent_id" ;
    var whatstatus = ($(this).hasClass("complainantbtn"))? "#complainant_status": "#respondent_status" ;
    var whatbtn = $(this).data("whatbtn")
    
    if((!whatbtn === "othercomplainant") && (!whatbtn === "otherrespondent")){
      var residentid = $(whatstatusid).val();
      var resident_status = $(whatstatus).val();
    }else{
      var residentid = $(this).data("id");
      var resident_status = $(this).data("status");

    }
    console.log(residentid)
    console.log(resident_status)

  if(resident_status == "Resident"){

    $("#DocumentDetailsModal, #ViewBlotterModal, #EditBlotterModal").modal('hide');
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

  $(document).on("hide.bs.modal",'#EditBlotterModal',function () {
    countComplainant =1
    countRespondent =1
    resultArrayofOtherNonResComplainant=[];
    resultArrayofOtherNonResRespondent=[];
    resultArrayofOtherResComplainant=[]
    resultArrayofOtherResRespondent=[]

    console.log("All referencing varable has been reset")
  });
  
  $(document).on("click", ".backbtntodocu", function () {
    $(this).prop("hidden", true);

    $("#ViewResidentModal, #ViewNonResidentModal").modal("hide");
    $("#DocumentDetailsModal").modal("show");

    if(lastmodal == '#ViewBlotterModal'){

      $("#ViewBlotterModal").modal("show");

    }else{

      $("#EditBlotterModal").modal("show");

    }
  });
 
  $(".editpersonbtn").off('click').click(function (e) { 
    e.preventDefault();
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
       
        SelectResandNonResModal("SelectResidentComplainant", whatparty);

      } else if (result.isDenied) {
        
        SelectResandNonResModal("SelectNonResidentComplainant", whatparty);

      }
    });
      
  });

  $(document).on('click','.removepersons',function (e) {
      e.preventDefault();

      console.log("removeperson has been triggered")
      var whatid = $(this).data("id");
      var whatbtn = $(this).data("whatbtn")
      var whatstatus = $(this).data("status")

      console.log(whatbtn)
      console.log(whatid)

      if(whatbtn == "OtherComplainants" ){
        console.log("Selected complainants has been clear")
        console.log("Count Complainant Before Decrement :"+countComplainant)
        countComplainant --
        console.log("Count Complainant After Decrement: "+countComplainant)
        $("#complainants_tab_pane2 #"+whatid).remove(); 

        if(whatstatus == "Resident"){
          resultArrayofOtherResComplainant = resultArrayofOtherResComplainant.filter(function (item) {
            return item !== whatid;
          });
        }else if(whatstatus == "Non-Resident"){
          resultArrayofOtherNonResComplainant = resultArrayofOtherNonResComplainant.filter(function (item) {
            return item !== whatid;
          });
        }else{
          alert("Failed to get the data in determining status")
        }
      

      }else if(whatbtn == "OtherRespondents"){
        console.log("Selected respondent has been clear")
        console.log("Count Respondent Before Operation: "+countRespondent)
        countRespondent --
        console.log("Count Respondent After Operation: "+countRespondent)
        $("#respondents_tab_pane2 #"+whatid).remove(); 
       
        if(whatstatus == "Resident"){
          resultArrayofOtherResRespondent = resultArrayofOtherResRespondent.filter(function (item) {
            return item !== whatid;
          });
        }else if(whatstatus == "Non-Resident"){
          resultArrayofOtherNonResRespondent = resultArrayofOtherNonResRespondent.filter(function (item) {
            return item !== whatid;
          });
        }else{
          alert("Failed to get the data in determining status")
        }
      }  

      console.log("Current Result of Resident Complainant"+resultArrayofOtherResComplainant)
      console.log("Current Result of Non-Resident Complainant"+resultArrayofOtherNonResComplainant)
      console.log("Current Result of Resident Respondent"+resultArrayofOtherResRespondent)
      console.log("Current Result of Non-Resident Respondent"+resultArrayofOtherNonResRespondent)
        
  })  

  $(document).off('click','.AddResidentComplainant, .AddResidentRespondent').on('click','.AddResidentComplainant, .AddResidentRespondent', function (e) {
    e.preventDefault();
    console.log("Add resident has been click")

    var whatparty = $(this).data("whatparty");
    var whatbutton = $(this).data("whatbutton");

    SelectResandNonResModal(whatbutton, whatparty);
    
  });

  function convertTo24HourFormat(time12h) {
      // Split the time string into [time, period] (e.g., ["11:30", "PM"])
      const [time, period] = time12h.split(' ');

      // Split the time into hours and minutes
      let [hours, minutes] = time.split(':');

      // Convert the hours to 24-hour format
      if (period === 'PM' && hours !== '12') {
          hours = parseInt(hours, 10) + 12;
      } else if (period === 'AM' && hours === '12') {
          hours = '00';
      }

      // Return the formatted 24-hour time as a string
      return `${hours}:${minutes}`;
  }

  function formatDate(date) {
      if (!date) {
          console.error("Invalid date object:", date);
          return "";
      }
      
      var year = date.getFullYear();
      var month = ('0' + (date.getMonth() + 1)).slice(-2);
      var day = ('0' + date.getDate()).slice(-2);
      
      return `${year}-${month}-${day}`;
  }

  $("#EditBlotterModalForm").submit(function(event){
    event.preventDefault();

    var schedule_date = new Date($("#EditBlotterModal #schedule_date").val());
    var schedule_starttime =$("#EditBlotterModal #schedule_starttime").val();
    var schedule_endtime = $("#EditBlotterModal #schedule_endtime").val();

    var formData = new FormData(this);  
    formData.append("schedule_date", formatDate(schedule_date));
    formData.append("schedule_starttime", convertTo24HourFormat(schedule_starttime));
    formData.append("schedule_endtime", convertTo24HourFormat(schedule_endtime));
    formData.append("operation", "EDIT_BLOTTER");


    // Objects for the Other Complainants and Respondents
   
    let resident_complainants=[];
    let non_resident_complainants=[]
    let resident_respondents=[];
    let non_resident_respondents=[]

    $(".othercomplainant tbody tr").each(function () {

      var id = $(this).data('id');
      var status = $(this).data('status');

      console.log("Complainant tr id :" +id)
      console.log("Complainant tr status :" +status)

      if (status === "Resident") {
          resident_complainants.push(id);
          console.log(resident_complainants)

      } else if (status === "Non-Resident") {
          non_resident_complainants.push(id);
          console.log(non_resident_complainants)
      }

    });

    $(".otherrespondent tbody tr").each(function () {

      var id = $(this).data("id");
      var status = $(this).data('status');

      console.log("Respondent tr id :" +id)
      console.log("Respondent tr status :" +status)

      // Add ID to the appropriate array based on status
      if (status === "Resident") {
          resident_respondents.push(id);
          console.log(resident_respondents)

      } else if (status === "Non-Resident") {
          non_resident_respondents.push(id);
          console.log(non_resident_respondents)

      }

    });

    for (var i = 0; i < 5; i++) {
      formData.append(`other_resident_complainant${i + 1}`, resident_complainants[i] || "null");
      formData.append(`other_nonresident_complainant${i + 1}`, non_resident_complainants[i] || "null");
      formData.append(`other_resident_respondent${i + 1}`, resident_respondents[i] || "null");
      formData.append(`other_nonresident_respondent${i + 1}`, non_resident_respondents[i] || "null");
    }

    $.ajax({
        type: "POST",
        url: "includes/blottersoperation.php",
        data: formData,
        dataType: "JSON",
        contentType: false,
        processData: false,
        success: function (response) {
            if(response.success == true){
                Swal.fire({
                    title: "Success!",
                    text: "Blotter Edited Successfully",
                    icon: "success"
                })

                reloadTable()

                $("#EditBlotterModal").modal('hide')
            }else{
                Swal.fire({
                    title: "Something went wrong.",
                    text: "The server reply's failed",
                    icon: "error"
                  });
            }
        },error: function(xhr, status, error) {
            console.error('Error fetching resident details:', error);
        }
    });

  });

  $(document).on("click",'#deletebtn',function () {
      var blotter_id = $(this).data("id");
      
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                type: "POST",
                url: "includes/blottersoperation.php",
                data: {operation: "DELETE_BLOTTER", blotter_id: blotter_id},
                dataType: "JSON",
                success: function (response) {
        
                  if(response.success){
                      Swal.fire({
                        title: "Success!",
                        text: "Blotter Edited Successfully",
                        icon: "success"
                      })
                      reloadTable()
                  }else{
                      Swal.fire({
                        title: "There's an error!",
                        text: "The server replyed failed",
                        icon: "error"
                      })
        
                  }
                  
                },error: function(xhr, status, error) {
                  console.error('Error fetching resident details:', error);
                  Swal.fire({
                    title: "There's an error!",
                    text: "The AJAX failed",
                    icon: "error"
                  })
                }
              });
          }
      });
  });

})
  

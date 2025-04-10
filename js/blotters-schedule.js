$(document).ready(function () {
    var calendar;
    generatemediatorname()

    function generatemediatorname(){
        $.ajax({ 
            url: 'includes/blottersoperation.php', 
            type: 'POST', 
            data: {operation: "FETCH_MEDIATOR_SELECT"},
            dataType: 'json', 
            success: function(data) { 
            data.forEach(function(option) { 
                $('#ViewBlotterModal #mediator_name_view').append($('<option>', 
                    { value: option.mediator_id, 
                    text: option.mediator_name 
                    })); 
            });  
            }, error: function(xhr, status, error){
            console.error('Error fetching options:', error); 
            }
        })
    }

    function formatTime(date) {
        var hours = ('0' + date.getHours()).slice(-2);
        var minutes = ('0' + date.getMinutes()).slice(-2);
        var seconds = ('0' + date.getSeconds()).slice(-2);
        return `${hours}:${minutes}:${seconds}`;
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

    var calendarEl = document.getElementById('calendar');
    var showpastdates =false
    
    window.initCalendar = function (){
        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,timeGridDay,listMonth'
            },
            slotMinTime: '08:00:00',
            slotMaxTime: '18:00:00',
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5], 
                startTime: '08:00', 
                endTime: '17:00' 
            },
            selectable: true,
            editable: true,       
            droppable: true,   
            allDaySlot: false,
            eventDurationEditable: true,
            validRange: function(nowDate) {
                if(!showpastdates){
                    return {
                        start: nowDate 
                    };
                }else{
                    return {}
                }
            },
            dateClick: function(info) {
                calendar.changeView('timeGridDay', info.date); 
            },
            eventDrop: function(info) {
                // Confirm and save the new date/time if needed
                console.log(formatTime(info.event.end))
                console.log(formatDate(info.event.start))
                console.log(formatTime(info.event.start))
    
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are moving this blotter to " + info.event.start,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, move it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "includes/blottersoperation.php",
                            data: {
                                operation: "CHANGE_SCHEDULE",
                                blotter_id: info.event.id,
                                schedule_date: formatDate(info.event.start),
                                schedule_starttime: formatTime(info.event.start),
                                schedule_endtime: formatTime(info.event.end)
                            },
                            dataType: "json",
                            success: function (response) {
                                if (response.success == true) {
                                    Swal.fire({
                                        title: "Success",
                                        text: "Mediation Schedule has been moved.",
                                        icon: "success"
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error",
                                        text: "The server replies error.",
                                        icon: "error"
                                    });
    
                                    info.revert();
                                }  
                            },
                            error: function (xhr, status, error) {
                                console.error("Error updating schedule:", error);
                            }
                        });
                    } else {
                        info.revert();
                    }
                });
            },windowResize: function(view) {
                calendar.updateSize();
            },eventResize: function(info) {
                if (confirm("Are you sure about this change?")) {
                    console.log("Event resized to end at: " + info.event.end);
                } else {
                    info.revert();
                }
            },
            
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: 'includes/blottersoperation.php',
                    method: 'POST',
                    dataType: 'json',
                    data: { operation: "FETCH_SCHEDULE_ON_MODAL" },
                    success: function(data) {
                        var events = [];
                        $.each(data, function(i, blotter) {
                            var mediation_date = blotter.mediation_date + " " + blotter.mediation_starttime;
                            var mediation_enddate = blotter.mediation_date + " " + blotter.mediation_endtime;
    
                            switch (parseInt(blotter.report_status, 10)){
                              case 1: schedule_color = "#198754"; break;
                              case 0: schedule_color = "#ffc107"; break;
                              case 2: schedule_color = "#dc3545"; break;
                              default: schedule_color = "#0000";
                          }
  
                            events.push({
                                blotter_id: blotter.blotter_id,
                                title: blotter.desc_incident,
                                incdate: blotter.incident_dt,
                                start: new Date(mediation_date),
                                end: new Date(mediation_enddate),
                                complainant: blotter.complainant_fullname,
                                respondent: blotter.respondent_fullname,
                                report_status: blotter.report_status,
                                color: schedule_color
                            });
                        });
                        successCallback(events);
                    },
                    error: function() {
                        failureCallback([]);
                    }
                });
            },
            
            eventClick: function(info) {
                var formattedStart = formatDate(info.event.start);
                var formattedincident = info.event.extendedProps.incdate;
                $('#ViewBlotterModal').modal('show')

                var blotter_id = info.event.extendedProps.blotter_id;
                console.log(blotter_id)

                $.ajax({
                    type: "POST",
                    url: "includes/blottersoperation.php",
                    data: {operation: "FETCH_MODAL_1ST_TAB", blotter_id: blotter_id},
                    dataType: "JSON",
                    success: function (response) {
                        response = response[0]

                        $("#complainant_respondent_tab").tab("show");
                        $('#ViewBlotterModal [id="fname"]').val(response.complainant_first_name);
                        $('#ViewBlotterModal [id="mname"]').val(response.complainant_middle_name); 
                        $('#ViewBlotterModal [id="lname"]').val(response.complainant_last_name);
                        $('#ViewBlotterModal [id="suffix"]').val(response.complainant_suffix);
                        $('#ViewBlotterModal [id="address"]').val(response.complainant_address);

                        $("#ViewBlotterModal #fname_res").val(response.respondent_first_name);
                        $('#ViewBlotterModal #mname_res').val(response.respondent_middle_name);
                        $('#ViewBlotterModal #lname_res').val(response.respondent_last_name);
                        $('#ViewBlotterModal #suffix_res').val(response.respondent_suffix);
                        $('#ViewBlotterModal [id="address_res"]').val(response.respondent_address);

                        $('#ViewBlotterModal [id="blotter_id"]').val(response.blotter_id);
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
                });
            
                $.ajax({
                  type: "POST",
                  url: "includes/blottersoperation.php",
                  data: {operation: "FETCH_OTHER_COMPLAINANTS_MODAL", blotter_id, blotter_id, what_modal: "#ViewBlotterModal"},
                  dataType: "HTML",
                  success: function (response) {
            
                    $('#ViewBlotterModal [id="Complainant"]').html(response);
                    
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
            
                $.ajax({
                  type: "POST",
                  url: "includes/blottersoperation.php",
                  data: {operation: "FETCH_OTHER_CASE_DETAILS_MODAL", blotter_id: blotter_id},
                  dataType: "JSON",
                  success: function (response) {
                    var data = response.data[0]
            
                    if(response.success == true){
                      
                      $('#ViewBlotterModal [id="schedule_date"]').val(data.mediation_date);
                      $('#ViewBlotterModal [id="schedule_starttime"]').val(data.mediation_starttime);
                      $('#ViewBlotterModal [id="schedule_endtime"]').val(data.mediation_endtime);
                      $('#ViewBlotterModal [id="incident_date"]').val(data.incident_dt);
                      $('#ViewBlotterModal [id="incident_location"]').val(data.location_of_incident);
                      $('#ViewBlotterModal [id="blotter_type"]').val(data.blotter_type);
                      $('#ViewBlotterModal [id="incident_desc"]').val(data.desc_incident);
                      $('#ViewBlotterModal [id="case_context"]').val(data.statemnt);
                      $('#ViewBlotterModal #mediator_name_view').val(data.mediator_name)
                      $('#ViewBlotterModal [id="blotter_status"]').val(data.report_status)
                      $('#ViewBlotterModal [id="resolution_date"]').val(data.date_of_resolution)
            
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
        });
    
        calendar.render();

    }

    initCalendar();

    $("#showpastdates").on("change", function () {
        console.log("Change switch has been triggered")
        showpastdates = !showpastdates; 
        initCalendar();
        
    });

    $(document).on("click",".sidebar-toggle",function () {

        initCalendar()
        
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
    
            
            $.ajax({
              type: "post",
              url: "includes/residentoperation.php",
              data: { operation: "CHECK_HIT", resident_id: response.resident_id },
              dataType: "json",
              success: function (response) {
                console.log(response);
    
                if(response.success == "clear"){
                  $("#ViewResidentModal #with_hit").text("None");
                  $("#ViewResidentModal #blotter_badge").removeClass("text-bg-danger");
                  $("#ViewResidentModal #blotter_badge").removeClass("text-bg-success");
                  $("#ViewResidentModal #blotter_badge").addClass("text-bg-success");
    
                }else if(response.success == "hit"){
                  $("#ViewResidentModal #with_hit").text("With Hit");
                  $("#ViewResidentModal #blotter_badge").removeClass("text-bg-danger") 
                  $("#ViewResidentModal #blotter_badge").removeClass("text-bg-success");
                  $("#ViewResidentModal #blotter_badge").addClass("text-bg-danger");
    
                }else{
                  alert("Server replys failed ")
                }
              }, error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
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
    
            $.ajax({
              type: "post",
              url: "includes/nonresidentoperation.php",
              data: { operation: "CHECK_HIT", nresident_id: response.nresident_id },
              dataType: "json",
              success: function (response) {
                console.log(response);  
        
                if(response.success == "clear"){
                  $("#ViewNonResidentModal #with_hit").text("None");
                  $("#ViewNonResidentModal #blotter_badge").removeClass("text-bg-danger");
                  $("#ViewNonResidentModal #blotter_badge").removeClass("text-bg-success");
                  $("#ViewNonResidentModal #blotter_badge").addClass("text-bg-success");
        
                }else if(response.success == "hit"){
                  $("#ViewNonResidentModal #with_hit").text("With Hit");
                  $("#ViewNonResidentModal #blotter_badge").removeClass("text-bg-danger") 
                  $("#ViewNonResidentModal #blotter_badge").removeClass("text-bg-success");
                  $("#ViewNonResidentModal #blotter_badge").addClass("text-bg-danger");
        
                }else{
                  alert("Server replys failed ")
                }
              }, error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
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
        $("#ViewBlotterModal").modal("show");
    
      });
     
});

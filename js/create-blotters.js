
$(document).ready(function(){

    $('#incident_date').tempusDominus({
        display: {
          components: {
                  // Set to true if you want second selection
          },
          icons: {
            time: 'bi bi-clock-fill',
            date: 'bi bi-calendar',
            up: 'bi bi-arrow-up',
            down: 'bi bi-arrow-down'
          }
        },
        localization: {
          format: 'MM/dd/yyyy HH:mm'  // Set your date and time format
        }
    });

    var selectedRowId = null;

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
                            return '<img src="includes/img/resident_img/' + data + '" alt="Image" class="img-thumbnail" style="width: 100px; height: 100px;">';
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
    

    $('#selectnonresident').on('shown.bs.modal', function() {
        if (!$.fn.DataTable.isDataTable('#NonResidentTable')) {
            $('#NonResidentTable').DataTable({
                ajax: {
                    url: 'includes/blottersoperation.php', 
                    dataSrc: '',
                    type: 'POST',
                    data: function(d) {
                
                        d.operation = "SELECT_NONRESIDENT_TABLELOAD"; 
                        
                    }
                },
                columns: [
                    { data: 'nresident_id', visible: false }, 
                    {
                        data: 'img_filename', 
                        render: function(data, type, row) {
                            return '<img src="includes/img/non_resident_img/' + data + '" alt="Image" class="img-thumbnail" style="width: 100px; height: 100px;">';
                        },
                        className: "text-center",
                        width: "5%"
                    },
                    { data: 'full_name', className: "text-center", width:"5%" }, 
                    { data: 'address', className: "text-center", width:"10%" },
                    { data: 'sex', className: "text-center", width:"2%" },
                    { data: 'marital_status', className: "text-center", width:"2%" },
                    { data: 'birth_date', className: "text-center", width:"4%" },
                    { data: 'cellphone_num', className: "text-center", width:"4%" }
                ],
                responsive: true,
                scrollX: false,
                lengthChange: false,
                pageLength: 5    

            });
        }
        console.log("Table has been shown");
    });

    $('#selectresident').on('hide.bs.modal', function () {
        var table = $('#ResidentTable').DataTable();
        table.clear().destroy();
    });
    
    $('#selectnonresident').on('hide.bs.modal', function () {
        var table = $('#NonResidentTable').DataTable();
        table.clear().destroy();
    });

    var countResidentComplainant =0 
    var countNonResidentComplainant =0
    var countResidentRespondent =0
    var countNonResidentRespondent =0

    var resultArrayofOtherResComplainant = []
    var resultArrayofOtherResRespondent = []
    var resultArrayofOtherNonResComplainant = []
    var resultArrayofOtherNonResRespondent = []

    function SelectResandNonResModal(whatbutton, whatparty){
        // console.log(resultArrayofOtherResComplainant)
        // console.log(resultArrayofOtherResRespondent)
        // console.log(resultArrayofOtherNonResComplainant)
        // console.log(resultArrayofOtherNonResRespondent)
        if (whatbutton === "SelectResidentComplainant" || whatbutton === "SelectResidentRes") {
            $("#selectresident").modal('show');
    
            // Unbind any previous event handlers to prevent multiple bindings
            $(document).off('click', '.ResidentTable tbody tr');
            
            $(document).on('click', '.ResidentTable tbody tr', function() {
                $(this).toggleClass("selected").siblings().removeClass("selected");
                
                var table = $('.ResidentTable').DataTable();
                var rowData = table.row(this).data();
                var residentid = rowData.resident_id; 
                var imagefile = rowData.img_filename;
                console.log(imagefile)

                $.ajax({
                    url: 'includes/fetch_nonres_res_details.php', 
                    type: 'POST',
                    data: { resident_id: residentid, OPERATION: "RESIDENT" },
                    success: function(response) {
                        var data = JSON.parse(response);

                        if (whatparty === 'respondent') {
                            $('#fnameres').val(data.first_name);
                            $('#mnameres').val(data.middle_name);
                            $('#lnameres').val(data.last_name);
                            $('#suffixres').val(data.suffix);
                            $('#addressres').val(data.address + " Camarin Caloocan City");
                            $("#id_to_recordres").val(residentid);
                            $("#checkresidentres").val("0");
                            $("#RespondentImg").attr("src", "includes/img/resident_img/"+imagefile);
                            resultArrayofOtherResRespondent.push(residentid)



                        } else if (whatparty === 'complainant') {
                            $('#fname').val(data.first_name);
                            $('#mname').val(data.middle_name);
                            $('#lname').val(data.last_name);
                            $('#suffix').val(data.suffix);
                            $('#address').val(data.address + " Camarin Caloocan City");
                            $("#checkresident").val("0");
                            $('#id_to_record').val(residentid);
                            $("#ComplainantImg").attr("src", "includes/img/resident_img/"+imagefile);
                            resultArrayofOtherResComplainant.push(residentid)


                        } else if (whatparty == "othercomplainant"){
                            

                            if(countResidentComplainant <= 4){
                                console.log(countResidentComplainant)

                                if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Entry Already Selected',
                                        text: 'This person has already been selected. Please choose another one.',
                                        confirmButtonText: 'OK'
                                    });
                                  
                                }else{
                                    countResidentComplainant++
                                    var newContent = `
                                    <tr>
                                    <td hidden class="ResidentComplainant${countResidentComplainant}">`+residentid+`</td>
                                    <td><img src="includes/img/resident_img/${imagefile}" width="100 height="100""></td>
                                    <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                                    </tr>`;
    
                                    $('#ResidentComplainant').append(newContent);
                                    resultArrayofOtherResComplainant.push(residentid);
                                    
                                 
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
                        
                            if(countResidentRespondent <= 4){
                               if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){

                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Entry Already Selected',
                                        text: 'This person has already been selected. Please choose another one.',
                                        confirmButtonText: 'OK'
                                    });
                                  
                               }else{
                                   
                                    countResidentRespondent++
                                    var newContent = `
                                    <tr>
                                    <th hidden class="ResidentRespondent${countResidentRespondent}">`+residentid+`</th>
                                    <td><img src="includes/img/resident_img/${imagefile}" width="100 height="100"></td>
                                    <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                                    </tr>`;

                                    $('#ResidentRespondent').append(newContent);
                                    resultArrayofOtherResRespondent.push(residentid);
                                  
                               }
                            }else{
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'You reached the maxium allowed entries',
                                    text: 'If more people is involved, please use to the other input field.',
                                    confirmButtonText: 'OK'
                                });

                            }

                        }else{
                            alert("This should not run")
                        }

                        $('#selectresident').modal('hide');
          
                        var checkwhatresidentstatus = $("#checkresident").val();
                        var checkwhatresidentstatusres = $("#checkresidentres").val();
                        var existingcomp = $("#id_to_record").val()
                        var existingres = $("#id_to_recordres").val()


                        if (existingcomp == existingres && checkwhatresidentstatusres == checkwhatresidentstatus) {
                            // Entry already selected, notify the user
                            Swal.fire({
                                icon: 'warning',
                                title: 'Entry Already Selected',
                                text: 'This person has already been selected. Please choose another one.',
                                confirmButtonText: 'OK'
                            });

                            if(whatparty == "complainant"){

                                $('#fname, #mname, #lname, #suffix, #address, #checkresident, #id_to_record').val('');
                                $("#ComplainantImg").attr("src", "includes/img/blank-profile.webp");


                            }else if (whatparty == "respondent"){

                                $('#fnameres, #mnameres, #lnameres, #suffixres, #addressres, #id_to_recordres, #checkresidentres').val('');
                                $("#RespondentImg").attr("src", "includes/img/blank-profile.webp");

                            }else{
                                alert("this should not run")

                            }

                        }else{
                            if(existingcomp && existingres && checkwhatresidentstatusres && checkwhatresidentstatus){

                                $(".AddOtherPartyBtn").removeAttr('disabled');
    
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching resident details:', error);
                    }
                });
                
            });

           
        } else {
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
                    url: 'includes/fetch_nonres_res_details.php', 
                    type: 'POST',
                    data: { nresident_id: residentid, OPERATION: "NON_RESIDENT" },
                    success: function(response) {
                        var data = JSON.parse(response);

                        if (whatparty === 'respondent') {
                            $('#fnameres').val(data.first_name);
                            $('#mnameres').val(data.middle_name);
                            $('#lnameres').val(data.last_name);
                            $('#suffixres').val(data.suffix);
                            $('#addressres').val(data.address);
                            $("#id_to_recordres").val(residentid);
                            $("#checkresidentres").val("1");
                            $("#RespondentImg").attr("src", "includes/img/non_resident_img/"+imagefile);
                            resultArrayofOtherNonResRespondent.push(residentid)


                        } else if (whatparty === 'complainant') {
                            $('#fname').val(data.first_name);
                            $('#mname').val(data.middle_name);
                            $('#lname').val(data.last_name);
                            $('#suffix').val(data.suffix);
                            $('#address').val(data.address);
                            $("#checkresident").val("1");
                            $('#id_to_record').val(residentid);
                            $("#ComplainantImg").attr("src", "includes/img/non_resident_img/"+imagefile);
                            resultArrayofOtherNonResComplainant.push(residentid)



                        } else if (whatparty === "othercomplainant"){

                            if(countNonResidentComplainant <= 4){
                                if(!resultArrayofOtherResRespondent.includes(residentid) || !resultArrayofOtherResComplainant.includes(residentid)){
                                    
                                    countNonResidentComplainant++;

                                    var newContent = `
                                    <tr>
                                    <td class="complainant${countNonResidentComplainant}" hidden>`+residentid+`</td>
                                    <td><img src="includes/img/non_resident_img/${imagefile}" width="100 height="100"></td>
                                    <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                                    </tr>`;

                                    $('#NonResComplainant').append(newContent);
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
                          
                            if(countNonResidentRespondentNon <=4){
                                if(!resultArrayofOtherResRespondent.includes(residentid) || !resultArrayofOtherResComplainant.includes(residentid)){
                                    countNonResidentRespondent++;
                                    var newContent = `
                                        <tr>
                                        <td hidden class="nonrescomplainant${countNonResidentRespondent}">`+residentid+`</td>
                                        <td><img src="includes/img/non_resident_img/${imagefile}" width="100 height="100"></td>
                                        <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                                        </tr>`;

                                    $('#NonResRespondent').append(newContent);
                                    resultArrayofOtherNonResRespondent.push(residentid);
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
          
                        var checkwhatresidentstatus = $("#checkresident").val();
                        var checkwhatresidentstatusres = $("#checkresidentres").val();
                        var existingcomp = $("#id_to_record").val()
                        var existingres = $("#id_to_recordres").val()

                        if(existingcomp && existingres && checkwhatresidentstatusres && checkwhatresidentstatus){

                            $(".AddOtherPartyBtn").removeAttr('disabled');

                        }

                        if(whatparty == "complainant" || whatparty == "respondent"){
                            if (existingcomp == existingres && checkwhatresidentstatusres == checkwhatresidentstatus) {
                                // Entry already selected, notify the user
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Entry Already Selected',
                                    text: 'This person has already been selected. Please choose another one.',
                                    confirmButtonText: 'OK'
                                });

                                if(whatparty == "complainant"){

                                    $('#fname, #mname, #lname, #suffix, #address, #checkresident, #id_to_record').val('');
                                    $("#ComplainantImg").attr("src", "includes/img/blank-profile.webp");


                                }else if (whatparty == "respondent"){

                                    $('#fnameres, #mnameres, #lnameres, #suffixres, #addressres, #id_to_recordres, #checkresidentres').val('');
                                    $("#RespondentImg").attr("src", "includes/img/blank-profile.webp");

                                }else{
                                    alert("this should not run")

                                }

                            }
                        } else if(whatparty == "othercomplainant" || whatparty == "otherrespondent"){

                            if ((existingcomp == existingres) && (checkwhatresidentstatusres == checkwhatresidentstatus)) {
                                // Entry already selected, notify the user
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Entry Already Selected',
                                    text: 'This person has already been selected. Please choose another one.',
                                    confirmButtonText: 'OK'
                                });

                            }


                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching resident details:', error);
                    }
                });
                
            });
        }
    }
    
    // Event listener for row click
    $(".SelectResidentBtn, .SelectNonResidentBtn, .SelectNonResidentBtnRes, .SelectResidentBtnRes").click(function (e) { 
        e.preventDefault();
    
        var whatbutton = $(this).attr("id");
        var whatparty = $(this).data("whatparty");
    
        SelectResandNonResModal(whatbutton, whatparty)
    });

    //Event listener for the scheduling modal
    $("#pick_schedule_btn").click(function(){
        console.log("Pick Schdule has been triggered")

        $("#SelectScheduleModal").modal('show');
    })

    var calendar;

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

    $("#SelectScheduleModal").on('shown.bs.modal', function() {
        console.log("Select Schedule Modal has been triggered");
        var calendarEl = document.getElementById('calendar');
        
        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridDay,listMonth'
            },
            slotMinTime: '08:00:00',
            slotMaxTime: '18:00:00',
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5], 
                startTime: '08:00', 
                endTime: '17:00' 
            },
            selectable: true,
            allDaySlot: false,
            validRange: function(nowDate) {
                return {
                    start: nowDate 
                };
            },
            dateClick: function(info) {
                calendar.changeView('timeGridDay', info.date); 
            },
            select: function(info) {
                var startInput = $('#schedule_starttime');
                var endInput = $('#schedule_endtime');
                var dateInput = $('#schedule_date');
                var dt

                if(calendar.view.type === 'dayGridMonth'){
                    alert("Date: " + formatDate(info.start));
                    dateInput.val(formatDate(info.start));
                    $('#eventTime').focus(); 
                }

                if (calendar.view.type === 'timeGridDay') {
                    // Extract start and end times from the info object
                    var startTime = formatTime(info.start);
                    var endTime = formatTime(info.end);

                    // Update input fields with the formatted time
                    startInput.val(startTime);
                    endInput.val(endTime);
                    alert(startTime +' '+ endTime);

                    $('#SelectScheduleModal').modal('hide')
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
                            events.push({
                                id: blotter.blotter_id,
                                title: blotter.desc_incident,
                                incdate: blotter.incident_dt,
                                start: new Date (blotter.mediation_date),
                                end: blotter.date_of_resolution,
                                complainant: blotter.complainant_fullname,
                                respondent: blotter.respondent_fullname,
                                reportstatus: blotter.report_status,
                                color: blotter.schedule_color
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

                console.log(info.event.mediation_date);

                var report;
                switch (info.event.extendedProps.reportstatus){
                    case 1: report = "<span style='color: green;'> RESOLVED</span>"; break;
                    case 0: report = "<span style='color: orange;'> ONGOING</span>"; break;
                    case 2: report = "<span style='color: red;'> FILE TO ACTION</span>"; break;
                    default: report = "Unknown Status";
                }

                Swal.fire({
                    title: 'Blotter Details',
                    html: '<b>Blotter Description:</b> ' + info.event.title +
                          '<br><b>Date of Incident:</b> ' + formattedincident +
                          '<br><b>Complainant:</b> ' + info.event.extendedProps.complainant +
                          '<br><b>Respondent:</b> ' + info.event.extendedProps.respondent +
                          '<br><b>Mediation Date:</b> ' + formattedStart +
                          '<br><b>Report Status:</b> ' + report,
                    width: 700
                });
            }
        });

        calendar.render();
    });

    $("#SelectScheduleModal").on('hidden.bs.modal', function(){
        if(calendar){
            calendar.destroy();
            calendar = null;
            console.log("Calendar destroyed");
        }
    });

    $(".AddOtherPartyBtn").click(function(){
        var whatbtn = $(this).data("whatbtn");
        var whatparty = $(this).data("whatparty");

        SelectResandNonResModal(whatbtn, whatparty)
    })
   
});

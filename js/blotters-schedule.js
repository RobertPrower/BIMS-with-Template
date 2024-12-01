$(document).ready(function () {
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
    
                            events.push({
                                id: blotter.blotter_id,
                                title: blotter.desc_incident,
                                incdate: blotter.incident_dt,
                                start: new Date(mediation_date),
                                end: new Date(mediation_enddate),
                                complainant: blotter.complainant_fullname,
                                respondent: blotter.respondent_fullname,
                                report_status: blotter.report_status,
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
    
                var report;
                if (info.event.extendedProps.report_status == 1){
                    report = "<span style='color: green;'> RESOLVED</span>"; 
                }else if(info.event.extendedProps.report_status == 0){
                    report = "<span style='color: orange;'> ONGOING</span>"; 

                }else if(info.event.extendedProps.report_status == 2){               
                    report = "<span style='color: red;'> FILE TO ACTION</span>";
                    
                }else{
                    report = "Unknown Status";
                }
    
                Swal.fire({
                    title: 'Blotter Details',
                    html: '<b>Blotter Description:</b> ' + info.event.title +
                          '<br><b>Date of Incident:</b> ' + formattedincident +
                          '<br><b>Complainant:</b> ' + info.event.extendedProps.complainant +
                          '<br><b>Respondent:</b> ' + info.event.extendedProps.respondent +
                          '<br><b>Mediation Date:</b> ' + formattedStart +
                          '<br><b>Report Status:</b> ' + report
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
});

$(document).ready(function () {
    
    var whatmodal = ($(".main-title").text() == "Manage Blotters")? "#EditBlotterModal": '';  
    $(whatmodal +' #incident_date').tempusDominus({
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
          format: 'yyyy-MM-dd HH:mm:ss'  // Set your date and time format
        }
    });

    //Event listener for the scheduling modal
    $("#pick_schedule_btn").click(function(e){
        e.preventDefault()
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
       var whatmodal = ($("#EditBlotterModal").hasClass('show'))? '#EditBlotterModal': '';
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
                var startInput = $(whatmodal +' #schedule_starttime');
                var endInput = $(whatmodal+' #schedule_endtime');
                var dateInput = $(whatmodal+ ' #schedule_date');
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
                                start: new Date (blotter.mediation_schedule),
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
                          '<br><b>Report Status:</b> ' + report
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

    $("#mediator_name").one("click", function () {
        $.ajax({
            type: "POST",
            url: "includes/blottersoperation.php",
            data: {operation: "FETCH_MEDIATOR_SELECT"},
            dataType: "HTML",
            success: function (response) {

                $("#mediator_name").html(response);
            }
        });
    });

});
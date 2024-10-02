$(document).ready(function() {

    var selectedRowId = null;
    // Initialize DataTable when the modal is shown
    $('#selectresident').on('shown.bs.modal', function() {
    $('#ResidentTable').DataTable();
    });

    $('#selectnonresident').on('shown.bs.modal', function() {
        $('#NonResidentTable').DataTable();
    });
    // Event listener for row click
    $(document).on('click', '.ResidentTable tbody tr', function() {
        $(this).toggleClass("selected").siblings().removeClass("selected");
        var residentid = $(this).find("#resident_id").text();
        selectedRowId = $(this).find("#resident_id").text();
        $("#res_id").val(residentid);
        $("#checkresident").val("1");


        if (residentid) {
            // Make an AJAX request to fetch resident details
            $.ajax({
            url: 'includes/fetch_nonres_res_details.php', 
            type: 'POST',
            data:  { resident_id: residentid, OPERATION: "RESIDENT" },
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);

                // Populate the form fields on the main page
                $('#fname').val(data.first_name);
                $('#mname').val(data.middle_name);
                $('#lname').val(data.last_name);
                $('#suffix').val(data.suffix);
                $('#resident_id').val(data.residentid);


                // Close the modal
                $('#selectresident').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching resident details:', error);
            }
            });
        } else {
            alert('No Resident selected please check your code.');
        }
    });

    $(document).on('click', '.NonResidentTable tbody tr', function() {
        $(this).toggleClass("selected").siblings().removeClass("selected");
        var nresidentid = $(this).find("#nresident_id").text();
        selectedRowId = $(this).find("#nresident_id").text();
        $("#res_id").val(nresidentid);
        $("#checkresident").val("2");
        if (nresidentid) {
            // Make an AJAX request to fetch resident details
            $.ajax({
            url: 'includes/fetch_nonres_res_details.php', 
            type: 'POST',
            data:  { nresident_id: nresidentid, OPERATION: "NON_RESIDENT" },
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);

                // Populate the form fields on the main page
                $('#fname').val(data.first_name);
                $('#mname').val(data.middle_name);
                $('#lname').val(data.last_name);
                $('#suffix').val(data.suffix);

                // Close the modal
                $('#selectnonresident').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching resident details:', error);
            }
            });
        } else {
            alert('No Resident selected please check your code.');
        }
    });

    $("#business_type").change(function(){
        var selected_option = $(this).val();
        console.log("Event has been triggered");

        switch(selected_option){
            case "Others":
                $("#otherbusiness_type").prop("disabled", false);
            break;
            default:
                $("#otherbusiness_type").prop("disabled", true);
        }
    })

    $("#generate_certificate").click(function(event){
        event.preventDefault();

        var checkresident = $("#checkresident").val();
        var res_status = (checkresident =="2")? "NON_RESIDENT" : "RESIDENT";
        var nonresRes_id = $("#res_id").val();
        var first_name = $("#fname").val();
        var middle_name = $("#mname").val();
        var last_name = $("#lname").val();
        var suffix = $("#suffix").val();
        var presented_id = $("#presented_id").val();
        var id_num = $("#IDnum").val();
        var business_name = $("#business_name").val();
        var business_hnum = $("#business_hnum").val();
        var business_street = $("#business_street").val();
        var business_subd = $("#business_subd").val();

        console.log(res_status);
        console.log(nonresRes_id);

        switch($("#business_type").val()){
            case "Others":
                var business_type = $("#otherbusiness_type").val();
            break;
            default:
                var business_type = $("#business_type").val();   
        }

        $.ajax({
            type: "POST",
            url: "documents/generate-business-permit.php",
            data: {res_sta: res_status, id_to_record: nonresRes_id,first_name: first_name, middle_name: middle_name, last_name: last_name,
                suffix: suffix, presented_id: presented_id, id_num: id_num, business_name: business_name
                , business_hnum: business_hnum, business_street: business_street, business_subd:business_subd, business_type:business_type
            },
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                var filename = "documents/business_permits/"+response.file;
                console.log(filename);
                
                $("#generatepdf").attr("src", filename); 
      
                $("#pdfModal").modal("show");
            },error: function (xhr, status, error) {
                console.error("Error generating PDF:", error);
            },
        });

        
    })

});
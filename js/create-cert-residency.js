$(document).ready(function() {

    var selectedRowId = null;
    // Initialize DataTable when the modal is shown
    $('#selectresident').on('shown.bs.modal', function() {
    $('#ResidentTable').DataTable();
    });

    // Event listener for row click
    $(document).on('click', '.ResidentTable tbody tr', function() {
        $(this).toggleClass("selected").siblings().removeClass("selected");
        var residentid = $(this).find("#resident_id").text();
        selectedRowId = $(this).find("#resident_id").text();
        $("#res_id").val(residentid);

        if (residentid) {
            // Make an AJAX request to fetch resident details
            $.ajax({
            url: 'includes/fetch_resident_details.php', // PHP script to fetch resident details
            type: 'POST',
            data:  { id: residentid },
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);

                // Populate the form fields on the main page
                $('#fname').val(data.first_name);
                $('#mname').val(data.middle_name);
                $('#lname').val(data.last_name);
                $('#suffix').val(data.suffix);
                $('#address').val(data.address +" Camarin Caloocan City");
                $('#resident_since').val(data.resident_since);
                $('#resident_id').val(data.residentid);


                // Close the modal
                $('#selectresident').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching resident details:', error);
            }
            });
        } else {
            alert('Please select a resident.');
        }
    });

    $("#purpose").change(function(){
        var selected_option = $(this).val();
        console.log("Event has been triggered");

        switch(selected_option){
            case "Others":
                $("#otherpurpose").prop("disabled", false);
            break;
            default:
                $("#otherpurpose").prop("disabled", true);
        }
    })

    $("#generate_certificate").click(function(event){
        event.preventDefault();
        var res_id = $("#res_id").val();
        var first_name = $("#fname").val();
        var middle_name = $("#mname").val();
        var last_name = $("#lname").val();
        var suffix = $("#suffix").val();
        var address = $("#address").val();
        var r_since = $("#resident_since").val();
        var presented_id = $("#presented_id").val();
        var id_num = $("#IDnum").val();

        switch($("#purpose").val()){
            case "Others":
                var purpose = $("#otherpurpose").val();
            break;
            default:
                var purpose = $("#purpose").val();
                
        }
        $.ajax({
            url: "documents/generate-residency.php",
            type: "POST",
            dataType:"JSON",
            data:{
                resident_no : res_id,
                firstname : first_name,
                middlename : middle_name,
                lastname : last_name,
                suffix : suffix,
                address : address,
                r_since: r_since,
                presented_id : presented_id,
                IDnum : id_num,
                purpose: purpose
            },
            success: function(response){
                var filename = "documents/"+response.file;
                console.log(filename);
                
                $("#generatepdf").attr("src", filename); 
      
                $("#pdfModal").modal("show");
            },
            error: function (xhr, status, error) {
                console.error("Error generating PDF:", error);
            },
        });
    })

});
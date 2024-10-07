$(document).ready(function() {

    var whatcert = $(".main-title").text();

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
            url: 'includes/fetch_nonres_res_details.php', // PHP script to fetch resident details
            type: 'POST',
            data:  { resident_id: residentid, OPERATION:"RESIDENT" },
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

    $("#agency").change(function(){
        var selected_option = $(this).val();
        console.log("Event has been triggered");

        switch(selected_option){
            case "Others":
                $("#otheragency").prop("disabled", false);
            break;
            default:
                $("#otheragency").prop("disabled", true);
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
        var agency = $("#agency").val();

        switch($("#purpose").val()){
            case "Others":
                var purpose = $("#otherpurpose").val();
            break;
            default:
                var purpose = $("#purpose").val();   
        }
        
        switch($("#agency").val()){
            case "Others":
                var agency = $("#otheragency").val();
            break;
            default:
                var agency = $("#agency").val();   
        }

        Swal.fire({
            title: 'Loading...',
            html: '<p>Generating Document, Please Wait.</p>',
            imageUrl: 'img/loading.gif', 
            imageWidth: 100, 
            imageHeight: 100, 
            showConfirmButton: false,
            allowOutsideClick: false 
        });

        if(whatcert == "Create Certificate of Indigency"){
            $.ajax({
                url: "documents/generate-indigency-tcpdf.php",
                type: "POST",
                dataType:"JSON",
                data:{
                    residentno : res_id,
                    first_name : first_name,
                    middle_name : middle_name,
                    last_name : last_name,
                    suffix : suffix,
                    address : address,
                    r_since: r_since,
                    presented_id : presented_id,
                    id_num : id_num,
                    purpose: purpose,
                    agency: agency
                },
                success: function(response){
                    var filename = "documents/certificate_of_indigency/"+response.file;
                    console.log(filename);
                    
                    $("#generatepdf").attr("src", filename); 
          
                    $("#pdfModal").modal("show");

                    $('#pdfModal').on('shown.bs.modal', function () {
                        Swal.close(); 
                    });   
                },
                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        }else if(whatcert == "Create Certificate of Residency"){
            $.ajax({
                url: "documents/generate-residency-tcpdf.php",
                type: "POST",
                dataType:"JSON",
                data:{
                    residentno : res_id,
                    first_name : first_name,
                    middle_name : middle_name,
                    last_name : last_name,
                    suffix : suffix,
                    address : address,
                    r_since: r_since,
                    presented_id : presented_id,
                    id_num : id_num,
                    purpose: purpose
                },
                success: function(response){
                    var filename = "documents/certificate_of_residency/"+response.file;
                    console.log(filename);

                    $("#generatepdf").attr("src", filename); 

                    $("#pdfModal").modal("show");

                    $('#pdfModal').on('shown.bs.modal', function () {
                        Swal.close(); 
                    });                    
                          
                },
                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        }else if(whatcert == "Create Certificate of Good Moral"){
            $.ajax({
                url: "documents/generate-good-moral-tcpdf.php",
                type: "POST",
                dataType:"JSON",
                data:{
                    residentno : res_id,
                    first_name : first_name,
                    middle_name : middle_name,
                    last_name : last_name,
                    suffix : suffix,
                    address : address,
                    presented_id : presented_id,
                    id_num : id_num,
                    purpose: purpose
                },
                success: function(response){
                    var filename = "documents/certificate_of_good_moral/"+response.file;
                    console.log(filename);

                    $("#generatepdf").attr("src", filename); 
          
                    $("#pdfModal").modal("show");

                    $('#pdfModal').on('shown.bs.modal', function () {
                        Swal.close(); 
                    });   
                    
                },
                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        }else if(whatcert == "Create Certificate of First Time Job Seeker"){
            $.ajax({
                url: "documents/generate-FTJS-tcpdf.php",
                type: "POST",
                dataType:"JSON",
                data:{
                    residentno : res_id,
                    first_name : first_name,
                    middle_name : middle_name,
                    last_name : last_name,
                    suffix : suffix,
                    address : address,
                    r_since: r_since,
                    presented_id : presented_id,
                    id_num : id_num,
                },
                success: function(response){
                    var filename = "documents/first_time_job_seeker/"+response.file;
                    console.log(filename);

                    $("#generatepdf").attr("src", filename); 
          
                    $("#pdfModal").modal("show");

                    $('#pdfModal').on('shown.bs.modal', function () {
                        Swal.close(); 
                    });   
                    
                },
                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        }
    })

});
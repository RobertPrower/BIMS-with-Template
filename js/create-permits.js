$(document).ready(function() {

    var selectedRowId = null;
    var currenttable
    // Initialize DataTable when the modal is shown
    $('#selectresident').on('shown.bs.modal', function() {
        currenttable = $('#ResidentTable').DataTable({
            ajax: {
                url: 'includes/modaloperation.php', 
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
                }],
                responsive: true,
                scrollX: true,
                lengthChange: false,
                autoWidth: false, 
                pageLength: 5   
        });
    });

    $('#selectnonresident').on('shown.bs.modal', function() {
       $('#NonResidentTable').DataTable({
            ajax: {
                url: 'includes/modaloperation.php', 
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
                        return '<img src="includes/img/non_resident_img/' + data + '" alt="Image" class="img-thumbnail" style="width: 100px; height: 100px;object-fit: cover; max-width: 100%; max-height: 100%;">';
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
    });

    $("#selectresident, #selectnonresident").on('hide.bs.modal', function () {

         var table = $('#ResidentTable, #NonResidentTable').DataTable();
            table.destroy().destroy;
         console.log("hidden event has been triggered");

    });
    // Event listener for row click
    $(document).on('click', '.ResidentTable tbody tr', function() {
        $(this).toggleClass("selected").siblings().removeClass("selected");
        var table = $("#ResidentTable").DataTable();
        var rowData = table.row(this).data();
        var residentid = rowData.resident_id; 
        selectedRowId = residentid;
        $("#id_to_record").val(residentid);
        $("#checkresident").val("1");

        if (residentid) {
            // Make an AJAX request to fetch resident details
            $.ajax({
            url: 'includes/modaloperation.php', 
            type: 'POST',
            data:  { resident_id: residentid, operation: "FETCH_RESIDENT_DETAILS" },
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);

                // Populate the form fields on the main page
                $('#fname').val(data.first_name);
                $('#mname').val(data.middle_name);
                $('#lname').val(data.last_name);
                $('#suffix').val(data.suffix);
                $('#address').val(data.address +" Camarin Caloocan City");
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
        var table = $('#NonResidentTable').DataTable();
        var data = table.row(this).data();
        var rowData = table.row(this).data();
        var nresidentid = rowData.nresident_id;
        selectedRowId = nresidentid;
        $("#id_to_record").val(nresidentid);
        $("#checkresident").val("2");
        if (nresidentid) {
            // Make an AJAX request to fetch resident details
            $.ajax({
            url: 'includes/modaloperation.php', 
            type: 'POST',
            data:  { nresident_id: nresidentid, operation: "FETCH_NON_RESIDENT_DETAILS" },
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);

                // Populate the form fields on the main page
                $('#fname').val(data.first_name);
                $('#mname').val(data.middle_name);
                $('#lname').val(data.last_name);
                $('#suffix').val(data.suffix);
                $('#address').val(data.address);


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

    $("#maker").change(function(){
        var selected_option = $(this).val();
        console.log("Event has been triggered");

        switch(selected_option){
            case "Others":
                $("#others").prop("disabled", false);
            break;
            default:
                $("#others").prop("disabled", true);
        }
    })

    $("#generate_certificate").click(function(event){
        event.preventDefault();

        var whatcert = $(".main-title").text();
        var checkresident = $("#checkresident").val();
        var res_status = (checkresident =="2")? "NON_RESIDENT" : "RESIDENT";
        var id_to_record = $("#id_to_record").val();
        var first_name = $("#fname").val();
        var middle_name = $("#mname").val();
        var last_name = $("#lname").val();
        var suffix = $("#suffix").val();
        var presented_id = $("#presented_id").val();
        var id_num = $("#IDnum").val();

        Swal.fire({
            title: 'Loading...',
            html: '<p>Generating Document, Please Wait.</p>',
            imageUrl: 'img/loading.gif', 
            imageWidth: 100, 
            imageHeight: 100, 
            showConfirmButton: false,
            allowOutsideClick: false 
        });

        if(id_to_record){
            if(whatcert == "Create Business Permit"){
                var business_name = $("#business_name").val();
                var business_hnum = $("#business_hnum").val();
                var business_street = $("#business_street").val();
                var business_subd = $("#business_subd").val();
        
                console.log(res_status);
                console.log(id_to_record);
        
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
                    data: {res_sta: res_status, id_to_record: id_to_record,first_name: first_name, middle_name: middle_name, last_name: last_name,
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

                        $('#pdfModal').on('shown.bs.modal', function () {
                            Swal.close(); 
                        });   
                    },error: function (xhr, status, error) {
                        console.error("Error generating PDF:", error);
                        Swal.close(); 

                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    },
                });
            }else if(whatcert == "Create Building Permits"){

                var house_num = $("#house_no").val();
                var street = $("#street").val();
                var subd = $("#subd").val();
                var purpose = $("#purpose").val();
                var address = $("#address").val();


                $.ajax({
                    url: "documents/generate-building-permit.php",
                    type: "POST",
                    dataType:"JSON",
                    data:{
                        id_to_record : id_to_record,
                        res_sta: res_status,
                        first_name : first_name,
                        middle_name : middle_name,
                        last_name : last_name,
                        suffix : suffix,
                        address : address,
                        presented_id : presented_id,
                        id_num : id_num,
                        house_num: house_num,
                        street: street,
                        subd: subd,
                        purpose: purpose
                    },
                    success: function(response){
                        var filename = "documents/building_permits/"+response.file;
                        console.log(filename);

                        $("#generatepdf").attr("src", filename); 
                
                        $("#pdfModal").modal("show");

                        $('#pdfModal').on('shown.bs.modal', function () {
                            Swal.close(); 
                        });   
                    },
                    error: function (xhr, status, error) {
                        console.error("Error generating PDF:", error);
                        Swal.close(); 

                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    },
                });
                
            }else if(whatcert == "Create Excavation Permits"){

                var house_num = $("#house_no").val();
                var street = $("#street").val();
                var subd = $("#subd").val();
                var purpose = $("#purpose").val();
                var address = $("#address").val();


                $.ajax({
                    url: "documents/generate-excavation-permit.php",
                    type: "POST",
                    dataType:"JSON",
                    data:{
                        id_to_record : id_to_record,
                        res_sta: res_status,
                        first_name : first_name,
                        middle_name : middle_name,
                        last_name : last_name,
                        suffix : suffix,
                        address : address,
                        presented_id : presented_id,
                        id_num : id_num,
                        house_num: house_num,
                        street: street,
                        subd: subd,
                        purpose: purpose
                    },
                    success: function(response){
                        var filename = "documents/excavation_permits/"+response.file;
                        console.log(filename);

                        $("#generatepdf").attr("src", filename); 
                
                        $("#pdfModal").modal("show");

                        $('#pdfModal').on('shown.bs.modal', function () {
                            Swal.close(); 
                        });   
                    },
                    error: function (xhr, status, error) {
                        console.error("Error generating PDF:", error);
                        Swal.close(); 

                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    },
                });
                
            }else if(whatcert == "Create Fencing Permits"){

                var house_num = $("#house_no").val();
                var street = $("#street").val();
                var subd = $("#subd").val();
                var purpose = $("#purpose").val();
                var address = $("#address").val();


                $.ajax({
                    url: "documents/generate-fencing-permit.php",
                    type: "POST",
                    dataType:"JSON",
                    data:{
                        id_to_record : id_to_record,
                        res_sta: res_status,
                        first_name : first_name,
                        middle_name : middle_name,
                        last_name : last_name,
                        suffix : suffix,
                        address : address,
                        presented_id : presented_id,
                        id_num : id_num,
                        house_num: house_num,
                        street: street,
                        subd: subd,
                        purpose: purpose
                    },
                    success: function(response){
                        var filename = "documents/fencing_permits/"+response.file;
                        console.log(filename);

                        $("#generatepdf").attr("src", filename); 
                
                        $("#pdfModal").modal("show");

                        $('#pdfModal').on('shown.bs.modal', function () {
                            Swal.close(); 
                        });   
                    },
                    error: function (xhr, status, error) {
                        console.error("Error generating PDF:", error);
                        Swal.close(); 

                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    },
                });
                
            }else if(whatcert == "Create Tricycle Pedicab Regulatory Services"){

                var toda = $("#toda").val();
                var route =$("#route").val();
                var plate_no = $("#plate_no").val();
                var chasis_no = $("#chasis_no").val();
                var engine_no = $("#engine_no").val();

                switch($("#maker").val()){
                    case "Others":
                        var maker = $("#other").val();
                    break;
                    default:
                        var maker = $("#maker").val(); 
                }


                $.ajax({
                    url: "documents/generate-tprs-tcpdf.php",
                    type: "POST",
                    dataType:"JSON",
                    data:{
                        id_to_record : id_to_record,
                        res_sta: res_status,
                        first_name : first_name,
                        middle_name : middle_name,
                        last_name : last_name,
                        suffix : suffix,
                        address : address,
                        presented_id : presented_id,
                        id_num : id_num,
                        toda: toda,
                        route: route,
                        plate_no: plate_no,
                        chasis_no: chasis_no,
                        maker: maker,
                        engine_no: engine_no
                    },
                    success: function(response){
                        var filename = "documents/tprs/"+response.file;
                        console.log(filename);

                        $("#generatepdf").attr("src", filename); 
                
                        $("#pdfModal").modal("show");

                        $('#pdfModal').on('shown.bs.modal', function () {
                            Swal.close(); 
                        });   
                    },
                    error: function (xhr, status, error) {
                        console.error("Error generating PDF:", error);
                        Swal.close(); 

                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    },
                });
                
            }
        }else{
            Swal.close(); 

            Swal.fire({
                icon: "error",
                title: "No Resident or Non Resident Selected",
                text: "Please select a Resident or Non Resident.",
              });
        }
        
    })

});
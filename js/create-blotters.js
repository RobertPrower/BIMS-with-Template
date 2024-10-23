
$(document).ready(function(){

    
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
    
    // Event listener for row click
    $(".SelectResidentBtn, .SelectNonResidentBtn, .SelectNonResidentBtnRes, .SelectResidentBtnRes").click(function (e) { 
        e.preventDefault();
        console.log("Select Event has been triggered");

        var whatbutton = $(this).attr("id");
        var whatparty = $(this).data('whatparty');
        console.log(whatbutton);

        if (whatbutton === "SelectResident") {
            $("#selectresident").modal('show');

            $(document).on('click', '.ResidentTable tbody tr', function() {
                $(this).toggleClass("selected").siblings().removeClass("selected");
                
                var table = $('.ResidentTable').DataTable();
                
                var rowData = table.row(this).data();
                
                var residentid = rowData.resident_id; 
                selectedRowId = residentid;
        
                if (residentid) {
                    // Make an AJAX request to fetch resident details
                    $.ajax({
                        url: 'includes/fetch_nonres_res_details.php', 
                        type: 'POST',
                        data: { resident_id: residentid, OPERATION: "RESIDENT" },
                        success: function(response) {
                            var data = JSON.parse(response);
                            console.log(whatparty);
                            
                            if (whatparty == "respondent") {
                                $('#fnameres').val(data.first_name);
                                $('#mnameres').val(data.middle_name);
                                $('#lnameres').val(data.last_name);
                                $('#suffixres').val(data.suffix);
                                $('#addressres').val(data.address + " Camarin Caloocan City");
                                $('#resident_idres').val(residentid);
                                $("#id_to_recordres").val(residentid);
                                $("#checkresidentres").val("1");
                            } else if (whatparty === "complainant") {
                                // Populate the form fields on the main page
                                $('#fname').val(data.first_name);
                                $('#mname').val(data.middle_name);
                                $('#lname').val(data.last_name);
                                $('#suffix').val(data.suffix);
                                $('#address').val(data.address + " Camarin Caloocan City");
                                $('#resident_id').val(data.residentid);
                                $("#checkresident").val("1");
                            } else {
                                alert("This should not run!!!");
                            }
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
        } else {
            $("#selectnonresident").modal('show');
        }
    });

    

    $(document).on('click', '.NonResidentTable tbody tr', function() {
        $(this).toggleClass("selected").siblings().removeClass("selected");
        
        var table = $('.NonResidentTable').DataTable();
        
        var rowData = table.row(this).data();
        
        var nresidentid = rowData.nresident_id; 
        var whatparty = $(this).data("whatparty");
        selectedRowId = nresidentid;

        if (nresidentid) {
            // Make an AJAX request to fetch resident details
            $.ajax({
                url: 'includes/fetch_nonres_res_details.php', 
                type: 'POST',
                data: { nresident_id: nresidentid, OPERATION: "NON_RESIDENT" },
                success: function(response) {
                    var data = JSON.parse(response);
                    var whatparty = $(".SelectResident, .SelectNonResident, .SelectResident4Res, .SelectNonResident4Res").data("whatparty");
                    
                    if (whatparty == "respondent") {
                        $('#fnameres').val(data.first_name);
                        $('#mnameres').val(data.middle_name);
                        $('#lnameres').val(data.last_name);
                        $('#suffixres').val(data.suffix);
                        $('#addressres').val(data.address);
                        $("#id_to_recordres").val(nresidentid);
                        $("#checkresidentres").val("2");
                    } else {
                        // Populate the form fields on the main page
                        $('#fname').val(data.first_name);
                        $('#mname').val(data.middle_name);
                        $('#lname').val(data.last_name);
                        $('#suffix').val(data.suffix);
                        $('#address').val(data.address);
                        $('#resident_id').val(data.residentid);
                        $("#id_to_record").val(nresidentid);
                        $("#checkresident").val("2");
                    }
                    // Close the modal
                    $('#selectnonresident').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching resident details:', error);
                }
            });
        } else {
            alert('No Non Resident selected please check your code.');
        }
    });
});

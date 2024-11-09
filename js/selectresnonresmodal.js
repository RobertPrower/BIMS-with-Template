$(document).ready(function () {
    // Initialize DataTable when the modal is shown
    $('#selectresident').on('shown.bs.modal', function() {
        console.log("Select Resident has been loaded");
        if (!$.fn.DataTable.isDataTable('#ResidentTable')) {
            $('#ResidentTable').DataTable({
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
});
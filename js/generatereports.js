$(document).ready(function () {

    $("input[name='start_date']").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
    });

    $("input[name='end_date']").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
    });

    var table = $('#ResidentTable').DataTable({
        dom: '<"d-flex justify-content-between"Bl>t<"d-flex justify-content-between"ip>', // This defines the placement of buttons
                buttons: [
                    {
                        extend: 'excelHtml5', 
                        text: 'Export to Excel', 
                        title: 'MyExportedData' 
                    }
                ],
        ajax: {
            url: 'includes/generatereportoperation.php', 
            dataSrc: '',
            type: 'POST',
            data: function(d) {
                d.OPERATION = "TABLE_LOAD"; 
            }
        },
        columns: [
            { data: 'request_id', visible: false }, 
            { data: 'date_issued', className: "text-center", width: "15%" },
            { data: 'expiration', className: "text-center" },
            {
                data: 'is_resident',
                render: function(data, type, row) {
                    return data == '1' 
                        ? '<td>Resident </td>' 
                        : '<td>Non-Resident<td>';
                },
                className: "text-center"
            },
            { data: null, render: function(data, type, row) {
                return row.last_name + ' ' + row.first_name + ' ' +row.middle_name + '' + row.suffix;
            },className: "text-center" },
            { data: null,render: function(data, type, row) {
                return row.house_num + ' ' + row.street + ' ' +row.subdivision + '' + row.city;
            }, className: "text-center" },
            { data: 'document_desc', className: "text-center", width:"12%" },
            { data: 'purpose', className: "text-center" },
            {
                data: 'status', // The status field from the row data
                render: function(data, type, row) {
                    switch (data) {
                        case 0:
                            return "<td><span class='badge badge-success'>ACTIVE</span></td>";
                        case 1:
                            return "<td><span class='badge badge-disabled'>EXPIRED</span></td>";
                        case 2:
                            return "<td><span class='badge badge-trashed'>REVOKED</span></td>";
                        default:
                            return "<td>Unknown Status</td>";
                    }
                },
                title: 'Status' // Column title
            }
        
            ],
            responsive: true,
            scrollX: true,
            lengthChange: false,
            autoWidth: false, 
            pageLength: 10   

    });

    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = $('#start_date').val();
            var max = $('#end_date').val();
            var date = data[1];

            if ((min === '' && max === '') || 
                (min === '' && date <= max) || 
                (min <= date && max === '') || 
                (min <= date && date <= max)) {
                return true;
            }
            return false;
        }
    );

    $('#sortbtn').click(function(e) {
        e.preventDefault()
        table.draw(); 
    });

    $('#certselect').change(function() {

        var filterValue = $('#certselect').val();

        if(filterValue == "*"){
            table.column(6).search('').draw();
        }else{
            table.column(6).search(filterValue).draw();
        }
    });
});
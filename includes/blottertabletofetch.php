<?php
foreach($result as $row){

echo '<tr>';
//echo '<td hidden id="resident_id">' . htmlspecialchars($row['blotter_id']) . '</td>';

    switch ($row['blotter_type']){
    case 0: echo "<td>Blotter</td>";
    break;  
    case 1: echo "<td>Incident</td>";
    break;
    default: echo "<td> Unknown Status </td>";   
    }     

echo '<td>' . htmlspecialchars($row['blotter_add_dt']) . '</td>';
echo '<td>' . htmlspecialchars($row['incident_dt']) . '</td>';
echo '<td>' . htmlspecialchars($row['desc_incident']) . '</td>';
echo '<td>' . htmlspecialchars($row['complainant_last_name']) .', '. htmlspecialchars($row['complainant_first_name']) .' 
'. htmlspecialchars($row['complainant_middle_name']) .' '. htmlspecialchars($row['complainant_suffix']) . '</td>';
echo '<td>' . htmlspecialchars($row['respondent_last_name']) .', '. htmlspecialchars($row['respondent_first_name']) .'
 '. htmlspecialchars($row['respondent_middle_name']) .' '. htmlspecialchars($row['respondent_suffix']) . '</td>';
     
switch ($row['report_status']){
case 0: echo "<td><span class='badge-pending'>ONGOING</span> </td>";
break;
case 1: echo "<td><span class='badge-success'>RESOLVED</span></td>";
break;
case 2: echo "<td> <span class='badge-trashed'>FILE TO ACTION</span></td>";
break;
default: echo "<td> Unknown Status </td>";
} 

echo '<td>
<div class="btn-group text-center">
        
    <button class="btn btn-primary mx-1 viewbtn"
        data-whatoperation = "view"
        data-complainant_first_name = "'.htmlspecialchars($row['complainant_first_name']).'"
        data-complainant_last_name = "'.htmlspecialchars($row['complainant_last_name']).'"
        data-complainant_middle_name = "'.htmlspecialchars($row['complainant_middle_name']).'"
        data-complainant_suffix = "'.htmlspecialchars($row['complainant_suffix']).'"
        data-complainant_address = "'.htmlspecialchars($row['complainant_address']).'"

        data-respondent_first_name = "'.htmlspecialchars($row['respondent_first_name']).'"
        data-respondent_last_name = "'.htmlspecialchars($row['respondent_last_name']).'"
        data-respondent_middle_name = "'.htmlspecialchars($row['respondent_middle_name']).'"
        data-respondent_suffix = "'.htmlspecialchars($row['respondent_suffix']).'"
        data-respondent_address = "'.htmlspecialchars($row['respondent_address']).'"

        data-complainant_no = "'.htmlspecialchars($row['complainant_no']).'"
        data-complainant_status = "'.htmlspecialchars($row['complainant_status']).'"
        data-respondent_no = "'.htmlspecialchars($row['respondent_no']).'"
        data-respondent_status = "'.htmlspecialchars($row['respondent_status']).'"
        data-complainant_filename = "'.htmlspecialchars($row['complainant_filename']).'";
        data-respondent_filename = "'.htmlspecialchars($row['respondent_filename']).'";
        data-blotter_id = "'.htmlspecialchars($row['blotter_id']).'"
        data-bs-toggle="modal" data-bs-target="#ViewBlotterModal">View
    </button>

    <button class="btn btn-success mx-1 editbtn" id="ebutton"
        data-whatoperation = "edit"
        data-complainant_first_name = "'.htmlspecialchars($row['complainant_first_name']).'"
        data-complainant_last_name = "'.htmlspecialchars($row['complainant_last_name']).'"
        data-complainant_middle_name = "'.htmlspecialchars($row['complainant_middle_name']).'"
        data-complainant_suffix = "'.htmlspecialchars($row['complainant_suffix']).'"
        data-complainant_address = "'.htmlspecialchars($row['complainant_address']).'"

        data-respondent_first_name = "'.htmlspecialchars($row['respondent_first_name']).'"
        data-respondent_last_name = "'.htmlspecialchars($row['respondent_last_name']).'"
        data-respondent_middle_name = "'.htmlspecialchars($row['respondent_middle_name']).'"
        data-respondent_suffix = "'.htmlspecialchars($row['respondent_suffix']).'"
        data-respondent_address = "'.htmlspecialchars($row['respondent_address']).'"

        data-complainant_no = "'.htmlspecialchars($row['complainant_no']).'"
        data-complainant_status = "'.htmlspecialchars($row['complainant_status']).'"
        data-respondent_no = "'.htmlspecialchars($row['respondent_no']).'"
        data-respondent_status = "'.htmlspecialchars($row['respondent_status']).'"
        data-complainant_filename = "'.htmlspecialchars($row['complainant_filename']).'";
        data-respondent_filename = "'.htmlspecialchars($row['respondent_filename']).'";
        data-blotter_id = "'.htmlspecialchars($row['blotter_id']).'"

        data-bs-toggle="modal" data-bs-target="#EditBlotterModal">Edit</button>';

    if($dept==="Admin"){
        if($row['is_deleted'] == "0"){ 
            echo '<button class="btn btn-danger mx-1 deletebtn" id="deletebtn"
                data-pageno=""
                data-id = "' . htmlspecialchars($row['blotter_id']) . '">Delete</button>';
        
        }else{
            echo '<button class="btn btn-warning mx-1" id="undodeletebutton"
            data-pageno="'.$page.'"
            data-blotter_id = "' . htmlspecialchars($row['blotter_id']) . '">Recover</button>';
        }
    }
echo '</tr>';
}
?>
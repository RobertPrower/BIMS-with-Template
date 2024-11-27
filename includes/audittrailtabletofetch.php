<?php 
require_once 'config.php';
require_once 'enforce_login.php';

foreach ($results as $row) {
    switch($row['dept_no']){
        case 1: 
            $department = "Clearance";
        break;
        case 2:
            $department = "Secretariat";
        break;
        case 3:
            $department = "Blotter";
        break;
        case 4:
            $department = "Admin"; 
        break; 
        default:
            $department = "Unknown";
    }

    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['event_dt']) . '</td>';
    echo '<td><img src="includes/img/users_img/' . htmlspecialchars($row['img_filename']) . '" style="width: 100px !important; height: 100px !important;"></td>';
    echo '<td>' . htmlspecialchars($row['lname']) . ', ' . htmlspecialchars($row['fname']) . ' ' . htmlspecialchars($row['mname']) . ' ' . htmlspecialchars($row['suffix']) . '</td>';
    echo '<td class="text-center">' . htmlspecialchars($row['username']) . '</td>';
    echo '<td>' . $department . '</td>';
    echo '<td>' . htmlspecialchars($row['operation']) . '</td>';


    echo '<td style="width: 35%;">
    <div class="btn-group text-center">
            
        <button class="btn btn-primary mx-1 viewResidentButton" id=vbutton
            data-id="' . htmlspecialchars($row['entry_id']) . '"
            data-bs-toggle="modal" data-bs-target="#ViewResidentModal">View Changes</button>';

        
    
}      
    echo '</div>
    </td>
</tr>';
?>
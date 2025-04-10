<?php 

foreach ($results as $row) {
 
    switch($row['depart_no']){
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
    echo '<td>' . htmlspecialchars($row['action_timestamp']) . '</td>';
    echo '<td><img src="includes/img/users_img/' . htmlspecialchars($row['img_filename']) . '" style="width: 100px !important; height: 100px !important;"></td>';
    echo '<td>' . htmlspecialchars($row['fullname']).'</td>';
    echo '<td class="text-center">' . htmlspecialchars($row['username']) . '</td>';
    echo '<td>' . $department . '</td>';
    echo '<td>' . htmlspecialchars($row['action_type']) . '</td>';


    echo '<td style="width: 35%;">
    <div class="btn-group text-center">';

    if($row['action_type'] == "UPDATE"){

        echo '
        
         <button class="btn btn-secondary mx-1 viewOldButton" id=vbutton
            data-id="' . htmlspecialchars($row['audit_id']) . '"

            ';

            if(isset($forblotter)){
                echo ' data-blotter_id="' . htmlspecialchars($row['audit_id']) . '"';
            }
            
            echo'>Old
        </button>
        
        <button class="btn btn-success mx-1 viewNewButton" id=vbutton2
            data-id="' . htmlspecialchars($row['audit_id']) . '"
            
                   ';

            if(isset($forblotter)){
                echo ' data-blotter_id="' . htmlspecialchars($row['audit_id']) . '"';
            }
            
            echo'>New
        </button>
        ';

    } else if($row['action_type'] == "INSERT"){

        echo' <button class="btn btn-primary mx-1 viewNewEntryButton" id=vbutton2
            data-id="' . htmlspecialchars($row['audit_id']) . '"
                   ';

            if(isset($forblotter)){
                echo ' data-blotter_id="' . htmlspecialchars($row['audit_id']) . '"';
            }
            
            echo'>View
        </button>';

    } else if($row['action_type'] == "RECOVER"){

        echo' <button class="btn btn-warning mx-1 viewRecoverButton" id=vbutton2
            data-id="' . htmlspecialchars($row['audit_id']) . '"
                   ';

            if(isset($forblotter)){
                echo ' data-blotter_id="' . htmlspecialchars($row['audit_id']) . '"';
            }
            
            echo'>View
        </button>';

    }else if($row['action_type'] == "DELETE"){

        echo' <button class="btn btn-danger mx-1 viewDeleteButton" id=vbutton2
            data-id="' . htmlspecialchars($row['audit_id']) . '"
                   ';

            if(isset($forblotter)){
                echo ' data-blotter_id="' . htmlspecialchars($row['audit_id']) . '"';
            }
            
            echo'>View Entry
        </button>';

    }    
    
}      
    echo '</div>
    </td>
</tr>';
?>
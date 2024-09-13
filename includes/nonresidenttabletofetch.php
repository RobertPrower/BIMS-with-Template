<?php 

foreach ($results as $row) {
    $subd = (empty($row['subdivision'])) ? "" : ", " . htmlspecialchars($row['subdivision']) ;
    echo '<tr>';
    echo '<td hidden id="nresident_id">' . htmlspecialchars($row['nresident_id']) . '</td>';
    echo '<td>' . htmlspecialchars($row['date_recorded']) . '</td>';
    echo '<td>' . htmlspecialchars($row['last_name']) . ', ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['middle_name']) . ' ' . htmlspecialchars($row['suffix']) . '</td>';
    echo '<td>' . htmlspecialchars($row['house_no']) . ', ' . htmlspecialchars($row['street']) . $subd . '</td>';
    echo '<td class="text-center">' . htmlspecialchars($row['district_brgy']) . '</td>';
    echo '<td>' . htmlspecialchars($row['city']) . '</td>';
    echo '<td>' . htmlspecialchars($row['sex']) . '</td>';
    echo '<td>' . htmlspecialchars($row['birth_date']) . '</td>';
    echo '<td>' . htmlspecialchars($row['birth_place']) . '</td>';
    echo '<td class="text-center">' . htmlspecialchars($row['cellphone_num']) . '</td>';
    echo '<td>' . htmlspecialchars($row['audit_trail_no']) . '</td>';
    echo '<td>' . ($row['is_a_voter'] ? 'YES' : 'NO') . '</td>';

    if(!isset($Isforcert)){
        echo '<td style="width: 35%;">
        <div class="btn-group text-center">
                
            <button class="btn btn-primary mx-1 viewResidentButton" id=vbutton
                data-id="' . htmlspecialchars($row['nresident_id']) . '"
                data-last-name="' . htmlspecialchars($row['last_name'], ENT_QUOTES) . '"
                data-first-name="' . htmlspecialchars($row['first_name'], ENT_QUOTES) . '"
                data-middle-name="' . htmlspecialchars($row['middle_name'], ENT_QUOTES) . '"
                data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
                data-house-no="' . htmlspecialchars($row['house_no'], ENT_QUOTES) . '"
                data-street-name="' . htmlspecialchars($row['street'], ENT_QUOTES) . '"
                data-subdivision="' . htmlspecialchars($row['subdivision'], ENT_QUOTES) . '"
                data-district-brgy="' . htmlspecialchars($row['district_brgy'], ENT_QUOTES) . '"
                data-city="' . htmlspecialchars($row['city'], ENT_QUOTES) . '"
                data-sex="' . htmlspecialchars($row['sex'], ENT_QUOTES) . '"
                data-birth-date="' . htmlspecialchars($row['birth_date'], ENT_QUOTES) . '"
                data-contact-num="' . htmlspecialchars($row['contact_num'], ENT_QUOTES) . '"
                data-audit-trail-num="' . htmlspecialchars($row['audit_trail_no'], ENT_QUOTES) . '"
                data-bs-toggle="modal" data-bs-target="#ViewResidentModal">View</button>';

            if($row['is_deleted'] == "0"){
                echo '<button class="btn btn-success mx-1 editResidentButton"
                data-pageno="'.$page.'"
                data-id="' . htmlspecialchars($row['nresident_id']) . '"
                data-last-name="' . htmlspecialchars($row['last_name'], ENT_QUOTES) . '"
                data-first-name="' . htmlspecialchars($row['first_name'], ENT_QUOTES) . '"
                data-middle-name="' . htmlspecialchars($row['middle_name'], ENT_QUOTES) . '"
                data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
                data-house-no="' . htmlspecialchars($row['house_no'], ENT_QUOTES) . '"
                data-street-name="' . htmlspecialchars($row['street'], ENT_QUOTES) . '"
                data-subdivision="' . htmlspecialchars($row['subdivision'], ENT_QUOTES) . '"
                data-district-brgy="' . htmlspecialchars($row['district_brgy'], ENT_QUOTES) . '"
                data-city="' . htmlspecialchars($row['city'], ENT_QUOTES) . '"
                data-sex="' . htmlspecialchars($row['sex'], ENT_QUOTES) . '"
                data-birth-date="' . htmlspecialchars($row['birth_date'], ENT_QUOTES) . '"
                data-contact-num="' . htmlspecialchars($row['contact_num'], ENT_QUOTES) . '"
                data-audit-trail-num="' . htmlspecialchars($row['audit_trail_no'], ENT_QUOTES) . '"
                data-bs-toggle="modal" data-bs-target="#EditResidentModal">Edit</button>';
            }else{
                //Nothing to Display
            }

            if($row['is_deleted'] == "0"){ 
                echo '<button class="btn btn-danger mx-1 deleteNResidentButton" id="deletebutton"
                    data-pageno="'.$page.'"
                    data-nresident_id = "' . htmlspecialchars($row['nresident_id']) . '">Delete</button>';
            }else{
                echo '<button class="btn btn-warning mx-1 deleteResidentButton" id="undodeletebutton"
                data-pageno="'.$page.'"
                data-nresident_id = "' . htmlspecialchars($row['nresident_id']) . '">Recover</button>';
            }
    } 
}      
    echo '</div>
    </td>
</tr>';
?>
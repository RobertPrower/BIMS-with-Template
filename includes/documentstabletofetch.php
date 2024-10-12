<?php
foreach ($results as $row) {
    echo '<tr>';
    echo '<td id="request_id">' . htmlspecialchars($row['request_id']) . '</td>';
    echo '<td>' . htmlspecialchars($row['date_issued']) . '</td>';
    echo '<td>' . htmlspecialchars($row['expiration']) . '</td>';
    switch ($row['is_resident']){
        case 1: echo "<td> Resident </td>";
        break;
        default: echo "<td> Non-Resident</td>";
    }
    echo '<td>' . htmlspecialchars($row['last_name']) . ', ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['middle_name']) . ' ' . htmlspecialchars($row['suffix']) . '</td>';
    echo '<td>' . htmlspecialchars($row['house_num']) . ', ' . htmlspecialchars($row['street']) . ', ' . htmlspecialchars($row['subdivision']) .' '. htmlspecialchars($row['city']) . '</td>';
    echo '<td>' . htmlspecialchars($row['document_desc']) . '</td>';
    echo '<td>' . htmlspecialchars($row['purpose']) . '</td>';
    switch ($row['status']){
        case 0: echo "<td><span class='badge-success'> ACTIVE</span> </td>";
        break;
        case 1: echo "<td><span class='badge-disabled'> EXPIRED</span></td>";
        break;
        case 2: echo "<td> <span class='badge-trashed'> REVOKED </span></td>";
        break;
        default: echo "<td> Unknown Status </td>";
    } 

    if(!isset($Isforcert)){
        echo '<td style="width: 35%;">
        <div class="btn-group text-center">
                
            <button class="btn btn-primary mx-1 viewDocumentsButton" id=vbutton
                data-id="' . htmlspecialchars($row['request_id']) . '"
                data-resident_id="' . htmlspecialchars($row['resident/nonres_id']) . '"
                data-resident-status="' . htmlspecialchars($row['is_resident']) . '"
                data-date-requested="' . htmlspecialchars($row['date_issued'], ENT_QUOTES) . '"
                data-expiration-date="' . htmlspecialchars($row['expiration'], ENT_QUOTES) . '"
                data-first-name="' . htmlspecialchars($row['first_name'], ENT_QUOTES) . '"
                data-middle-name="' . htmlspecialchars($row['middle_name'], ENT_QUOTES) . '"
                data-last-name="' . htmlspecialchars($row['last_name'], ENT_QUOTES) . '"
                data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
                data-house-no="' . htmlspecialchars($row['house_num'], ENT_QUOTES) . '"
                data-street-name="' . htmlspecialchars($row['street'], ENT_QUOTES) . '"
                data-subdivision="' . htmlspecialchars($row['subdivision'], ENT_QUOTES) . '"
                data-sex="' . htmlspecialchars($row['sex'], ENT_QUOTES) . '"
                data-age="' . htmlspecialchars($row['age'], ENT_QUOTES) . '"
                data-docu-desc="' . htmlspecialchars($row['document_desc'], ENT_QUOTES) . '"
                data-presented-id="' . htmlspecialchars($row['presented_id'], ENT_QUOTES) . '"
                data-id_num="' . htmlspecialchars($row['ID_number'], ENT_QUOTES) . '"
                data-purpose="' . htmlspecialchars($row['purpose'], ENT_QUOTES) . '"
                data-status="' . htmlspecialchars($row['status'], ENT_QUOTES) . '"                        
                data-last-edited="' . htmlspecialchars($row['date_edited'], ENT_QUOTES) . '"
                data-last-deleted="' . htmlspecialchars($row['date_deleted'], ENT_QUOTES) . '"
                data-bs-toggle="modal" data-bs-target="#DocumentDetailsModal">View</button>';

            if($row['is_deleted'] == "0"){ 
                echo '<button class="btn btn-danger mx-1 deleteResidentButton" id="deletebutton"
                    data-pageno="'.$page.'"
                    data-request_id = "' . htmlspecialchars($row['request_id']) . '">Delete</button>';
            }else{
                echo '<button class="btn btn-warning mx-1 deleteResidentButton" id="undodeletebutton"
                data-pageno="'.$page.'"
                data-request_id = "' . htmlspecialchars($row['request_id']) . '">Recover</button>';
            }
    }
}      
    echo '</div>
    </td>
</tr>';
?>
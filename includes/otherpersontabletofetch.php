<?php

echo'<tr id="'.htmlspecialchars($row['id']).'" data-status="'.$row['status'].'" data-id="'.$row['id'].'">
<td hidden class="otherrespondentsIDs">'.htmlspecialchars($row['id']).'</td>';

if(htmlspecialchars($row['status']) == "Resident"){
    echo '<td><img src="includes/img/resident_img/'.htmlspecialchars($row['img_filename']).'" width="100" height="100" style="object-fit: contain; max-width: 100%; max-height: 100%;"/></td>';
}else{
    echo '<td><img src="includes/img/non_resident_img/'.htmlspecialchars($row['img_filename']).'" width="100" height="100" style="object-fit: contain; max-width: 100%; max-height: 100%;"/></td>';
}

echo    '<td>'.htmlspecialchars($row['full_name']).'</td>
        <td>'.htmlspecialchars($row['status']).'</td>
        <td>';

if($isedit == "#EditBlotterModal"){
    echo '
        <button class="btn btn-danger mx-2 removepersons" id="removeOtherComplainants"
                data-id="'.htmlspecialchars($row['id']).'"
                data-whatbtn="OtherRespondents" data-status="'.htmlspecialchars($row['status']).'">
                Remove
        </button>';        
}else{

    echo '
        <button class="btn btn-primary viewPersonDetails" id="viewResorNonResfromBlot"
            data-id="'.htmlspecialchars($row['id']).'"
            data-status="'.htmlspecialchars($row['status']).'"
            data-whatbtn="otherrespondent">
            View Details
        </button>';   
        }
    echo '
        </td>
        </tr>';
?>
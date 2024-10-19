<?php
  foreach ($results as $row) {
    $subd = (empty($row['subdivision'])) ? "" : ", " . htmlspecialchars($row['subdivision']) ;
        
    echo '<tr>';
    switch($isResident){
        case 1:
            echo '<td hidden id="resident_id">' . htmlspecialchars($row['resident_id']) . '</td>';
        break;
        case 0:
            echo '<td hidden id="nresident_id">' . htmlspecialchars($row['nresident_id']) . '</td>';
        default: 
    }
    switch($isResident){
        case 1:
            echo '<td class="text-center"> <img width="100" height="100" src="includes/img/resident_img/' . htmlspecialchars($row['img_filename']) . '"</td>';
        break;
        case 0:
            echo '<td class="text-center"> <img width="100" height="100" src="includes/img/non_resident_img/' . htmlspecialchars($row['img_filename']) . '"</td>';
        default:
    }
    echo '<td class="text-center">' . htmlspecialchars($row['last_name']) . ', ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['middle_name']) . ' ' . htmlspecialchars($row['suffix']) . '</td>';
    switch($isResident){
        case 1:
            echo '<td class="text-center">' . htmlspecialchars($row['house_num']) . ', ' . htmlspecialchars($row['street']) . $subd . '</td>';
        break;
        case 0:
            echo '<td class="text-center">' . htmlspecialchars($row['house_num']) . ', ' . htmlspecialchars($row['street']) . $subd .', '.htmlspecialchars($row['district_brgy']).', '.htmlspecialchars($row['city']).', '.htmlspecialchars($row['province']).', '.htmlspecialchars($row['zipcode']).'</td>';
        default:
    }
    echo '<td class="text-center">' . htmlspecialchars($row['sex']) . '</td>';
    echo '<td class="text-center">' . htmlspecialchars($row['marital_status']) . '</td>';
    echo '<td class="text-center">' . htmlspecialchars($row['birth_date']) . '</td>';                                        
    echo '<td class="text-center">' . htmlspecialchars($row['cellphone_num']) . '</td>';
    switch($isResident){
        case 1:
            echo '<td class="text-center">' . ($row['is_a_voter'] ? '<img width="30" height="30" src="./img/svg/check-solid.png" style="color: #2cfc62"></img>' : '<img width="30" height="30" src="./img/svg/xmark-solid.svg" style="opacity: 40%"></img>') . '</td>';
        break;
        case 0:
            
        break;
        default:

    }

}      
    echo '</div>
    </td>
</tr>';
?>
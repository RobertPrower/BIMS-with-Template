<?php 
require_once 'config.php';
require_once 'enforce_login.php';

foreach ($results as $row) {
  
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['created_dt']) . '</td>';
    echo '<td>' . htmlspecialchars($row['username']) . '</td>';
    echo '<td>' . htmlspecialchars($row['lname']) . ', ' . htmlspecialchars($row['fname']) . ' ' . htmlspecialchars($row['mname']) . 
    ' ' . htmlspecialchars($row['suffix']) . '</td>';
    echo '<td>' . htmlspecialchars($row['last_login']) . '</td>';
    if($row['isactive']){
        echo '<td><span class="badge-success"> ACTIVE</span> </td>';
    }else{
        echo "<td><span class='badge-disabled'> LOG OUT </span> </td>";
    }
    echo '<td style="width: 35%;">
    <div class="btn-group text-center">
            
        <button class="btn btn-primary mx-1 viewbtn" id=vbutton
            data-id="' . htmlspecialchars($row['user_id']) . '"
            data-first-name="' . htmlspecialchars($row['fname'], ENT_QUOTES) . '"
            data-middle-name="' . htmlspecialchars($row['mname'], ENT_QUOTES) . '"
            data-last-name="' . htmlspecialchars($row['lname'], ENT_QUOTES) . '"
            data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
            data-username="' . htmlspecialchars($row['username'], ENT_QUOTES) . '"
            data-dept_no="' . htmlspecialchars($row['depart_no'], ENT_QUOTES) . '"
            data-img_filename="' . htmlspecialchars($row['img_filename'], ENT_QUOTES) . '"
            data-username="' . htmlspecialchars($row['username'], ENT_QUOTES) . '"
            data-created_by="' . htmlspecialchars($row['created_by'], ENT_QUOTES) . '"



            data-bs-toggle="modal" data-bs-target="#ViewUserModal">View</button>';

        if($row['is_deleted'] == "0"){
            echo '<button class="btn btn-success mx-1 editbtn"
            data-first-name="' . htmlspecialchars($row['fname'], ENT_QUOTES) . '"
            data-middle-name="' . htmlspecialchars($row['mname'], ENT_QUOTES) . '"
            data-last-name="' . htmlspecialchars($row['lname'], ENT_QUOTES) . '"
            data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
            data-username="' . htmlspecialchars($row['username'], ENT_QUOTES) . '"
            data-dept_no="' . htmlspecialchars($row['depart_no'], ENT_QUOTES) . '"
            data-img_filename="' . htmlspecialchars($row['img_filename'], ENT_QUOTES) . '"
            data-username="' . htmlspecialchars($row['username'], ENT_QUOTES) . '"
            data-created_by="' . htmlspecialchars($row['created_by'], ENT_QUOTES) . '"
            data-user_id="' . htmlspecialchars($row['user_id'], ENT_QUOTES) . '"

            data-bs-toggle="modal" data-bs-target="#EditUserProfile">Edit</button>';
        }else{
            //Nothing to Display
        }

        if($departmentno==4){
            if($row['is_deleted'] == "0"){ 
                echo '<button class="btn btn-danger mx-1 deletebtn" id="deletebtn"
                data-user_id="' . htmlspecialchars($row['user_id']) . '">Delete</button>';
            }else{
                echo '<button class="btn btn-warning mx-1 recoverbtn" id="undodeletebutton"
                data-user_id="' . htmlspecialchars($row['user_id']) . '">Recover</button>';
            }
        }
} 
   
    echo '</div>
    </td>
</tr>';
?>
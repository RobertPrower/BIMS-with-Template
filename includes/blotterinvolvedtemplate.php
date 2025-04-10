<?php 

foreach($result as $row){

    echo '<tr>';
    //echo '<td id="resident_id">' . htmlspecialchars($row['blotter_id']) . '</td>';
    
        switch ($row['blotter_type']){
        case 0: echo "<td>Blotter</td>";
        break;  
        case 1: echo "<td>Incident</td>";
        break;
        default: echo "<td> Unknown Status </td>";   
        }     
    
    echo '<td>' . htmlspecialchars($row['blotter_add_dt']) . '</td>';
    echo '<td>' . htmlspecialchars($row['person_status']) . '</td>';
    echo '<td>' . htmlspecialchars($row['incident_dt']) . '</td>';
    echo '<td>' . htmlspecialchars($row['desc_incident']) . '</td>';
    switch ($row['date_of_resolution']){
        case null: echo "<td>N/A</td>";
        break;  
        case !NULL: echo "<td>".$row['date_of_resolution']."</td>";
        break;
        default: echo "<td> Unknown Status </td>";   
    }     
         
    switch ($row['report_status']){
        case 0: echo "<td><span class='badge-pending'>ONGOING</span> </td>";
        break;
        case 1: echo "<td><span class='badge-success'>RESOLVED</span></td>";
        break;
        case 2: echo "<td> <span class='badge-trashed'>FILE TO ACTION</span></td>";
        break;
        default: echo "<td> Unknown Status </td>";
    } 
}
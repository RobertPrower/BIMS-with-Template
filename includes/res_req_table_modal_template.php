<?php
foreach ($result as $row) {
    echo "<tr>";
    
    echo   "<td>{$row['request_id']}</td>
            <td>{$row['date_issued']}</td>
            <td>{$row['expiration']}</td>
            <td>{$row['cert_type']}</td>
            <td>{$row['purpose']}</td>
            <td>{$row['age']}</td>
            <td>{$row['presented_id']}</td>
            <td>{$row['ID_number']}</td>";

    switch ($row['status']){
        case 0: echo "<td><span class='badge-success'> ACTIVE</span> </td>";
        break;
        case 1: echo "<td><span class='badge-disabled'> EXPIRED</span></td>";
        break;
        case 2: echo "<td> <span class='badge-trashed'> REVOKED </span></td>";
        break;
        default: echo "<td> Unknown Status </td>";
    } 

    echo "</tr>";
                
}
?>
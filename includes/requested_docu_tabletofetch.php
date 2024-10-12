<?php
foreach ($result as $row) {
    echo "<tr>";
    echo "<td>{$row['request_id']}</td>
          <td>{$row['date_issued']}</td>
          <td>{$row['expiration']}</td>
          <td>{$row['document_desc']}</td>
          <td>{$row['purpose']}</td>
          <td>{$row['age']}</td>
          <td>{$row['presented_id']}</td>
          <td>{$row['ID_number']}</td>";

    switch ($row['status']) {
        case 0:
            echo "<td><span class='badge badge-success'>ACTIVE</span></td>";
            break;
        case 1:
            echo "<td><span class='badge badge-secondary'>EXPIRED</span></td>";
            break;
        case 2:
            echo "<td><span class='badge badge-danger'>REVOKED</span></td>";
            break;
        default:
            echo "<td>Unknown Status</td>";
    }

    echo "</tr>";
}
?>
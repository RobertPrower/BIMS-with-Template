<?php 

include 'connecttodb.php';
$limit = 10;
$page = isset($_POST['pageno']) ? $_POST['pageno'] : 1;
$start_from = ($page - 1) * $limit;

try {
        $sql = "SELECT * FROM vw_all_documents ORDER BY date_issued DESC"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any results
    if (count($results) > 0) {
        // Output each row as HTML
        // require_once('documentstabletofetch.php');
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td id="request_id">' . htmlspecialchars($row['request_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['date_issued']) . '</td>';
            echo '<td>' . htmlspecialchars($row['last_name']) . ', ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['middle_name']) . ' ' . htmlspecialchars($row['suffix']) . '</td>';
            echo '<td>' . htmlspecialchars($row['house_num']) . ', ' . htmlspecialchars($row['street']) . ', ' . htmlspecialchars($row['subdivision']) . htmlspecialchars($row['city']) . '</td>';
            echo '<td>' . htmlspecialchars($row['sex']) . '</td>';
            echo '<td>' . htmlspecialchars($row['age']) . '</td>';
            echo '<td>' . htmlspecialchars($row['document_desc']) . '</td>';
            echo '<td>' . htmlspecialchars($row['presented_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ID_number']) . '</td>';
            echo '<td>' . htmlspecialchars($row['purpose']) . '</td>';
        
            switch ($row['status']){
                case 0: echo "<td style='background-color: green; color: white'> ACTIVE </td>";
                break;
                case 1: echo "<td style='background-color: grey; color: white'> EXPIRED </td>";
                break;
                case 2: echo "<td style='background-color: red; color: white'> REVOKED </td>";
                break;
                default: echo "<td> Unknown Status </td>";
            } 
        
            if(!isset($Isforcert)){
                echo '<td style="width: 35%;">
                <div class="btn-group text-center">
                        
                    <button class="btn btn-primary mx-1 viewDocumentsButton" id=vbutton
                        data-id="' . htmlspecialchars($row['request_id']) . '"
                        data-resident_id="' . htmlspecialchars($row['resident_id']) . '"
                        data-date-requested="' . htmlspecialchars($row['date_issued'], ENT_QUOTES) . '"
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
                        data-bs-toggle="modal" data-bs-target="#DocumentDetailsModal">View</button>';
        
                    if($row['is_deleted'] == "0"){ 
                        echo '<button class="btn btn-danger mx-1 deleteResidentButton" id="deletebutton"
                            data-pageno="'.$page.'"
                            data-resident_id = "' . htmlspecialchars($row['request_id']) . '">Delete</button>';
                    }else{
                        echo '<button class="btn btn-warning mx-1 deleteResidentButton" id="undodeletebutton"
                        data-pageno="'.$page.'"
                        data-resident_id = "' . htmlspecialchars($row['request_id']) . '">Recover</button>';
                    }
            }
        }      
            echo '</div>
            </td>
        </tr>';
    } else {
        echo '<tr><td colspan="12">No records found.</td></tr>';
    }
} catch (PDOException $e) {
    echo 'Error: ' . htmlspecialchars($e->getMessage());
}

// Close the connection
$pdo = null;
?>
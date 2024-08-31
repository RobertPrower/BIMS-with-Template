<?php

include 'connecttodb.php';

try {
        $sql = "SELECT * FROM vw_all_resident"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any results
    if (count($results) > 0) {
        // Output each row as HTML
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td hidden>' . htmlspecialchars($row['resident_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['date_recorded']) . '</td>';
            echo '<td>' . htmlspecialchars($row['last_name']) . ', ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['middle_name']) . ' ' . htmlspecialchars($row['suffix']) . '</td>';
            echo '<td>' . htmlspecialchars($row['house_num']) . ', ' . htmlspecialchars($row['street']) . ', ' . htmlspecialchars($row['subdivision']) . '</td>';
            echo '<td class="text-center">' . htmlspecialchars($row['resident_since']) . '</td>';
            echo '<td>' . htmlspecialchars($row['sex']) . '</td>';
            echo '<td>' . htmlspecialchars($row['marital_status']) . '</td>';
            echo '<td>' . htmlspecialchars($row['birth_date']) . '</td>';
            echo '<td>' . htmlspecialchars($row['birth_place']) . '</td>';
            echo '<td class="text-center">' . htmlspecialchars($row['cellphone_num']) . '</td>';
            echo '<td>' . ($row['is_a_voter'] ? 'YES' : 'NO') . '</td>';
            echo '<td style="width: 35%;">
                <div class="btn-group text-center">
                        
                        
                    <button class="btn btn-primary mx-1 viewResidentButton" id=vbutton
                        data-id="' . htmlspecialchars($row['resident_id']) . '"
                        data-first-name="' . htmlspecialchars($row['first_name'], ENT_QUOTES) . '"
                        data-middle-name="' . htmlspecialchars($row['middle_name'], ENT_QUOTES) . '"
                        data-last-name="' . htmlspecialchars($row['last_name'], ENT_QUOTES) . '"
                        data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
                        data-house-no="' . htmlspecialchars($row['house_num'], ENT_QUOTES) . '"
                        data-street-name="' . htmlspecialchars($row['street'], ENT_QUOTES) . '"
                        data-subdivision="' . htmlspecialchars($row['subdivision'], ENT_QUOTES) . '"
                        data-sex="' . htmlspecialchars($row['sex'], ENT_QUOTES) . '"
                        data-marital-status="' . htmlspecialchars($row['marital_status'], ENT_QUOTES) . '"
                        data-birth-date="' . htmlspecialchars($row['birth_date'], ENT_QUOTES) . '"
                        data-birth-place="' . htmlspecialchars($row['birth_place'], ENT_QUOTES) . '"
                        data-phone-number="' . htmlspecialchars($row['cellphone_num'], ENT_QUOTES) . '"
                        data-isa-voter="' . htmlspecialchars($row['is_a_voter'], ENT_QUOTES) . '"
                        data-rsince="' . htmlspecialchars($row['resident_since'], ENT_QUOTES) . '"
                        data-bs-toggle="modal" data-bs-target="#ViewResidentModal">View</button>

                        
                    <button class="btn btn-success mx-1 editResidentButton"
                        data-id="' . htmlspecialchars($row['resident_id']) . '"
                        data-first-name="' . htmlspecialchars($row['first_name'], ENT_QUOTES) . '"
                        data-middle-name="' . htmlspecialchars($row['middle_name'], ENT_QUOTES) . '"
                        data-last-name="' . htmlspecialchars($row['last_name'], ENT_QUOTES) . '"
                        data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
                        data-house-no="' . htmlspecialchars($row['house_num'], ENT_QUOTES) . '"
                        data-street-name="' . htmlspecialchars($row['street'], ENT_QUOTES) . '"
                        data-subdivision="' . htmlspecialchars($row['subdivision'], ENT_QUOTES) . '"
                        data-sex="' . htmlspecialchars($row['sex'], ENT_QUOTES) . '"
                        data-marital-status="' . htmlspecialchars($row['marital_status'], ENT_QUOTES) . '"
                        data-birth-date="' . htmlspecialchars($row['birth_date'], ENT_QUOTES) . '"
                        data-birth-place="' . htmlspecialchars($row['birth_place'], ENT_QUOTES) . '"
                        data-phone-number="' . htmlspecialchars($row['cellphone_num'], ENT_QUOTES) . '"
                        data-isa-voter="' . htmlspecialchars($row['is_a_voter'], ENT_QUOTES) . '"
                        data-residentsince="' . htmlspecialchars($row['resident_since'], ENT_QUOTES) . '"
                        data-bs-toggle="modal" data-bs-target="#EditResidentModal">Edit</button>

                      
                    <button class="btn btn-danger mx-1 deleteResidentButton" id="deletebutton"
                        data-id="' . htmlspecialchars($row['resident_id']) . '">Delete</button>
                </div>
            </td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="12">No records found.</td></tr>';
    }
} catch (PDOException $e) {
    echo 'Error: ' . htmlspecialchars($e->getMessage());
}

// Close the connection
$pdo = null;
?>

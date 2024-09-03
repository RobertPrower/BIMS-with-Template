<?php 

require_once('connecttodb.php');

$limit = 10;
$search = isset($_POST['search']) ? $_POST['search'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : '1';
$start_from = ($page - 1) * $limit;

$stmt = $pdo->prepare("SELECT COUNT(*) FROM resident WHERE last_name LIKE :search");
$stmt->execute(['search' => "%$search%"]);
$total_records = $stmt->fetchColumn();

$total_pages = ceil($total_records / $limit);


if($_POST['operation']=="SEARCH"){
    if(!empty($search)){

        // query to fetch records with pagination
        $stmt = $pdo->prepare("SELECT 
            `resident`.`resident_id`       AS `resident_id`,
            `res_audit_trail`.`date_added` AS `date_recorded`,
            `resident`.`img_filename`      AS `img_filename`,
            `resident`.`last_name`         AS `last_name`,
            `resident`.`first_name`        AS `first_name`,
            `resident`.`middle_name`       AS `middle_name`,
            `resident`.`suffix`            AS `suffix`,
            `resident`.`house_num`         AS `house_num`,
            `resident`.`street`            AS `street`,
            `resident`.`subdivision`       AS `subdivision`,
            `resident`.`resident_since`    AS `resident_since`,
            `resident`.`sex`               AS `sex`,
            `resident`.`marital_status`    AS `marital_status`,
            `resident`.`birth_date`        AS `birth_date`,
            `resident`.`birth_place`       AS `birth_place`,
            `resident`.`cellphone_num`     AS `cellphone_num`,
            `resident`.`is_a_voter`        AS `is_a_voter` FROM resident 
            JOIN res_audit_trail 
            ON resident.audit_trail = res_audit_trail.res_at_id
            WHERE last_name LIKE :search
            ORDER BY last_name  ASC LIMIT $start_from, $limit"); 

        $stmt->execute(['search' => "%$search%"]);

        $results = $stmt->fetchAll();

        if(!empty($results)){
            // Code for displaying the results
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
                        <button class="btn btn-primary mx-1 viewResidentButton" id="vbutton"
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
                            data-pageno="'.$page.'"
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
                            data-pageno="'.$page.'"
                            data-resident_id = "' . htmlspecialchars($row['resident_id']) . '">Delete</button>
                    </div>
                </td>';
                echo '</tr>';

            }

            echo '<nav aria-label="Page navigation">';
            echo '<ul class="pagination justify-content-end">';
        
            // Previous Button
            if ($page > 1) {
                echo '<li class="page-item">
                        <a class="page-link" href="#" data-page="' . ($page - 1) . '">Previous</a>
                    </li>';
            }
        
            // Page Numbers
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                        <a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>
                    </li>';
            }
        
            // Next Button
            if ($page < $total_pages) {
                echo '<li class="page-item">
                        <a class="page-link" href="#" data-page="' . ($page + 1) . '">Next</a>
                    </li>';
            }
        
            echo '</ul>';
            echo '</nav>';
        }else{
            echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
        }
    }else{
        echo '<tr><td colspan="11">No Query</td></tr>';
    }
}

if($_POST['operation']=="SEARCH_PAGINATION"){

    echo '<nav aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-end">';

    // Previous Button
    if ($page > 1) {
        echo '<li class="page-item">
                <a class="page-link" href="#" data-page="' . ($page - 1) . '">Previous</a>
              </li>';
    }

    // Page Numbers
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                <a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>
              </li>';
    }

    // Next Button
    if ($page < $total_pages) {
        echo '<li class="page-item">
                <a class="page-link" href="#" data-page="' . ($page + 1) . '">Next</a>
              </li>';
    }

    echo '</ul>';
    echo '</nav>';

}


?>
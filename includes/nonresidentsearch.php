<?php 

require_once('connecttodb.php');

$limit = 10;
$search = isset($_POST['search']) ? sanitizeData($_POST['search']): '';
$page = isset($_POST['page']) ? $_POST['page'] : '1';
$start_from = ($page - 1) * $limit;

$stmt = $pdo->prepare("SELECT COUNT(*) FROM non_resident WHERE last_name LIKE :search OR first_name LIKE :search OR middle_name LIKE :search");
$stmt->execute(['search' => "%$search%"]);
$total_records = $stmt->fetchColumn();

$total_pages = ceil($total_records / $limit);


if($_POST['operation']=="SEARCH"){
    if(!empty($search)){

        // query to fetch records with pagination
        $stmt = $pdo->prepare("SELECT 
            `non_resident`.`nresident_id`       AS `nresident_id`,
            `nonres_audit_trail`.`datetime_added` AS `date_recorded`,
            `non_resident`.`img_filename`      AS `img_filename`,
            `non_resident`.`last_name`         AS `last_name`,
            `non_resident`.`first_name`        AS `first_name`,
            `non_resident`.`middle_name`       AS `middle_name`,
            `non_resident`.`suffix`            AS `suffix`,
            `non_resident`.`house_num`         AS `house_num`,
            `non_resident`.`street`            AS `street`,
            `non_resident`.`subdivision`       AS `subdivision`,
            `non_resident`.`district_brgy`,
            `non_resident`.`city`, 
            `non_resident`.`province`,
            `non_resident`.`sex`               AS `sex`,
            `non_resident`.`marital_status`    AS `marital_status`,
            `non_resident`.`birth_date`        AS `birth_date`,
            `non_resident`.`birth_place`       AS `birth_place`,
            `non_resident`.`cellphone_num`     AS `cellphone_num`,
            `non_resident`.`is_deleted`
            FROM non_resident 
            JOIN nonres_audit_trail 
            ON non_resident.audit_trail_no = nonres_audit_trail.audit_trail_id
            WHERE is_deleted=0 AND (last_name LIKE :search OR first_name LIKE :search OR middle_name LIKE :search)
            ORDER BY last_name  ASC LIMIT $start_from, $limit"); 

        $stmt->execute(['search' => "%$search%"]);

        $results = $stmt->fetchAll();

        if(!empty($results)){
            // Code for displaying the results
           require_once'nonresidenttabletofetch.php';
            
        }else{
            echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
        }
    }else{
        echo '<tr><td colspan="11">No Query</td></tr>';
    }
}elseif($_POST['operation']=="DELETED_SEARCH"){
    if(!empty($search)){

        // query to fetch records with pagination
        $stmt = $pdo->prepare("SELECT 
            `non_resident`.`nresident_id`       AS `nresident_id`,
            `nonres_audit_trail`.`datetime_added` AS `date_recorded`,
            `non_resident`.`img_filename`      AS `img_filename`,
            `non_resident`.`last_name`         AS `last_name`,
            `non_resident`.`first_name`        AS `first_name`,
            `non_resident`.`middle_name`       AS `middle_name`,
            `non_resident`.`suffix`            AS `suffix`,
            `non_resident`.`house_num`         AS `house_num`,
            `non_resident`.`street`            AS `street`,
            `non_resident`.`subdivision`       AS `subdivision`,
            `non_resident`.`district_brgy`,
            `non_resident`.`city`, 
            `non_resident`.`province`,
            `non_resident`.`sex`               AS `sex`,
            `non_resident`.`marital_status`    AS `marital_status`,
            `non_resident`.`birth_date`        AS `birth_date`,
            `non_resident`.`birth_place`       AS `birth_place`,
            `non_resident`.`cellphone_num`     AS `cellphone_num`,
            `non_resident`.`is_deleted`
            FROM non_resident 
            JOIN nonres_audit_trail 
            ON non_resident.audit_trail_no = nonres_audit_trail.audit_trail_id
            WHERE is_deleted=1 AND (last_name LIKE :search OR first_name LIKE :search OR middle_name LIKE :search)
            ORDER BY last_name  ASC LIMIT $start_from, $limit"); 

        $stmt->execute(['search' => "%$search%"]);

        $results = $stmt->fetchAll();

        if(!empty($results)){
            // Code for displaying the results
            require_once'residenttabletofetch.php';
            
        }else{
            echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
        }
    }else{
        echo '<tr><td colspan="11">No Query</td></tr>';
    }

}

if($_POST['operation']=="SEARCH_PAGINATION"){
    $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $current_page = max(1, min($current_page, $total_pages));
    $start_from = ($current_page - 1) * $limit;
        
    require_once'paginationtemplate.php';
}

function sanitizeData($input){
    $removedSpecialChar = trim ($input, "!@#$%^&*()=[]{};:`~'<>,./\?| "); 
    $removedSpecialCharinthemiddle= preg_replace('/[^a-zA-Z0-9\s\-ñÑ#]/u','', $removedSpecialChar);

    $sanatizedData=htmlspecialchars($removedSpecialCharinthemiddle);

    return $sanatizedData;

}


?>
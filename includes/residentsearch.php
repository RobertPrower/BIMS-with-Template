<?php 

require_once('connecttodb.php');

$limit = 10;
$search = isset($_POST['search']) ? sanitizeData($_POST['search']): '';
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
            `resident`.`is_a_voter`        AS `is_a_voter` ,
            `resident`.`is_deleted`
            FROM resident 
            JOIN res_audit_trail 
            ON resident.audit_trail = res_audit_trail.res_at_id
            WHERE is_deleted=0 AND last_name LIKE :search
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
}elseif($_POST['operation']=="DELETED_SEARCH"){
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
            `resident`.`is_a_voter`        AS `is_a_voter`,
            `resident`.`is_deleted`       
            
            FROM resident 
            JOIN res_audit_trail 
            ON resident.audit_trail = res_audit_trail.res_at_id
            WHERE last_name LIKE :search AND is_deleted=1
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
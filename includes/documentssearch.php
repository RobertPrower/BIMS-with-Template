<?php 

require_once('connecttodb.php');
require('anti-SQLInject.php');

$limit = 10;
$search = isset($_POST['search']) ? sanitizeData($_POST['search']): '';
$page = isset($_POST['page']) ? $_POST['page'] : '1';
$start_from = ($page - 1) * $limit;

$stmt = $pdo->prepare("SELECT COUNT(*) FROM resident WHERE last_name LIKE :search OR first_name LIKE :search OR middle_name LIKE :search");
$stmt->execute(['search' => "%$search%"]);
$total_records = $stmt->fetchColumn();

$total_pages = ceil($total_records / $limit);
$operation_check = (isset($_POST['operation']))? $_POST['operation']: null ;


if($operation_check=="SEARCH"){
    if(!empty($search)){

        // query to fetch records with pagination
        $stmt = $pdo->prepare("SELECT *
            FROM vw_all_documents
            WHERE is_deleted = 0
            AND (last_name LIKE :search OR first_name LIKE :search OR middle_name LIKE :search OR request_id LIKE :search)
            ORDER BY last_name ASC
            LIMIT $start_from, $limit;
            "); 

        $stmt->execute(['search' => "%$search%"]);

        $results = $stmt->fetchAll();

        if(!empty($results)){
            // Code for displaying the results
           require_once'documentstabletofetch.php';
            
        }else{
            echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
        }
    }else{
        echo '<tr><td colspan="11">No Query</td></tr>';
    }
}elseif($operation_check=="DELETED_SEARCH"){
    if(!empty($search)){

        // query to fetch records with pagination
        $stmt = $pdo->prepare("SELECT *
            FROM vw_all_documents
            WHERE is_deleted = 1
            AND (last_name LIKE :search OR first_name LIKE :search OR middle_name LIKE :search OR request_id LIKE :search)
            ORDER BY last_name ASC
            LIMIT"); 

        $stmt->execute(['search' => "%$search%"]);

        $results = $stmt->fetchAll();

        if(!empty($results)){
            // Code for displaying the results
            require_once'documentstabletofetch.php';
            
        }else{
            echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
        }
    }else{
        echo '<tr><td colspan="11">No Query</td></tr>';
    }

}elseif($operation_check=="SEARCH_PAGINATION"){
    $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $current_page = max(1, min($current_page, $total_pages));
    $start_from = ($current_page - 1) * $limit;
        
    require_once'paginationtemplate.php';
}




?>
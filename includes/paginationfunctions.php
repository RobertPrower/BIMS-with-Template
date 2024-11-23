<?php

require_once 'anti-SQLInject.php';
function limit_main_table($page){
    $limit = 10;
    $page = isset($page) ? sanitizeData($page) : 1;
    $start_from = ($page - 1) * $limit;
    return $start_from;
}

function limit_pagination($total_records, $pageno){
    $limit=10;
    $total_pages = ceil($total_records / $limit);
    $current_page = isset($pageno) ? (int)$pageno : 1;
    $current_page = max(1, min($current_page, $total_pages));
    $start_from = ($current_page - 1) * $limit;

    return ["current_page" => $current_page, "start_from" => $start_from, "total_pages" => $total_pages]; 
}

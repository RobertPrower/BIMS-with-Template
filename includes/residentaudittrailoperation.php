<?php
    require_once 'connecttodb.php' ;
    require_once 'config.php';
    require_once 'enforce_login.php';

    $limit = 10;

    //Variables formula for the table start from
    $page = (isset($_POST['pageno']))? $_POST['pageno']: 1 ;
    $start_from = ((int)$page - 1) * $limit;

    $operation_check = ($_POST['operation'])? $_POST['operation'] :null ;
    $id = (isset($_POST['audit_id']))? $_POST['audit_id']: null ;
    $search = (isset($_POST['search']))? $_POST['search']: null;
    $start_date = (isset($_POST['start_date']))? $_POST['start_date']: null;
    $end_date = (isset($_POST['end_date']))? $_POST['end_date']: null;


    if($operation_check == "RESIDENT_FETCH_TABLE"){

        $sqlquery = "SELECT * FROM vw_resident_audit ORDER BY action_timestamp DESC LIMIT :start_from , 10";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'audittabletofetch.php';

    }else if ($operation_check =="FETCH_RESIDENT_OLD_DETAILS"){

        $sqlquery="SELECT JSON_EXTRACT(action_data, '$.old_values') AS old_values FROM `resident_audit` WHERE audit_id=?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);

    }else if($operation_check =="FETCH_RESIDENT_NEW_DETAILS"){

        
        $sqlquery="SELECT JSON_EXTRACT(action_data, '$.new_values') AS old_values FROM `resident_audit` WHERE audit_id=?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);


    }else if($operation_check =="FETCH_RESIDENT_NEW_ENTRY"){

        
        $sqlquery="SELECT action_data AS new_entry FROM `resident_audit` WHERE audit_id=?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);


    }else if($operation_check =="FETCH_RESIDENT_RECOVER_DELETE"){

        
        $sqlquery="SELECT JSON_EXTRACT(action_data, '$.old_values') AS old_entry,
        JSON_EXTRACT(action_data, '$.new_values')
         AS new_entry FROM `resident_audit` WHERE audit_id=?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);


    }elseif($operation_check=="RESIDENT_AUDIT_SEARCH"){
        if(!empty($search)){
            $page = isset($_POST['page']) ? $_POST['page'] : '1';
            $start_from = ($page - 1) * $limit;
    
            // query to fetch records with pagination
            $stmt = $pdo->prepare("CALL SearchResidentAudit(:search, :start_from)"); 
    
            $stmt->execute(['search' => $search, 'start_from' => "$start_from"]);
    
            $results = $stmt->fetchAll();
    
            if(!empty($results)){
                // Code for displaying the results
               require_once'audittabletofetch.php';
                
            }else{
                echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
            }
        }else{
            echo '<tr><td colspan="11">No Query</td></tr>';
        }
    }elseif($operation_check=="RESIDENT_AUDIT_SEARCH_WITH_FILTERS"){
        if(!empty($search)){
            $page = isset($_POST['page']) ? $_POST['page'] : '1';
            $start_from = ($page - 1) * $limit;
    
            // query to fetch records with pagination
            $stmt = $pdo->prepare("CALL SearchResidentAuditIWithDate(:search, :start_from, :start_date, :end_date)"); 
    
            $stmt->execute(['search' => $search, 'start_from' => "$start_from", ':start_date' => "$start_date", ':end_date' => "$end_date"]);
    
            $results = $stmt->fetchAll();
    
            if(!empty($results)){
                // Code for displaying the results
               require_once'audittabletofetch.php';
                
            }else{
                echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
            }
        }else{
            echo '<tr><td colspan="11">No Query</td></tr>';
        }
    }elseif($operation_check=="RESIDENT_AUDIT_SEARCH_WITH_DATE"){

        $page = isset($_POST['page']) ? $_POST['page'] : '1';
        $start_from = ($page - 1) * $limit;

        // query to fetch records with pagination
        $stmt = $pdo->prepare("CALL SearchResidentAuditIWithDateFilter(:start_from, :start_date, :end_date)"); 

        $stmt->execute(['start_from' => "$start_from", ':start_date' => "$start_date", ':end_date' => "$end_date"]);

        $results = $stmt->fetchAll();

        if(!empty($results)){
            // Code for displaying the results
            require_once'audittabletofetch.php';
            
        }else{
            echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
        }
      
    }else if($operation_check=="FETCH_RESIDENT_PAGINATION"){

        // Fetch the total number of records
        $total_records = $pdo->query("SELECT COUNT(*) FROM vw_resident_audit")->fetchColumn();
        $limit = 10; //To limit the number of pages
        $total_pages = ceil($total_records / $limit);

        // Get the current page or set a default
        $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
        $current_page = max(1, min($current_page, $total_pages));
        $start_from = ($current_page - 1) * $limit;

        require_once'paginationtemplate.php';
    }
?>
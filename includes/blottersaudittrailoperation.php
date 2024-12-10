<?php

    require_once 'connecttodb.php' ;
    require_once 'config.php';
    require_once 'enforce_login.php';

    $limit = 10;
    $forblotter = true;

    //Variables formula for the table start from
    $page = (isset($_POST['pageno']))? $_POST['pageno']: 1 ;
    $start_from = ((int)$page - 1) * $limit;

    $operation_check = ($_POST['operation'])? $_POST['operation'] :null ;
    $id = (isset($_POST['audit_id']))? $_POST['audit_id']: null ;
    $search = (isset($_POST['search']))? $_POST['search']: null;
    $start_date = (isset($_POST['start_date']))? $_POST['start_date']: null;
    $end_date = (isset($_POST['end_date']))? $_POST['end_date']: null;
    $blotter_id =(isset($_POST['blotter_id']))? $_POST['blotter_id']: null ;

    function getactiondata($pdo, $id){
        $sqlquery = "SELECT action_data FROM tbl_blotters_audit WHERE audit_id=?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$id]);
        $result = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function decode_json_data($result){
        $action_data = json_decode($result['action_data'], true); 
        return $action_data;
    }

    function fetch_other_persons_table($result){
        $isedit = 0;
        require_once 'blotterotherpersontabletofetch.php';
    }

    if($operation_check == "BLOTTER_FETCH_TABLE"){

        $sqlquery = "SELECT * FROM vw_blotters_audit ORDER BY action_timestamp DESC LIMIT :start_from , 10";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'audittabletofetch.php';

    }else if ($operation_check =="FETCH_BLOTTER_DETAILS"){

        $results=getactiondata($pdo, $id);

        echo json_encode($results);

    }else if($operation_check == "FETCH_OTHER_COMPLAINANTS_RESPONDENTS_MODAL"){
        try{

            $result = getactiondata($pdo, $id);

            $action_data=decode_json_data($result);

            if ($result && !empty($result['action_data'])) {
            
                if($_POST['comporres']==0){
                    if($_POST['oldornew'] == "old"){

                        // Check if old_other_person exists
                        if (!empty($action_data['old_other_complainants'])) {
                            $data_to_encode = $action_data['old_other_complainants'];
                            fetch_other_persons_table(result: $data_to_encode);
                    
                        } else {
                            echo '<tr id="NoResult"><td colspan="4">No Old Other Complainants Found</td></tr>';
                        }

                    }else if($_POST['oldornew'] == "new"){

                        // Check if old_other_person exists
                        if (!empty($action_data['new_other_complainants'])) {
                            $data_to_encode = $action_data['new_other_complainants'];

                            fetch_other_persons_table( $data_to_encode);

                    
                        } else {
                            echo '<tr id="NoResult"><td colspan="4">No New Other Complainants Found</td></tr>';
                        }
        
                    }
                }else if($_POST['comporres']==1){
                    if($_POST['oldornew'] == "old"){

                        // Check if old_other_person exists
                        if (!empty($action_data['old_other_respondents'])) {
                            $data_to_encode = $action_data['old_other_respondents'];
                           fetch_other_persons_table($data_to_encode);
                    
                        } else {
                            echo '<tr id="NoResult"><td colspan="4">No Old Other Respondents Found</td></tr>';
                        }

                    }else if($_POST['oldornew'] == "new"){

                        // Check if old_other_person exists
                        if (!empty($action_data['new_other_respondents'])) {
                            $data_to_encode = $action_data['new_other_respondents'];

                            fetch_other_persons_table( $data_to_encode);

                        } else {
                            echo '<tr id="NoResult"><td colspan="4">No New Other Respondents Found</td></tr>';
                        }
        
                    }
                }

            } else {
                echo '<tr id="NoResult"><td colspan="4">No Other Respondents Found</td></tr>';

            }
                

        }catch(Exception $e){
            echo json_encode(["success" => false, "message" => "Server Error: ".$e->getMessage()]);
        }
    }elseif($operation_check=="BLOTTER_AUDIT_SEARCH"){
        if(!empty($search)){
            $page = isset($_POST['page']) ? $_POST['page'] : '1';
            $start_from = ($page - 1) * $limit;
    
            // query to fetch records with pagination
            $stmt = $pdo->prepare("CALL `SearchBlotterAudit`(:search, :start_from)"); 
    
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
    }elseif($operation_check=="BLOTTER_AUDIT_SEARCH_WITH_FILTERS"){
        if(!empty($search)){
            $page = isset($_POST['page']) ? $_POST['page'] : '1';
            $start_from = ($page - 1) * $limit;
    
            // query to fetch records with pagination
            $stmt = $pdo->prepare("CALL `SearchBlotterAuditWithDate`(:search, :start_from, :start_date, :end_date)"); 
    
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
    }elseif($operation_check=="BLOTTER_AUDIT_SEARCH_WITH_DATE"){

        $page = isset($_POST['page']) ? $_POST['page'] : '1';
        $start_from = ($page - 1) * $limit;

        // query to fetch records with pagination
        $stmt = $pdo->prepare("CALL `SearchBlotterAuditDateFilter`(:start_from, :start_date, :end_date)"); 

        $stmt->execute(['start_from' => "$start_from", ':start_date' => "$start_date", ':end_date' => "$end_date"]);

        $results = $stmt->fetchAll();

        if(!empty($results)){
            // Code for displaying the results
            require_once'audittabletofetch.php';
            
        }else{
            echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
        }
      
    }else if($operation_check=="FETCH_BLOTTER_PAGINATION"){

        // Fetch the total number of records
        $total_records = $pdo->query("SELECT COUNT(*) FROM vw_blotters_audit")->fetchColumn();
        $limit = 10; //To limit the number of pages
        $total_pages = ceil($total_records / $limit);

        // Get the current page or set a default
        $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
        $current_page = max(1, min($current_page, $total_pages));
        $start_from = ($current_page - 1) * $limit;

        require_once'paginationtemplate.php';
    }else if($operation_check =="SEARCH_PAGINATION"){

        if(!empty($search)){

            $query= "CALL `SearchBlotterAudit`(:search, :start_from)";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':search', (string)"%$search%", PDO::PARAM_STR);
            $stmt->bindValue(':start_from', (int)$start_from, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else if(!empty($search) && !empty($start_date) && !empty($end_date)){

            $stmt = $pdo->prepare("CALL `SearchBlotterAuditWithDate`(:search, :start_from, :start_date, :end_date)"); 
            $stmt->execute(['search' => $search, 'start_from' => "$start_from", ':start_date' => "$start_date", ':end_date' => "$end_date"]);
            $results = $stmt->fetchAll();
        
        }else if(!empty($start_date) && !empty($end_date)){

            $stmt = $pdo->prepare("CALL `SearchBlotterAuditDateFilter`(:start_from, :start_date, :end_date)"); 
            $stmt->execute(['start_from' => "$start_from", ':start_date' => "$start_date", ':end_date' => "$end_date"]);
            $results = $stmt->fetchAll();
    
        }else{
            die("Empty");
        }
    
        $total_entries = count($results);
    
        $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
        $total_pages = max(1, min($current_page, $total_entries));
        $start_from = ($current_page - 1) * $limit;
            
        require_once 'paginationtemplate.php';

    }
?>
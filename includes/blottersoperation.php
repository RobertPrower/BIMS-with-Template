<?php 
if($_SERVER['REQUEST_METHOD']=="POST"){

    require_once 'config.php';
    require_once 'enforce_login.php';
    require_once 'connecttodb.php';
    require_once 'anti-SQLInject.php';

    $operation_check = (isset($_POST['operation']))? $_POST['operation']: null;
    $userid = $_SESSION['user_id'];
    $id_to_fetch = (isset($_POST['blotter_id']))? $_POST['blotter_id']: null;
    $report_status = (isset($_POST['blotter_status']))? $_POST['blotter_status']: null;
    $nowdate = date("Y-m-d");


    $limit = 10;
    $search = isset($_POST['search']) ? sanitizeData($_POST['search']): '';
    $page = isset($_POST['pageno']) ? $_POST['pageno'] : '1';
    $start_from = ceil(($page - 1) * $limit);

    $main_complainantid = isset($_POST['main_complainantid'])?sanitizeData($_POST['main_complainantid']): NULL; 
    $main_complainant_status = isset($_POST['main_complainant_status'])?sanitizeData($_POST['main_complainant_status']): NULL;
    $main_respondentid = isset($_POST['main_respondentid'])?sanitizeData($_POST['main_respondentid']): NULL;
    $main_respondent_status = isset($_POST['main_respondent_status'])?sanitizeData($_POST['main_respondent_status']): NULL;;

    function handleNullValue($value) {
        return $value === "null" ? NULL : $value;
    }

    $dataTypes = ['resident_complainant', 'resident_respondent', 'nonresident_complainant', 'nonresident_respondent'];
    $data = [];

    if ($operation_check == "ADD_BLOTTER" || $operation_check == "EDIT_BLOTTER") {
        $other_person = [
            'other_complainants' => [
                'resident' => [],
                'non_resident' => []
            ],
            'other_respondents' => [
                'resident' => [],
                'non_resident' => []
            ]
        ];
    
        foreach (['resident_complainant', 'nonresident_complainant', 'resident_respondent', 'nonresident_respondent'] as $type) {
            for ($i = 1; $i <= 5; $i++) {
                $key = "other_{$type}{$i}";
                $value = handleNullValue($_POST[$key]);
                if (!empty($value)) {
                    $role = strpos($type, 'complainant') !== false ? 'other_complainants' : 'other_respondents';
                    $person_type = strpos($type, 'nonresident') !== false ? 'non_resident' : 'resident';
        
                    $other_person[$role][$person_type][] = $value;
                }
            }
        }
        
        
        
    }
    

    $schedule_date = isset($_POST['schedule_date'])?$_POST['schedule_date']: NULL;
    $schedule_starttime = isset($_POST['schedule_starttime'])?$_POST['schedule_starttime']: NULL;
    $schedule_endtime = isset($_POST['schedule_endtime'])?$_POST['schedule_endtime']: NULL;
    $schedule_color = isset($_POST['schedule_color'])?$_POST['schedule_color']: NULL;
    $mediator_no = isset($_POST['mediator_name'])?$_POST['mediator_name']: NULL;
    $incident_date = isset($_POST['incident_date'])?$_POST['incident_date']: NULL;
    $incident_desc = isset($_POST['incident_desc'])?$_POST['incident_desc']: NULL;
    $incident_location = isset($_POST['incident_location'])?sanitizeData($_POST['incident_location']): NULL;
    $blotter_type = isset($_POST['blotter_type'])?sanitizeData($_POST['blotter_type']): NULL;
    $case_context = isset($_POST['case_context'])?sanitizeData($_POST['case_context']): NULL;
    $resport_status = isset($_POST['report_status'])?sanitizeData($_POST['report_status']): NULL;

    $blotter_evidence_fd = "img/blotter_evidence/";
    $blotter_context_fd = "img/blotter_context/";

    $lname = $_POST['mediator_first_name']?? null;
    $fname = $_POST['mediator_last_name']?? null;
    $mname = $_POST['mediator_middle_name']?? null;
    $suffix = $_POST['mediator_suffix']?? null;


    function generateUniqueFileName($target_dir, $originalFileName) {
        $imageFileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
        $baseName = pathinfo($originalFileName, PATHINFO_FILENAME);

        // Generate a unique file name
        $fileName = $originalFileName;
        $fileSuffix = 1;
        while (file_exists($target_dir . $fileName)) {
            $fileName = $baseName . " ($fileSuffix)." . $imageFileType;
            $fileSuffix++;
        }

        return $fileName;
    }

    function handleImageUpload($fileInputName, $targetDir) {
        if (!isset($_FILES[$fileInputName])) {
            throw new Exception("No file uploaded.");
        }

        // Get file details
        $targetFile = $targetDir . basename($_FILES[$fileInputName]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Generate a unique filename
        $fileName = generateUniqueFileName($targetDir, basename($_FILES[$fileInputName]["name"]));
        $targetFile = $targetDir . $fileName;

        // Check if file is an image
        $check = getimagesize($_FILES[$fileInputName]["tmp_name"]);
        if ($check === false) {
            $response = "File is not an image.";
            throw new Exception($response);

        }

        // Check file size
        if ($_FILES[$fileInputName]["size"] > 500000) {
            $response = "File too large";
            throw new Exception($response);
        }

        // Allow only specific file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
            $response = "Sorry, only JPG, JPEG & PNG files are allowed.";
            throw new Exception($response);
        }

        // Move uploaded file to target directory
        if (!move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
            $response = "Sorry, there was an error uploading your file.";

            throw new Exception($response);
        }

        return $fileName;
    }

    function fetch_other_respondents($pdo, $id_to_fetch){
        $other_respondents_query = "CALL FetchAllRespondents(?)";
        $other_respondents_stmt = $pdo->prepare($other_respondents_query);
        $other_respondents_stmt->execute([$id_to_fetch]);
        $other_respondents= $other_respondents_stmt->fetchAll(PDO::FETCH_ASSOC);
        $other_respondents_stmt->closeCursor();

        return $other_respondents;
    }

    function fetch_other_complainants($pdo, $id_to_fetch){
        $other_complainants_query = "CALL FetchAllComplainant(?)";
        $other_complainants_stmt = $pdo->prepare($other_complainants_query);
        $other_complainants_stmt->execute([$id_to_fetch]);
        $other_complainants= $other_complainants_stmt->fetchAll(PDO::FETCH_ASSOC);
        $other_complainants_stmt->closeCursor();  
        
        return $other_complainants;
    }

    function fetch_other_details($pdo, $id_to_fetch){
        $other_details_query = "SELECT b.blotter_type, b.desc_incident, b.incident_dt, 
        b.location_of_incident, b.date_of_resolution, b.statemnt, 
        b.mediation_starttime, b.mediation_endtime, b.mediation_date, 
        b.schedule_color, b.report_status, b.`blotter_contextfile`, b.`blotter_evidencefile`,
        b.mediator_no AS mediator_name, b.is_deleted
        FROM tbl_blotters b
        LEFT JOIN tbl_blotter_mediator m ON b.mediator_no = m.mediator_id
        WHERE b.blotter_id = ?";
        $other_details_stmt = $pdo->prepare($other_details_query);
        $other_details_stmt->execute([$id_to_fetch]);
        $other_details = $other_details_stmt->fetch(PDO::FETCH_ASSOC);

        return $other_details;
    }

    function fetch_1st_tab_data($pdo, $id_to_fetch){

        $fetch_data_query= "SELECT `respondent_address`,`complainant_address`,respondent_filename, 
        complainant_filename, respondent_no, respondent_status, complainant_no, complainant_status,
        respondent_suffix, respondent_middle_name, respondent_first_name, respondent_last_name, 
        complainant_suffix, complainant_middle_name,complainant_first_name, complainant_last_name
         FROM vw_blotters WHERE blotter_id =?";
        $stmt_data = $pdo->prepare($fetch_data_query);
        $stmt_data->execute([$id_to_fetch]);
        $data=$stmt_data->fetch(PDO::FETCH_ASSOC);

        return $data;
    
    }


    if($operation_check == "FETCH_SCHEDULE_ON_MODAL"){

        $sqlquery = "SELECT * FROM vw_blotters_schedule";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);
    }else if($operation_check == "FETCH_MEDIATOR_SELECT"){

        $sqlquery = "SELECT mediator_id, CONCAT(first_name, ' ', middle_name, ', ', last_name, ' ', COALESCE(suffix, '')) AS mediator_name FROM tbl_blotter_mediator";
        $stmt = $pdo -> prepare($sqlquery);
        $stmt -> execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);

    }else if($operation_check == "ADD_BLOTTER"){

        try {
            // Determine main complainant type (resident or non-resident)
            if ($main_complainant_status == 0) {
                $resident_complainant = $main_complainantid;
                $non_resident_complainant = NULL;
            } else if ($main_complainant_status == 1) {
                $non_resident_complainant = $main_complainantid;
                $resident_complainant = NULL;
            }
        
            // Determine main respondent type (resident or non-resident)
            if ($main_respondent_status == 0) {
                $resident_respondent = $main_respondentid;
                $non_resident_respondent = NULL;
            } else if ($main_respondent_status == 1) {
                $non_resident_respondent = $main_respondentid;
                $resident_respondent = NULL;
            }
        
            // Handle file uploads
            try {
                $blotter_evidencefile = handleImageUpload('blotter_evidencefile', $blotter_evidence_fd);
                $blotter_contextfile = handleImageUpload('blotter_contextfile', $blotter_context_fd);
            } catch (Exception $e) {
                $response = ["success" => false, "message" => "Error uploading files: " . $e->getMessage()];
                $pdo = null;
                exit(json_encode($response));
            }
        
            $pdo->beginTransaction();
        
            // Insert the blotter record
            $blotter_query = "
                INSERT INTO tbl_blotters(res_complainant_no, nres_complainant_no, res_respondent_no, nres_respondent_no, 
                    blotter_type, desc_incident, incident_dt, location_of_incident, statemnt, mediation_date, 
                    mediation_starttime, mediation_endtime, mediator_no ,schedule_color, blotter_evidencefile, blotter_contextfile) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)
            ";
            $blotter_stmt = $pdo->prepare($blotter_query);
            $blotter_stmt->execute([
                $resident_complainant, $non_resident_complainant,
                $resident_respondent, $non_resident_respondent,
                $blotter_type, $incident_desc, $incident_date,
                $incident_location, $case_context, $schedule_date,
                $schedule_starttime, $schedule_endtime, $mediator_no,
                $schedule_color, $blotter_evidencefile, $blotter_contextfile
            ]);
        
            // Get the last inserted blotter ID
            $blotter_id = $pdo->lastInsertId();

            // Insert into the audit trail
            $audit_trail_query = "INSERT INTO tbl_blotter_audit_trail(assist_by_no, blotter_id) VALUES(?, ?)";
            $stmt = $pdo->prepare($audit_trail_query);
            $stmt->execute([$userid, $blotter_id]);
        
            // Insert other complainants and respondents into tbl_other_parties
            $other_party_query = "
                INSERT INTO tbl_blotter_other_person(party_type, blotter_id, resident_id, non_resident_id) 
                VALUES (?, ?, ?, ?)
            ";
            $other_party_stmt = $pdo->prepare($other_party_query);
        
            foreach ($other_person as $role => $party) {
                foreach ($party as $type => $person_ids) {
                    foreach ($person_ids as $person_id) {
                        if (!empty($person_id)) {
                            // Determine role type and assign resident or non-resident
                            $role_type = $role === 'other_complainants' ? 'complainant' : 'respondent';
                            $res_person_no = ($type === 'resident') ? $person_id : null;
                            $nres_person_no = ($type === 'non_resident') ? $person_id : null;
            
                            $other_party_stmt->execute([$role_type, $blotter_id, $res_person_no, $nres_person_no]);
                        }
                    }
                }
            }
            
            
        
            $pdo->commit();
        
        } catch (Exception $e) {
            $pdo->rollBack();
            $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
            exit(json_encode($response));
        }

        try {
        
            $new_other_complainants = fetch_other_complainants($pdo, $blotter_id);
            $new_other_respondents = fetch_other_respondents($pdo, $blotter_id);
            $new_other_details = fetch_other_details($pdo, $blotter_id);
            $new_data = fetch_1st_tab_data($pdo, $blotter_id);
        
            // Structure data as a JSON object
            $action_data = [
                "new_other_complainants" => $new_other_complainants,
                "new_other_respondents" => $new_other_respondents,
                "new_main_comp_res_details" => $new_data,
                "new_other_data" => $new_other_details
            ];
        
            // Convert to JSON string
            $action_data_json = json_encode($action_data, JSON_PRETTY_PRINT);
        
            // Insert into tbl_blotter_audit
            $record_snapshot_query = "
                INSERT INTO tbl_blotters_audit (blotter_no, action_type, user_no, is_deleted, action_data)
                VALUES (?, 'INSERT', ?, 0,?)";
            $record_snapshot_stmt = $pdo->prepare($record_snapshot_query);
            $record_snapshot_stmt->execute([$blotter_id, $userid, $action_data_json]);

            $response = ["success" => true, "message" => "Blotter Added Successfully!"];
            echo json_encode($response);
        
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    


    }else if($operation_check == "EDIT_BLOTTER") { 

        try {
            // Determine main complainant type (resident or non-resident)
            if ($main_complainant_status == "Resident") {
                $resident_complainant = $main_complainantid;
                $non_resident_complainant = NULL;
            } else if ($main_complainant_status == "Non-Resident") {
                $non_resident_complainant = $main_complainantid;
                $resident_complainant = NULL;
            }else{
                exit("Empty!");
            }
        
            // Determine main respondent type (resident or non-resident)
            if ($main_respondent_status == "Resident") {
                $resident_respondent = $main_respondentid;
                $non_resident_respondent = NULL;
            } else if ($main_respondent_status == "Non-Resident") {
                $non_resident_respondent = $main_respondentid;
                $resident_respondent = NULL;
            }else{

                exit("Empty");
            }

            if($report_status == 1){
                $dateofresolution = $nowdate;
            }else if($report_status ==0){
                $dateofresolution = NULL;
            }else{
                $dateofresolution = $nowdate;
            }
        
            // Initialize variables for the file paths (will be null if no file is uploaded)
            $blotter_evidencefile = null;
            $blotter_contextfile = null;
        
            // Check if files were uploaded for evidence and context, and handle accordingly
            if (isset($_FILES['blotter_evidencefile']) && $_FILES['blotter_evidencefile']['error'] == UPLOAD_ERR_OK) {
                try {
                    // Only handle the upload if the file exists and no errors occurred
                    $blotter_evidencefile = handleImageUpload('blotter_evidencefile', $blotter_evidence_fd);
                } catch (Exception $e) {
                    $response = ["success" => false, "message" => "Error uploading blotter evidence file: " . $e->getMessage()];
                    $pdo = null;
                    exit(json_encode($response));
                }
            }
        
            if (isset($_FILES['blotter_contextfile']) && $_FILES['blotter_contextfile']['error'] == UPLOAD_ERR_OK) {
                try {
                    // Only handle the upload if the file exists and no errors occurred
                    $blotter_contextfile = handleImageUpload('blotter_contextfile', $blotter_context_fd);
                } catch (Exception $e) {
                    $response = ["success" => false, "message" => "Error uploading blotter context file: " . $e->getMessage()];
                    $pdo = null;
                    exit(json_encode($response));
                }
            }
        
            $pdo->beginTransaction();

            $old_other_complainants= fetch_other_complainants($pdo, $id_to_fetch);
            $old_other_respondents= fetch_other_respondents($pdo, $id_to_fetch);
            $old_other_details = fetch_other_details($pdo, $id_to_fetch);
            $old_data=fetch_1st_tab_data($pdo, $id_to_fetch);
        
            // Update the audit trail
            $audit_trail_query = "UPDATE tbl_blotter_audit_trail 
                SET edited_by = ?, blotter_edit_dt = CURRENT_TIMESTAMP 
                WHERE blotter_at_id = ?";
            $stmt = $pdo->prepare($audit_trail_query);
            $stmt->execute([$userid, $id_to_fetch]);
        
            // Build the query dynamically based on whether the file fields are set
            $update_columns = [
                'res_complainant_no' => $resident_complainant,
                'nres_complainant_no' => $non_resident_complainant,
                'res_respondent_no' => $resident_respondent,
                'nres_respondent_no' => $non_resident_respondent,
                'blotter_type' => $blotter_type,
                'desc_incident' => $incident_desc,
                'incident_dt' => $incident_date,
                'location_of_incident' => $incident_location,
                'statemnt' => $case_context,
                'mediation_date' => $schedule_date,
                'mediation_starttime' => $schedule_starttime,
                'mediation_endtime' => $schedule_endtime,
                'mediator_no' => $mediator_no,
                'schedule_color' => $schedule_color,
                'report_status' => $report_status,
                'date_of_resolution' => $dateofresolution
            ];
        
            // Conditionally add file columns only if files are uploaded
            if ($blotter_evidencefile !== null) {
                $update_columns['blotter_evidencefile'] = $blotter_evidencefile;
            }
        
            if ($blotter_contextfile !== null) {
                $update_columns['blotter_contextfile'] = $blotter_contextfile;
            }
        
            // Build the dynamic SET part of the query
            $set_clause = [];
            $params = [];
            foreach ($update_columns as $column => $value) {
                $set_clause[] = "$column = ?";
                $params[] = $value;
            }
        
            $set_clause_str = implode(", ", $set_clause);
            $params[] = $id_to_fetch; // Add blotter_id to the parameters for WHERE clause
        
            // Final SQL query with conditional columns
            $blotter_query = "UPDATE tbl_blotters SET $set_clause_str WHERE blotter_id = ?";
            $blotter_stmt = $pdo->prepare($blotter_query);
            $blotter_stmt->execute($params);
        
            // Delete existing other complainants and respondents for the blotter ID
            $delete_other_parties_query = "DELETE FROM tbl_blotter_other_person WHERE blotter_id = ?";
            $delete_stmt = $pdo->prepare($delete_other_parties_query);
            $delete_stmt->execute([$id_to_fetch]);
        
            // Re-insert updated other complainants and respondents
            $other_party_query = "
                INSERT INTO tbl_blotter_other_person(party_type, blotter_id, resident_id, non_resident_id) 
                VALUES (?, ?, ?, ?)
            ";
            $other_party_stmt = $pdo->prepare($other_party_query);
        
            foreach ($other_person as $role => $party) {
                foreach ($party as $type => $person_ids) {
                    foreach ($person_ids as $person_id) {
                        if (!empty($person_id)) {
                            // Determine role type and assign resident or non-resident
                            $role_type = $role === 'other_complainants' ? 'complainant' : 'respondent';
                            $res_person_no = ($type === 'resident') ? $person_id : null;
                            $nres_person_no = ($type === 'non_resident') ? $person_id : null;
        
                            $other_party_stmt->execute([$role_type, $id_to_fetch, $res_person_no, $nres_person_no]);
                        }
                    }
                }
            }

            $pdo->commit();
        
        } catch (Exception $e) {
            $pdo->rollBack();
            $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
            exit(json_encode($response));
        }

        try {
        
            $new_other_complainants = fetch_other_complainants($pdo, $id_to_fetch);
            $new_other_respondents = fetch_other_respondents($pdo, $id_to_fetch);
            $new_other_details = fetch_other_details($pdo, $id_to_fetch);
            $new_data = fetch_1st_tab_data($pdo, $id_to_fetch);
        
            // Structure data as a JSON object
            $action_data = [
                "old_other_complainants" => $old_other_complainants,
                "old_other_respondents" => $new_other_respondents,
                "old_main_comp_res_details" => $old_data,
                "new_other_complainants" => $new_other_complainants,
                "new_other_respondents" => $new_other_respondents,
                "new_main_comp_res_details" => $new_data,
                "old_other_data" => $old_other_details,
                "new_other_data" => $new_other_details
            ];
        
            // Convert to JSON string
            $action_data_json = json_encode($action_data, JSON_PRETTY_PRINT);
        
            // Insert into tbl_blotter_audit
            $record_snapshot_query = "
                INSERT INTO tbl_blotters_audit (blotter_no, action_type, user_no, is_deleted, action_data)
                VALUES (?, 'UPDATE', ?, 0,?)";
            $record_snapshot_stmt = $pdo->prepare($record_snapshot_query);
            $record_snapshot_stmt->execute([$id_to_fetch, $userid, $action_data_json]);

            $response = ["success" => true, "message" => "Blotter Updated Successfully!"];
            echo json_encode($response);
        
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        
        
    }else if ($operation_check == "FETCH_MAIN_TABLE"){
        
        try {
            $sql = "SELECT * FROM vw_blotters WHERE is_deleted = 0 ORDER BY blotter_add_dt DESC LIMIT :start_from, :lim"; 
            $stmt = $pdo->prepare($sql);
            $stmt -> bindValue(':start_from', (int)$start_from, PDO::PARAM_INT);
            $stmt -> bindValue(':lim', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if there are any results
            if (count($result) > 0) {
                // Output each row as HTML
                require_once'blottertabletofetch.php';
            } else {
                echo '<tr><td colspan="12">No records found.</td></tr>';
            }

            
        } catch (PDOException $e) {
            echo 'Error: ' . htmlspecialchars($e->getMessage());
        }

    }else if($operation_check == "FETCH_COMPLAINANTS_IDS"){

        try{
            $sqlquery = "CALL FetchAllComplainantsID(?)";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$id_to_fetch]);
            $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);    

            echo json_encode($result);
            

        }catch(Exception $e){

            echo json_encode(["success" => false, "message" => "Server Error: ".$e->getMessage()]);

        }

    }else if($operation_check == "FETCH_RESPONDENTS_IDS"){

        try{
            $sqlquery = "CALL FetchAllRespondentsID(?)";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$id_to_fetch]);
            $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($result);        

        }catch(Exception $e){

            echo json_encode(["success" => false, "message" => "Server Error: ".$e->getMessage()]);

        }

    }else if($operation_check == "FETCH_OTHER_COMPLAINANTS_MODAL"){
        $isedit = (isset($_POST['what_modal']))?$_POST['what_modal']:null;
        
            try{
                $sqlquery = "CALL FetchAllComplainant(?)";
                $stmt = $pdo->prepare($sqlquery);
                $stmt->execute([$id_to_fetch]);
                $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);

                if(!$result == 0){
                    require_once 'blotterotherpersontabletofetch.php';
                }else{
                    echo '<tr id="NoResult"><td colspan="4">No Other Complainants Found</td></tr>';
                }
        
            }catch(Exception $e){
                echo json_encode(["success" => false, "message" => "Server Error: ".$e->getMessage()]);
            }
    
        echo $isedit;
    }else if($operation_check == "FETCH_OTHER_RESPONDENTS_MODAL"){
        $isedit = (isset($_POST['what_modal']))?$_POST['what_modal']:null;

        try{
            $sqlquery = "CALL FetchAllRespondents(?)";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$id_to_fetch]);
            $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
            
            if(!$result == 0){
                require_once 'blotterotherpersontabletofetch.php';
            }else{
                echo '<tr id="NoResult"><td colspan="4">No Other Respondents Found</td></tr>';
            }
        
        }catch(Exception $e){
            echo json_encode(["success" => false, "message" => "Server Error: ".$e->getMessage()]);
        }
    
    }else if($operation_check == "FETCH_MODAL_IMG"){

        try{
            $sqlquery = "SELECT blotter_contextfile, blotter_evidencefile FROM tbl_blotters WHERE blotter_id= ?";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$id_to_fetch]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(["success" => true, "data" => $result]);


        }catch(Exception $e){

            echo json_encode(["success" => false, "message" => "Server Error: ".$e->getMessage()]);

        }


    }else if($operation_check == "FETCH_OTHER_CASE_DETAILS_MODAL"){

        try{
            $sqlquery = "SELECT b.blotter_type, b.desc_incident, b.incident_dt, 
                        b.location_of_incident, b.date_of_resolution, b.statemnt, 
                        b.mediation_starttime, b.mediation_endtime, b.mediation_date, 
                        b.schedule_color, b.report_status,
                        b.mediator_no AS mediator_name
                        FROM tbl_blotters b
                        LEFT JOIN tbl_blotter_mediator m ON b.mediator_no = m.mediator_id
                        WHERE b.blotter_id = ?";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$id_to_fetch]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(["success" => true, "data" => $result]);
        }catch(Exception $e){
            echo json_encode(["success" => false, "message" => "Server Error: ".$e->getMessage()]);
        }

    }else if($operation_check == "DELETE_BLOTTER"){
        try{
        
            $pdo -> beginTransaction();
            $audit_query = "UPDATE tbl_blotter_audit_trail SET deleted_by=?, blotter_delete_dt= CURRENT_TIMESTAMP";
            $stmt = $pdo->prepare($audit_query);
            $stmt->execute([$userid]);

            $sqlquery = "UPDATE tbl_blotters SET is_deleted=1 WHERE blotter_id = ?";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$id_to_fetch]);
            $pdo->commit();
            echo json_encode(["success" => true, "message" => "Blotter deleted successfully"]);

        }catch(Exception $e){
            $pdo->rollBack();
            echo json_encode(["success" => false, "message" => "Server Error: ".$e]);

        }

        try {
        
            $new_other_complainants = fetch_other_complainants($pdo, $id_to_fetch);
            $new_other_respondents = fetch_other_respondents($pdo, $id_to_fetch);
            $new_other_details = fetch_other_details($pdo, $id_to_fetch);
            $new_data = fetch_1st_tab_data($pdo, $id_to_fetch);
        
            // Structure data as a JSON object
            $action_data = [
                "new_other_complainants" => $new_other_complainants,
                "new_other_respondents" => $new_other_respondents,
                "new_main_comp_res_details" => $new_data,
                "new_other_data" => $new_other_details
            ];
        
            // Convert to JSON string
            $action_data_json = json_encode($action_data, JSON_PRETTY_PRINT);
        
            // Insert into tbl_blotter_audit
            $record_snapshot_query = "
                INSERT INTO tbl_blotters_audit (blotter_no, action_type, user_no, is_deleted, action_data)
                VALUES (?, 'DELETE', ?, 1,?)";
            $record_snapshot_stmt = $pdo->prepare($record_snapshot_query);
            $record_snapshot_stmt->execute([$id_to_fetch, $userid, $action_data_json]);

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

    }else if($operation_check == "UNDO_DELETE"){
        try{
        
            $pdo -> beginTransaction();
            $audit_query = "UPDATE tbl_blotter_audit_trail SET deleted_by=?, blotter_delete_dt= CURRENT_TIMESTAMP";
            $stmt = $pdo->prepare($audit_query);
            $stmt->execute([$userid]);

            $sqlquery = "UPDATE tbl_blotters SET is_deleted=0 WHERE blotter_id = ?";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$id_to_fetch]);
            $pdo->commit();

        }catch(Exception $e){
            $pdo->rollBack();
            echo json_encode(["success" => false, "message" => "Server Error: ".$e]);
            die();

        }

        try {
        
            $new_other_complainants = fetch_other_complainants($pdo, $id_to_fetch);
            $new_other_respondents = fetch_other_respondents($pdo, $id_to_fetch);
            $new_other_details = fetch_other_details($pdo, $id_to_fetch);
            $new_data = fetch_1st_tab_data($pdo, $id_to_fetch);
        
            // Structure data as a JSON object
            $action_data = [
                "new_other_complainants" => $new_other_complainants,
                "new_other_respondents" => $new_other_respondents,
                "new_main_comp_res_details" => $new_data,
                "new_other_data" => $new_other_details
            ];
        
            // Convert to JSON string
            $action_data_json = json_encode($action_data, JSON_PRETTY_PRINT);
        
            // Insert into tbl_blotter_audit
            $record_snapshot_query = "
                INSERT INTO tbl_blotters_audit (blotter_no, action_type, user_no, is_deleted, action_data)
                VALUES (?, 'RECOVER', ?, 0,?)";
            $record_snapshot_stmt = $pdo->prepare($record_snapshot_query);
            $record_snapshot_stmt->execute([$id_to_fetch, $userid, $action_data_json]);

            $response = ["success" => true, "message" => "Blotter Recovered Successfully!"];
            echo json_encode($response);
        
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            die();
        }

    }else if($operation_check == "PAGINATION"){
        // Fetch the total number of records
        $query ="SELECT COUNT(*) FROM vw_blotters WHERE is_deleted = 0";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $total_records = $stmt->fetchColumn();
        $limit = 10; //To limit the number of pages
        $total_pages = ceil($total_records / $limit);

        // Get the current page or set a default
        $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
        $current_page = max(1, min($current_page, $total_pages));
        $start_from = ($current_page - 1) * $limit;

        require_once'paginationtemplate.php';

    
    }else if($operation_check == "SHOW_DELETED"){

        // Fetch the total number of records
        $total_records = $pdo->query("SELECT COUNT(*) FROM vw_blotters_deleted")->fetchColumn();
        $limit = 10; //To limit the number of pages
        $total_pages = ceil($total_records / $limit);

        // Get the current page or set a default
        $page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
        $page = max(1, min($page, $total_pages));
        $start_from = ($page - 1) * $limit;

        // Fetch the data for the current page
        $query = $pdo->prepare("SELECT * FROM vw_blotters_deleted ORDER BY blotter_add_dt DESC LIMIT :start_from, :lim");
        $query->bindValue('start_from',(int)$start_from, PDO::PARAM_INT);
        $query->bindValue('lim', (int)$limit, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll();

    if(!empty($result)){
        require_once'blottertabletofetch.php';
    }else{
        echo '<tr><td colspan="11"><b>No Deleted Records found</b></td></tr>';
    }

    }else if($operation_check == "SEARCH"){
        if(!empty($search)){

            // query to fetch records with pagination
            $searchquery = "CALL SearchBlotterRecords(:search,:start_from,:limit)";
            $stmt = $pdo->prepare($searchquery); 
            $stmt->execute(['search' => "%$search%", 'start_from' => "$start_from", 'limit' => "$limit"]);

            $result = $stmt->fetchAll();

            $lastpage = $page - 1; 

            if(!empty($result)){
                // Code for displaying the results
            require_once'blottertabletofetch.php';
                
            }else if(count($result) === 1){
                $page = $lastpage - 1;
                require_once'blottertabletofetch.php';

            }else{
                echo '<tr><td colspan="11"><b>No results found</b></td></tr>';
            }
        }else{
            echo '<tr><td colspan="11">No Query</td></tr>';
        }
    }else if($operation_check == "SEARCH_PAGINATION"){
        
            $query= "CALL SearchBlotterRecords(:search, :start_from, :lim)";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':search', (string)"%$search%", PDO::PARAM_STR);
            $stmt->bindValue(':start_from', (int)$start_from, PDO::PARAM_INT);
            $stmt -> bindValue(':lim',$limit, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll();
        
            $total_entries = count($results);
        
            $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
            $total_pages = max(1, min($current_page, $total_entries));
            $start_from = ($current_page - 1) * $limit;
                
            require_once'paginationtemplate.php';
        
    }else if($operation_check == "PAGINATION_FOR_DEL_REC"){
        
            if(!empty($search)){
        
                $searchquery = "CALL SearchBlotterRecords(:search, :start_from, $limit)";
                $stmt = $pdo->prepare($searchquery);
                $stmt -> bindValue(':search',"%$search%", PDO::PARAM_STR);
                $stmt -> bindValue(':start_from',$start_from, PDO::PARAM_INT);
                $stmt->execute();
                $results = $stmt->fetchAll();
                $total_pages = (ceil(count($results) - 1) / $limit);
        
            }else{
        
                // Fetch the total number of records
                $total_records = $pdo->query("SELECT COUNT(*) FROM vw_blotters_deleted")->fetchColumn();
                $limit = 10; //To limit the number of pages
                $total_pages = ceil($total_records / $limit);
        
            }
            // Get the current page or set a default
            $page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
            $current_page = max(1, min($page, $total_pages));
            $start_from = ($page - 1) * $limit;
            require_once('paginationtemplate.php');
    }else if($operation_check == "CHANGE_SCHEDULE"){

        try{
            $pdo->beginTransaction();

            $update_query = "UPDATE tbl_blotters SET mediation_date=?, mediation_starttime=?, mediation_endtime=? WHERE blotter_id=?";
            $stmt = $pdo->prepare($update_query);
            $stmt->execute(array($schedule_date, $schedule_starttime, $schedule_endtime,$id_to_fetch));

            $pdo->commit();

            echo json_encode(["success"=>true, "message"=>"Blotter Schedule Updated Successfully"]);

        }catch(Exception $e){
            $pdo->rollBack();
            echo json_encode(["success"=>false, "message"=>$e->getMessage()]);

        }

    }else if($operation_check == "FETCH_MEDIATOR"){
        $sqlquery = "SELECT * FROM tbl_blotter_mediator WHERE mediator_id = ?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute(array($mediator_no));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);
    }else if($operation_check == "FETCH_MODAL_1ST_TAB"){

        $sql = "SELECT * FROM vw_blotters WHERE blotter_id = :blotterid"; 
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(':blotterid', (int)$id_to_fetch, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
    
    }else if($operation_check == "FETCH_MEDIATORS_TABLE"){

        $is_deleted=($_POST['is_deleted']==0)? 0 : 1; 

        $sqlquery = "SELECT * FROM tbl_blotter_mediator WHERE is_deleted = ?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$is_deleted]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($is_deleted == 0){
            foreach($result as $mediator){

                echo ' <tr>
                            <td>
                                <input type="text" id="lname_'.htmlspecialchars($mediator['mediator_id']).'" class="form-control" value="'.htmlspecialchars($mediator['last_name']).'" data-id="'.htmlspecialchars($mediator['mediator_id']).'" placeholder=""/>
                            </td>
                            <td>
                                <input type="text" id="fname_'.htmlspecialchars($mediator['mediator_id']).'" class="form-control" value="'.htmlspecialchars($mediator['first_name']).'" data-id="'.htmlspecialchars($mediator['mediator_id']).'" placeholder=""/>
                            </td>
                            <td>
                                <input type="text" id="mname_'.htmlspecialchars($mediator['mediator_id']).'" class="form-control" value="'.htmlspecialchars($mediator['middle_name']).'" data-id="'.htmlspecialchars($mediator['mediator_id']).'" placeholder=""/>
                            </td>
                            <td>
                                <input type="text" id="suffix_'.htmlspecialchars($mediator['mediator_id']).'" class="form-control" value="'.htmlspecialchars($mediator['suffix']).'" data-id="'.htmlspecialchars($mediator['mediator_id']).'" placeholder=""/>
                            </td>
                            <td class="d-flex justify-content-center">

                            <button class="btn btn-success mx-2 editmediatorbtn" data-id='.htmlspecialchars($mediator['mediator_id']).'>Edit</button>
                                <button class="btn btn-danger deletemediatorbtn" data-id='.htmlspecialchars($mediator['mediator_id']).'>Delete</button>
                        
                            </td>
                            
                            
                        </tr>
                        
                        ';


            }

                echo '<tr>
                        <th scope="row">
                            <input type="text" class="form-control" id="newmediator_lname" placeholder=""/>
                        </th>
                        <th scope="row">
                            <input type="text" class="form-control" id="newmediator_fname" placeholder=""/>
                        </th>
                        <th scope="row">
                            <input type="text" class="form-control" id="newmediator_mname" placeholder=""/>
                        </th>
                        <th scope="row">
                            <input type="text" class="form-control" id="newmediator_mname" placeholder=""/>
                        </th>

                        <td class="d-flex justify-content-center">
                            <button class="btn btn-primary addmediatorbtn">Add</button>
                        </td>
                    </tr>';
        }else{

            foreach($result as $mediator){

                echo ' <tr>
                            <td>
                                '.htmlspecialchars($mediator['last_name']).'
                            </td>
                            <td>
                                '.htmlspecialchars($mediator['first_name']).'
                            </td>
                            <td>
                                '.htmlspecialchars($mediator['middle_name']).'
                            </td>
                            <td>
                               '.htmlspecialchars($mediator['suffix']).'
                            </td>
                            <td class="d-flex justify-content-center">

                            <button class="btn btn-warning mx-2 recovertmediatorbtn" data-id='.htmlspecialchars($mediator['mediator_id']).'>Recover</button>
                        
                            </td>
                            
                            
                        </tr>
                        
                        ';


            }

        }

    }else if($operation_check == "EDIT_MEDIATOR"){

        if(empty($fname) && empty($lname)){
            exit(["success" => false, "message" => "First name and Last Name should not be empty!"]);
        }

        try{
            $pdo->beginTransaction();
        
            $sqlquery = "UPDATE tbl_blotter_mediator SET first_name =?, last_name=?, middle_name=?, suffix=? WHERE mediator_id=?";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$fname, $lname, $mname, $suffix, $mediator_no]);

            $pdo->commit();

            echo json_encode(["success"=>true, "message" => "Mediator updated successfully"]);
        }catch(Exception $e){
            echo json_encode(["success"=>false, "message" => $e->getMessage()]);
            $pdo->rollBack();

        }
    }else if($operation_check == "ADD_MEDIATOR"){

        if(empty($fname) && empty($lname)){
            exit(["success" => false, "message" => "First name and Last Name should not be empty!"]);
        }

        try{
            $pdo->beginTransaction();
        
            $sqlquery = "INSERT INTO tbl_blotter_mediator(last_name, first_name, middle_name, suffix) VALUES (?,?,?,?)";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$lname, $fname, $mname, $suffix]);
            $pdo->commit();
    
            echo json_encode(["success"=>true, "message" => "Mediator added successfully"]);
        }catch(Exception $e){
            echo json_encode(["success"=>false, "message" => $e->getMessage()]);
            $pdo->rollBack();
    
        }
    }else if($operation_check == "DELETE_MEDIATOR"){

        try{
            $pdo->beginTransaction();
        
            $sqlquery = "UPDATE tbl_blotter_mediator SET is_deleted = 1 WHERE mediator_id = ?";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$mediator_no]);
    
            $pdo->commit();
    
            echo json_encode(["success"=>true, "message" => "Mediator deleted successfully"]);
        }catch(Exception $e){
            echo json_encode(["success"=>false, "message" => $e->getMessage()]);
            $pdo->rollBack();
    
        }
    }else if($operation_check == "RECOVER_MEDIATOR"){

        try{
            $pdo->beginTransaction();
        
            $sqlquery = "UPDATE tbl_blotter_mediator SET is_deleted = 0 WHERE mediator_id = ?";
            $stmt = $pdo->prepare($sqlquery);
            $stmt->execute([$mediator_no]);
    
            $pdo->commit();
    
            echo json_encode(["success"=>true, "message" => "Mediator deleted successfully"]);
        }catch(Exception $e){
            echo json_encode(["success"=>false, "message" => $e->getMessage()]);
            $pdo->rollBack();
    
        }
    }else{
        echo json_encode(["success" => false, "message" =>"Nothing was recieved"]);
    }
    $pdo = NULL;

}else{
    header('Location: index.php');
    exit();
}

?>
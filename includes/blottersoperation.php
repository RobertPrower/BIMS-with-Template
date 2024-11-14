<?php 
if($_SERVER['REQUEST_METHOD']!=="POST"){
    exit("Access Denied");
}

require_once'connecttodb.php';
require_once'anti-SQLInject.php';

$operation_check = (isset($_POST['operation']))? $_POST['operation']: null;
$userid = null;
$id_to_fetch = (isset($_POST['blotter_id']))? $_POST['blotter_id']: null;

$limit = 10;
$search = isset($_POST['search']) ? sanitizeData($_POST['search']): '';
$page = isset($_POST['page']) ? $_POST['page'] : '1';
$start_from = ($page - 1) * $limit;

$main_complainantid = isset($_POST['main_complainantid'])?sanitizeData($_POST['main_complainantid']): NULL; 
$main_complainant_status = isset($_POST['main_complainant_status'])?sanitizeData($_POST['main_complainant_status']): NULL;
$main_respondentid = isset($_POST['main_respondentid'])?sanitizeData($_POST['main_respondentid']): NULL;
$main_respondent_status = isset($_POST['main_respondent_status'])?sanitizeData($_POST['main_respondent_status']): NULL;;

function handleNullValue($value) {
    return $value === "null" ? NULL : $value;
}

$dataTypes = ['resident_complainant', 'resident_respondent', 'nonresident_complainant', 'nonresident_respondent'];
$data = [];

if($operation_check == "ADD_BLOTTER" || $operation_check =="EDIT_BLOTTER"){
    foreach ($dataTypes as $type) {
        for ($i = 1; $i <= 5; $i++) {
            $key = "other_{$type}{$i}";
            $other_person[$key] = handleNullValue($_POST[$key]);
        }
    }
}

$schedule_date = isset($_POST['schedule_date'])?$_POST['schedule_date']: NULL;
$schedule_starttime = isset($_POST['schedule_starttime'])?$_POST['schedule_starttime']: NULL;
$schedule_endtime = isset($_POST['schedule_endtime'])?$_POST['schedule_endtime']: NULL;
$schedule_color = isset($_POST['schedule_color'])?$_POST['schedule_color']: NULL;
$mediator_name = isset($_POST['mediator_name'])?$_POST['mediator_name']: NULL;
$incident_date = isset($_POST['incident_date'])?$_POST['incident_date']: NULL;
$incident_desc = isset($_POST['incident_desc'])?$_POST['incident_desc']: NULL;
$incident_location = isset($_POST['incident_location'])?sanitizeData($_POST['incident_location']): NULL;
$blotter_type = isset($_POST['blotter_type'])?sanitizeData($_POST['blotter_type']): NULL;
$case_context = isset($_POST['case_context'])?sanitizeData($_POST['case_context']): NULL;

$blotter_evidence_fd = "img/blotter_evidence/";
$blotter_context_fd = "img/blotter_context/";

function handleNullValues($value){
    return $value ==="null"? NULL : $value;
}
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

if($operation_check == "FETCH_SCHEDULE_ON_MODAL"){

    $sqlquery = "SELECT * FROM vw_blotters_schedule";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
}else if($operation_check == "FETCH_MEDIATOR_SELECT"){

    $sqlquery = "SELECT CONCAT(first_name, ' ', middle_name, ', ', last_name, ' ', COALESCE(suffix, '')) AS mediator_name FROM tbl_blotter_mediator";
    $stmt = $pdo -> prepare($sqlquery);
    $stmt -> execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<option value="" hidden>Select Mediator</option>';

    foreach($results as $mediator_name){

        echo '<option value="'.htmlspecialchars($mediator_name['mediator_name']).'">'.htmlspecialchars($mediator_name['mediator_name']).'</option>';

    }

}else if($operation_check == "ADD_BLOTTER"){
    if($main_complainant_status == 0){
        $resident_complainant = $main_complainantid;
        $non_resident_complainant = NULL;
    }else if($main_complainant_status ==1){
        $non_resident_complainant = $main_complainantid;
        $resident_complainant = NULL;   
    }

    if($main_respondent_status == 0){
        $resident_respondent = $main_respondentid;
        $non_resident_respondent = NULL;
    }else if($main_respondent_status ==1){
        $non_resident_respondent = $main_respondentid;
        $resident_respondent = NULL;
    }

    try{
        $blotter_evidencefile = handleImageUpload('blotter_evidencefile',$blotter_evidence_fd);
        $blotter_contextfile = handleImageUpload('blotter_contextfile',$blotter_context_fd);
    }catch(Exception $e){
        $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
        $pdo=null;
        exit(json_encode($response));
    }

    try{
        $pdo -> beginTransaction();

        $audit_trail_query = "INSERT INTO tbl_blotter_audit_trail(assisted_by_no) VALUES(?)";
        $stmt = $pdo->prepare($audit_trail_query);
        $stmt->execute([$userid]);

        $other_query = "INSERT INTO tbl_other_complainants(res_person_1,nres_person_1,res_person_2,nres_person_2,res_person_3,nres_person_3,res_person_4,nres_person_4,res_person_5,nres_person_5) 
                        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $other_stmt=$pdo->prepare($other_query);
        $other_stmt->execute([$other_person['other_resident_complainant1'],$other_person['other_nonresident_complainant1'],$other_person['other_resident_complainant2'],$other_person['other_nonresident_complainant2'],$other_person['other_resident_complainant3'],$other_person['other_nonresident_complainant3'],$other_person['other_resident_complainant4'],$other_person['other_nonresident_complainant4'],$other_person['other_resident_complainant5'],$other_person['other_nonresident_complainant5']]);

        $other_query = "INSERT INTO tbl_other_respondents(res_person_1,nres_person_1,res_person_2,nres_person_2,res_person_3,nres_person_3,res_person_4,nres_person_4,res_person_5,nres_person_5) 
        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $other_stmt=$pdo->prepare($other_query);
        $other_stmt->execute([$other_person['other_resident_respondent1'],$other_person['other_nonresident_respondent1'],$other_person['other_resident_respondent2'],$other_person['other_nonresident_respondent2'],$other_person['other_resident_respondent3'],$other_person['other_nonresident_respondent3'],$other_person['other_resident_respondent4'],$other_person['other_nonresident_respondent4'],$other_person['other_resident_respondent5'],$other_person['other_nonresident_respondent5']]);

        $blotter_query = "INSERT INTO tbl_blotters(res_complainant_no, nres_complainant_no, res_respondent_no, nres_respondent_no, blotter_type, desc_incident,
         incident_dt, location_of_incident, statemnt, mediation_date, mediation_starttime, mediation_endtime, schedule_color, blotter_evidencefile, blotter_contextfile) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
        $blotter_stmt = $pdo -> prepare($blotter_query);
        $blotter_stmt -> execute([$resident_complainant, $non_resident_complainant, $resident_respondent, $non_resident_respondent,
                        $blotter_type, $incident_desc, $incident_date, $incident_location, $case_context, $schedule_date, $schedule_starttime, $schedule_endtime, $schedule_color, $blotter_evidencefile, $blotter_contextfile]);
        $pdo->commit();

        $response = ["success" => true, "message" => "Blotter Added Successfully!"];
        echo json_encode($response);

   }catch(Exception $e){
        $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
        $pdo->rollBack(); 
        exit(json_encode($response));
   }

}else if($operation_check == "EDIT_BLOTTER") { 

    $resolution_date = (!empty($_POST['resolution_date']))? $_POST['resolution_date']: null;

    $converted_comp_status = ($main_complainant_status === "Resident")? 0 : 1;
    $converted_res_status = ($main_respondent_status === "Resident")? 0 : 1;

    if($converted_comp_status == 0) {

        $resident_complainant = $main_complainantid;
        $non_resident_complainant = NULL;

    } else if($converted_res_status == 1) {

        $non_resident_complainant = $main_complainantid;
        $resident_complainant = NULL;   
    }

    if($converted_res_status == 0) {
        $resident_respondent = $main_respondentid;
        $non_resident_respondent = NULL;
    } else if($converted_res_status == 1) {
        $non_resident_respondent = $main_respondentid;
        $resident_respondent = NULL;
    }

    if(isset($_FILES['blotter_evidencefile']) && $_FILES['blotter_evidencefile']['error'] === UPLOAD_ERR_OK){
        try {
            $blotter_evidencefile = handleImageUpload('blotter_evidencefile', $blotter_evidence_fd);
        } catch(Exception $e) {
            $response = ["success" => false, "message" => "Error uploading evidence file: " . $e->getMessage()];
            $pdo = null;
            exit(json_encode($response));
        }
    }

    if(isset($_FILES['blotter_contextfile']) && $_FILES['blotter_contextfile']['error'] === UPLOAD_ERR_OK){
        try {
            $blotter_contextfile = handleImageUpload('blotter_contextfile', $blotter_context_fd);
        } catch(Exception $e) {
            $response = ["success" => false, "message" => "Error uploading context file: " . $e->getMessage()];
            $pdo = null;
            exit(json_encode($response));
        }
    }
    

    try {
        $pdo->beginTransaction();

        // Insert into audit trail
        $audit_trail_query = "INSERT INTO tbl_blotter_audit_trail(edited_by, blotter_edit_dt) VALUES(?, CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($audit_trail_query);
        $stmt->execute([$userid]);

        // Update tbl_other_complainants
        $update_complainants_query = "
            UPDATE tbl_other_complainants 
            SET res_person_1 = ?, nres_person_1 = ?, 
                res_person_2 = ?, nres_person_2 = ?, 
                res_person_3 = ?, nres_person_3 = ?, 
                res_person_4 = ?, nres_person_4 = ?, 
                res_person_5 = ?, nres_person_5 = ? 
            WHERE complainant_id = ?
        ";
        $update_complainants_stmt = $pdo->prepare($update_complainants_query);
        $update_complainants_stmt->execute([
            $other_person['other_resident_complainant1'], $other_person['other_nonresident_complainant1'],
            $other_person['other_resident_complainant2'], $other_person['other_nonresident_complainant2'],
            $other_person['other_resident_complainant3'], $other_person['other_nonresident_complainant3'],
            $other_person['other_resident_complainant4'], $other_person['other_nonresident_complainant4'],
            $other_person['other_resident_complainant5'], $other_person['other_nonresident_complainant5'],
            $id_to_fetch
        ]);

        // Update tbl_other_respondents
        $update_respondents_query = "
            UPDATE tbl_other_respondents 
            SET res_person_1 = ?, nres_person_1 = ?, 
                res_person_2 = ?, nres_person_2 = ?, 
                res_person_3 = ?, nres_person_3 = ?, 
                res_person_4 = ?, nres_person_4 = ?, 
                res_person_5 = ?, nres_person_5 = ? 
            WHERE respondent_id = ?
        ";
        $update_respondents_stmt = $pdo->prepare($update_respondents_query);
        $update_respondents_stmt->execute([
            $other_person['other_resident_respondent1'], $other_person['other_nonresident_respondent1'],
            $other_person['other_resident_respondent2'], $other_person['other_nonresident_respondent2'],
            $other_person['other_resident_respondent3'], $other_person['other_nonresident_respondent3'],
            $other_person['other_resident_respondent4'], $other_person['other_nonresident_respondent4'],
            $other_person['other_resident_respondent5'], $other_person['other_nonresident_respondent5'],
            $id_to_fetch
        ]);

        // Update tbl_blotters
        $blotter_query = "
            UPDATE tbl_blotters 
            SET res_complainant_no = ?, nres_complainant_no = ?, 
                res_respondent_no = ?, nres_respondent_no = ?, 
                blotter_type = ?, desc_incident = ?, 
                incident_dt = ?, location_of_incident = ?, 
                statemnt = ?, mediation_date = ?, 
                mediation_starttime = ?, mediation_endtime = ?, 
                schedule_color = ?
        ";
        $params = [
            $resident_complainant, $non_resident_complainant, 
            $resident_respondent, $non_resident_respondent,
            $blotter_type, $incident_desc, 
            $incident_date, $incident_location, 
            $case_context, $schedule_date, 
            $schedule_starttime, $schedule_endtime, 
            $schedule_color
        ];

        if (isset($blotter_contextfile)) {
            $blotter_query .= ", blotter_contextfile = ?";
            $params[] = $blotter_contextfile;
        }

        if(isset($resolution_date)){
            $blotter_query .= ", date_of_resolution = ?";
            $params[] = $resolution_date;
        }

        if (isset($blotter_evidencefile)) {
            $blotter_query .= ", blotter_evidencefile = ?";
            $params[] = $blotter_evidencefile;
        }

        $blotter_query .= " WHERE blotter_id = ?";
        $params[] = $id_to_fetch;

        $blotter_stmt = $pdo->prepare($blotter_query);
        $blotter_stmt->execute($params);

        $pdo->commit();

        $response = ["success" => true, "message" => "Blotter Updated Successfully!"];
        echo json_encode($response);

    } catch (Exception $e) {
        $pdo->rollBack();
        $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
        exit(json_encode($response));
    }
}else if ($operation_check == "FETCH_MAIN_TABLE"){
    $sqlquery = "SELECT * FROM vw_blotters WHERE is_deleted = 0";
    $stmt=$pdo->prepare($sqlquery);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

    require_once'blottertabletofetch.php';


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
                foreach($result as $row){
                    $html = '<tr id="'.$row['id'].'" data-id="'.$row['id'].'" data-status="'.$row['status'].'">
                    
                    <td hidden class="othercomplainantIDs">'.htmlspecialchars($row['id']).'</td>';
            
                    if(htmlspecialchars($row['status']) == "Resident"){
                        $html .= '<td><img src="includes/img/resident_img/'.htmlspecialchars($row['img_filename']).'" width="100" height="100" style="object-fit: contain; max-width: 100%; max-height: 100%;"/></td>';
                    }else{
                        $html.= '<td><img src="includes/img/non_resident_img/'.htmlspecialchars($row['img_filename']).'" width="100" height="100" style="object-fit: contain; max-width: 100%; max-height: 100%;"/></td>';
                    }
            
                    $html.=    '<td class="text-center justify-content-center">'.htmlspecialchars($row['full_name']).'</td>';
    
                    if($row['status'] == "Resident"){
    
                        $html .= '<td class="text-center d-flex align-items-center justify-content-center">'.htmlspecialchars($row['status']).'</td>';
                    }else if($row['status'] == "Non-Resident"){
                        $html .= '<td class="text-center justify-content-center">'.htmlspecialchars($row['status']).'</td>';
                    }else{
                        $html .= '<td class="text-center justify-content-center"><span class="badge rounded-pill  text-bg-secondary">Unknown</span></td>';
                    }
    

                    if($isedit == "#EditBlotterModal"){
                        $html .= '<td><button class="btn btn-danger mx-2 removepersons" id="removeOtherComplainants"
                                    data-id="'.htmlspecialchars($row['id']).'"
                                    data-whatbtn="OtherComplainants" data-status="'.htmlspecialchars($row['status']).'">
                                    Remove
                                </button>';        
                    }else{

                        $html .= '
                            <td>
                            <button class="btn btn-primary viewPersonDetails"
                                data-id="'.htmlspecialchars($row['id']).'"
                                data-status="'.htmlspecialchars($row['status']).'"
                                data-whatbtn="othercomplainant">
                                View Details
                            </button></td>';
                        
                    }

                    $html .='</td>
                            </tr>';
    
                            echo $html;
    
                }
    
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
            foreach($result as $row){
                echo'<tr id="'.htmlspecialchars($row['id']).'" data-status="'.$row['status'].'" data-id="'.$row['id'].'">
                <td hidden class="otherrespondentsIDs">'.htmlspecialchars($row['id']).'</td>';
        
                if(htmlspecialchars($row['status']) == "Resident"){
                    echo '<td><img src="includes/img/resident_img/'.htmlspecialchars($row['img_filename']).'" width="100" height="100" style="object-fit: contain; max-width: 100%; max-height: 100%;"/></td>';
                }else{
                    echo '<td><img src="includes/img/non_resident_img/'.htmlspecialchars($row['img_filename']).'" width="100" height="100" style="object-fit: contain; max-width: 100%; max-height: 100%;"/></td>';
                }
        
                echo    '<td>'.htmlspecialchars($row['full_name']).'</td>
                        <td>'.htmlspecialchars($row['status']).'</td>
                        <td>';

                if($isedit == "#EditBlotterModal"){
                    echo '
                        <button class="btn btn-danger mx-2 removepersons" id="removeOtherComplainants"
                                data-id="'.htmlspecialchars($row['id']).'"
                                data-whatbtn="OtherRespondents" data-status="'.htmlspecialchars($row['status']).'">
                                Remove
                        </button>';        
                }else{
    
                    echo '
                        <button class="btn btn-primary viewPersonDetails" id="viewResorNonResfromBlot"
                            data-id="'.htmlspecialchars($row['id']).'"
                            data-status="'.htmlspecialchars($row['status']).'"
                            data-whatbtn="otherrespondent">
                            View Details
                        </button>';   
                        }
                    echo '
                        </td>
                        </tr>';
            }
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
                    b.schedule_color, 
                    CONCAT(m.first_name, ', ', m.middle_name, ' ', m.last_name, ' ', m.suffix) AS mediator_name
                    FROM tbl_blotters b
                    JOIN tbl_blotter_mediator m ON b.mediator_no = m.mediator_id
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
        $audit_query = "INSERT INTO tbl_blotter_audit_trail (deleted_by, blottter_delete_dt) VALUES(?, CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($audit_query);
        $stmt->execute([$user_id]);

        $sqlquery = "UPDATE tbl_blotters SET is_deleted=1 WHERE blotter_id = ?";
        $stmt = $pdo->prepare($sqlquery);
        $stmt->execute([$id_to_fetch]);
        $pdo->commit();
        echo json_encode(["success" => true, "message" => "Blotter deleted successfully"]);

    }catch(Exception $e){
        $pdo->rollBack();
        echo json_encode(["success" => false, "message" => "Server Error: ".$e]);

    }

}else if($operation_check == "PAGINATION"){
    // Fetch the total number of records
    $total_records = $pdo->query("SELECT COUNT(*) FROM vw_blotters WHERE is_deleted = 0")->fetchColumn();
    $limit = 10; //To limit the number of pages
    $total_pages = ceil($total_records / $limit);

    // Get the current page or set a default
    $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $current_page = max(1, min($current_page, $total_pages));
    $start_from = ($current_page - 1) * $limit;

    // Fetch the data for the current page
    // $query = $pdo->prepare("SELECT * FROM vw_blotters ORDER BY request_id ASC LIMIT $start_from, $limit");
    // $query->execute();
    // $result = $query->fetchAll();

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
   
    


}else{
    echo json_encode(["success" => false, "message" =>"Nothing was recieved"]);
}
$pdo = NULL;

?>
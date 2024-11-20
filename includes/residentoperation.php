<?php
if($_SERVER['REQUEST_METHOD']!=="POST"){
    header('Location: ../index.php');
    exit();
}

require_once("connecttodb.php");
require_once("anti-SQLInject.php");
// require_once("fileUpload.php");

function uploadImageFile($what_field, $target_dir){

    if($_FILES[$what_field]['error'] == UPLOAD_ERR_OK){
    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_INI_SIZE){

        $imgopresponse = "UPLOAD_ERR_INI_SIZE: You exceeded the allow file size";
        throw new Exception($imgopresponse); 

    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_FORM_SIZE){

        $imgopresponse = "UPLOAD_ERR_INI_SIZE: You exceeded the allow HTML directive size";
        throw new Exception($imgopresponse); 


    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_PARTIAL){

        $imgopresponse = "UPLOAD_ERR_PARTIAL: The uploaded file was partially upload. Check your Internet Connection";
        throw new Exception($imgopresponse); 

    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_NO_FILE){

        $imgopresponse = "UPLOAD_ERR_NO_FILE: No file is uploaded";
        throw new Exception($imgopresponse); 

    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_CANT_WRITE){
        $imgopresponse = "UPLOAD_ERR_CANT_WRITE: Unable to write file to disk.";
        throw new Exception($imgopresponse); 

    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_EXTENSION){
        $imgopresponse = "UPLOAD_ERR_EXTENSION: A PHP extension stopped the file upload.";
        throw new Exception($imgopresponse); 

    }elseif($_FILES[$what_field]['error']==UPLOAD_ERR_NO_TMP_DIR){
        $imgopresponse = "UPLOAD_ERR_NO_TEMP_DIR: You have a missing directory";
        throw new Exception($imgopresponse);

    }else{
        $imgopresponse = "No unknown Error";
        throw new Exception($imgopresponse);

        
    }// End of Image Check If statement

     //Variable for the Name of the Folder which is img
    //  $target_dir = "img/resident_img/";

     //Variable for the path
     $target_file = $target_dir . basename($_FILES[$what_field]["name"]);

     // To get the file extension and converts it to lower case
     $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

     // Generate a Unique filename via the generateUniqueFileName user define function below
     $fileName = generateUniqueFileName($target_dir, basename($_FILES[$what_field]["name"]));
     $target_file = $target_dir . $fileName;

     // Check if file is an image
     $check = getimagesize($_FILES[$what_field]["tmp_name"]);
     if ($check === false) {
         throw new Exception("File is not an image.");
     }

    // Allow only specific file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
        throw new Exception("Sorry, only JPG, JPEG & PNG files are allowed.");
    }

     $mimeType = mime_content_type($_FILES[$what_field]["tmp_name"]);
     if($mimeType != "image/jpeg" && $mimeType != "image/png"){
        throw new Exception("Sorry, only JPG, JPEG & PNG are allowed.");
     }

     // Check file size
     if ($_FILES[$what_field]["size"] > 500000) {
         throw new Exception("Sorry, your file is too large.");
     }

     // Move uploaded file to target directory
     if (!move_uploaded_file($_FILES[$what_field]["tmp_name"], $target_file)) {
         throw new Exception("Sorry, there was an error uploading your file.");
     }

     return $fileName;
}

function captureImageUpload($what_field){
    //Capture the Data
    if(!isset($_POST[$what_field])){
        throw new Exception("No data was captured.");
    }

    $data_uri = $_POST[$what_field];

    //Extract the base64 Data
    $encoded_image = explode(",", $data_uri)[1];

    //Decode the base64 string
    $decoded_image = base64_decode($encoded_image);

    if($decoded_image ===false){
        throw new Exception("Failed to decode base64 image data.");
    }

    //For the filename being entered in the Database
    $fileName =  'capture_'.time().'.jpg';

    $filePath = 'img/resident_img/'.$fileName;

    if(!is_dir('img/resident_img/') || !is_writable('img/resident_img/')){
        throw new Exception("Failed to write image to the directory.");
    }

    //Save the image file
    $result = file_put_contents($filePath, $decoded_image);

    if($result === false){
        throw new Exception("Failed to save the image file.");
    }

    return $fileName;
}

function check_empty_values ($required_fields){

    $all_filled = true;

    foreach($required_fields as $check_fields){
        if($check_fields === "" || $check_fields === NULL){
            $all_filled = false;
            break;
        }

    }

    return $all_filled;

}

function check_db_duplicate($pdo, $arraytocheck){

    //Check for any duplicates of the entered details
    $check_query = "SELECT * FROM resident WHERE last_name = ? AND first_name = ? AND middle_name = ? AND suffix = ? AND house_num = ? AND street = ? AND subdivision = ? 
    AND resident_since = ? AND sex = ? AND marital_status = ? AND birth_date = ? AND birth_place = ? AND cellphone_num = ? AND is_a_voter =?";
    
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->execute($arraytocheck);
    return $check_stmt->fetch(mode: PDO::FETCH_ASSOC);

}

function checkForDuplicateFiles($pdo,$resident_id, $target_dir){
    //Checks the img/resident_img folder for any used images

    if(isset($resident_id)){
        try{
            // Fetch all filenames from the database
            $stmt = $pdo->prepare("SELECT img_filename FROM resident WHERE resident_id = ?");
            $stmt -> execute([$resident_id]);
            $filename = $stmt->fetchColumn();
        }catch(Exception $e){
            throw new Exception("Failed to fetch filename from database");
        }
        

        $filePath = $target_dir . $filename;
        if (file_exists($filePath)) {
            unlink($filePath);
            return true;
        }else{
            throw new Exception("Failed to Delete the file");
        }
    }else{
        throw new Exception("No resident ID was passed to this function");
    }
}

$operation_check=$_POST['operation']; //Catches What operation to perform
$nowdate = date("y-m-d"); //Checks the current date
$time = date('H:i:s'); //Checks the current time
$userid=null; // For the user currently using the system
$departno= null; // For the users depart currently using
$limit = 10;
$search = isset($_POST['search']) ? sanitizeData($_POST['search']): '';
$page = isset($_POST['page']) ? sanitizeData($_POST['page']) : '1';
$start_from = ($page - 1) * $limit;

 // Retrieve data sent via POST for add and edit
 $fname = (isset($_POST['fname'])) ? sanitizeData($_POST['fname']): null;
 $mname = (isset($_POST['mname'])) ? sanitizeData($_POST['mname']): null;
 $lname = (isset($_POST['lname'])) ? sanitizeData($_POST['lname']): null;
 $suffix = (isset($_POST['suffix'])) ? sanitizeData($_POST['suffix']): null;
 $houseno = (isset($_POST['house_no'])) ? sanitizeData($_POST['house_no']): null;
 $street = (isset($_POST['street'])) ? sanitizeData($_POST['street']): null;
 $subd = (isset($_POST['subd'])) ? sanitizeData($_POST['subd']): null;
 $sex = (isset($_POST['sex'])) ? sanitizeData($_POST['sex']): null;
 $maritalstatus = (isset($_POST['marital_status'])) ? sanitizeData($_POST['marital_status']): null;
 $birthdate = (isset($_POST['birth_date'])) ? sanitizeData($_POST['birth_date']): null;
 $birthplace = (isset($_POST['birth_place'])) ? sanitizeData($_POST['birth_place']): null;
 $cellphonenumber = (isset($_POST['cellphone_number'])) ? sanitizeData($_POST['cellphone_number']): null;
 $is_a_voter = (isset($_POST['is_a_voter'])) ? sanitizeData($_POST['is_a_voter']): null;
 $residentsince = (isset($_POST['rsince'])) ? sanitizeData($_POST['rsince']): null;

 $params = [$lname, $fname, $mname, $suffix, $houseno, $street, $subd, $residentsince, $sex, $maritalstatus, $birthdate, $birthplace, $cellphonenumber, $is_a_voter];
 $paramstocheckempty = [$lname, $fname, $houseno, $street, $residentsince, $sex, $maritalstatus, $birthdate, $birthplace, $cellphonenumber, $is_a_voter];

if($operation_check == "ADD"){ //For the add operation

    if(check_empty_values($paramstocheckempty) == false){
        echo json_encode(["success" => false, "message" => "Some fields are empty"]);
        die();
    }

    if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK){

        if(!empty(check_db_duplicate($pdo, $params))){
            echo json_encode(["success" => "entry_match", "message" => "Duplicate Entry has been found!", "data" => check_db_duplicate($pdo, $params)]);
            die();
        }

        try{
           $fileName = uploadImageFile("image_file", "img/resident_img/");

        }catch(Exception $e){
            echo json_encode(["success" => "error", "message" => $e->getMessage()]);
            die();
        }

    }else if(isset($_POST['captureImageData'])){ //Incase the image comes from the camera

        if(!empty(check_db_duplicate($pdo, $params))){
            echo json_encode(["success" => "entry_match", "message" => "Duplicate Entry has been found!", "data" => check_db_duplicate($pdo, $params)]);
            die();
        }

        try{
           $fileName = captureImageUpload('captureImageData');
        }catch(Exception $e){
            echo json_encode(["success" => "error", "message" => $e->getMessage()]);
            die();
        }

    }else{

        exit(json_encode(['success' => false, 'message' => 'No image was sent!'.$e->Message()])); 

    }
        

    try {
        $pdo->beginTransaction();

        //Record to Audit Trail
        $audit_query = "INSERT INTO res_audit_trail (added_depart_no, added_by_no)
        VALUES (?, ?)";
        $audit_stmt = $pdo->prepare($audit_query);
        $audit_stmt->execute([$departno, $userid]);

        $params[] = $fileName;
    
        // Insert data into the resident table
        $insert_query = "INSERT INTO resident (last_name, first_name, middle_name, suffix, house_num, street, subdivision, 
                            resident_since, sex, marital_status, birth_date, birth_place, cellphone_num, is_a_voter, img_filename)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?);";
        $insert_stmt = $pdo->prepare($insert_query);
        $insert_stmt->execute($params);

        // Success response encodes it to JSON format for the AJAX to read
        $response = ["success" => true, "message" => "Data Added successfully"];
        echo json_encode($response);

        $pdo->commit();
    } catch (Exception $e) {
    
        $pdo->rollBack();
        $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
        echo json_encode($response);
    }

}elseif($operation_check == "EDIT"){

    $isEmpty = check_empty_values($paramstocheckempty);

     // Retrieve data sent via POST
     $residentId = sanitizeData($_POST['resident_id']);
 
    if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK){

        try{
            checkForDuplicateFiles($pdo, $residentId, "img/resident_img/");
        }catch(Exception $error){
            $response = ["success" => false, "message" => "Error checking duplicate images: ".$error->getMessage()];
        }

        if($isEmpty === false){
            echo json_encode(["success" => false, "message" => "Some fields are empty"]);
            die();
        }

        try{
            $fileName = uploadImageFile('image_file', "img/resident_img/");
        }catch(Exception $e){
            $response = ["success" => false, "message" => "Error updating data: ".$e->getMessage()];
            die();
        }
            
        $imgopresponse = "File uploaded successfully";
        $noimage = false;


    }elseif(isset($_POST['isfromcamcheck'])){ //Incase the image comes from the camera

        try{
            checkForDuplicateFiles($pdo, $residentId, "img/resident_img/");
        }catch(Exception $error){
            $response = ["success" => false, "message" => "Error checking duplicate images: ".$error->getMessage()];
        }

        try{
            $fileName = captureImageUpload("isfromcamcheck");
        }catch(Exception $e){
            $response = ["success" => false, "message" => "Error uploading the capture image :".$e->getMessage()];
        }

        $imgopresponse = "Captured Picture recorded successfully";
        $noimage = false;
        
    }else{
        $imgopresponse = "No image data was recevied";
        $noimage = true;
    }
        

    try {

        $pdo->beginTransaction();
   
        // Prepare SQL statement for updating resident data

        $entriestodb = [$fname, $mname, $lname, $suffix, $houseno, $street, $subd,$residentsince, $sex, $maritalstatus, $birthdate, $birthplace, $cellphonenumber, $is_a_voter];
        
        $sqlquery = "UPDATE resident SET first_name = ?, middle_name = ?, last_name = ?,suffix = ?, house_num = ?, street = ?, subdivision = ?, resident_since=?, sex = ?, marital_status = ?, birth_date = ?, birth_place = ?, cellphone_num = ?, is_a_voter = ?";
        
        if($noimage == false){
            $entriestodb[] = $fileName;
            $sqlquery .= ", img_filename=?";
        }
           
        $entriestodb[] = $residentId;
        $sqlquery .= " WHERE resident_id = ?";
        
        $statement = $pdo->prepare($sqlquery);
        
        // Bind parameters and execute the statement
        $statement->execute($entriestodb);
        
        // Send success response
        echo json_encode(["success" => true, "message" => "Data updated successfully". " ImageStatus: " . $imgopresponse]);

        $update_audit_sql= "UPDATE res_audit_trail SET edited_depart_no=?, last_edited_by=?, last_edited_dt=CURRENT_TIMESTAMP WHERE res_at_id=?";
         $atstmt= $pdo->prepare($update_audit_sql);
         $atstmt -> execute([$departno, $userid, $residentId]);

        $pdo->commit();
    } catch (PDOException $e) {
        // Handle database connection or query errors
        error_log($e->getMessage());

        $pdo->rollBack();

        echo json_encode(["success" => false, "message" => "Error updating data: " . $e->getMessage()]);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

}elseif($operation_check == "DELETE"){
    // Get the ID of the record to delete
    $id_to_delete = $_POST['resident_id'];

    if(isset($id_to_delete)){
        // Prepare an update statement to mark the record as deleted
        try{

            $pdo->beginTransaction();
        
            $update_query = "UPDATE resident SET is_deleted = 1 WHERE resident_id = ?";
            $update_stmt = $pdo->prepare($update_query);
            $update_stmt->execute([$id_to_delete]);

            $update_audit_sql= "UPDATE res_audit_trail SET dept_del_no=?, del_by_no=?, del_dt=CURRENT_TIMESTAMP WHERE res_at_id=?";
            $atstmt= $pdo->prepare($update_audit_sql);
            $atstmt -> execute([$departno, $userid, $id_to_delete]);
            echo json_encode(["success" => true, "message" => "Record Soft deleted successfully."]);

            $pdo->commit();
        }catch(PDOException $e){

            $pdo->rollBack();
            error_log($e->getMessage());
            echo json_encode(["success" => false, "message" => "Error deleting record" . $e->getMessage()]);

        }
    }else{
        echo json_encode(["success" => false, "message" => "ID not Provided"]);

    }
}elseif($operation_check=="UNDO_DELETE"){
    //For Admin only
    $id_to_delete = $_POST['resident_id'];

    if(isset($id_to_delete)){
        // Prepare an update statement to mark the record as is_deleted=0
        try{
        
            $pdo->beginTransaction();

            $update_query = "UPDATE resident SET is_deleted = 0 WHERE resident_id = ?";
            $update_stmt = $pdo->prepare($update_query);
            $update_stmt->execute([$id_to_delete]);

            $update_audit_sql= "UPDATE res_audit_trail SET dept_rec_no=?, rec_by_no=?, rec_dt= CURRENT_TIMESTAMP WHERE res_at_id=?";
            $atstmt= $pdo->prepare($update_audit_sql);
            $atstmt -> execute([$departno, $userid, $id_to_delete]);
            echo json_encode(["success" => true, "message" => "Record recovered successfully."]);

            $pdo->commit();
        }catch(PDOException $e){

            $pdo->rollBack();
            error_log($e->getMessage());
            echo json_encode(["success" => false, "message" => "Error recovering the record" . $e->getMessage()]);

        }
    }else{
        echo json_encode(["success" => false, "message" => "ID not Provided"]);

    }


}elseif($operation_check=="PAGINATION"){
    
   // Fetch the total number of records
    $total_records = $pdo->query("SELECT COUNT(*) FROM vw_resident")->fetchColumn();
    $limit = 10; //To limit the number of pages
    $total_pages = ceil($total_records / $limit);

    // Get the current page or set a default
    $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $current_page = max(1, min($current_page, $total_pages));
    $start_from = ($current_page - 1) * $limit;

    // // Fetch the data for the current page
    // $query = $pdo->prepare("SELECT * FROM vw_resident ORDER BY last_name ASC LIMIT $start_from, $limit");
    // $query->execute();
    // $result = $query->fetchAll();

    require_once'paginationtemplate.php';

}elseif($operation_check=="SHOW_DELETED"){

     // Fetch the total number of records
     $total_records = $pdo->query("SELECT COUNT(*) FROM resident WHERE is_deleted=1")->fetchColumn();
     $limit = 10; //To limit the number of pages
     $total_pages = ceil($total_records / $limit);
 
     // Get the current page or set a default
     $page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
     $page = max(1, min($page, $total_pages));
     $start_from = ($page - 1) * $limit;
 
    try{
        // Fetch the data for the current page
        $query = "SELECT * FROM vw_resident_deleted ORDER BY date_recorded DESC LIMIT :start_from, :lim";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':start_from', (int)$start_from, PDO::PARAM_INT);
        $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($results)){
            require_once'residenttabletofetch.php';
        }else{
            echo '<tr><td colspan="11"><b>No Deleted Records found</b></td></tr>';
        }

    }catch(Exception $e){

        echo '<tr><td colspan="11"><b>Error: '.$e->getMessage().'</b></td></tr>';
        
    }

}elseif($operation_check=="PAGINATION_FOR_DEL_REC"){

    if(!empty($search)){
        
        $stmt = $pdo->prepare("CALL SearchResident(:search, :start_from, $limit)"); 
        $stmt->execute(['search' => "%$search%", 'start_from' => "$start_from"]);
        $results = $stmt->fetchAll();
        $total_pages = ceil(count($results) -1) / $limit;


    }else{
        // Fetch the total number of records
        $total_records = $pdo->query("SELECT COUNT(*) FROM resident WHERE is_deleted=1")->fetchColumn();
        $limit = 10; //To limit the number of pages
        $total_pages = ceil($total_records / $limit);
    }

    // Get the current page or set a default
    $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $current_page = max(1, min($current_page, $total_pages));
    $start_from = ($current_page - 1) * $limit;

    require_once('paginationtemplate.php');

}elseif($operation_check == "COUNT_RES_CERT"){
    $resident_no = $_POST['resident_id'];

    $countquery = "SELECT COUNT(*) AS count FROM tbl_docu_request WHERE resident_no = ? AND is_deleted=0";
    $stmt = $pdo->prepare($countquery);
    $stmt->execute([$resident_no]);
    $results = $stmt -> fetchColumn();

    echo json_encode($results);

}elseif($operation_check == "FETCH_TABLE"){

    $limit = 10;
    $page = isset($_POST['pageno']) ? $_POST['pageno'] : 1;
    $start_from = ($page - 1) * $limit;

    try {
            $sql = "SELECT * FROM vw_resident ORDER BY last_name ASC LIMIT :start_from, :lim"; 
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":start_from",(int)$start_from, PDO::PARAM_INT);
            $stmt->bindValue(":lim",(int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if there are any results
        if (count($results) > 0) {
            // Output each row as HTML
            require_once'residenttabletofetch.php';
        } else {
            echo '<tr><td colspan="12">No records found.</td></tr>';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . htmlspecialchars($e->getMessage());
    }
    
}elseif($operation_check=="SEARCH"){
    if(!empty($search)){
        $page = isset($_POST['page']) ? $_POST['page'] : '1';
        $start_from = ($page - 1) * $limit;

        // query to fetch records with pagination
        $stmt = $pdo->prepare("CALL SearchResident(:search, :start_from, $limit)"); 

        $stmt->execute(['search' => "%$search%", 'start_from' => "$start_from"]);

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
}elseif($operation_check=="DELETED_SEARCH"){
    if(!empty($search)){

        // query to fetch records with pagination
        $stmt = $pdo->prepare("CALL SearchResidentDeleted(:search, :start_from, :lim)"); 
        $stmt-> bindValue('search', (string)"%$search%", PDO::PARAM_STR);
        $stmt-> bindValue('start_from', (int)$start_from, PDO::PARAM_INT);
        $stmt-> bindValue('lim',(int)$limit, PDO::PARAM_INT);

        $stmt->execute();

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

}elseif($operation_check=="SEARCH_PAGINATION"){
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM resident WHERE last_name LIKE :search OR first_name LIKE :search OR middle_name LIKE :search");
    $stmt->execute(['search' => "%$search%"]);
    $total_records = $stmt->fetchColumn();

    switch($total_records){
        case 0:
            $total_pages = 0;
        break;
        default:
            $total_pages = ceil($total_records / $limit);
    }

    $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $current_page = max(1, min($current_page, $total_pages));
    $start_from = ($current_page - 1) * $limit;
        
    require_once'paginationtemplate.php';
}else{
    echo '<tr><td colspan="11">Unknown Operation. Please Call IT Deptparment for troubleshooting</td></tr>';
}
    

// Function to check if a file with the given name exists in the resident_img table

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

// Close the database connection
$pdo = null;
?>

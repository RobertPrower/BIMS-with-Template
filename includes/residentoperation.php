<?php
require_once("connecttodb.php");

date_default_timezone_set('Asia/Hong_Kong'); //Set the default timezone

$operation_check=$_POST['operation'];
$nowdate = date("y-m-d");
$time = date('H:i:s');
$userid=null;
$departno= null;

if($operation_check == "ADD"){
    try {

        // Retrieve data sent via POST
        $fname=sanitizeData($_POST['fname']);
        $mname=sanitizeData($_POST['mname']);
        $lname=sanitizeData($_POST['lname']);
        $suffix=sanitizeData($_POST['suffix']);
        $houseno=sanitizeData($_POST['house_no']);
        $street=sanitizeData($_POST['street']);
        $sudb=sanitizeData($_POST['subd']);
        $sex=sanitizeData($_POST['sex']);
        $maritalstatus=sanitizeData($_POST['marital_status']);
        $birthdate=sanitizeData($_POST['birth_date']);
        $birthplace=sanitizeData($_POST['birth_place']);
        $cellphonenumber=sanitizeData($_POST['cellphone_number']);
        $is_a_voter=sanitizeData($_POST['is_a_voter']);
        $residentsince=sanitizeData($_POST['resident_since']);


        //Variable for the Name of the Folder which is img
        $target_dir = "img/resident_img/";

        //Variable for the path
        $target_file = $target_dir . basename($_FILES["image_file"]["name"]);

        // To get the file extension and converts it to lower case
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Generate a Unique filename via the generateUniqueFileName user define function below
        $fileName = generateUniqueFileName($target_dir, basename($_FILES["image_file"]["name"]));
        $target_file = $target_dir . $fileName;

        // Check if file is an image
        $check = getimagesize($_FILES["image_file"]["tmp_name"]);
        if ($check === false) {
            throw new Exception("File is not an image.");
        }

        // Check file size
        if ($_FILES["image_file"]["size"] > 500000) {
            throw new Exception("Sorry, your file is too large.");
        }

        // Allow only specific file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
            throw new Exception("Sorry, only JPG, JPEG & PNG files are allowed.");
        }

        // Move uploaded file to target directory
        if (!move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
            throw new Exception("Sorry, there was an error uploading your file.");
        }

       
        // Insert data into the resident table
        $insert_query = "INSERT INTO resident (img_filename, last_name, first_name, middle_name, suffix, house_num, street, subdivision, 
                            resident_since, sex, marital_status, birth_date, birth_place, cellphone_num, is_a_voter)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?);";
        $insert_stmt = $pdo->prepare($insert_query);
        $insert_stmt->execute([
            
            $fileName,
            $lname,
            $fname,
            $mname,
            $suffix,
            $houseno,
            $street,
            $sudb,
            $residentsince,
            $sex,
            $maritalstatus,
            $birthdate,
            $birthplace,
            $cellphonenumber,
            $is_a_voter,
            
        ]);

        $audit_query = "INSERT INTO res_audit_trail (added_depart_no, added_by_no, date_added, time_added)
        VALUES (?, ?,?,?)";
        $audit_stmt = $pdo->prepare($audit_query);
        $audit_stmt->execute
        ([
        $departno,
        $userid,
        $datenow,
        $timenow
        ]);


        // Success response encodes it to JSON format for the AJAX to read
        $response = ["success" => true, "message" => "Data Added successfully"];
        echo json_encode($response);
    } catch (Exception $e) {
        // Error response
        $response = ["success" => false, "message" => "Error updating data: " . $e->getMessage()];
        echo json_encode($response);
    }
}elseif($operation_check == "EDIT"){

     // Retrieve data sent via POST
     $residentId = sanitizeData($_POST['resident_id']);
     $firstName = sanitizeData($_POST['fname']);
     $middleName = sanitizeData($_POST['mname']);
     $lastName = sanitizeData($_POST['lname']);
     $suffix = sanitizeData($_POST['suffix']);
     $houseno = sanitizeData($_POST['house_no']);
     $streetname = sanitizeData($_POST['street']);
     $subdivision = sanitizeData($_POST['subd']);
     $sex = sanitizeData($_POST['sex']);
     $maritalstatus = sanitizeData($_POST['marital_status']);
     $birthdate = sanitizeData($_POST['birth_date']);
     $birthplace = sanitizeData($_POST['birth_place']); 
     $phonenumber = sanitizeData($_POST['cp_number']);
     $isavoter = sanitizeData($_POST['is_a_voter']);
     $residentsince = sanitizeData($_POST['residentsince']);
 
 
    // Check if there is uploaded file or theres an error
    if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == UPLOAD_ERR_OK){
 
         //Variable for the Name of the Folder which is img
         $target_dir = "img/resident_img/";
 
         //Variable for the path
         $target_file = $_FILES["image_file"]["name"];
 
         // To get the file extension and converts it to lower case
         $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
 
         // Generate a Unique filename via the generateUniqueFileName user define function below
         $fileName = generateUniqueFileName($target_dir, basename($_FILES["image_file"]["name"]));
         $target_file = $target_dir . $fileName;
 
         // Check if file is an image
         $check = getimagesize($_FILES["image_file"]["tmp_name"]);
         if ($check === false) {
             throw new Exception("File is not an image.");
         }
 
         // Check file size
         if ($_FILES["image_file"]["size"] > 500000) {
             throw new Exception("Sorry, your file is too large.");
         }
 
         // Allow only specific file formats
         if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
             throw new Exception("Sorry, only JPG, JPEG & PNG files are allowed.");
         }
 
         // Move uploaded file to target directory
         if (!move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
             throw new Exception("Sorry, there was an error uploading your file.");
         }
 
         
         //MetaData Entering to the Database
         $stmt = $pdo->prepare("UPDATE resident SET img_filename=? WHERE resident_id=?");
 
         $stmt -> execute([$fileName, $residentId]);
 
         //Checks the img/resident_img folder for any used images
 
            // Fetch all filenames from the database
         $stmt = $pdo->query("SELECT img_filename FROM resident");
         $dbFiles = $stmt->fetchAll(PDO::FETCH_COLUMN);
 
         // Retrieve all filenames from the folder
         $folderFiles = array_diff(scandir($target_dir), array('..', '.'));
 
         // Prepend the directory path to each filename
         $folderFiles = array_map(function($filename) {
             return $filename;
         }, $folderFiles);
 
         // Find filenames in the folder but not in the database
         $unusedFiles = array_diff($folderFiles, $dbFiles);
 
         // Delete unused files
         foreach ($unusedFiles as $filename) {
            $filePath = $target_dir . $filename;
             if (file_exists($filePath)) {
                 unlink($filePath);
             }
         }
 
         $imgopresponse = "Image Updated Successfully";

    }elseif($_FILES['image_file']['error']==UPLOAD_ERR_INI_SIZE){
        $imgopresponse = "UPLOAD_ERR_INI_SIZE: You exceeded the allow file size";
    }elseif($_FILES['image_file']['error']==UPLOAD_ERR_FORM_SIZE){
        $imgopresponse = "UPLOAD_ERR_INI_SIZE: You exceeded the allow HTML directive size";
    }elseif($_FILES['image_file']['error']==UPLOAD_ERR_PARTIAL){
        $imgopresponse = "UPLOAD_ERR_PARTIAL: The uploaded file was partially upload. Check your Internet Connection";
    }elseif($_FILES['image_file']['error']==UPLOAD_ERR_NO_FILE){
        $imgopresponse = "UPLOAD_ERR_NO_FILE: No file is uploaded";
    }elseif($_FILES['image_file']['error']==UPLOAD_ERR_CANT_WRITE){
        $imgopresponse = "UPLOAD_ERR_CANT_WRITE: Unable to write file to disk.";
    }elseif($_FILES['image_file']['error']==UPLOAD_ERR_EXTENSION){
        $imgopresponse = "UPLOAD_ERR_EXTENSION: A PHP extension stopped the file upload.";
    }elseif($_FILES['image_file']['error']==UPLOAD_ERR_NO_TMP_DIR){
        $imgopresponse = "UPLOAD_ERR_NO_TEMP_DIR: You have a missing directory";
    }else{
        $imgopresponse = "No unknown Error";
    }// End of Image Check If statement

    try {
        // Prepare SQL statement for updating resident data
        $statement = $pdo->prepare("UPDATE resident SET first_name = ?, middle_name = ?, last_name = ?,suffix = ?, house_num = ?, street = ?, subdivision = ?, resident_since=?, sex = ?, marital_status = ?, birth_date = ?, birth_place = ?, cellphone_num = ?, is_a_voter = ? WHERE resident_id = ?");
        
        // Bind parameters and execute the statement
        $statement->execute([$firstName, $middleName, $lastName, $suffix, $houseno, $streetname, $subdivision,$residentsince, $sex, $maritalstatus, $birthdate, $birthplace, $phonenumber, $isavoter, $residentId]);
        
        // Send success response
        echo json_encode(["success" => true, "message" => "Data updated successfully" . $imgopresponse]);

        $update_audit_sql= "INSERT INTO res_audit_trail(edited_depart_no, last_edited_by, last_edited_dt, last_edited_tm) VALUES(?,?,?,?)";
         $atstmt= $pdo->prepare($update_audit_sql);
         $atstmt -> execute([$departno, $userid, $nowdate, $time]);

        
    } catch (PDOException $e) {
        // Handle database connection or query errors
        error_log($e->getMessage());

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
        
            $update_query = "UPDATE resident SET is_deleted = 1 WHERE resident_id = ?";
            $update_stmt = $pdo->prepare($update_query);
            $update_stmt->execute([$id_to_delete]);
            echo json_encode(["success" => true, "message" => "Record Soft deleted successfully."]);

        }catch(PDOException $e){
            error_log($e->getMessage());
            echo json_encode(["success" => false, "message" => "Error deleting record" . $e->getMessage()]);

        }
    }else{
        echo json_encode(["success" => false, "message" => "ID not Provided"]);

    }

}elseif($operation_check=="PAGINATION"){
    
   // Fetch the total number of records
    $total_records = $pdo->query("SELECT COUNT(*) FROM vw_all_resident")->fetchColumn();
    $limit = 10; //To limit the number of pages
    $total_pages = ceil($total_records / $limit);

    // Get the current page or set a default
    $current_page = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;
    $current_page = max(1, min($current_page, $total_pages));
    $start_from = ($current_page - 1) * $limit;

    // Fetch the data for the current page
    $query = $pdo->prepare("SELECT * FROM vw_all_resident ORDER BY last_name ASC LIMIT $start_from, $limit");
    $query->execute();
    $result = $query->fetchAll();

    // Generate pagination controls
    echo '<nav aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-end">';

    // Previous Button
    if ($current_page > 1) {
    echo '<li class="page-item">
            <a class="page-link" href="#" data-page="' . ($current_page - 1) . '">Previous</a>
            </li>';
    }

    // Page Number Buttons
    for ($i = 1; $i <= $total_pages; $i++) {
    $active = $i == $current_page ? 'active' : '';
    echo '<li class="page-item ' . $active . '">';
    echo '<a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>';
    echo '</li>';
    }

    // Next Button
    if ($current_page < $total_pages) {
    echo '<li class="page-item">
            <a class="page-link" href="#" data-page="' . ($current_page + 1) . '">Next</a>
            </li>';
    }

    echo '</ul>';
    echo '</nav>';

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
//To Sanitize the Data to prevent SQL Injections and Cross site scripting and insertion of special characters
function sanitizeData($input){
    $removedSpecialChar = trim ($input, "!@#$%^&*()=[]{};:`~'<>,./\?| "); 
    $removedSpecialCharinthemiddle= preg_replace('/[^a-zA-Z0-9\s\-ñÑ#]/u','', $removedSpecialChar);

    $sanatizedData=htmlspecialchars($removedSpecialCharinthemiddle);

    return $sanatizedData;

}

// Close the database connection
$pdo = null;
?>

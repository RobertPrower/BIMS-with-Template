<?php
require_once("connecttodb.php");


// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

   // Check if there is uploaded file or theres an error
   if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == UPLOAD_ERR_OK){

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
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            throw new Exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Move uploaded file to target directory
        if (!move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
            throw new Exception("Sorry, there was an error uploading your file.");
        }

        
        //MetaData Entering to the Database
        $stmt = $pdo->prepare("UPDATE resident SET img_path=? WHERE resident_id=?");

        $stmt -> execute([$target_file, $residentId]);

        //Checks the img/resident_img folder for any used images

      // Fetch all filenames from the database
        $stmt = $pdo->query("SELECT img_path FROM resident");
        $dbFiles = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Retrieve all filenames from the folder
        $folderFiles = array_diff(scandir($target_dir), array('..', '.'));

        // Prepend the directory path to each filename
        $folderFiles = array_map(function($filename) use ($target_dir) {
            return $target_dir . $filename;
        }, $folderFiles);

        // Find filenames in the folder but not in the database
        $unusedFiles = array_diff($folderFiles, $dbFiles);

        // Delete unused files
        foreach ($unusedFiles as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $imgopresponse = "Image Updated Successfully";

}else{
    $imgopresponse = "No File Uploaded or There an Error with the file";
   }
    
    try {
        // Prepare SQL statement for updating resident data
        $statement = $pdo->prepare("UPDATE resident SET first_name = ?, middle_name = ?, last_name = ?,suffix = ?, house_number = ?, street_name = ?, subdivision = ?, sex = ?, marital_status = ?, birth_date = ?, birth_place = ?, cellphone_number = ?, is_a_voter = ? WHERE resident_id = ?");
        
        // Bind parameters and execute the statement
        $statement->execute([$firstName, $middleName, $lastName, $suffix, $houseno, $streetname, $subdivision, $sex, $maritalstatus, $birthdate, $birthplace, $phonenumber, $isavoter, $residentId]);
        
        // Send success response
        echo json_encode(["success" => true, "message" => "Data updated successfully" . $imgopresponse]);

        
    } catch (PDOException $e) {
        // Handle database connection or query errors
        error_log($e->getMessage());

        echo json_encode(["success" => false, "message" => "Error updating data: " . $e->getMessage()]);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
    
} else {
    // Send error response for invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
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

function sanitizeData($input){
    $removedSpecialChar = trim ($input, "!@#$%^&*()-=[]{};:`~'<>,./\?| "); 
    $removedSpecialCharinthemiddle= preg_replace('/[^a-zA-Z0-9\s\-ñÑ#]/u','', $removedSpecialChar);

    $sanatizedData=htmlspecialchars($removedSpecialCharinthemiddle);

    return $sanatizedData;

}

$pdo=null;
?>

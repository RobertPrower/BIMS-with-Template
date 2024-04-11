<?php
require_once("connecttodb.php");

//ini_set('display_errors', 0);

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent via POST
    $residentId = $_POST['resident_id'];
    $firstName = $_POST['fname'];
    $middleName = $_POST['mname'];
    $lastName = $_POST['lname'];
    $houseno = $_POST['house_no'];
    $streetname = $_POST['street'];
    $subdivision = $_POST['subd'];
    $sex = $_POST['sex'];
    $maritalstatus = $_POST['marital_status'];
    $birthdate = $_POST['birth_date'];
    $birthplace = $_POST['birth_place']; 
    $phonenumber = $_POST['cp_number'];
    $isavoter = $_POST['is_a_voter'];

   // Check if there is uploaded file or theres an error
   if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == UPLOAD_ERR_OK){

        //Variable for the Name of the Folder which is img
        $target_dir = "img/";

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

            // Extract image metadata
            $imageSize = $check[0]; 
            $imageHeight = $check[1]; 
            $imageMimeType = $_FILES["image_file"]["type"];

        //MetaData Entering to the Database
        $stmt = $pdo->prepare("UPDATE resident_img SET `path`=?, `size`=?, height=?, mime_type=? WHERE id=?");

        $stmt -> execute([$target_file, $imageSize, $imageHeight, $imageMimeType, $residentId]);

         // Retrieve the current filename from the database
        $stmt = $pdo->prepare("SELECT `path` FROM resident_img WHERE id = ?");
        $stmt->execute([$residentId]);
        $currentFileName = $stmt->fetchColumn();

        // If there's a current file, delete it
        if($currentFileName) {
            $currentFilePath = $target_dir . $currentFileName;
            if(file_exists($currentFilePath)) {
                unlink($currentFilePath); // Delete the file
            }
        }

        $imgopresponse = "Image Updated Successfully";

   }else{
    $imgopresponse = "No File Uploaded or There an Error with the file";
   }
    
    try {
        // Prepare SQL statement for updating resident data
        $statement = $pdo->prepare("UPDATE resident SET first_name = ?, middle_name = ?, last_name = ?, house_number = ?, street_name = ?, subdivision = ?, sex = ?, marital_status = ?, birth_date = ?, birth_place = ?, cellphone_number = ?, is_a_voter = ? WHERE resident_id = ?");
        
        // Bind parameters and execute the statement
        $statement->execute([$firstName, $middleName, $lastName, $houseno, $streetname, $subdivision, $sex, $maritalstatus, $birthdate, $birthplace, $phonenumber, $isavoter, $residentId]);
        
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

$pdo=null;
?>

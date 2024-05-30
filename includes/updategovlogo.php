<?php
require_once('connecttodb.php');

    $target_dir = "../img/";

    //Variable for the path
    $target_file = $target_dir . basename($_FILES["gov_logo"]["name"]);

    // To get the file extension and converts it to lower case
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Generate a Unique filename via the generateUniqueFileName user define function below
    $fileName = generateUniqueFileName($target_dir, basename($_FILES["gov_logo"]["name"]));
    $target_file = $target_dir . $fileName;

    // Check if file is an image
    $check = getimagesize($_FILES["gov_logo"]["tmp_name"]);
    if ($check === false) {
        throw new Exception("File is not an image.");
    }

    // Check file size
    if ($_FILES["gov_logo"]["size"] > 500000) {
        throw new Exception("Sorry, your file is too large.");
    }

    // Allow only specific file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
        throw new Exception("Sorry, only JPG, JPEG, and PNG files are allowed.");
    }

    // Move uploaded file to target directory
    if (!move_uploaded_file($_FILES["gov_logo"]["tmp_name"], $target_file)) {
        throw new Exception("Sorry, there was an error uploading your file.");
    }

      // Fetch all filenames from the database
    // $stmt = $pdo->query("SELECT img_path FROM resident");
    // $dbFiles = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // // Retrieve all filenames from the folder
    // $folderFiles = array_diff(scandir($target_dir), array('..', '.'));

    // // Prepend the directory path to each filename
    // $folderFiles = array_map(function($filename) use ($target_dir) {
    //     return $target_dir . $filename;
    // }, $folderFiles);

    // // Find filenames in the folder but not in the database
    // $unusedFiles = array_diff($folderFiles, $dbFiles);

    // // Delete unused files
    // foreach ($unusedFiles as $filePath) {
    //     if (file_exists($filePath)) {
    //         unlink($filePath);
    //     }
    // }

$sqlquery="UPDATE `certificate-img` SET filename=? WHERE img_id=3";
$stmt = $pdo->prepare($sqlquery);
$stmt -> execute([$target_file]);
$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
$pdo = null;

echo json_encode(["success" => true, "message" => "Data updated successfully"]);

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

?>
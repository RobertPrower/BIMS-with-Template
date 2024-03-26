<?php
require_once("connecttodb.php");
    try {

        // For the Image
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // For Resident Details Set parameters and execute
        $first_name = $_POST['fname'];
        $middle_name = $_POST['mname'];
        $last_name = $_POST['lname'];
        $house_no = $_POST['house_no'];
        $street = $_POST['street'];
        $subdivision = $_POST['subd'];
        $sex = $_POST['sex'];
        $maritalstatus = $_POST['marital_status'];
        $birth_date = $_POST['birth_date']; 
        $birth_place = $_POST['birth_place']; 
        $cellphone_number = $_POST['cellphone_number'];
        $is_a_voter = $_POST['is_a_voter'];

        //To record the Date Recorded
        $reported_date = date("Y-m-d H:i:s");    

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image_file"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image_file"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["image_file"]["name"])). " has been uploaded.";


            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        
        // Retrieve the last used ID from the login table
            $last_id_query = "SELECT resident_id FROM resident ORDER BY resident_id DESC LIMIT 1";
            $last_id_stmt = $pdo->query($last_id_query);

        if ($last_id_stmt && $last_id_stmt->rowCount() > 0) {
            $row = $last_id_stmt->fetch(PDO::FETCH_ASSOC);
            $next_id = $row['resident_id'] + 1;
        } else {
            // If there are no existing records, start with ID 1
            $next_id = 1;
        }

        //$imagetoupload = $_FILES['image_file'];

        // Prepare and bind parameters
        $insert_query = "INSERT INTO resident (resident_id, date_recorded, first_name, middle_name, last_name, house_number, street_name, subdivision, sex, marital_status, birth_date, birth_place, cellphone_number, is_a_voter)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                        ?)";
        $insert_stmt = $pdo->prepare($insert_query);
        
        $insert_stmt->bindParam(1, $next_id, PDO::PARAM_INT);
        $insert_stmt->bindParam(2, $reported_date);
        //$insert_stmt->bindParam(3, $imagetoupload);
        $insert_stmt->bindParam(3, $first_name);
        $insert_stmt->bindParam(4, $middle_name);
        $insert_stmt->bindParam(5, $last_name);
        $insert_stmt->bindParam(6, $house_no);
        $insert_stmt->bindParam(7, $street);
        $insert_stmt->bindParam(8, $subdivision);
        $insert_stmt->bindParam(9, $sex);
        $insert_stmt->bindParam(10, $maritalstatus);
        $insert_stmt->bindParam(11, $birth_date);
        $insert_stmt->bindParam(12, $birth_place);
        $insert_stmt->bindParam(13, $cellphone_number);
        $insert_stmt->bindParam(14, $is_a_voter);

        $insert_stmt->execute();
        
        } catch (PDOException $e){
        // Handle exception
        echo "Error: " . $e->getMessage();
    }

    // Close the connection
    $pdo = null;



?>
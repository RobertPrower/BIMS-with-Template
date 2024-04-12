<?php

// Include the database connection file
require_once('connecttodb.php');

// Check if the ID of the record to delete is provided in the POST data
/*if (isset($_POST['delete_resident_id'])) {
    // Get the ID of the record to delete
    $id_to_delete = $_POST['delete_resident_id'];

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Prepare a delete statement
        $delete_query = "DELETE FROM resident WHERE resident_id = ?";
        $delete_stmt = $pdo->prepare($delete_query);

        // Bind the ID parameter
        $delete_stmt->bindParam(1, $id_to_delete, PDO::PARAM_INT);

        // Execute the delete statement
        if ($delete_stmt->execute()) {
            // Deletion successful
            echo "<script> alert ('Record deleted successfully.') </script>";

            // Retrieve the remaining records
            $select_query = "SELECT resident_id FROM resident";
            $result = $pdo->query($select_query);

            // Reassign IDs
            $new_id = 1;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $old_id = $row['resident_id'];
                $update_query = "UPDATE resident SET resident_id = ? WHERE resident_id = ?";
                $update_stmt = $pdo->prepare($update_query);
                $update_stmt->bindParam(1, $new_id, PDO::PARAM_INT);
                $update_stmt->bindParam(2, $old_id, PDO::PARAM_INT);
                $update_stmt->execute();
                $new_id++;
            }

            // Commit changes
            $pdo->commit();

            exit();
        } else {
            // Error handling if deletion fails
            echo "<script> alert ('Error deleting record:') </script> " . implode(" ", $delete_stmt->errorInfo());
        }

        // Close the prepared statement
        $delete_stmt->closeCursor();
    } catch (PDOException $e) {
        // Rollback transaction if an exception occurs
        $pdo->rollBack();
        echo "<script> alert ('Error deleting record:') </script> " . $e->getMessage();
    }
} else {
    // If the ID is not provided in the POST data
    echo "ID not provided.";

}*/


// Check if the ID of the record to delete is provided in the POST data
if (isset($_POST['resident_id'])) { // Use POST method
    // Get the ID of the record to delete
    $id_to_delete = $_POST['resident_id'];

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Prepare an update statement to mark the record as deleted
        $update_query = "UPDATE resident SET is_deleted = true WHERE resident_id = ?";
        $update_stmt = $pdo->prepare($update_query);

        // Bind the ID parameter
        $update_stmt->bindParam(1, $id_to_delete, PDO::PARAM_INT);

        // Execute the update statement
        if ($update_stmt->execute()) {
            // Deletion successful
            echo json_encode(["success" => true, "message" => "Record deleted successfully."]);
            // Commit changes
            $pdo->commit();
        } else {
            // Error handling if update fails
            echo json_encode(["success" => false, "message" => "Error deleting record: " . implode(" ", $update_stmt->errorInfo())]);
        }

        // Close the prepared statement
        $update_stmt->closeCursor();
    } catch (PDOException $e) {
        // Rollback transaction if an exception occurs
        $pdo->rollBack();
        echo json_encode(["success" => false, "message" => "Error deleting record: " . $e->getMessage()]);
    }
} else {
    // If the ID is not provided in the POST data
    echo json_encode(["success" => false, "message" => "ID not provided."]);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Custom styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.min.css">

  <!--Scripts Must be Always On the Top -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>


<body>

<div class="users-table table-wrapper">
    <table class="posts-table ResidentTable" id="ResidentTable">
        <thead>
        <tr class="users-table-info">

            <!--th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th--> 
            <th style="width: 2%"class="text-center resident_id">ID</th> 
            <th style="width: 10%;"class="text-center">Date Recorded</th>
            <th style="width: 10%;" class="text-center">Full Name</th>
            <th style="width: 10%;" class="text-center">Address</th>
            <th style="width: 10%;" class="text-center">Sex</th>
            <th style="width: 10%;" class="text-center">Marital Status</th>
            <th style="width: 10%;" class="text-center">Birth Date</th>
            <th style="width: 10%;" class="text-center">Birth Place</th>
            <th style="width: 10%;" class="text-center">Phone Number</th>
            <th style="width: 10%;" class="text-center">Is a Voter</th>
            <th style="width: 10%;" class="text-center col-span-3">Action</th>
        </tr>
        </thead>
        <tbody>

<?php 
require_once ('connecttodb.php');

    $stmt = $pdo->query("SELECT * FROM resident WHERE is_deleted = 0");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        
      
        echo "<tr>";
        //echo '<td><input type="checkbox" class="check-all"></td>';
        echo "<td>{$row['resident_id']}</td>";
        echo "<td>{$row['date_recorded']}</td>";
        echo "<td>{$row['last_name']}, {$row['first_name']} {$row['middle_name']} {$row['suffix']}</td>";
        echo "<td>{$row['house_number']}, {$row['street_name']}, {$row['subdivision']}</td>";
        echo "<td>{$row['sex']}</td>";
        echo "<td>{$row['marital_status']}</td>";
        echo "<td>{$row['birth_date']}</td>";
        echo "<td>{$row['birth_place']}</td>";

          //Prevent "0" From appearing in Cellphone Number

          if($row['cellphone_number']== "0"){
            echo "<td> </td> ";
        } else{
            echo "<td>{$row['cellphone_number']}</td>";
        }
        
        if($row['is_a_voter'] == 1){
        echo "<td>YES</td>";
        }else{
        echo "<td>NO</td>";
        }


        //For the view button
        echo "<td style='width: 15%;'><div class='btn-group text-center'>";

        echo "<form method='GET' action='#'>";
        echo '<button href="#" class="btn btn-primary mx-1 viewButton" 
        data-id="' . $row['resident_id'] . '"
        data-first-name="' . htmlspecialchars($row['first_name'], ENT_QUOTES) . '"
        data-middle-name="' . htmlspecialchars($row['middle_name'], ENT_QUOTES) . '"
        data-last-name="' . htmlspecialchars($row['last_name'], ENT_QUOTES) . '"
        data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
        data-house-no="' . htmlspecialchars($row['house_number'], ENT_QUOTES) . '"
        data-street-name="' . htmlspecialchars($row['street_name'], ENT_QUOTES) . '"
        data-subdivision="' . htmlspecialchars($row['subdivision'], ENT_QUOTES) . '"
        data-sex="' . htmlspecialchars($row['sex'], ENT_QUOTES) . '"
        data-marital-status="' . htmlspecialchars($row['marital_status'], ENT_QUOTES) . '"
        data-birth-date="' . htmlspecialchars($row['birth_date'], ENT_QUOTES) . '"
        data-birth-place="' . htmlspecialchars($row['birth_place'], ENT_QUOTES) . '"
        data-phone-number="' . htmlspecialchars($row['cellphone_number'], ENT_QUOTES) . '"
        data-isa-voter="' . htmlspecialchars($row['is_a_voter'], ENT_QUOTES) . '"
        data-bs-toggle="modal" data-bs-target="#ViewResidentModal">View</button>';
        echo "</form>";
        
        
        

        //For the edit button
       
        echo "<form method='GET' action='#'>";

        echo '<button href="#" class="btn btn-success mx-1 editResidentButton" 
        data-id="' . $row['resident_id'] . '"
        data-first-name="' . htmlspecialchars($row['first_name'], ENT_QUOTES) . '"
        data-middle-name="' . htmlspecialchars($row['middle_name'], ENT_QUOTES) . '"
        data-last-name="' . htmlspecialchars($row['last_name'], ENT_QUOTES) . '"
        data-suffix="' . htmlspecialchars($row['suffix'], ENT_QUOTES) . '"
        data-house-no="' . htmlspecialchars($row['house_number'], ENT_QUOTES) . '"
        data-street-name="' . htmlspecialchars($row['street_name'], ENT_QUOTES) . '"
        data-subdivision="' . htmlspecialchars($row['subdivision'], ENT_QUOTES) . '"
        data-sex="' . htmlspecialchars($row['sex'], ENT_QUOTES) . '"
        data-marital-status="' . htmlspecialchars($row['marital_status'], ENT_QUOTES) . '"
        data-birth-date="' . htmlspecialchars($row['birth_date'], ENT_QUOTES) . '"
        data-birth-place="' . htmlspecialchars($row['birth_place'], ENT_QUOTES) . '"
        data-phone-number="' . htmlspecialchars($row['cellphone_number'], ENT_QUOTES) . '"
        data-isa-voter="' . htmlspecialchars($row['is_a_voter'], ENT_QUOTES) . '"
        data-bs-toggle="modal" data-bs-target="#EditResidentModal">Edit</button>';

        echo "</form>";
       


        // For the Delete Button
        

        echo "<form method='POST' action='#';'>";
        echo "<input type='hidden' id='resident_id' name='delete_resident_id' value='" . $row['resident_id'] . "'>";
        echo "<button type='submit' id='Delete_Button' name='deletebtn' class='btn btn-danger mx-1'>Delete</button>";
       
       
        echo "</form>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";

    }
    
?>
    
     </tbody>;



</body>
</html>
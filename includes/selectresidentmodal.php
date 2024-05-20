<?php
        require_once("connecttodb.php");
        
        $sqlquery = "SELECT * FROM resident WHERE is_deleted=0";


        $stmt=$pdo->prepare($sqlquery);
        $stmt -> execute();
        $result = $stmt->fetchAll();
?>
<form action="#" id="SelectResidentForm" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="selectresident" name="add" tabindex="-1" aria-labelledby="EditResidentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditResidentModalLabel">View Resident Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                <div class="content pt-2">
                      <div class="users-table table-wrapper">
                        <form id="SelectResidentTable">
                            <table class="tablehover ResidentTable" id="ResidentTable" style="scale: 98%;">
                                <thead>
                                <tr class="users-table-info">
                    
                                    <!-- <th style="width: 2%;"class="text-center"><input type="checkbox" class="check-all"></th> -->
                                    <th style="width:  1%;"class="text-center resident_id">ID</th> 
                                    <th style="width: 15%;"class="text-center">Date Recorded</th>
                                    <th style="width: 15%;" class="text-center">Full Name</th>
                                    <th style="width: 20%;" class="text-center">Address</th>
                                    <th style="width: 20%;" class="text-center">Residence Since</th>
                                    <th style="width: 5%;" class="text-center">Sex</th>
                                    <th style="width: 8%;" class="text-center">Marital Status</th>
                                    <th style="width: 20%;" class="text-center">Birth Date</th>
                                    <th style="width: 25%;" class="text-center">Birth Place</th>
                                    <th style="width: 10%;" class="text-center">Phone Number</th>
                                    <th style="width: 1%;" class="text-center">Is a Voter</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                
                                <?php
                                    
                                //To Populate table rows with user data
                                foreach ($result as $row) {
                                    echo "<tr class='text-center' data-fname='{$row['first_name']} data-mname='{$row['middle_name']}' data-lname='{$row['last_name']}' data-suffix='{$row['suffix']}' 
                                    data-houseno='{$row['house_number']}' data-street='{$row['street_name']}' data-sudb='{$row['subdivision']}' data-residentsince='{$row['resident_since']}'>";
                                    // echo '<td><input type="checkbox" class="check-all"></td>';
                                    echo "<td class='resident_id'>{$row['resident_id']}</td>";
                                    echo "<td>{$row['date_recorded']}</td>";
                                    echo "<td>{$row['last_name']}, {$row['first_name']} {$row['middle_name']} {$row['suffix']}</td>";
                                    echo "<td>{$row['house_number']}, {$row['street_name']}, {$row['subdivision']}</td>";
                                    echo "<td>{$row['resident_since']}</td>";
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
                                }
                                ?>
                                </tbody>
                            
                                
                                <!-- </tbody> -->

                            
                            </table>
                      <!-- End of Table -->
                      </div>
                    </div>
                   
                </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                        </form>


                
            </div>
        </div>
    </div>
</form>
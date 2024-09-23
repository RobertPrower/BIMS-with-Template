<?php
        require_once("connecttodb.php");
        
        $sqlquery = "SELECT * FROM vw_resident";


        $stmt=$pdo->prepare($sqlquery);
        $stmt -> execute();
        $results = $stmt->fetchAll();
        $Isforcert = "YES";
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
                                    <th hidden style="width:  1%;"class="text-center resident_id">ID</th> 
                                    <th style="width: 15%;"class="text-center">Date Recorded</th>
                                    <th style="width: 15%;" class="text-center">Full Name</th>
                                    <th style="width: 25%;" class="text-center">Address</th>
                                    <th style="width: 5%;" class="text-center">Residence Since</th>
                                    <th style="width: 5%;" class="text-center">Sex</th>
                                    <th style="width: 8%;" class="text-center">Marital Status</th>
                                    <th style="width: 25%;" class="text-center">Birth Date</th>
                                    <th style="width: 25%;" class="text-center">Birth Place</th>
                                    <th style="width: 10%;" class="text-center">Phone Number</th>
                                    <th style="width: 1%;" class="text-center">Is a Voter</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                
                                <?php
                                    
                                require_once('includes/residenttabletofetch.php');
                               
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
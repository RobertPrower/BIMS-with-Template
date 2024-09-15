<!-- Modal -->
<div class="modal fade" id="DocumentDetailsModal" tabindex="-1" aria-labelledby="DocumentDetailsModal" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="DocumentDetailsModal">Document Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        
        <p id="Request_ID"><b>Request ID: </b></p>
        <br>
        <p id="Date_issued"><b>Date Issued: </b> </p> 
        <br>
        <p id="Expiration_Date"><b>Expiration Date </b> </p> 
        <br>
        <p id="Fullname"><b>Name: </b> </p> 
        <br>
        <p id="Address"><b>Address: </b> </p> 
        <br>
        <p id="Sex"><b>Sex:</b> </p>
        <br>
        <p id="Age"><b>Age:</b> </p>
        <br>
        <p id="Document_Desc"><b>Document Description: </b> </p> 
        <br>
        <p id="Presented_ID"><b>Presented ID: </b> </p> 
        <br>
        <p id="ID_num"><b>ID Number: </b> </p>   
        <br>
        <p id="Purpose"><b>Purpose: </b> </p> 
        <br>
        <p id="Status"><b>Status: </b> </p> 
        <input hidden id="resident_id" name="resident_id"/>
    </div>
    <div class="modal-footer">

        <form>

            <input hidden id="first_name" name="first_name"/>
            <input hidden id="middle_name" name="middle_name"/>
            <input hidden id="last_name" name="last_name"/>
            <input hidden id="suffix" name="suffix"/>
            <input hidden id="house_no" name="house_no"/>
            <input hidden id="request_id" name="request_id"/>

            <button type="button" id="viewResidentfromDocu" class="btn btn-primary" data-bs-target="#ViewResidentModal" data-bs-toggle="modal" data-isfordocu="YES">View Resident Details</button>
            <button type="submit" class="btn btn-success">Reprint</button>
            <button type="button" class="btn btn-danger" id="revokebtn">Revoke</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </form>
        
    </div>
    </div>
</div>
</div>

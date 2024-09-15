$(document).ready (function(){
    reloadTable();

    function reloadTable(page) {
        $.ajax({
          url: "includes/documentsautoreloadtable.php",
          type: "POST",
          data: {pageno: page},
          dataType: "HTML",
          success: function (data) {
            $("#DocumentsTableBody").html(data);
            // updatePaginationControls(page);
          },
          error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
          },
        });
    }

    $(document).on("click", ".viewDocumentsButton", function (event) { 
      event.preventDefault();

      var request_id = $(this).data("id");
      var resident_id = $(this).data("resident_id");
      var date_requested = $(this).data("date-requested");
      var expiration = $(this).data("expiration-date");
      var first_name = $(this).data("first-name");
      var middle_name = $(this).data("middle-name");
      var last_name = $(this).data("last-name");
      var suffix = $(this).data("suffix");
      var house_no = $(this).data("house-no");
      var street_name = $(this).data("street-name");
      var subdivision = $(this).data("subdivision")
      var sex = $(this).data("sex");
      var age = $(this).data("age");
      var docu_type = $(this).data("docu-desc");
      var presented_id = $(this).data("presented-id");
      var ID_number = $(this).data("id_num");
      var purpose = $(this).data("purpose");
      var status = $(this).data("status");

      $("#Request_ID").html('<b>Request ID:  </b>'+request_id);
      $("#Date_issued").html('<b>Date Issued:  </b>'+date_requested);
      $("#Expiration_Date").html('<b>Expiration Date:  </b>'+expiration);
      $("#Fullname").html('<b>Fullname:  </b>'+first_name+' '+ middle_name+','+' '+ last_name+' '+suffix);
      $("#Address").html('<b>Address:</b> '+house_no+' '+street_name+' '+subdivision+' Camarin Caloocan City');
      $("#Sex").html('<b>Sex: </b>' +sex);
      $("#Age").html('<b>Age (Upon Request): </b>' +age+" Years Old");
      $("#Document_Desc").html('<b>Document Description:  </b>' +docu_type);
      $("#Presented_ID").html('<b>Presented ID:  </b>' +presented_id);
      $("#ID_num").html('<b>ID Number:  </b>' +ID_number);
      $("#Purpose").html('<b>Purpose:  </b>' +purpose);
      $("#resident_id").val(resident_id);
      $("#request_id").val(request_id)


      switch(status){
        case 0:
          $("#Status").html('<b>Status: </b>' + "<b style='color: green';>ACTIVE</b>");
        break;
        case 1:
          $("#Status").html('<b>Status: </b>' + "<b style='color: grey';>EXPIRED</b>");
        break;
        case 2:
          $("#Status").html('<b>Status: </b>' + "<b style='color: red';>REVOKED</b>");
        break;
        default:
          $("#Status").html('<b>Status: </b>' + "<b>Unknown Status</b>");

      }

    })

    $(document).on("click","#viewResidentfromDocu", function(){
      var residentid = $("#resident_id").val();
      $('#nav-home-tab').tab('show');

      $.ajax({
        url: "includes/fetchresidentdetails.php",
        type: "POST",
        data: {id: residentid},
        dataType: "JSON",
        success: function (response) {

          var imagepath = "includes/img/resident_img/"+response.img_filename;

          $("#viewresident_id").val(response.resident_id)
          $("#fname").val(response.first_name);
          $("#mname").val(response.middle_name);
          $("#lname").val(response.last_name);
          $("#house_no").val(response.house_num);
          $("#street").val(response.street);
          $("#subd").val(response.subdivision);
          $("#sex").val(response.sex);
          $("#marital_status").val(response.marital_status);
          $("#birth_date").val(response.birth_date);
          $("#birth_place").val(response.birth_place);
          $("#cp_number").val(response.cellphone_num);
          $("#is_a_voter").val(response.is_a_voter);
          $("#rsince").val(response.resident_since);
          $("#viewimagePreview").prop("src", imagepath);

          $("#backbtntodocu").prop("hidden", false);

        },
        error: function (xhr, status, error) {
          console.error("Error fetching table data:", error);
        },
      });
    })

    $(document).on("click","#backbtntodocu", function(){
      $(this).prop("hidden", true);

      $("#ViewResidentModal").modal("hide");
      $("#DocumentDetailsModal").modal("show");

    })

    //AJAX request for the clearance tab and table of the modal
  $(document).on("click", "#nav-clearance-tab", function () {
    var resident_id = $('#resident_id').val();

    console.log(resident_id);
    
      $.ajax({
        url: "includes/get-resident-docu-request.php",
        type: "POST",
        data: {resident_id: resident_id},
        dataType: "HTML",
        success: function (data) {
          $("#ResidentRequestTable tbody").html(data);
        },
        error: function (xhr, status, error) {
          console.error("Error fetching table data:", error);
        },
      });

  });

  $("#revokebtn").click(function (e) { 
    e.preventDefault();

    var request_id = $('#request_id').val();

    swal({
      title: "Are you sure?",
      text: "Revoking the certificate VOIDS a certificate validity",
      icon: "warning",
      buttons: ["Cancel","Yes"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: "includes/documentsoperation.php",
          type: "POST",
          data: {OPERATION: "REVOKE", request_id: request_id},
          success: function(){

            swal("The certificate has been REVOKED!", {
              icon: "success"
            });

            reloadTable();
            
          },
          error: function(xhr,status,error){
            swal("Error!", "Failed to delete the entry.", "error");
          },
        })
   
      } else {
        swal("The certificate is not revoked");
      }
    });
    
  });
 
    
    
});
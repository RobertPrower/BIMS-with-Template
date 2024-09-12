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
      $("#Fullname").html('<b>Fullname:  </b>'+first_name+' '+ middle_name+','+' '+ last_name+' '+suffix);
      $("#Address").html('<b>Address:</b> '+house_no+' '+street_name+' '+subdivision+' Camarin Caloocan City');
      $("#Sex").html('<b>Sex: </b>' +sex);
      $("#Age").html('<b>Age: </b>' +age);
      $("#Document_Desc").html('<b>Document Description:  </b>' +docu_type);
      $("#Presented_ID").html('<b>Presented ID:  </b>' +presented_id);
      $("#ID_num").html('<b>ID Number:  </b>' +ID_number);
      $("#Purpose").html('<b>Purpose:  </b>' +purpose);
      $("#resident_id").val(resident_id);


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

    $(document).on("click","#viewResident", function(){
      var resident_id = $("#resident_id").val();
      $.ajax({
        url: "includes/fetchresidentdetails.php",
        type: "POST",
        data: {id: resident_id},
        dataType: "JSON",
        success: function (data) {
          $("#DocumentsTableBody").html(data);
          // updatePaginationControls(page);
        },
        error: function (xhr, status, error) {
          console.error("Error fetching table data:", error);
        },
      });
    })
    
});
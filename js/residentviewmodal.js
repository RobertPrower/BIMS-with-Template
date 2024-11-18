$(document).ready(function(){
    function DocuRequestloadTable(page) {

        var residentid = $("#viewresident_id").val();

        $.ajax({
          url: "includes/modaloperation.php",
          type: "POST",
          data: { pageno: page, resident_id: residentid, operation: "RES_DOCUREQ_FETCH_TABLE" },
          dataType: "HTML",
          success: function (data) {
            $("#ResidentRequestTable tbody").html(data);
            updatePaginationControls(page, 0,0);
          },
          error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
          },
        });
    }

    function BlotterTable(page){

      var resident_id = $("#viewresident_id").val();
      console.log(resident_id)

      $.ajax({
        type: "POST",
        url: "includes/modaloperation.php",
        data: {operation: "FETCH_RES_BLOTTER_INVOLVED", resident_id: resident_id, pageno: page},
        dataType: "HTML",
        success: function (response) {

          $("#ResidentBlotterTable tbody").html(response);
          updatePaginationControls(page, 1);

        }
      });
    }

    function updatePaginationControls(currentPage, whattable) {
        var residentid = $("#viewresident_id").val();

        if(whattable == 1){
          var table = 1
          var operation = "RES_BLOTTER_PAGINATION"

        }else if(whattable == 0){
          var table = 0
          var operation = "RES_DOCUREQ_PAGINATION"

        }else{
          alert("This should not run")
        }

        $.ajax({
          url: "includes/modaloperation.php",
          type: "POST",
          data: { pageno: currentPage, operation: operation, resident_id: residentid, whattable: table },
          dataType: "HTML",
          success: function (data) {
            if(whattable == 0){
              $("#clearance-tab .docu-pagination").html(data);
            }else if(whattable == 1){
              $("#nav-contact .blotter-pagination").html(data);
            }else{
              alert("This should not run")
            }          
  
          },
          error: function (xhr, status, error) {
            console.error("Error updating pagination data:", error);
          },
        });
      }

    $(document).on("shown.bs.modal","#ViewResidentModal", function () {
      //Click event in triggering the pagination control of the table
      $(document).on("click", ".docutab-pagination-control", function (e) {
          e.preventDefault();

          var residentid = $("#res_id_to_fetch").val();
          var page = $(this).data("page");

          $(".modal-pagination .modal-page-item").removeClass("active");
          $(this).parent().addClass("active");

          DocuRequestloadTable(page);
          updatePaginationControls(page, 0, 0);
      });

      $(document).on("click",".blottertab-pagination-control", function (e) {
        e.preventDefault();

        console.log("Blotter Pagination has been click")

        var residentid = $("#res_id_to_fetch").val();
        var page = $(this).data("page");

        $(".modal-pagination .modal-page-item").removeClass("active");
        $(this).parent().addClass("active");

        BlotterTable(page);
      });

      //Load the Resident Docu request table once the clearance tab was clicked
      $(document).off("click", "#nav-clearance-tab").one("click", "#nav-clearance-tab", function () {
          var resident_id = $("#viewresident_id").val();

          console.log(resident_id);

          DocuRequestloadTable();
          updatePaginationControls(1,0);
          
      });

      $(document).off('click','#nav-blotters-tab').one('click','#nav-blotters-tab', function(){

        BlotterTable()

      })

    });
});
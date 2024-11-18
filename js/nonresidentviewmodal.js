$(document).ready(function(){
    function DocuRequestloadTable(page) {

        var nresidentid = $("#viewnonresident_id").val();

        $.ajax({
          url: "includes/modaloperation.php",
          type: "POST",
          data: { pageno: page, nresident_id: nresidentid, operation: "NONRES_DOCREQ_FETCH_TABLE" },
          dataType: "HTML",
          success: function (data) {
            $("#NonResidentRequestTable tbody").html(data);
            updatePaginationControls(page,0);
          },
          error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
          },
        });
    }

    function updatePaginationControls(currentPage, whattable) {
      var nresidentid = $("#viewnonresident_id").val();

      if(whattable == 1){
        var table = 4
        var operation = "NONRES_BLOTTER_PAGINATION"

      }else if(whattable == 0){
        var table = 3
        var operation = "NONRES_DOCREQ_PAGINATION"

      }else{
        alert("This should not run")
      }

      $.ajax({
        url: "includes/modaloperation.php",
        type: "POST",
        data: { pageno: currentPage, operation: operation, nresident_id: nresidentid, whattable: table },
        dataType: "HTML",
        success: function (data) {
          if(whattable == 0){
            $("#ViewNonResidentModal #nonres_clearance-tab .docu-pagination").html(data);
          }else if(whattable == 1){
            $("#ViewNonResidentModal #nonres_blotters .blotter-pagination").html(data);
          }else{
            alert("This should not run")
          }          

        },
        error: function (xhr, status, error) {
          console.error("Error updating pagination data:", error);
        },
      });
    }

    function BlotterTable(page){

      var nresident_id = $("#viewnonresident_id").val();
      console.log(nresident_id)

      $.ajax({
        type: "POST",
        url: "includes/modaloperation.php",
        data: {operation: "FETCH_NONRES_BLOTTER_INVOLVED", nresident_id: nresident_id, pageno: page},
        dataType: "HTML",
        success: function (response) {

          $("#NonResidentBlotterTable tbody").html(response);
          updatePaginationControls(page, 1);

        }
      });
    }

    $(document).on("shown.bs.modal","#ViewNonResidentModal",function () {

      //Click event in triggering the pagination control of the table
      $(document).on("click", ".nrdocutab-pagination-control", function (e) {
        e.preventDefault();

        var page = $(this).data("page");

        $(".modal-pagination .modal-page-item").removeClass("active");
        $(this).parent().addClass("active");

        DocuRequestloadTable(page);
      });

      $(document).on("click",".nrblottertab-pagination-control", function (e) {
        e.preventDefault();

        console.log("Blotter Pagination has been click")

        var page = $(this).data("page");

        $(".modal-pagination .modal-page-item").removeClass("active");
        $(this).parent().addClass("active");

        BlotterTable(page);
    });

      $(document).on("click","#nav-blotters-tab", function(){

        BlotterTable()

      })

      //Load the Resident Docu request table once the clearance tab was clicked
      $(document).on("click", "#open-clearance-tab", function () {
          var nresident_id = $("#viewnonresident_id").val();
      
          $("#nonres_clearance-tab").tab("show");

          console.log(nresident_id);

          DocuRequestloadTable(1);
          
      });
      
    });
});
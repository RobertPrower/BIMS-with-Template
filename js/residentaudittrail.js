$(document).ready(function () {

    reloadTable();

    function reloadTable(page) {
        $.ajax({
        url: "includes/audittrailoperation.php",
        type: "POST",
        data: { pageno: page, operation: "FETCH_TABLE"  },
        dataType: "HTML",
        success: function (data) {
            $("#ResidentAuditTrailTable tbody").html(data);
            updatePaginationControls(page);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
        },
        });
    }

    function updatePaginationControls(currentPage) {
        $.ajax({
          url: "includes/residentoperation.php",
          type: "POST",
          data: { pageno: currentPage, operation: "PAGINATION" },
          dataType: "HTML",
          success: function (data) {
            $(".main-pagination").html(data);
            var noofpageitems = $(".pagination-control").length;
            console.log(noofpageitems);
            //Prevent the pagination from showing when the entries is less than 10
            switch(noofpageitems){
              case 1 :
                $("#pagenav").prop("hidden", true);
              break;
              default:
                $("#pagenav").prop("hidden", false);
    
            }
          },
          error: function (xhr, status, error) {
            console.error("Error updating pagination data:", error);
          },
        });
      }
    
      //Update the pagination controls every search
      function updateSearchPaginationControls(query, currentPage) {
        $.ajax({
          url: "includes/residentoperation.php",
          type: "POST",
          data: {
            search: query,
            pageno: currentPage,
            operation: "SEARCH_PAGINATION",
          },
          success: function (data) {
            $(".main-pagination").html(data);
    
            //Prevent the pagination from showing when the entries is less than 10 entries
            var noofpageitems = $(".pagination-control").length;
            switch(noofpageitems){
              case 1 :
                $("#pagenav").prop("hidden", true);
              break;
              default:
                $("#pagenav").prop("hidden", false);
    
            }
          },
          error: function (xhr, status, error) {
            console.error("Error updating search pagination data:", error);
          },
        });
    }

    $(document).on("click",".viewResidentButton",function (event) {
        event.preventDefault();

        var residentid = $(this).data("id");
  
        $.ajax({
            url: "includes/audittrailoperation.php",
            type: "POST",
            data: { resident_id: residentid, operation: "FETCH_RESIDENT_DETAILS" },
            dataType: "JSON",
            success: function (data) {
              var response = data[0];
              var imagepath = "includes/img/resident_img/" + response.img_filename;
    
                if(response.is_deleted == 1){

                    deleted_stat = "DELETED";
                    $("#delete_badge").removeClass("text-bg-danger");
                    $("#delete_badge").removeClass("text-bg-success");
                    $("#delete_badge").addClass("text-bg-danger");

                }else{
                    deleted_stat = "ACTIVE";
                    $("#delete_badge").removeClass("text-bg-danger") 
                    $("#delete_badge").removeClass("text-bg-success");
                    $("#delete_badge").addClass("text-bg-success");

                }


              $("#viewresident_id").val(response.resident_id);
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
              $("#resident_since").val(response.resident_since);
              $("#delete_status").text(deleted_stat);
              $("#imagePreview").prop("src", imagepath);


    
            },
            error: function (xhr, status, error) {
              console.error("Error fetching table data:", error);
            },
        });
         
        
      }
    );




});
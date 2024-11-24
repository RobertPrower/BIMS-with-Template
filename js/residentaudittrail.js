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
  
        // Get common data attributes
        var resident_id = $(this).data("id");
        var first_name = $(this).data("first-name");
        var middle_name = $(this).data("middle-name");
        var last_name = $(this).data("last-name");
        var suffix = $(this).data("suffix");
        var house_no = $(this).data("house-no");
        var street_name = $(this).data("street-name");
        var subdivision = $(this).data("subdivision");
        var sex = $(this).data("sex");
        var marital_status = $(this).data("marital-status");
        var birth_date = $(this).data("birth-date");
        var birthplace = $(this).data("birth-place");
        var phone_number = $(this).data("phone-number");
        var is_a_voter = $(this).data("isa-voter");
        var resident_since = $(this).data("rsince");
  
        // Modal ID based on the button clicked (Edit or View)
        var modalId = isEdit ? "#EditResidentModal" : "#ViewResidentModal";
  
        // Populate the common fields in the modal
        $(modalId + ' input[name="resident_id"]').val(resident_id);
        $(modalId + ' input[name="fname"]').val(first_name);
        $(modalId + ' input[name="mname"]').val(middle_name);
        $(modalId + ' input[name="lname"]').val(last_name);
        $(modalId + ' input[name="suffix"]').val(suffix);
        $(modalId + ' input[name="house_no"]').val(house_no);
        $(modalId + ' input[name="street"]').val(street_name);
        $(modalId + ' select[name="subd"]').val(subdivision);
        $(modalId + ' select[name="sex"]').val(sex);
        $(modalId + ' select[name="marital_status"]').val(marital_status);
        $(modalId + ' input[name="birth_date"]').val(birth_date);
        $(modalId + ' input[name="birth_place"]').val(birthplace);
        $(modalId + ' input[name="cellphone_number"]').val(phone_number);
        $(modalId + ' select[name="is_a_voter"]').val(is_a_voter);
        $(modalId + ' input[name="rsince"]').val(resident_since);
  
        // Specific logic for editing
        if (isEdit) {
          var page = $(this).data("pageno");
          $(modalId + ' input[name="pageno"]').val(page);
          $(modalId).modal("show"); // Show the Edit modal
  
          // Specific logic for viewing
        } else {
          // Make the profile tab the default tab when the view button is clicked
          $("#nav-home-tab").tab("show");
          $(modalId).modal("show"); // Show the View modal
          //For counting certificates requested
          $.ajax({
            type: "post",
            url: "includes/residentoperation.php",
            data: { operation: "COUNT_RES_CERT", resident_id: resident_id },
            dataType: "json",
            success: function (response) {
              console.log(response);
  
              $("#noofcerts").text(response);
            },
          });
  
          $.ajax({
            type: "post",
            url: "includes/residentoperation.php",
            data: { operation: "CHECK_HIT", resident_id: resident_id },
            dataType: "json",
            success: function (response) {
              console.log(response);
  
              if(response.success == "clear"){
                $("#with_hit").text("None");
                $("#blotter_badge").removeClass("text-bg-danger");
                $("#blotter_badge").removeClass("text-bg-success");
                $("#blotter_badge").addClass("text-bg-success");
  
              }else if(response.success == "hit"){
                $("#with_hit").text("With Hit");
                $("#blotter_badge").removeClass("text-bg-danger") 
                $("#blotter_badge").removeClass("text-bg-success");
                $("#blotter_badge").addClass("text-bg-danger");
  
              }else{
                alert("Server replys failed ")
              }
            }, error: function (xhr, status, error) {
              console.error("Error fetching data:", error);
            },
          });
        }
      }
    );




});
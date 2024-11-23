$(document).ready(function () {

    reloadTable(1);

    function reloadTable(page) {
      $.ajax({
        url: "includes/useroperation.inc.php",
        type: "POST",
        data: { pageno: page, operation: "TABLE_LOAD"},
        dataType: "HTML",
        success: function (data) {
          $("#UsersTable tbody").html(data);
          updatePaginationControls(page);
        },
        error: function (xhr, status, error) {
          console.error("Error fetching table data:", error);
        },
      });
    }
  
      //Reload the table of the Deleted Entries
      function reloadDeletedEntries(page) {
        $.ajax({
          url: "includes/useroperation.inc.php",
          type: "POST",
          data: { pageno: page, operation: "SHOW_DELETED" },
          dataType: "HTML",
          success: function (data) {
            $("#UsersTable tbody").html(data);
            updateDeletedPaginationControls(page);
          },
          error: function (xhr, status, error) {
            console.error("Error fetching table data:", error);
          },
        });
      }
    
      //Update the pagination controls every operation
      function updatePaginationControls(currentPage) {
        $.ajax({
          url: "includes/useroperation.inc.php",
          type: "POST",
          data: { pageno: currentPage, operation: "PAGINATION" },
          dataType: "HTML",
          success: function (data) {
            $(".main-pagination").html(data);
  
          //Prevent the pagination from showing when the entries is less than 10 entries
          var noofpageitems = $(".page-item").length;
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
          url: "includes/useroperation.inc.php",
          type: "POST",
          data: {
            search: query,
            pageno: currentPage,
            operation: "SEARCH_PAGINATION",
          },
          success: function (data) {
            $(".pagination").html(data);
  
            //Prevent the pagination from showing when the entries is less than 10 entries
            var noofpageitems = $(".page-item").length;
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

      function updateDeletedPaginationControls(currentPage, query) {
        $.ajax({
          url: "includes/useroperation.inc.php",
          type: "POST",
          data: { pageno: currentPage, search: query, operation: "PAGINATION_FOR_DEL_REC" },
          success: function (data) {
            $(".pagination").html(data);
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
            console.error("Error updating pagination data:", error);
          },
        });
      }
    
      //Function to search for entries
      function fetchResults(query, page = 1) {
        if ($("#showdeletedentries").is(":checked")) {
          console.log("Deleted Entries switch has been on");
          $.ajax({
            url: "includes/useroperation.inc.php",
            type: "POST",
            data: { search: query, pageno: page, operation: "DELETED_SEARCH" },
            success: function (data) {
              $("#UsersTable tbody").html(data);
              updateDeletedPaginationControls(page, query);
            },
            error: function (xhr, status, error) {
              console.error("Error fetching search results:", error);
            },
          });
        } else {
          console.log("Deleted Entries switch has been off");
          $.ajax({
            url: "includes/useroperation.inc.php",
            type: "POST",
            data: { search: query, pageno: page, operation: "SEARCH" },
            success: function (data) {
              $("#UsersTable tbody").html(data);
              updateSearchPaginationControls(query, page);
            },
            error: function (xhr, status, error) {
              console.error("Error fetching search results:", error);
            },
          });
        }
      }
    

    $("#UserSignup").on("submit",function (e) {
        e.preventDefault();

        var formdata  = new FormData(this);
        formdata.append("operation", "ADD_USER");

        $.ajax({
            type: "POST",
            url: "includes/useroperation.inc.php",
            data: formdata,
            dataType: "JSON",
            processData: false
            ,contentType: false,
            success: function (response) {

                if(response.success){
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "User has been added",
                    });

                    $('#UserSignup')[0].reset();

                    $("#imagePreview").attr("src", "includes/img/blank-profile.webp");

                    $("#AddUserModal").modal('hide');

                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Error :" + response.message,
                    });
                }
            },error: function(jqXHR, textStatus, errorThrown) {
                console.log("Request failed:", textStatus, errorThrown);
            }
        });




    });

    $("#showdeletedentries").click(function () {
      let query = $("#searchbox").val(); // Get the current search query
      if ($(this).is(":checked")) {
        console.log("Checkbox ON - Show Deleted Entries");
        reloadDeletedEntries(1); // Reload deleted entries
      } else {
        console.log("Checkbox OFF - Hide Deleted Entries");
        reloadTable(1); // Reload all entries
      }
    });

    $("#searchbox").on("keyup", function () {
      let query = $(this).val();
  
      if (query.length > 0) {
        //Fetch the results by the fetchResults function above
        fetchResults(query);
      } else {
        if ($("#showdeletedentries").is(":checked")) {
          //If query is less than 2 character just reload the table
          reloadDeletedEntries(1);
        } else {
          reloadTable();
        }
      }
    });

    $(document).on("click",".deletebtn", function () {
      Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete this user",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "includes/useroperation.inc.php",
            data: {
              operation: "DELETE_USER",
              user_id: $(this).data("user_id"),
              },
            dataType: "JSON",
            success: function (response) {
              
              if(response.success == true){
                Swal.fire({
                  title: "Success",
                  text: "The user has been deleted",
                  icon: "success"
                });
                reloadTable(1);
              }else{
                Swal.fire({
                  title: "Failed to delete!",
                  text: "The user failed to delete",
                  icon: "error"
                });
              }
            }, error: function (xhr, status, error) {
                Swal.fire({
                  title: "Failed to delete!",
                  text: "AJAX error",
                  icon: "error"
                });

                console.log("Error :" + error);
            },
          });
          
         
        }
      });
 
    });

    $(document).on("click", ".recoverbtn", function (event) {
      event.preventDefault();
  
      var userId = $(this).data("user_id");
      var page = $(this).data("page");
  
      Swal.fire({
        title: "Are you sure?",
        text: "The user will be recovered.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, recover it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "includes/useroperation.inc.php",
            type: "POST",
            data: { user_id: userId, operation: "RECOVER_USER" },
            dataType: "json",
            success: function (response) {
              console.log("User recovered successfully:", response);
              Swal.fire({
                title: "Success.",
                text: "User is Recovered successfully.",
                icon: "success"
              });
              reloadDeletedEntries(page);
            },
            error: function (xhr, status, error) {
              console.error("Error deleting data:", error);
              Swal.fire({
                title: "Error",
                text: "AJAX error: User is not recovered.",
                icon: "error"
              });
            },
          });
        }else{
          Swal.fire({
            title: "Recover User Canceled",
            text: "User is not recovred.",
            icon: "info"
          });
        }
      });
    });

    $(document).on("click",".viewbtn, .editbtn", function () {
        var whatbtn = ($(this).hasClass("viewbtn"))? "#ViewUserModal" : "#EditUserModal";

        var fname =$(this).data("first-name");
        var lname =$(this).data("last-name");
        var suffix =$(this).data("suffix");
        var mname =$(this).data("middle-name");
        var depart =$(this).data("dept_no");
        var filename =$(this).data("img_filename");
        var username = $(this).data("username")
        var created_by = $(this).data("created_by")

        if(whatbtn =="#ViewUserModal"){
          $("#ViewUserModal #imagePreview").attr("src", "includes/img/users_img/"+filename);
          $(".usernamelabel").text(username);
          $("#created_by").text(created_by);
          $("#view_fname").val(fname);
          $("#view_lname").val(lname);
          $("#view_mname").val(mname);
          $("#view_suffix").val(suffix);
          $("#view_department").val(depart);
        }else{
          $("#editimagePreview").attr("src", "includes/img/users_img/"+filename)
          $("#edit_fname").val(fname);
          $("#edit_lname").val(lname);
          $("#edit_mname").val(mname);
          $("#edit_suffix").val(suffix);
          $("#edit_department").val(depart);
        }

        if(depart == 1){

          $(".usernamelabel").removeClass("text-bg-danger");
          $(".usernamelabel").addClass("text-bg-primary")
        }else if(depart == 2){
          $(".usernamelabel").removeClass("text-bg-danger");
          $(".usernamelabel").addClass("text-bg-success")

        }else if(depart == 3){
          $(".usernamelabel").removeClass("text-bg-danger");
          $(".usernamelabel").addClass("text-bg-warning")
        }else if (depart == 5){
          $(".usernamelabel").removeClass("text-bg-danger");
          $(".usernamelabel").addClass("text-bg-secondary");
        }





       

    });
  


});
$(document).ready(function () {

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
});
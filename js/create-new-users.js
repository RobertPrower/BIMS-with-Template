$(document).ready(function () {

    $("#Signupform").on("submit",function (e) {
        e.preventDefault();

        var formdata  = new FormData(this);

        $.ajax({
            type: "POST",
            url: "includes/",
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

                    $('#Signupform')[0].reset();

                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Error :" + response.message,
                    });
                }
            },error ,function(e){
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something goes wrong.",
                });
            }
        });




    });
});
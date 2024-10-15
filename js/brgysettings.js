$(document).ready(function(){

    $("#EditBrgyOfficialsBtn").on('click', function (e) { 
        e.preventDefault();

        console.log("Event has been trigger")

        $("#EditBrgyOfficials").modal('show');

       var punong_brgy = $(this).data('punong_brgy');
       var brgy_sec = $(this).data('brgy_sec');
       var brgy_sk = $(this).data('brgy_sk');

       console.log(punong_brgy, brgy_sec, brgy_sk)

        $("#punong_barangay").val(punong_brgy);
        $("#brgy_secretary").val(brgy_sec);
        $("#brgy_skchair").val(brgy_sk);
        
    });

    $("#nav-kagawad-tab").on('click', function(){

        console.log("Fetch kagawad has been triggered");

        $.ajax({
            type: "POST",
            url: "includes/settingsoperation.php",
            data: {OPERATION: "FETCH_KAGAWAD"},
            dataType: "HTML",
            success: function (response) {

                $("#kagawadtable tbody").html(response);
                
            }
        });

    })

    $(document).on('click','.editkagawadbtn' ,function (e) { 
        e.preventDefault();

        console.log("Edit kagawad has been triggered");

        var id = $(this).data('id')
        var getkagawadname = "#kagawad"+id;
        var kagawad_name = $(getkagawadname).val();

        $.ajax({
            type: "POST",
            url: "includes/settingsoperation.php",
            data: {OPERATION:  "EDIT_KAGAWAD",kagawad_name: kagawad_name, id: id},
            dataType: "JSON",
            success: function (response) {

            if(response.success == true){
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Kagawad has been updated!"
                });

                $.ajax({
                    type: "POST",
                    url: "includes/settingsoperation.php",
                    data: {OPERATION : "FETCH_KAGAWAD", SUBOPERATION : "FOR_REFRESHING"},
                    dataType: "HTML",
                    success: function (response) {

                        $('#brgy_kagawads').html(response);
                        
                    }
                });


            }else{
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong. Please contact IT dept for troubleshooting"
                });

                console.log(response.message);
            }
                
            }, error: function(xhr, status, error) {
                console.error('Error fetching resident details:', error);
        
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!"
                });
            }
        });

        
    });

    $(document).on('click','.addkagawadbtn' ,function (e) { 
        e.preventDefault();

        console.log("Add kagawad has been triggered");

        var kagawad_name = $("#newkagawad").val();

        if(kagawad_name){
            $.ajax({
                type: "POST",
                url: "includes/settingsoperation.php",
                data: {OPERATION:  "ADD_KAGAWAD",kagawad_name: kagawad_name,},
                dataType: "JSON",
                success: function (response) {
    
                if(response.success == true){
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Kagawad has been Added!"
                    });
    
                    $.ajax({
                        type: "POST",
                        url: "includes/settingsoperation.php",
                        data: {OPERATION : "FETCH_KAGAWAD", SUBOPERATION: "FOR_REFRESHING"},
                        dataType: "HTML",
                        success: function (response) {
    
                            $('#brgy_kagawads').html(response);
                            
                        }
                    });
    
                    $.ajax({
                        type: "POST",
                        url: "includes/settingsoperation.php",
                        data: {OPERATION: "FETCH_KAGAWAD"},
                        dataType: "HTML",
                        success: function (response) {
            
                            $("#kagawadtable tbody").html(response);
                            
                        }
                    });
    
    
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Something went wrong. Please contact IT dept for troubleshooting"
                    });
    
                    console.log(response.message);
                }
                    
                }, error: function(xhr, status, error) {
                    console.error('Error fetching resident details:', error);
            
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                }
            });
    
        }else{
            Swal.fire({
                icon: "error",
                title: "Cannot be empty",
                text: "Please type name first before adding."
            });
        }
        
    });

    $(document).on('click','.deletekagawadbtn' ,function (e) { 
        e.preventDefault();

        console.log("Delete kagawad has been triggered");

        var kagawad_id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
          }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleted!",
                    text: "Your kagawad has been deleted",
                    icon: "success"
                });

                $.ajax({
                    type: "POST",
                    url: "includes/settingsoperation.php",
                    data: {OPERATION:  "DELETE_KAGAWAD",id: kagawad_id,},
                    dataType: "JSON",
                    success: function (response) {
        
                    if(response.success == true){
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: "Kagawad has been Deleted!"
                        });
        
                        $.ajax({
                            type: "POST",
                            url: "includes/settingsoperation.php",
                            data: {OPERATION : "FETCH_KAGAWAD", SUBOPERATION: "FOR_REFRESHING"},
                            dataType: "HTML",
                            success: function (response) {
        
                                $('#brgy_kagawads').html(response);
                                
                            }
                        });
        
                        $.ajax({
                            type: "POST",
                            url: "includes/settingsoperation.php",
                            data: {OPERATION: "FETCH_KAGAWAD"},
                            dataType: "HTML",
                            success: function (response) {
                
                                $("#kagawadtable tbody").html(response);
                                
                            }
                        });
        
        
                    }else{
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Something went wrong. Please contact IT dept for troubleshooting"
                        });
        
                        console.log(response.message);
                    }
                        
                    }, error: function(xhr, status, error) {
                        console.error('Error fetching resident details:', error);
                
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!"
                        });
                    }
                });


            }
          });

        
    });

    $(document).on('click','.psskbtnsave', function (e) {
        e.preventDefault;

        console.log("Save btn has been click")

        var punong_brgy = $("#punong_barangay").val();
        var brgy_sec = $("#brgy_secretary").val();
        var brgy_skchair = $("#brgy_skchair").val();

        $.ajax({
            type: "POST",
            url: "includes/settingsoperation.php",
            data: {OPERATION: "SAVE_PSSK", pb :punong_brgy, bsec : brgy_sec, bsk : brgy_skchair },
            dataType: "JSON",
            success: function (response) {

                $("#EditBrgyOfficials").modal('hide');

                $("#punong_brgy").html(punong_brgy);
                $("#brgy_sec").html(brgy_sec);
                $("#brgy_sk").html(brgy_skchair);

                if(response.success == true){
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "Brgy Officials Updated Successfully!!"
                    });

                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong! Please Contact the IT department."
                    });
                }
                
            }
        });
        
    });

    $("#EditBrgyDetailsBtn").click(function(e){
        e.preventDefault;

        console.log("Edit Brgy Details has been trigered")

        var brgyname = $(this).data('brgyname');
        var brgyaddress = $(this).data('brgyaddress');
        var brgytelnum = $(this).data('brgytelnum');
        var brgycpnum = $(this).data('brgycpnum');
        var brgyemail = $(this).data('brgyemail');
        var brgysona = $(this).data('sona');
        var brgydistrict =  $(this).data('district');
      

        console.log(brgycpnum)

        $("#brgy_name").val(brgyname);
        $("#brgy_address").val(brgyaddress);
        $("#brgy_telnum").val(brgytelnum);
        $("#brgy_celnum").val(brgycpnum);
        $("#brgy_email").val(brgyemail);
        $("#brgy_sona").val(brgysona);
        $("#brgy_district").val(brgydistrict);




    })

    $("#brgydetailsform").submit(function (e) { 
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("OPERATION","EDIT_BRGY_DETAILS");

        $.ajax({
            type: "POST",
            url: "includes/settingsoperation.php",
            data: formData,
            contentType: false, 
            processData: false,
            dataType: "JSON",
            success: function (response) {

                $("#EditBrgyDetails").modal('hide')

                if(response.success == true){

                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Barangay details updated successfully"
                    });

                    var brgy_name = formData.get("brgy_name");
                    var brgy_address = formData.get("brgy_address");
                    var brgy_sona = formData.get("brgy_sona");
                    var brgy_district = formData.get("brgy_district");
                    var brgy_telnum = formData.get("brgy_telnum");
                    var brgy_celnum = formData.get("brgy_celnum");
                    var brgy_email = formData.get("brgy_email");

                    $("#barangay_name").html(brgy_name);
                    $("#barangay_address").html(brgy_address);
                    $("#barangay_sona").html(brgy_sona);
                    $("#barangay_district").html(brgy_district);
                    $("#barangay_telnum").html(brgy_telnum);
                    $("#barangay_celnum").html(brgy_celnum);
                    $("#barangay_email").html(brgy_email);
                    



                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong! Please Contact the IT department."
                    });
                }
                
            }
        });

        
    });


})
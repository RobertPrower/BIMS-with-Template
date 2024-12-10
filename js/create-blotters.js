
$(document).ready(function(){

    generatemediatorname()

    function generatemediatorname(){
  
        $.ajax({ 
            url: 'includes/blottersoperation.php', 
            type: 'POST', 
            data: {operation: "FETCH_MEDIATOR_SELECT"},
            dataType: 'json', 
            success: function(data) { 
              data.forEach(function(option) {
                $('#mediator_name').append($('<option>', 
                  { value: option.mediator_id, 
                  text: option.mediator_name 
                  })); 
                });
            }, error: function(xhr, status, error){
              console.error('Error fetching options:', error); 
            }
          })
    }

    $(document).on("click", "#mediator_name", function () {

        var option_length = $("#mediator_name option")

        if (option_length.length == 0){

            generatemediatorname()

        }
        
    });

    var countResidentComplainant =0 
    var countNonResidentComplainant =0
    var countResidentRespondent =0
    var countNonResidentRespondent =0

    var resultArrayofOtherResComplainant = []
    var resultArrayofOtherResRespondent = []
    var resultArrayofOtherNonResComplainant = []
    var resultArrayofOtherNonResRespondent = []

    function SelectResandNonResModal(whatbutton, whatparty){
        if (whatbutton === "SelectResidentComplainant" || whatbutton === "SelectResidentRes") {
            $("#selectresident").modal('show');
    
            // Unbind any previous event handlers to prevent multiple bindings
            $(document).off('click', '.ResidentTable tbody tr');

            
            $(document).on('click', '.ResidentTable tbody tr', function() {
                $(this).toggleClass("selected").siblings().removeClass("selected");
                
                var table = $('.ResidentTable').DataTable();
                var rowData = table.row(this).data();
                var residentid = rowData.resident_id; 
                var imagefile = rowData.img_filename;
                console.log(imagefile)

                $('#example_filter').prepend(
                    `<button id="openAdditionalModal" class="btn btn-primary me-3" data-bs-modal="#AddResidentModal" data-bs-toggle="modal" >Open Additional Modal</button>`
                );

                $.ajax({
                    url: 'includes/modaloperation.php', 
                    type: 'POST',
                    data: { resident_id: residentid, operation: "FETCH_RESIDENT_DETAILS" },
                    success: function(response) {
                        var data = JSON.parse(response);

                        if (whatparty === 'respondent') {
                            $('#fnameres').val(data.first_name);
                            $('#mnameres').val(data.middle_name);
                            $('#lnameres').val(data.last_name);
                            $('#suffixres').val(data.suffix);
                            $('#addressres').val(data.address + " Camarin Caloocan City");
                            $("#id_to_recordres").val(residentid);
                            $("#checkresidentres").val("0");
                            $("#RespondentImg").attr("src", "includes/img/resident_img/"+imagefile);
                            resultArrayofOtherResRespondent.push(residentid)

                        } else if (whatparty === 'complainant') {
                            $('#f_name').val(data.first_name);
                            $('#m_name').val(data.middle_name);
                            $('#l_name').val(data.last_name);
                            $('#suffix').val(data.suffix);
                            $('#address').val(data.address + " Camarin Caloocan City");
                            $("#checkresident").val("0");
                            $('#id_to_record').val(residentid);
                            $("#ComplainantImg").attr("src", "includes/img/resident_img/"+imagefile);
                            resultArrayofOtherResComplainant.push(residentid)


                        } else if (whatparty == "othercomplainant"){
                            

                            if(countResidentComplainant <= 4){
                                console.log(countResidentComplainant)

                                if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Entry Already Selected',
                                        text: 'This person has already been selected. Please choose another one.',
                                        confirmButtonText: 'OK'
                                    });
                                  
                                }else{
                                    countResidentComplainant++
                                    var newContent = `
                                    <tr>
                                    <td hidden class="ResidentComplainant${countResidentComplainant}">`+residentid+`</td>
                                    <td><img src="includes/img/resident_img/${imagefile}" width="100 height="100""></td>
                                    <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                                    </tr>`;
    
                                    $('#ResidentComplainant').append(newContent);
                                    resultArrayofOtherResComplainant.push(residentid);
                                    
                                 
                                }
                                
                           
                            }else{
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'You reached the maxium allowed entries',
                                    text: 'If more people is involved, please use to the other input field.',
                                    confirmButtonText: 'OK'
                                });

                            }


                        }else if(whatparty == "otherrespondent"){
                        
                            if(countResidentRespondent <= 4){
                               if(resultArrayofOtherResRespondent.includes(residentid) || resultArrayofOtherResComplainant.includes(residentid)){

                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Entry Already Selected',
                                        text: 'This person has already been selected. Please choose another one.',
                                        confirmButtonText: 'OK'
                                    });
                                  
                               }else{
                                   
                                    countResidentRespondent++
                                    var newContent = `
                                    <tr>
                                    <th hidden class="ResidentRespondent${countResidentRespondent}">`+residentid+`</th>
                                    <td><img src="includes/img/resident_img/${imagefile}" width="100 height="100"></td>
                                    <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                                    </tr>`;

                                    $('#ResidentRespondent').append(newContent);
                                    resultArrayofOtherResRespondent.push(residentid);
                                  
                               }
                            }else{
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'You reached the maxium allowed entries',
                                    text: 'If more people is involved, please use to the other input field.',
                                    confirmButtonText: 'OK'
                                });

                            }

                        }else{
                            alert("This should not run")
                        }

                        $('#selectresident').modal('hide');
          
                        var checkwhatresidentstatus = $("#checkresident").val();
                        var checkwhatresidentstatusres = $("#checkresidentres").val();
                        var existingcomp = $("#id_to_record").val()
                        var existingres = $("#id_to_recordres").val()


                        if (existingcomp == existingres && checkwhatresidentstatusres == checkwhatresidentstatus) {
                            // Entry already selected, notify the user
                            Swal.fire({
                                icon: 'warning',
                                title: 'Entry Already Selected',
                                text: 'This person has already been selected. Please choose another one.',
                                confirmButtonText: 'OK'
                            });

                            if(whatparty == "complainant"){

                                $('#fname, #mname, #lname, #suffix, #address, #checkresident, #id_to_record').val('');
                                $("#ComplainantImg").attr("src", "includes/img/blank-profile.webp");


                            }else if (whatparty == "respondent"){

                                $('#fnameres, #mnameres, #lnameres, #suffixres, #addressres, #id_to_recordres, #checkresidentres').val('');
                                $("#RespondentImg").attr("src", "includes/img/blank-profile.webp");

                            }else{
                                alert("this should not run")

                            }

                        }else{
                            if(existingcomp && existingres && checkwhatresidentstatusres && checkwhatresidentstatus){

                                $(".AddOtherPartyBtn").removeAttr('disabled');
    
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching resident details:', error);
                    }
                });
                
            });

           
        } else {
            $("#selectnonresident").modal('show');
            console.log(whatparty)
            $(document).off('click', '.NonResidentTable tbody tr');
    
            $(document).on('click', '.NonResidentTable tbody tr', function() {
                $(this).toggleClass("selected").siblings().removeClass("selected");
                
                var table = $('.NonResidentTable').DataTable();
                var rowData = table.row(this).data();
                var residentid = rowData.nresident_id; 
                var imagefile = rowData.img_filename;
               
                $.ajax({
                    url: 'includes/modaloperation.php',
                    type: 'POST',
                    data: { nresident_id: residentid, operation: "FETCH_NON_RESIDENT_DETAILS" },
                    success: function(response) {
                        var data = JSON.parse(response);

                        if (whatparty === 'respondent') {
                            $('#fnameres').val(data.first_name);
                            $('#mnameres').val(data.middle_name);
                            $('#lnameres').val(data.last_name);
                            $('#suffixres').val(data.suffix);
                            $('#addressres').val(data.address);
                            $("#id_to_recordres").val(residentid);
                            $("#checkresidentres").val("1");
                            $("#RespondentImg").attr("src", "includes/img/non_resident_img/"+imagefile);
                            resultArrayofOtherNonResRespondent.push(residentid)


                        } else if (whatparty === 'complainant') {
                            $('#fname').val(data.first_name);
                            $('#mname').val(data.middle_name);
                            $('#lname').val(data.last_name);
                            $('#suffix').val(data.suffix);
                            $('#address').val(data.address);
                            $("#checkresident").val("1");
                            $('#id_to_record').val(residentid);
                            $("#ComplainantImg").attr("src", "includes/img/non_resident_img/"+imagefile);
                            resultArrayofOtherNonResComplainant.push(residentid)



                        } else if (whatparty === "othercomplainant"){

                            if(countNonResidentComplainant <= 4){
                                if(!resultArrayofOtherResRespondent.includes(residentid) || !resultArrayofOtherResComplainant.includes(residentid)){
                                    
                                    countNonResidentComplainant++;

                                    var newContent = `
                                    <tr>
                                    <td class="NonResComplainant${countNonResidentComplainant}" hidden>`+residentid+`</td>
                                    <td><img src="includes/img/non_resident_img/${imagefile}" width="100 height="100"></td>
                                    <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                                    </tr>`;

                                    $('#NonResComplainant').append(newContent);
                                    resultArrayofOtherNonResComplainant.push(residentid);
                                }
                            }else{
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'You reached the maxium allowed entries',
                                    text: 'If more people is involved, please use to the other input field.',
                                    confirmButtonText: 'OK'
                                });

                            }


                        }else if(whatparty == "otherrespondent"){
                          
                            if(countNonResidentRespondent <=4){
                                if(!resultArrayofOtherResRespondent.includes(residentid) || !resultArrayofOtherResComplainant.includes(residentid)){
                                    countNonResidentRespondent++;
                                    var newContent = `
                                        <tr>
                                        <td hidden class="NonResRespondent${countNonResidentRespondent}">`+residentid+`</td>
                                        <td><img src="includes/img/non_resident_img/${imagefile}" width="100 height="100"></td>
                                        <td>`+ data.last_name+', '+data.first_name+' '+data.middle_name+' '+data.suffix+`</td>
                                        </tr>`;

                                    $('#NonResRespondent').append(newContent);
                                    resultArrayofOtherNonResRespondent.push(residentid);
                                }
                            }else{
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'You reached the maxium allowed entries',
                                    text: 'If more people is involved, please use the other input field.',
                                    confirmButtonText: 'OK'
                                });

                        }

                        }

                        $('#selectnonresident').modal('hide');
          
                        var checkwhatresidentstatus = $("#checkresident").val();
                        var checkwhatresidentstatusres = $("#checkresidentres").val();
                        var existingcomp = $("#id_to_record").val()
                        var existingres = $("#id_to_recordres").val()

                        if(existingcomp && existingres && checkwhatresidentstatusres && checkwhatresidentstatus){

                            $(".AddOtherPartyBtn").removeAttr('disabled');

                        }

                        if(whatparty == "complainant" || whatparty == "respondent"){
                            if (existingcomp == existingres && checkwhatresidentstatusres == checkwhatresidentstatus) {
                                // Entry already selected, notify the user
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Entry Already Selected',
                                    text: 'This person has already been selected. Please choose another one.',
                                    confirmButtonText: 'OK'
                                });

                                if(whatparty == "complainant"){

                                    $('#fname, #mname, #lname, #suffix, #address, #checkresident, #id_to_record').val('');
                                    $("#ComplainantImg").attr("src", "includes/img/blank-profile.webp");


                                }else if (whatparty == "respondent"){

                                    $('#fnameres, #mnameres, #lnameres, #suffixres, #addressres, #id_to_recordres, #checkresidentres').val('');
                                    $("#RespondentImg").attr("src", "includes/img/blank-profile.webp");

                                }else{
                                    alert("this should not run")

                                }

                            }
                        } else if(whatparty == "othercomplainant" || whatparty == "otherrespondent"){

                            if ((existingcomp == existingres) && (checkwhatresidentstatusres == checkwhatresidentstatus)) {
                                // Entry already selected, notify the user
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Entry Already Selected',
                                    text: 'This person has already been selected. Please choose another one.',
                                    confirmButtonText: 'OK'
                                });

                            }


                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching resident details:', error);
                    }
                });
                
            });
        }
    }
    
    $(".SelectResidentBtn, .SelectNonResidentBtn, .SelectNonResidentBtnRes, .SelectResidentBtnRes").click(function (e) { 
        e.preventDefault();
    
        var whatbutton = $(this).attr("id");
        var whatparty = $(this).data("whatparty");
    
        SelectResandNonResModal(whatbutton, whatparty)
    });

    $(".AddOtherPartyBtn").click(function(){
        var whatbtn = $(this).data("whatbtn");
        var whatparty = $(this).data("whatparty");

        SelectResandNonResModal(whatbtn, whatparty)
    })

    $("#blotter_form").submit(function(event){
        event.preventDefault();
        var complainant_id = $("#id_to_record").val();
        var complainant_status = $("#checkresident").val();
        var respondent_id = $("#id_to_recordres").val();
        var respondent_status = $("#checkresidentres").val();

        var schedule_date = $("#schedule_date").val();
        var schedule_starttime =$("#schedule_starttime").val();
        var schedule_endtime = $("#schedule_endtime").val();

        if((schedule_date.length !== 0 ) || (schedule_starttime.length !== 0 ) || (schedule_endtime.length !== 0 )){
            var formData = new FormData(this);  
            formData.append("main_complainantid", complainant_id);
            formData.append("main_complainant_status", complainant_status);
            formData.append("main_respondentid", respondent_id);
            formData.append("main_respondent_status", respondent_status);
            formData.append("schedule_date", schedule_date);
            formData.append("schedule_starttime", schedule_starttime);
            formData.append("schedule_endtime", schedule_endtime);
            formData.append("operation", "ADD_BLOTTER");


            // Objects for the Other Complainants and Respondents
            let resident_complainants = {};
            let resident_respondents = {};
            let non_resident_complainants = {};
            let non_resident_respondents = {};

            //Fetch all Complanants and Respondents
            $("[class^='ResidentComplainant']").each(function(index) {
                resident_complainants[`Res_Complainant${index + 1}`] = $(this).text();
            });
            
            $("[class^='ResidentRespondent']").each(function(index) {
                resident_respondents[`Res_Respondent${index + 1}`] = $(this).text();
            });
            
            $("[class^='NonResComplainant']").each(function(index) {
                non_resident_complainants[`NonRes_Complainant${index + 1}`] = $(this).text();
            });
            
            $("[class^='NonResRespondent']").each(function(index) {
                non_resident_respondents[`NonRes_Respondent${index + 1}`] = $(this).text();
            });


        // Append resident complainants
            for (let i = 1; i <= 10; i++) {
                formData.append(`other_resident_complainant${i}`, resident_complainants[`Res_Complainant${i}`] || "null");
            }

            // Append resident respondents
            for (let i = 1; i <= 10; i++) {
                formData.append(`other_resident_respondent${i}`, resident_respondents[`Res_Respondent${i}`] || "null");
            }

            // Append non-resident complainants
            for (let i = 1; i <= 10; i++) {
                formData.append(`other_nonresident_complainant${i}`, non_resident_complainants[`NonRes_Complainant${i}`] || "null");
            }

            // Append non-resident respondents
            for (let i = 1; i <= 10; i++) {
                formData.append(`other_nonresident_respondent${i}`, non_resident_respondents[`NonRes_Respondent${i}`] || "null");
            }


            $.ajax({
                type: "POST",
                url: "includes/blottersoperation.php",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response.success == true){
                        Swal.fire({
                            title: "Blotter Added Successfully",
                            text: "Do you want to print the Blotter Report?",
                            icon: "success",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            cancelButtonText: "No",
                            confirmButtonText: "Yes"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                
                            }
                        });

                    }else{
                        Swal.fire({
                            title: "Something went wrong.",
                            text: "The server reply's failed : " + response.message,
                            icon: "error"
                        });
                    }
                }
            });
        }else{
            swal.fire({
                icon: "error",
                title: "No selected schedule!",
                text: "Please Select a schedule first",
            })
        }

        

    })

    $("#AddResidentModalForm").submit(function (event) {
        event.preventDefault();
    
        var captureImageData = $("#imagePreview").attr("src");
        console.log(captureImageData);
    
        var formData = new FormData(this);
        formData.append("operation", "ADD");
        formData.append("captureImageData", captureImageData);
    
        var page = $(this).data("pageno");
        console.log(page);
    
        $.ajax({
          url: "includes/residentoperation.php",
          type: "POST",
          data: formData,
          dataType: "JSON",
          contentType: false,
          processData: false,
          success: function (response) {
            // Handle success response
            console.log("Data saved successfully:", response);
    
            if (response.success == true) {
              $("#AddResidentModal").modal("hide");
              Swal.fire({
                title: "Add Entry",
                text: "Entry Added Sucessfully!",
                icon: "success",
              });
              reloadTable(page);
            } else if (response.success == "entry_match") {
    
               $("#AddResidentModal").modal("hide");
    
                Swal.fire({
                  title: "Duplicate Entry Detected.",
                  text: "Do you want to view the duplicate record?",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "View"
                  }).then((result) => {
                    if (result.isConfirmed) {
                      console.log(response.data.nresident_id)
                      $("#ViewResidentModal").modal("show");
    
                      var correctimagepath = "includes/img/resident_img/" + response.data.img_filename 
    
                      $("#viewimagePreview").attr("src", correctimagepath);
                      console.log("Existing Record View Pic has been loaded");
                      console.log(correctimagepath);
    
                      $('#nav-home-tab').tab('show');
    
                      // Populate the fields in the modal
                      $('#ViewResidentModal input[name="resident_id"]').val(response.data.resident_id);
                      $('#ViewResidentModal input[name="fname"]').val(response.data.first_name);
                      $('#ViewResidentModal input[name="mname"]').val(response.data.middle_name);
                      $('#ViewResidentModal input[name="lname"]').val(response.data.last_name);
                      $('#ViewResidentModal input[name="suffix"]').val(response.data.suffix);
                      $('#ViewResidentModal input[name="house_no"]').val(response.data.house_num);
                      $('#ViewResidentModal input[name="street"]').val(response.data.street);
                      $('#ViewResidentModal select[name="subd"]').val(response.data.subdivision);
                      $('#ViewResidentModal select[name="sex"]').val(response.data.sex);
                      $('#ViewResidentModal select[name="marital_status"]').val(response.data.marital_status);
                      $('#ViewResidentModal input[name="birth_date"]').val(response.data.birth_date);
                      $('#ViewResidentModal input[name="birth_place"]').val(response.data.birth_place);
                      $('#ViewResidentModal input[name="cellphone_number"]').val(response.data.cellphone_num);
                      $('#ViewResidentModal select[name="is_a_voter"]').val(response.data.is_a_voter);
                      $('#ViewResidentModal input[name="rsince"]').val(response.data.resident_since);
    
                        //For counting certificates requested
                      $.ajax({
                        type: "post",
                        url: "includes/residentoperation.php",
                        data: { operation: "COUNT_RES_CERT", resident_id: response.data.resident_id },
                        dataType: "json",
                        success: function (response) {
                          console.log(response);
    
                          $("#noofcerts").text(response);
                        },
                      });
                      
                    }
                });
    
                  
            } else if (response.success == false){
                $("#AddResidentModal").modal("hide");
                Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: "Server Replys Failed! Error"+ response.message,
                });
            } // END of if
          },
          error: function (xhr, status, error) {
            // Handle error response
            console.error("Error saving data:", error);
            // Optionally, display an error message to the user
            $("#AddResidentModal").modal("hide");
            Swal.fire({
              title: "Error",
              text: "Something went wrong!",
              icon: "error"
            });
          },
        });
      });

      $("#AddNonResidentModalForm").submit(function (event) {
        event.preventDefault();
    
        var captureImageData = $('#AddNonResidentModal #nonres_imagePreview').attr("src");
        console.log(captureImageData);
    
        var formData = new FormData(this);
        formData.append("operation", "ADD");
        formData.append("captureImageData", captureImageData);
    
        var page = $(this).data('pageno');
        console.log(page);
    
        $.ajax({
            url: "includes/nonresidentoperation.php",
            type: "POST",
            data: formData,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function (response) {
                // Handle success response
                console.log("Data saved successfully:", response);
    
                if (response.success === true) {
                    $("#AddNonResidentModal").modal("hide");
                    swal.fire({
                        title: "Add Entry",
                        text: "Entry Added Successfully!",
                        icon: "success",
                        button: "Close",
                    });
                    reloadTable(page);
                }else if(response.success === "entry_match") {
    
                    $("#AddNonResidentModal").modal("hide");
                    swal.fire("Duplicated Entry Detected", {
                        icon: "warning",
                        buttons: {
                            close: "Close",
                            view: {
                                text: "View Details",
                                value: "view",
                            },
                        },
                    }).then((value) => {
                      console.log(value);
                          console.log(response.data.nresident_id)
                          if (response.success == false) {
                            $("#ViewNonResidentModal").modal("show");
    
                            var correctimagepath = "includes/img/non_resident_img/" + response.data.img_filename 
    
                            $("#viewimagePreview").attr("src", correctimagepath);
                            console.log("Existing Record View Pic has been loaded");
                            console.log(correctimagepath);
    
                            $('#nav-home-tab').tab('show');
    
                            // Populate the fields in the modal
                            $('#ViewNonResidentModal input[name="nresident_id"]').val(response.data.nresident_id);
                            $('#ViewNonResidentModal input[name="fname"]').val(response.data.first_name);
                            $('#ViewNonResidentModal input[name="mname"]').val(response.data.middle_name);
                            $('#ViewNonResidentModal input[name="lname"]').val(response.data.last_name);
                            $('#ViewNonResidentModal input[name="suffix"]').val(response.data.suffix);
                            $('#ViewNonResidentModal input[name="house_no"]').val(response.data.house_num);
                            $('#ViewNonResidentModal input[name="street"]').val(response.data.street);
                            $('#ViewNonResidentModal input[name="subd"]').val(response.data.subdivision);
                            $('#ViewNonResidentModal input[name="district_brgy"]').val(response.data.district_brgy);
                            $('#ViewNonResidentModal input[name="city"]').val(response.data.city);
                            $('#ViewNonResidentModal input[name="province"]').val(response.data.province);
                            $('#ViewNonResidentModal input[name="zipcode"]').val(response.data.zipcode);
                            $('#ViewNonResidentModal select[name="sex"]').val(response.data.sex);
                            $('#ViewNonResidentModal select[name="marital_status"]').val(response.data.marital_status);
                            $('#ViewNonResidentModal input[name="birth_date"]').val(response.data.birth_date);
                            $('#ViewNonResidentModal input[name="birth_place"]').val(response.data.birth_place);
                            $('#ViewNonResidentModal input[name="cellphone_number"]').val(response.data.cellphone_num);
    
                          } else {
                            swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                            });
                          }
                      
                    });
                } else{

                    swal.fire({
                        icon: "error",
                        title: "Server replies failed",
                        text: response.message,
                    });

                }
            },
            error: function (xhr, status, error) {
                // Handle error response
                console.error("Error saving data:", error);
                $("#AddNonResidentModal").modal("hide");
                swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                });
            },
        });
    });

    var isCameraOpen = false;

    $('#openCamera, #nonres_openCamera').click(function() {
        var isEdit = $("#AddNonResidentModal").hasClass("show");


        if (!isCameraOpen) {
            // Initialize the webcam feed using Webcam.js
            Webcam.set({
                width: 200,
                height: 200,
                dest_width: 1280,
                dest_height: 720,
                crop_width: 720,
                crop_height: 720,
                image_format: 'jpeg',
                jpeg_quality: 100
            });

            if(isEdit){
                Webcam.attach('#nonres_cameraFeed', {
                    width: 200, // Width of the video
                    height: 200 // Height of the video
                }); // Attach the webcam to the camera feed div
  
                // Show the camera feed and hide the preview image
                $('#nonres_cameraFeedWrapper').show();
                $('#nonres_imagePreviewWrapper').hide();
                $('#nonres_imagefile').prop('disabled',true)

                // Change button text and style
                $('#nonres_openCamera').text('Capture').removeClass('btn-primary').addClass('btn-success');
                isCameraOpen = true;
    
                $("#nonres_imagePreview").attr("disabled");
                
            }else{ //For adding resident
                Webcam.attach('#cameraFeed'); // Attach the webcam to the camera feed div
  
                // Show the camera feed and hide the preview image
                $('#cameraFeedWrapper').show();
                $('#imagePreviewWrapper').hide();
                $('#imagefile').prop('disabled',true)

                // Change button text and style
                $('#openCamera').text('Capture').removeClass('btn-primary').addClass('btn-success');
                isCameraOpen = true;
    
                $("#imagePreview").attr("disabled");

            
            }

        }else{
            if(isEdit){
                // Capture the image from the webcam
                Webcam.snap(function(data_uri) {
                // Stop the webcam
                Webcam.reset();
    
                // Display the captured image in the preview section
                $('#nonres_imagePreview').attr('src', data_uri);
                                
                // Show the preview image and hide the camera feed
                $('#nonres_imagePreviewWrapper').show();
                $('#nonres_cameraFeedWrapper').hide();
    
                // Reset the button text and style
                $('#nonres_openCamera, .nonres_openCamera').text('Open Camera').removeClass('btn-success').addClass('btn-primary');
                $('#nonres_imagefile').prop('disabled',false)
                $("#nonres_imagefile").val('');  
                
                //$("#isfromcamcheck").prop("disabled", false);
                //$('#isfromcamcheck').val(data_uri);
                isCameraOpen = false;
                });

                console.log("nonres_ Captured has been triggred")

            }else{
                // Capture the image from the webcam
                Webcam.snap(function(data_uri) {
                // Stop the webcam
                Webcam.reset();
    
                // Display the captured image in the preview section
                $('#imagePreview').attr('src', data_uri);

                // Show the preview image and hide the camera feed
                $('#imagePreviewWrapper').show();
                $('#cameraFeedWrapper').hide();
    
                // Reset the button text and style
                $('#openCamera').text('Open Camera').removeClass('btn-success').addClass('btn-primary');
                $('#imagefile').prop('disabled',false)
                $("#imagefile").val('');  
                isCameraOpen = false;
                });
            }
        }
    });

    $(document).on("click", "#closeButton, .btnClose, #clearButton", function () {
        // Reset the form
        var form = $("#AddResidentModalForm, #AddNonResidentModalForm")[0]; // Access the DOM element
        form.reset(); // Resets the form fields
    
        // Reset webcam feed if open
        if (isCameraOpen === true) {
            Webcam.reset();
        }
    
        // Reset image preview
        var imagePreview = $("#imagePreview, #nonres_imagePreview");
        imagePreview.attr("src", "includes/img/blank-profile.webp"); // Properly reset the src attribute
    
        // Enable the file upload input and log reset if it was disabled
        var imageFile = $("#imagefile");
        if (imageFile.prop("disabled", true)) {
            console.log("The File upload has been reset!");
            imageFile.prop("disabled", false); // Re-enable the file input
        } else {
            alert("This block of code should not be executed!!");
        }
    });

    $('#imagefile, #nonres_imagefile').on('change', function() {
        var fileInput = this; // store reference to file input
        var file = this.files[0];
        var imageType = /image.*/;
        var validExtensions = ['png', 'jpg', 'jpeg']; 
        var isEdit = $("#AddNonResidentModal").hasClass("show");
        var oldImageSrc = (isEdit) ? $('#nonres_imagePreview').attr('src') : $('#imagePreview').attr('src'); 
        console.log(isEdit)
    
        if (!file.type.match(imageType)) {
            swal.fire({
                icon: "error",
                title: "The uploaded file is not a image!",
                text: "Please upload a vaild image file!",
            });
    
            if(isEdit){
                $('#nonres_imagePreview').attr('src', oldImageSrc);
            }else{
                $('#imagePreview').attr('src', oldImageSrc);
            }
    
            $(fileInput).val(''); // use stored reference
            return;
        }//Pass to the next check
    
        var extension = file.name.split('.').pop().toLowerCase();
        if(validExtensions.indexOf(extension) == -1) {
            swal.fire({
                icon: "error",
                title: "Oops... Invalid extension!",
                text: "Only png, jpg, and jpeg are allowed.",
            });
    
            if(isEdit){
                $('#nonres_imagePreview').attr('src', oldImageSrc);
            }else{
                $('#imagePreview').attr('src', oldImageSrc);
            }
            $(fileInput).val(''); // use stored reference
            return;
        }
    
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = new Image();
            img.onload = function() {
                if(img.width > 500 || img.height > 500) {
                    swal.fire({
                        icon: "error",
                        title: "Image Size is too large",
                        text: "Please upload an image with dimensions not exceeding 500x500 pixels.",
                    });
                     if(isEdit){
                        $('#nonres_imagePreview').attr('src', oldImageSrc);
                    }else{
                        $('#imagePreview').attr('src', oldImageSrc);
                    }
                    $(fileInput).val(''); // use stored reference
                    return;
                }
                // If the image is valid, update the preview image source
                if(isEdit){
                    $('#nonres_imagePreview').attr('src', reader.result);
                }else{
                    $('#imagePreview').attr('src', reader.result);
                }
            }
            img.src = reader.result;
        }
        reader.readAsDataURL(file);
    });
    
    
});
    
    
   


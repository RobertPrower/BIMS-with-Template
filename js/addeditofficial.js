$(document).on('click', '#EditOfficialBtn',function(){

  $('#EditOfficialModalForm').submit(function(){
    event.preventDefault();
  
    var formData = new FormData(this);
  
    console.log(formData);
  
      $.ajax({
    
        url: 'includes/addofficialsaction.php',
        type: 'POST',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response){
          alert("Official Successfully Edited");
          console.log('Server response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown){
          console.log('Error:', textStatus, errorThrown);
        }
  
      });
    
    
  });
});

$(document).on('click', '#AddOfficialBtn', function(){
  $('#AddOfficialModalForm').submit(function(){
    event.preventDefault();
  
    var formData = new FormData(this);
  
    console.log(formData);
  
      $.ajax({
    
        url: 'includes/addofficialsaction.php',
        type: 'POST',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response){
          alert("Official Successfully Added");
          console.log('Server response:', response);
        },
        error: function(jqXHR, textStatus, errorThrown){
          console.log('Error:', textStatus, errorThrown);
        }
  
      });
    
  });

  
});



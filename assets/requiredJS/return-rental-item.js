$(function() {
    $('#form').on('submit', function (e) {                                                                            

        if(!e.isDefaultPrevented() ) {
           if($(".checkboxes").length==0){
                alert("No item need to return");
           }else if($(".checkboxes:checked").length==0){
                alert("Click the checkbox for the returned item");
           }else{
                   bootbox.confirm({
                      size: "small",                                         
                      message: "Are you sure?", 
                      callback: function(result){ 
                               if(result){
                                    var url = "phpscript/rental/saveReturnedItems.php";
                                          $.ajax({
                                              type: "POST",
                                              url: url,
                                              dataType   : 'json',
                                              data: $("#form").serialize(),
                                              success: function (data)
                                              {
                                                  $('.alert').removeClass('alert-success, alert-danger')
                                                             .addClass(data.type)
                                                             .html(data.message)
                                                             .fadeIn(100,function(){
                                                                 $(this).fadeOut(5000);
                                                             });                                         
                                                  
                                                   $.each(data.data, function(key,value){
                                                       $("#row_"+value).remove();
                                                   });                                    

                                              }
                                          });                                    
                                } 
                      }
                   });  
            }                                  
             return false;     
        }    
                                               
                               
    });
});



           

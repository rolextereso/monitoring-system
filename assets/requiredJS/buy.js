$(function() {
                  $('#form').validator();
                  // when the form is submitted
                  $('#form').on('submit', function (e) {
                      // if the validator does not prevent form submit
                      if (!e.isDefaultPrevented()) {
                          bootbox.confirm({
                                          size: "small",                                         
                                          message: "Are you sure?", 
                                          callback: function(result) { 
                                                   if(result && $("#total_amount span").text()!=0){
                                                          var url = "phpscript/savePayment/savePayment.php";                                                       
                                                          
                                                          // POST values in the background the the script URL
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
                                                                  
                                                                  if(data.type=='alert-success'){
                                                                     // $('#form')[0].reset();
                                                                     $("#total_amount").val(0);
                                                                     $("#or_number_input").attr("disabled","disabled");
                                                                     $("#save_changes_").html("<h5 id='mark_saved'>OR has been saved</h5>");

                                                                     
                                                                  }
                                                                  
                                                              }
                                                          });
                                                          
                                              }else{
                                                alert("No payment to pay");
                                              }
                                      }
                                    });
                                    return false;
                      }
                  });

});

           
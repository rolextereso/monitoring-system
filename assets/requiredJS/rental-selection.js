$(function() {
                  $('#form').validator();
                  // when the form is submitted
                  $('#form').on('submit', function (e) {
                      // if the validator does not prevent form submit
                      if (!e.isDefaultPrevented()) {
                          bootbox.confirm({
                                          size: "small",                                         
                                          message: "Are you sure?", 
                                          callback: function(result){ 
                                                   if((result && $("#total_amount_").val()!=0) || $("[name='cancel'").length==1){
                                                          var url = "phpscript/rental/saveRentalSelection.php";
                                                          
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

                                                                      var transaction_id=$("[name='transaction_id']").val();
                                                              
                                                                      if(data.type=='alert-success' && $("[name='cancel'").length==0){
                                                                        var d=new Date(),
                                                                        day=d.getHours(),
                                                                        minute=d.getMinutes(),
                                                                        seconds=d.getSeconds(),
                                                                        month=d.getMonth(),
                                                                        year=d.getFullYear();

                                                                         $('#form')[0].reset();
                                                                         $('tr[row]').remove();
                                                                         $("[name='transaction_id']").val("RE"+seconds+year+month+day+"-"+minute+seconds);
                                                                         totalAmount();
                                                                         dialog_(transaction_id);
                                                                         
                                                                      }else if($("[name='cancel'").length==1){
                                                                        if($("#total_amount_").val()!=0){
                                                                           dialog_(transaction_id);
                                                                        }
                                                                       
                                                                        $("#cancelation button").attr("disabled","disabled");
                                                                        $("#cancelation span").hide();
                                                                      }
                                                                      
                                                                  }
                                                              });
                                                          }else{
                                                              alert("Please select an item ");
                                                           }
                                                  }
                                      
                                    });
                                    return false;
                        }
                  });
            });

function dialog_(transaction_id){
    bootbox.confirm({
                      size: "small",                                         
                      message: "Would you like to print the certification?", 
                      callback: function(result){ 
                               if(result){
                                  WindowPopUp('phpscript/savePayment/printCertification.php?id='+transaction_id+'&for=rental','print','480','450')
                               }
                      }
   });
}

         
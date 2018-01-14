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
                                                   if(result){
                                                          var url = "phpscript/savePayment/saveSelection.php";
                                                          
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
                                                              
                                                                      if(data.type=='alert-success'){
                                                                        var d=new Date(),
                                                                        day=d.getHours(),
                                                                        minute=d.getMinutes(),
                                                                        seconds=d.getSeconds(),
                                                                        month=d.getMonth(),
                                                                        year=d.getFullYear();

                                                                         $('#form')[0].reset();
                                                                         $('tr[row]').remove();
                                                                         $("[name='transaction_id']").val(""+seconds+year+month+day+"-"+minute+seconds);
                                                                         totalAmount();

                                                                         bootbox.confirm({
                                                                                            size: "small",                                         
                                                                                            message: "Would you like to print the certification?", 
                                                                                            callback: function(result){ 
                                                                                                     if(result){
                                                                                                        WindowPopUp('phpscript/savePayment/printCertification.php?id='+transaction_id,'print','480','450',windowClose)
                                                                                                     }
                                                                                            }
                                                                         });
                                                                      }
                                                                      
                                                                  }
                                                              });
                                                          }
                                                  }
                                      
                                    });
                                    return false;
                        }
                  });

                 

                  $('input#amount').keyup(function (event) {
                      // skip for arrow keys
                      if (event.which >= 37 && event.which <= 40) {
                          event.preventDefault();
                      }

                      var currentVal = ($(this).val()=="")? '0.00':$(this).val();                    

                      var testDecimal = testDecimals(currentVal);
                      if (testDecimal.length > 1) {
                          console.log("You cannot enter more than one decimal point");
                          currentVal = currentVal.slice(0, -1);
                      }

                      $(this).val(replaceCommas(currentVal));  
                      change(currentVal);               

                });
            });

            function change(value){
                   if($('#change').length==1){                 
                      var total_amount = parseFloat($('#total_amount_').val());
                      var change=parseFloat(value.replace(',',''))-total_amount;
                      $("#change").html("&#8369; "+change.format(2));
                   }
            }

          var windowClose=function(){

          }
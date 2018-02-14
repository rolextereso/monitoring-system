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
                                                   if(result && $("#total_amount_").val()!=0){
                                                          var url = "phpscript/savePayment/savePayment.php";
                                                          var amount=parseFloat($('#amount').val().replace(',',''));
                                                          var total_amount=parseFloat($('#total_amount_').val());
                                                          if(amount<total_amount){
                                                               $('.alert').removeClass('alert-success, alert-danger')
                                                                                 .addClass('alert-danger')
                                                                                 .html("<b>Amount tendered</b> must be exact or greater than the <b>total amount</b>")
                                                                                 .fadeIn(100,function(){
                                                                                     $(this).fadeOut(5000);
                                                                                 });
                                                          }else{
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

                                                                      var or_number=$("[name='or']").val();
                                                                      var amount_tendered=$("#amount").val();
                                                                      var selection_for=$("[name='selection_for']").val();
                                                                      
                                                                      if(data.type=='alert-success'){
                                                                         $('#form')[0].reset();
                                                                         $('tr[row]').remove();
                                                                         totalAmount();

                                                                         bootbox.confirm({
                                                                                            size: "small",                                         
                                                                                            message: "Would you like to print reciept?", 
                                                                                            callback: function(result){ 
                                                                                                     if(result){
                                                                                                        WindowPopUp('phpscript/savePayment/printReciept.php?or='+or_number+'&a='+amount_tendered+'&paid_for='+selection_for,'print','480','450',windowClose)
                                                                                                     }
                                                                                            }
                                                                         });
                                                                      }
                                                                      
                                                                  }
                                                              });
                                                          }
                                              }else{
                                                alert("No payment to pay");
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
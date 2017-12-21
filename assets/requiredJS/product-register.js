$(function() {

                  $('#form').validator();
                  // when the form is submitted
                  $('#form').on('submit', function (e) {                                                                             

                                 if(!e.isDefaultPrevented() ) {
                                       bootbox.confirm({
                                          size: "small",                                         
                                          message: "Are you sure?", 
                                          callback: function(result){ 
                                                   if(result){
                                                        var url = "phpscript/productSetup/registerProduct.php";
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
                                                                      
                                                                      if($("#product_id").length==0){
                                                                          $("#measurement_").html("Measurement");
                                                                          $("#price_").html("Price");
                                                                          $("#stat").html("(Unactive)").removeClass("green").removeClass("red").addClass("red");
                                                                          $('#form')[0].reset();
                                                                      }                                           

                                                                  }
                                                              });                                    
                                                    } 
                                          }
                                       });                                    
                                       return false;
                                  }                          
                  });

                  $('#cancel').on('click',function(){
                       $("#measurement_").html("Measurement");
                       $("#price").html("Price");                       
                       $('#form')[0].reset();
                  });

                   //script for the checkbox account status
                  $('#product_status').on('change',function(){
                      if($(this).is(':checked')){
                          $('#stat').removeClass('red').addClass('green');
                          $('#stat').text('(Active)');
                      }else{
                          $('#stat').removeClass('green').addClass('red');
                          $('#stat').html('(Unactive)');                         
                      }
                  });

                  $("input#measurement").keyup(function(e){
                      $("#measurement_").html(($(this).val()=="")?"Measurement":$(this).val());
                  });

                

                  $('input#price').keyup(function (event) {
                      // skip for arrow keys
                      if (event.which >= 37 && event.which <= 40) {
                          event.preventDefault();
                      }

                      var currentVal = $(this).val();
                      var testDecimal = testDecimals(currentVal);
                      if (testDecimal.length > 1) {
                          console.log("You cannot enter more than one decimal point");
                          currentVal = currentVal.slice(0, -1);
                      }
                      $(this).val(replaceCommas(currentVal));

                      $("#price_").html(($(this).val()=="")?"Price":$(this).val());
                  });
            });



           

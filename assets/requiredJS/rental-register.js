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
                                                        var url = "phpscript/rental/registerRental.php";
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
                                                                      
                                                                      if($("#item_id").length==0){
                                                                          $("#measurement_").html("Unit");
                                                                          $("#rental_").html("Rental Fee");
                                                                          $("#stat").html("(Unactive)").removeClass("green").removeClass("red").addClass("red");
                                                                          $("#per_day").html("(No)").removeClass("green").removeClass("red").addClass("red");
                                                                          $("#gpass").html("(No)").removeClass("green").removeClass("red").addClass("red");
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
                       $("#measurement_").html("Unit");
                       $("#rental").html("Rental Fee");                       
                       $('#form')[0].reset();
                  });

                   //script for the checkbox account status
                  $('#status').on('change',function(){
                      if($(this).is(':checked')){
                          $('#stat').removeClass('red').addClass('green');
                          $('#stat').text('(Active)');
                      }else{
                          $('#stat').removeClass('green').addClass('red');
                          $('#stat').html('(Unactive)');                         
                      }
                  });

                    //script for the checkbox account need gatepass and per day
                  $('#gate_pass').on('change',function(){
                      if($(this).is(':checked')){
                          $('#gpass').removeClass('red').addClass('green');
                          $('#gpass').text('(Yes)');
                      }else{
                          $('#gpass').removeClass('green').addClass('red');
                          $('#gpass').html('(No)');                         
                      }
                  });

                  $('#per_day').on('change',function(){
                      if($(this).is(':checked')){
                          $('#perD').removeClass('red').addClass('green');
                          $('#perD').text('(Yes)');
                      }else{
                          $('#perD').removeClass('green').addClass('red');
                          $('#perD').html('(No)');                         
                      }
                  });

                  $("input#measurement").keyup(function(e){
                      $("#measurement_").html(($(this).val()=="")?"Unit":$(this).val());
                  });

                

                  $('input#rental_fee').keyup(function (event) {
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

                      $("#rental_").html(($(this).val()=="")?"Rental Fee":$(this).val());
                  });
            });



           

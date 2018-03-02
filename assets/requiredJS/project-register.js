 $(function() {

                  $('#project_started, #project_ended').datepicker({
                      autoclose: true,    
                      todayHighlight: true,       
                  });

                  $('#form').validator();
                  // when the form is submitted
                  $('#form').on('submit', function (e) {
                      // if the validator does not prevent form submit
                     if(!e.isDefaultPrevented() ) {
                            bootbox.confirm({
                                          size: "small",                                         
                                          message: "Are you sure?", 
                                          callback: function(result){ 
                                            
                                                if(result){
                                                      var url = "phpscript/projectSetup/registerProject.php";

                                                       if(validateProjectDates() && $("#project_ended").val()!=""){
                                                             $('.alert').removeClass('alert-success, alert-danger')
                                                                                     .addClass('alert-danger')
                                                                                     .html("<b>Project Started</b> must be greater than <b>Project Ended</b>")
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

                                                                    if($("#project_id").length==0){
                                                                        $('#form')[0].reset();
                                                                        $("#stat").html("(Inactive)").removeClass("green").removeClass("red").addClass("red");
                                                                    }
                                                                }
                                                            });
                                                       }
                                                }
                                              }
                            });
                                
                            return false;
                      }
                  });

                  $('#cancel').on('click',function(){
                       $('#form')[0].reset();
                  });

                   //script for the checkbox account status
                  $('#project_status').on('change',function(){
                      if($(this).is(':checked')){
                          $('#stat').removeClass('red').addClass('green');
                          $('#stat').text('(Active)');
                      }else{
                          $('#stat').removeClass('green').addClass('red');
                          $('#stat').html('(Inactive)');
                         
                      }
                  });
            });

            function validateProjectDates(){
                var $from=$("#project_started").datepicker('getDate');
                var $to =$("#project_ended").datepicker('getDate');

                var error=false;
                if($from > $to){
                    error=true;
                }
               
                return error;
            }
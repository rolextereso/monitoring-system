$(document).ready(function(){

                  var url = "phpscript/registerAccount/editUser.php";
                  $('#form').validator();
                  $('#uploadForm').validator();
                  // when the form is submitted
                  $('#form').on('submit', function (e) {
                      // if the validator does not prevent form submit
                      if (!e.isDefaultPrevented()) {                                
                           bootbox.confirm({
                                          size: "small",                                         
                                          message: "Are you sure?", 
                                          callback: function(result){ 
                                            
                                                if(result){
                                                      // POST values in the background the the script URL
                                                      $.ajax({
                                                          type: "POST",
                                                          url: url,
                                                          dataType   : 'json',
                                                          data: $("#form").serialize(),
                                                          success: function (data)
                                                          {
                                                              $('.alert').removeClass('alert-success').removeClass('alert-danger')
                                                                         .addClass('alert-'+data.type)
                                                                         .html(data.message)
                                                                         .fadeIn(100,function(){
                                                                             $(this).fadeOut(5000);
                                                                         });                                            
                                                          }
                                                      });
                                               }
                                        }
                                      });
                                return false;
                      }
                  });

                  //script for the checkbox change password
                  $("#change_password input").attr('disabled','disabled').removeAttr('required').val('');
                  $('#check').on('change',function(){
                      if($(this).is(':checked')){
                          $("#change_password").show();
                          $("#change_password input").removeAttr('disabled').attr('required','required');
                      }else{
                          $("#change_password").hide();
                          $('#change_password div.form-group').removeClass('has-error has-danger');
                         
                      }
                  });

                  //script for the checkbox account status
                  $('#account_status').on('change',function(){
                      if($(this).is(':checked')){
                          $('#stat').removeClass('red').addClass('green');
                          $('#stat').text('(Active)');
                      }else{
                          $('#stat').removeClass('green').addClass('red');
                          $('#stat').html('(Unactive)');
                         
                      }
                  });

                  // script for uploading picture
                  $("#uploadForm").on('submit',(function(e) {
                            e.preventDefault();
                            
                            $('.spinner').show();

                                $.ajax({
                                  url: url,
                                  type: "POST",
                                  data:  new FormData(this),
                                  contentType: false,
                                  cache: false,
                                  processData:false,
                                  dataType   : 'json',
                                  success: function(data)
                                    {
                                           $('.spinner').hide();
                                           $("#pic").css('opacity',1);
                                           $('.alert').removeClass('alert-success').removeClass('alert-danger')
                                                       .addClass('alert-'+data.type)
                                                       .html(data.message)
                                                       .fadeIn(100,function(){
                                                           $(this).fadeOut(5000);
                                                       });
                                    },
                                  error: function() 
                                    {
                                      $('.spinner').hide();
                                        //alert('error: please contact the developer');
                                    }           
                                 });
                            
                      }));
            });

          var change_profile = function(event) {
                var output = document.getElementById('pic');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.style.opacity=0.5;
          };
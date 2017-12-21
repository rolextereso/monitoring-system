 $(function() {
                      $('#form').validator();
                      // when the form is submitted
                      $('#form').on('submit', function (e) {
                          // if the validator does not prevent form submit
                          if (!e.isDefaultPrevented()) {                            
                                          var url = "phpscript/login/loginPass.php";

                                          // POST values in the background the the script URL
                                          $.ajax({
                                              type: "POST",
                                              url: url,
                                              dataType   : 'json',
                                              data: $("#form").serialize(),
                                              success: function (data)
                                              {

                                                 if(!data.status){
                                                    $('#msg').html("<i class='fa fa-times'></i> Invalid username or password").addClass("red");
                                                    $('#hint').html(data.hint);

                                                    $('#password').val("");
                                                 }else{

                                                   $('#msg').html("<i class='fa fa-check'></i> Redirecting... Please wait.").addClass("green");
                                                    var redirect=function(){
                                                         window.location.href="index.php";
                                                    }

                                                    setTimeout(redirect, 3000);

                                                 }
                                                 

                                              }
                                          });                                   
                                           
                                    return false;
                          }
                      });
                });

function logout(){
            bootbox.confirm({
                      size: "small",                                         
                      message: "Are you sure you want to log-out?", 
                      callback: function(result){                         
                            if(result){
                                  var url = "phpscript/login/logout.php";
                                  // POST values in the background the the script URL
                                  $.ajax({
                                      type: "GET",
                                      url: url,                                                                      
                                      success: function (data)
                                      {
                                         if(data=="logout"){                                                    
                                              window.location.href="login.php";                                                   
                                         }
                                      }
                                  });
                            }
                     }
                    });
         }    
                         
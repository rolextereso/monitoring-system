	</div>
 </div>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="./assets/popper.min.js"></script>
    <script src="./assets/bootstrap.min.js"></script>
    <script src="./assets/bootbox.4.4.0.min.js"></script>
    <script src="./assets/requiredJS/CountNotification.js"></script>
	<script>
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
                                              delete_cookie();                                                   
                                              window.location.href="login.php";                                                   
                                         }
                                      }
                                  });
                            }
                     }
                    });
         }  
  //this will delete cookie hidealert when the overdue rented alert exists
  function delete_cookie(){
     document.cookie="hideAlert=;path=/";
  }

	</script>   
  
   
</body>
</html>
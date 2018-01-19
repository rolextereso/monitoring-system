<?php require_once('layout/header.php');
      require_once('classes/Crud.php');

     $crud = new Crud();

     $user_type_ = $crud->getData("SELECT * FROM user_type WHERE status='Y' AND user_type_id!=1;");          

?>   
<style>
  #profile-container{
      width: 300px;
      height: 300px;
     
  }

  #profile-container img{
      display: block;
      margin: auto;
      line-height: 300px;
      max-width: 100%;
      max-height: 100%;
  }



</style>

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='user-list.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Users List</a> / Register User</li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                 <i class="fa fa-address-book-o" aria-hidden="true"></i> Add Account
              </div>
              <div class="card-body">
                      <div class="row">
                        <div class="col-md-7">
                               <form data-toggle="validator" role="form" id="form">
                                        
                                        <div class="form-row">
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label for="exampleInputName">First name*</label>
                                                      <input class="form-control form-control-sm" id="firstname" name="firstname" type="text"  placeholder="Enter first name" required>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                      <label for="exampleInputLastName">Last name*</label>
                                                      <input class="form-control form-control-sm" id="lastname" name="lastname" type="text" placeholder="Enter last name" required>
                                                  </div>

                                              </div>
                                        </div>
                                      
                                        <div class="form-group">
                                                  <label  >Username*</label>
                                                  <input class="form-control form-control-sm" id="username" name="username" type="text"  placeholder="Enter username" required>
                                        </div>

                                        <div class="form-group">
                                                  <label  >Access Role*</label>
                                                  <select required class="form-control form-control-sm" id="access_role" name="access_role">
                                                        <option value="">Select type of role</option>
                                                        <?php 
                                                              foreach($user_type_ as $user){
                                                        ?>
                                                                <option value="<?php echo $user['user_type_id'] ?>" >
                                                                  <?php echo $user['user_type'] ?>
                                                                </option>

                                                        <?php
                                                              }
                                                        ?>
                                                  </select>
                                        </div>
                                        
                                        <div class="form-group">
                                          <div class="form-row">
                                            <div class="col-md-6">
                                                  <label for="exampleInputPassword1">Password*</label>
                                                  <input class="form-control form-control-sm"  id="password" name="password" type="password" placeholder="Password" required>
                                    
                                            </div>
                                            <div class="col-md-6">
                                                  <label for="exampleConfirmPassword">Confirm password*</label>
                                                  <input class="form-control form-control-sm" id="confirmpassword" name="confirmpassword" type="password" placeholder="Confirm password" required data-match="#password" data-match-error="Password mismatch!!!">
                                                
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                                  <label  >Login Hint:</label>
                                                  <input class="form-control form-control-sm" id="hint" name="hint" type="text"  placeholder="Type your password hint here...">
                                        </div>
                                        <div class="form-group">
                                          <button type="submit" name="submit" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Register</button>
                                        </div>
                              </form> 
                              <br/>
                      </div>
                      <div class="col-md-4">
                          <div id="profile-container">
                              <img id="pic"  src="img/pic_avatar.jpg"  />
                          </div>

                          
                      </div>
                  </div>
              </div>
        </div>
        </div>
      </main>


<script src='assets/validator.min.js'></script>   
<script>
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
                                                      var url = "phpscript/registerAccount/registerAccount.php";

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
                                                              $('#form')[0].reset();

                                                          }
                                                      });
                                                }
                                         }
                                      });
                                return false;
                      }
                  });
            });
</script>

<?php require_once('layout/footer.php');?>      
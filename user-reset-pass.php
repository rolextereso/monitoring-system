<?php 
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

     $user_id   = "";
     $firstname = "";
     $lastname  = "";
     $username  = "";
     $profile_pic="";
     $user_found=false;

    if(isset($_GET['u'])){
        //getting id from url
        $id = $crud->escape_string($_GET['u']);
         
        //selecting data associated with this particular id
        $result = $crud->getData("SELECT * FROM users WHERE user_id=$id LIMIT 1");
        
        $user_found=(count($result)==1)?true:false;
       
        foreach ($result as $res) {
            $user_id = $res['user_id'];
            $firstname = $res['firstname'];
            $lastname = $res['lastname'];
            $username = $res['username'];
          
          
        }
    }


?>  

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if(access_role("Users Setting","edit_command",$_SESSION['user_type'])){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='user-list.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> / User Password Reset</li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></i> Password Reset
              </div>
              <div class="card-body">
                <?php if($user_found){ ?>
                      <div class="row">
                        <div class="col-md-6">
                               <form data-toggle="validator" role="form" id="form" action="post">
                                        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                        User Name: <h5><?php echo $firstname.' '.$lastname;?></h5>
                                        <hr/>
                                        <div class="form-group">
                                                  <label for="exampleInputEmail1">New Password*</label>
                                                  <input class="form-control form-control-sm" id="newpassword" name="newpassword" type="password"  placeholder="Enter here" required >
                                        </div>

                                        
                                        <div class="form-group">
                                          <button type="submit" name="submit" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Save new password</button>
                                        </div>
                              </form> 
                              <br/>
                      </div>
                      <div class="col-md-6">
                               <h5>Administrative Rights Only:</h5>
                               <p> *Just type the new password in the textbox to change the password of the user.
                                   This is usually happen when user forgot their password to login.
                      </div>
               
                  </div>
                  <?php } else { ?>
                        <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>User Not Found, maybe because user is not exist.</small></h2>

                  <?php } ?>
              </div>
        </div>
        </div>
<script src='assets/validator.min.js'></script>   
<script>
          $(document).ready(function(){

                  var url = "phpscript/registerAccount/resetPassword.php";
                  $('#form').validator();
                
                  // when the form is submitted
                  $('#form').on('submit', function (e) {
                      // if the validator does not prevent form submit
                      if (!e.isDefaultPrevented()) {                                

                                // POST values in the background the the script URL
                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    dataType   : 'json',
                                    data: $(this).serialize(),
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
                                return false;
                      }
                  });
        });

                  
</script>

<?php }else{ echo UnauthorizedOpenTemp(); } ?>
      </main>




<?php require_once('layout/footer.php');?>      
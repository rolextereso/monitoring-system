<?php 
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

     $user_id   = "";
     $firstname = "";
     $lastname  = "";
     $username  = "";
     $profile_pic="";
     $user_type="";
     $status="N";
     $user_found=false;

    if(isset($_GET['u'])){
        //getting id from url
        $id = $crud->escape_string($_GET['u']);

        if(is_numeric($id) && $id!=''){
       
            //selecting data associated with this particular id
            $result = $crud->getData("SELECT * FROM users WHERE user_id=$id LIMIT 1");
            
            $user_found=(count($result)==1)?true:false;
           
            foreach ($result as $res) {
                $user_id   = $res['user_id'];
                $firstname = $res['firstname'];
                $lastname  = $res['lastname'];
                $username  = $res['username'];
                $user_type =$res['user_type'];
                $status =$res['status'];
                $profile_pic =$res['profile_pic'];
              
            }
        }
    }
?>  



<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='user-list.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> / Edit User/ <h2><?php echo $firstname.' '.$lastname;?></h2></li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></i> Edit Account
              </div>
              <div class="card-body">
                <?php if($user_found){ ?>
                      <div class="row">
                        <div class="col-md-7">
                               <form data-toggle="validator" role="form" id="form" action="post">
                                        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                        <div class="form-row">
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label for="exampleInputName">First name*</label>
                                                      <input class="form-control form-control-sm" id="firstname" name="firstname" type="text"  placeholder="Enter first name" required value="<?php echo $firstname;?>">
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                      <label for="exampleInputLastName">Last name*</label>
                                                      <input class="form-control form-control-sm" id="lastname" name="lastname" type="text" placeholder="Enter last name" required value="<?php echo $lastname;?>">
                                                  </div>

                                              </div>
                                        </div>
                                      
                                        <div class="form-group">
                                                  <label for="exampleInputEmail1">Username*</label>
                                                  <input class="form-control form-control-sm" id="username" name="username" type="text"  placeholder="Enter username" required value="<?php echo $username;?>">
                                        </div>

                                        <div class="form-group">
                                                  <label for="exampleInputEmail1">Access Role*</label>
                                                  <select required class="form-control form-control-sm" id="access_role" name="access_role">
                                                        <option value="">Select type of role</option>
                                                        <option value="1" <?php echo ($user_type=="1")?'selected': '';?>>Project In-Charge</option>
                                                        <option value="2" <?php echo ($user_type=="2")?'selected': '';?>>Campus Dean</option>
                                                        <option value="3" <?php echo ($user_type=="3")?'selected': '';?>>Accounting</option>
                                                  </select>
                                        </div>

                                        <div class="form-group">
                                                  <label for="check">Change Password</label>
                                                  <input  id="check" name="check" type="checkbox"  />
                                        </div>
                                        <hr/>
                                        <div id="change_password" style="display:none;">
                                              <div class="form-group">
                                                        <label for="oldpassword">Old Password*</label>
                                                        <input class="form-control form-control-sm" id="oldpassword" name="oldpassword" type="password"  placeholder="Enter old password" required>
                                              </div>

                                              <div class="form-group">
                                                <div class="form-row">
                                                  <div class="col-md-6">
                                                        <label for="exampleInputPassword1">New Password*</label>
                                                        <input class="form-control form-control-sm"  id="password" name="password" type="password" placeholder="Password" required>
                                          
                                                  </div>
                                                  <div class="col-md-6">
                                                        <label for="exampleConfirmPassword">Confirm password*</label>
                                                        <input class="form-control form-control-sm" id="confirmpassword" name="confirmpassword" type="password" placeholder="Confirm password" required data-match="#password" data-match-error="Password mismatch!!!">
                                                      
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                        <label for="exampleInputEmail1">Login Hint:</label>
                                                        <input class="form-control form-control-sm" id="hint" name="hint" type="text"  placeholder="Type your password hint here...">
                                              </div>
                                        </div>
                                         <div class="form-group">
                                                  <label for="check">Account Status</label>                                                  
                                                  <input  id="account_status" name="account_status" type="checkbox" <?php echo($status=='Y')?'checked':'';?> />
                                                  <span id="stat" class="italic <?php echo($status=='Y')?'green':'red';?>"><?php echo($status=='Y')?'(Active)':'(Unactive)';?></span>
                                        </div>
                                        <div class="form-group">
                                          <button type="submit" name="submit" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Edit Account</button>
                                        </div>
                              </form> 
                              <br/>
                      </div>
                      <div class="col-md-4">
                        <form id="uploadForm"  method="post">
                              <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                              <div id="profile-container">
                                  <img id="pic" class="img-fluid" src="<?php echo ($profile_pic=='')? 'img/pic_avatar.jpg':$profile_pic;?>"  />
                                    <img class="spinner"  src="assets/img/spinner.gif" style="display: none;" >
                              </div>

                              <input type="file" name="userImage" required class="btn"
                                  onchange="change_profile(event);"/>
                              <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-user-circle" aria-hidden="true"></i> Save Profile Picture</button>
                        </form>


                      </div>
                  </div>
                  <?php } else { ?>
                        <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>User Not Found, maybe because user is not exist.</small></h2>

                  <?php } ?>
              </div>
        </div>
        </div>
      </main>


<script src='assets/validator.min.js'></script>   
<script src='assets/requiredJS/user-edit.js'>        
</script>

<?php require_once('layout/footer.php');?>      
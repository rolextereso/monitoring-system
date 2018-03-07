<?php 
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

     $compName   = "";
     $compAddress = "";
     $compContact = "";
     $logo=""; 
     $id="";

     $result = $crud->getData("SELECT * FROM signatories  LIMIT 1");          
         
      foreach ($result as $res) {
          $id= $res['id'];
          $compName   = $res['compName'];
          $compAddress = $res['compAddress'];
          $logo  = $res['logo'];
          $compContact = $res['compContact'];     
      }
   
?>  



<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if(access_role("Admin Setting","view_page",$_SESSION['user_type'])){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='setting.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Setting </a> </li>
              </ol>
              <ul class="nav nav-tabs">
                          <li class="nav-item">
                               <a class="nav-link active" href="owner-info.php"><i class="fa fa-hand-pointer-o" ></i> Owner Information</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="user-role.php"> <i class="fa fa-male" ></i> User Role</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="bundle-remittance.php"> <i class="fa fa-cubes" ></i> Bundle Remittance</a>
                          </li>
                         
              </ul>
           </nav>

         <br/>
         <div class="card">
              <div class="card-header">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></i> Owner Information
              </div>
              <div class="card-body">
                <?php if(true){ ?>
                      <div class="row">
                        <div class="col-md-7">
                               <form data-toggle="validator" role="form" id="form" action="post">
                                        <input type="hidden" name="id" value="<?php echo $id;?>">
                                        <div class="form-group">                                            
                                                  
                                            <label>Company Name:*</label>
                                            <input class="form-control form-control-sm" id="compName" name="compName" type="text"  placeholder="Enter the company name" required value="<?php echo $compName;?>">                                      
                                                                                       
                                        </div>
                                      
                                        <div class="form-group">                                            
                                            <label>Company Address*</label>
                                            <input class="form-control form-control-sm" id="compAddress" name="compAddress" type="text" placeholder="Enter address" required value="<?php echo $compAddress;?>">
                                        </div>
                                    
                                        <div class="form-group">                                            
                                            <label>Contact Number</label>
                                            <input class="form-control form-control-sm" id="compContact" name="compContact" type="text" placeholder="Enter mobile/telephone number"  value="<?php echo $compContact;?>">
                                        </div>
                                         <br/>
                                         <br/>
                                   

                                        <div class="form-group">
                                          <button type="submit" name="submit" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                        </div>
                              </form> 
                              <br/>
                      </div>
                      <div class="col-md-4">
                        <form id="uploadForm"  method="post">
                              <input type="hidden" name="id" value="<?php echo $id;?>">
                              <div id="profile-container" style="height: auto;">
                                  <img id="pic" class="img-fluid" src="<?php echo ($logo=='')? 'img/logo-avatar.jpg':$logo;?>"  />
                                    <img class="spinner"  src="assets/img/spinner.gif" style="display: none;" >
                              </div>

                              <input type="file" name="logoImage" required class="btn"
                                  onchange="change_logo(event);"/>
                              <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-user-circle" aria-hidden="true"></i> Save Logo</button>
                        </form>


                      </div>
                  </div>
                  <?php } else { ?>
                        <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>Your are not authorized to view this page.</small></h2>

                  <?php } ?>
              </div>
        </div>
        </div>
<script src='assets/validator.min.js'></script>   
<script src='assets/requiredJS/owner-info.js'>      
</script>
<?php }else{ echo UnauthorizedOpenTemp(); } ?>
      </main>




<?php require_once('layout/footer.php');?>      
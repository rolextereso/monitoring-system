<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

    $users = $crud->getData("SELECT * FROM account WHERE IGP='9' ;");

    $project_id= "";
    $project_name= "";
    $project_description  = "";
    $project_status="";
    $project_incharge ="";
    $project_type ="";
    $found=false;
    $add=true;

    if(isset($_GET['edit'])){

       $id = $crud->escape_string($_GET['edit']);

       if(is_numeric($id) && $id!=''){
            $projects = $crud->getData("SELECT * FROM projects WHERE project_id=".$_GET['edit']);

            $found=(count($projects)==1)?true:false;

            $add=false;
            
            foreach ($projects as $res) {
                $project_id   = $res['project_id'];
                $project_name = $res['project_name'];
                $project_description  = $res['project_description'];
                $project_status  = $res['project_status'];
                $project_type  = $res['project_type'];
                $project_incharge =$res['project_incharge'];
                        
            }
      }
    }
    
?>   
<link href="assets/bootstrap-datepicker3.min.css" rel="stylesheet">
<style>

  .has-error .form-control {
    border-color: #a94442;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
  }

</style>

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if(access_role("Project List","view_page",$_SESSION['user_type'])){?> 
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                      <a href='<?php echo (isset($_GET['assigned']))? "project_assigned.php":"project-list.php";?>'>
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back</a> / Project / <h2><?php echo  $project_name;?></h2></li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                <i class="fa fa-tasks" aria-hidden="true"></i> <?php echo($add)?'Add':'Edit';?> Project
              </div>
              <div class="card-body">

              <?php if($found || $add){?>
                      <div class="row">
                        <div class="col-md-12">
                               <form data-toggle="validator" role="form" id="form">
                                        <?php 
                                          if($found){
                                        ?>
                                            <input type="hidden" id="project_id" name="project_id" value="<?php echo $project_id;?>">
                                        <?php } ?>

                                        
                                        <div class="form-row">
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                        <label for="exampleInputName">Project name*</label>
                                                        <input class="form-control form-control-sm" id="project_name" name="project_name" type="text"  placeholder="Enter project name" required value="<?php echo $project_name;?>">
                                                  </div>

                                                   <div class="form-group">
                                                  <label>Project In-Charge*</label>
                                                        <select required class="form-control form-control-sm" id="project_incharge" name="project_incharge">
                                                              <option value=""> Select Person In-charge</option>
                                                              <?php
                                                                  foreach ($users as $res) {
                                                              ?>
                                                              <option value="<?php echo $res['user_id'];?>"
                                                                <?php echo($res['user_id']==$project_incharge)?'Selected':'';?>
                                                                ><?php echo $res['FirstName'].' '.$res['LastName'];?></option>                                                                         
                                                              <?php } ?>
                                                        </select>
                                                  </div>

                                                  <div class="form-group">
                                                  <label>Project Type*</label>
                                                        <select required class="form-control form-control-sm" id="project_type" name="project_type">
                                                              <option value=""> Select type</option>
                                                              <option value="Agricultural" <?php echo($project_type=='Agricultural')?'selected':'';?>>Agricultural</option>
                                                              <option value="Non-Agricultural" <?php echo($project_type=='Non-Agricultural')?'selected':'';?>>Non-Agricultural</option>
                                                        </select>
                                                  </div>
                                                  <div class="form-group">
                                                              <label for="check">Project Status</label>                                                  
                                                              <input  id="project_status" name="project_status" type="checkbox" 
                                                              <?php echo($project_status=='Y')?'checked':'';?> />
                                                              <span id="stat" class="italic <?php echo($project_status=='Y')?'green':'red';?>"><?php echo($project_status=='Y')?'(Active)':'(Inactive)';?></span>
                                                    </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                      <label for="exampleInputLastName">Project Description</label>
                                                      <textarea rows="5" class="form-control " name="project_description" style="margin-top: 0px; margin-bottom: 0px;"><?php echo($project_description=='')?'':$project_description;?></textarea>
                                                  </div>

                                              </div>
                                        </div>
                                      
                                       
                                       
                                        <div class="form-group">
                                          <div class="form-row">
                                              <div class="col-md-6">
                                                  <button type="submit" name="submit" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Save Project</button>
                                              </div>
                                              <br/><br/>
                                        
                                              <div class="col-md-6">
                                                  <button id="cancel" class="btn btn-danger btn-block" ><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
                                              </div>
                                          </div>

                                      </div>
                              </form> 
                              <br/>
                      </div>
                     
                  </div>
                  <?php }else{?>
                         <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>Project Not Found, maybe because project is not exist.</small></h2>


                  <?php } ?>
              </div>
        </div>
        </div>
        <script src='assets/validator.min.js'></script>
        <script src="assets/bootstrap-datepicker.min.js"></script>   
        <script src="assets/requiredJS/project-register.js"></script>
        <?php }else{ echo UnauthorizedOpenTemp(); } ?>
      </main>




<?php require_once('layout/footer.php');?>      
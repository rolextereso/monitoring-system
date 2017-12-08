<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

    $users = $crud->getData("SELECT * FROM users ;");
    
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
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='user-list.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> / Register User</li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                <i class="fa fa-tasks" aria-hidden="true"></i> Add Project
              </div>
              <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                               <form data-toggle="validator" role="form" id="form">
                                        
                                        <div class="form-row">
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                        <label for="exampleInputName">Project name*</label>
                                                        <input class="form-control form-control-sm" id="project_name" name="project_name" type="text"  placeholder="Enter project name" required>
                                                  </div>

                                                   <div class="form-group">
                                                  <label for="exampleInputEmail1">Project In-Charge*</label>
                                                        <select required class="form-control form-control-sm" id="project_incharge" name="project_incharge">
                                                              <option value=""> Select Person In-charge</option>
                                                              <?php
                                                                  foreach ($users as $res) {
                                                              ?>
                                                              <option value="<?php echo $res['user_id'];?>"><?php echo $res['firstname'].' '.$res['lastname'];?></option>                                                                         
                                                              <?php } ?>
                                                        </select>
                                                  </div>

                                                   <div class="form-group">
                                                        <label for="exampleInputEmail1">Project Started*</label>
                                                        <input class="form-control form-control-sm" id="project_started" name="project_started" type="text"  placeholder="Date Started" data-date-format="yyyy-mm-dd" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Project Ended</label>
                                                        <input data-date-format="yyyy-mm-dd" class="form-control form-control-sm" id="project_ended" name="project_ended" type="text"  placeholder="Date Ended" >
                                                    </div>

                                                    <div class="form-group">
                                                              <label for="check">Project Status</label>                                                  
                                                              <input  id="project_status" name="project_status" type="checkbox"> 
                                                              <span id="stat" class="italic"></span>
                                                    </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                      <label for="exampleInputLastName">Project Description</label>
                                                      <textarea rows="4" cols="50" class="form-control " name="project_description" style="margin-top: 0px; margin-bottom: 0px; height: 263px;"></textarea>
                                                  </div>

                                              </div>
                                        </div>
                                      
                                       
                                       
                                        <div class="form-group">
                                          <div class="form-row">
                                              <div class="col-md-6">
                                                  <button type="submit" name="submit" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Register Project</button>
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
              </div>
        </div>
        </div>
      </main>


<script src='assets/validator.min.js'></script>
<script src="assets/bootstrap-datepicker.min.js"></script>   
<script>
          $(function() {

                  $('#project_started, #project_ended').datepicker({
                      autoclose: true,                   
                  });

                  $('#form').validator();
                  // when the form is submitted
                  $('#form').on('submit', function (e) {
                      // if the validator does not prevent form submit
                      if (!e.isDefaultPrevented()) {
                                var url = "phpscript/projectSetup/registerProject.php";

                                // POST values in the background the the script URL
                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    dataType   : 'json',
                                    data: $(this).serialize(),
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
                          $('#stat').html('(Unactive)');
                         
                      }
                  });
            });
</script>

<?php require_once('layout/footer.php');?>      
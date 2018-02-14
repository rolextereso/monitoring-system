<?php require_once('layout/header.php');?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
<?php require_once('layout/nav.php');?>
<style>
  tr[role='row'] td small {
     display: inline; 
  }
</style>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if(access_role("Project List","view_command",$_SESSION['user_type'])){?> 
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-cube"></i> Projects </li>
              </ol>
              <ul class="nav nav-tabs">
                          <li class="nav-item">
                               <a class="nav-link " href="project-list.php">Budgeted Project List</a>
                          </li>
                          <?php if(access_role("Project List","view_command",$_SESSION['user_type'])){?> 
                          <li class="nav-item ">
                              <a class=" nav-link active" href="project_assigned.php">Assigned Projects</a>
                          </li>   
                          <?php } ?>                       
              </ul>
           </nav>
           <br/>
            <a href='project-register.php?assigned' class="btn btn-success" style="margin-left: 17px;" ><i class="fa fa-plus" aria-hidden="true"></i> Add New Project</a>
           <br/>
           <div class="table-responsive">                          
                    <table class="table table-hover" id="dataTable" width="100%" cellpadding="0" cellspacing="0">
                      <thead class="thead-dark">
                            <tr> 
                                 
                                  <th>Project Name</th>
                                  <th>Project Type</th>                                             
                                  <th>Project In-Charge</th>
                                  <th>Status</th>                                  
                                  <th>Commands</th>
                            </tr>
                      </thead>
                  </table>
          </div>
              
        </div>
      <script src="assets/datatables/jquery.dataTables.js"></script>
      <script src="assets/datatables/dataTables.bootstrap4.js"></script> 
      <script src="assets/dataTables.rowGroup.min.js"></script> 
      <script>   

          $(document).ready(function(){
               
                  var dataTable = $('#dataTable').DataTable( {
                                            "processing": true,
                                            "serverSide": true,
                                            "searching" : true,                                            
                                            "bLengthChange": false,
                                            "ajax":{
                                              url :"phpscript/projectSetup/projectList_assigned.php" 
                                            },
                                            columnDefs: [ {
                                                targets: [3,4], // column or columns numbers
                                                orderable: false,  // set orderable for selected columns
                                            }]
                                });  
          });
      </script>
 <?php }else{ echo UnauthorizedOpenTemp(); } ?>
      </main>
     
<?php require_once('layout/footer.php');?>      
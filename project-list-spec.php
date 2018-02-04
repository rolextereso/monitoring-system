<?php require_once('layout/header.php');?> 
<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

    $project_name= "";
    $project_id="";
    $found=false;  

    if(isset($_GET['id'])){
       $id = $crud->escape_string($_GET['id']);
       if(is_numeric($id) && $id!=''){
            $projects = $crud->getData("SELECT * FROM projects WHERE project_id=".$_GET['id']);

            $found=(count($projects)==1)?true:false;      
            foreach ($projects as $res) {               
                $project_name = $res['project_name'];  
                $project_id=$res['project_id'];                                   
            }
      }
    }
    
?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
<style>
  .toolbar {
      float: left;
  }
</style>
<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='project-list.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Project List</a> / Project /<?php echo  $project_name;?></li>
              </ol>
           </nav>
           <?php if($found){?>
           <div class="table-responsive"> 
                    
                    <input type="hidden"  value="<?php echo $project_id;?>" id="id" />                         
                    <table class="table table-hover" id="dataTable" width="100%" cellpadding="0" cellspacing="0">
                      <thead class="thead-dark">
                            <tr> 
                                  <th>Auto-ID</th>
                                  <th>Project Started</th>
                                  <th>Project Ended</th>      
                                  <th>Save by</th>                                             
                                  <th>Date Saved</th>
                                  <th>Status</th>
                                  <th>Commands</th>
                            </tr>
                      </thead>
                  </table>
          </div>
           <?php }else{?>
                         <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>ID Not Found, maybe because product is not exist.</small></h2>


           <?php } ?>
              
        </div>
      </main>
      <script src="assets/datatables/jquery.dataTables.js"></script>
      <script src="assets/datatables/dataTables.bootstrap4.js"></script> 

      <script>   
          var datatable;
          $(document).ready(function(){        
    
               
                   dataTable = $('#dataTable').DataTable( {
                                  "processing": true,
                                  "serverSide": true,
                                  "searching" : true,
                                  "dom": '<"toolbar">frtip',
                                  "bLengthChange": false,
                                  "ajax":{
                                    url :"phpscript/projectSetup/projectListspec.php?id="+$("#id").val(),
                                  },
                                  columnDefs: [{
                                                  targets: [1,2,3,4,5], // column or columns numbers
                                                  orderable: false,  // set orderable for selected columns
                                              }]
                                } ); 
                  var project_id=$('#id').val();
                  <?php 
                  $add_="";
                  if(access_role("Project List","add_command",$_SESSION['user_type'])){ ?>
                      $("div.toolbar").html("<a href='product-register-step.php?p_id="+project_id+"'><i class='fa fa-plus-square'></i> Add another project budget</span></a>");
                  <?php }else{  ?> 
                      $("div.toolbar").html("");
                  <?php } ?>
                  
          });

          function deleteBudget(id){
            bootbox.confirm({
                      size: "small",                                         
                      message: "Remember once deleted it will never be recover, Are you sure you want to proceed?", 
                      callback: function(result){                         
                            if(result){
                                  var url = "phpscript/projectSetup/deleteProjectBudget.php";
                                  // POST values in the background the the script URL
                                  $.ajax({
                                      type: "POST",
                                      url: url, 
                                      data: {project_specific_id:id},
                                      dataType   : 'json',                                                                  
                                      success: function (data)
                                      {
                                            $('.alert').removeClass('alert-success, alert-danger')
                                                                                     .addClass(data.type)
                                                                                     .html(data.message)
                                                                                     .fadeIn(100,function(){
                                                                                         $(this).fadeOut(5000);
                                                                                     }); 

                                            dataTable.ajax.reload( null, false );
                                      }
                                  });
                            }
                     }
                    });
         }  
      </script>
    
<?php require_once('layout/footer.php');?>      
<?php require_once('layout/header.php');?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
 <style>
    a.btn{
      text-decoration: none;
      color:white !important;
    }

    #dataTable tr td {
        height: 30px;
        padding-bottom:0.1rem ;
        padding-top:0.1rem ;
    }

    .edit{
          padding: 0px 6px;
    }
</style>

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='setting.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> / Project List</li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                <i class="fa fa-table"></i> Projects
                <a href='project-register.php' type="button" class="btn btn-info" style="float:right;"><i class="fa fa-plus" aria-hidden="true"></i> Add Project</a>
              </div>
              <div class="card-body">
                       <div class="table-responsive">                               

                               <table class="table table-striped table-hover table-bordered" id="dataTable" width="100%">
                                  <thead>
                                        <tr>  <th>No.</th>
                                              <th>Project Name</th>
                                              <th>Project Description</th>                                             
                                              <th>Project In-Charge</th>
                                              <th>Project status</th>
                                              <th>Commands</th>
                                        </tr>
                                  </thead>
                              </table>
                      </div>
              </div>
        </div>
        </div>
      </main>

      <script src="assets/datatables/jquery.dataTables.js"></script>
      <script src="assets/datatables/dataTables.bootstrap4.js"></script> 
      <script>   

          $(document).ready(function(){
               
                  var dataTable = $('#dataTable').DataTable( {
                                  "processing": true,
                                  "serverSide": true,
                                  "searching" : true,
                                  "ajax":{
                                    url :"phpscript/projectSetup/projectList.php", // json datasource
                                    
                                    error: function(){  // error handling
                                      $(".employee-grid-error").html("");
                                      $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                      $("#employee-grid_processing").css("display","none");
                                      
                                    }
                                  }
                                } );  


          });
      </script>
<?php require_once('layout/footer.php');?>      
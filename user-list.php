<?php require_once('layout/header.php');?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
 <style>
    a.btn{
      text-decoration: none;
      color:white !important;
    }

    .edit{
          padding: 0px 6px;
    }
</style>

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">

           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='setting.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> / Users List</li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                <i class="fa fa-table"></i> Users

                <?php if(access_role("Users Setting","add_command",$_SESSION['user_type'])){?>
                      <a href='user-register.php' type="button" class="btn btn-info" style="float:right;"><i class="fa fa-plus" aria-hidden="true"></i> Add User</a>
                <?php } ?>


              </div>
              <div class="card-body">
                       <div class="table-responsive">                               

                               <table class="table table-striped table-hover table-bordered" id="dataTable" width="100%" cellpadding="0" cellspacing="0">
                                  <thead class="thead-dark">
                                        <tr>  <th>Picture</th>
                                              <th>First Name</th>
                                              <th>Last Name</th>
                                              <th>Username</th>
                                              <th>User Type</th>
                                              <th>Status</th>
                                              <th>Commands</th>
                                        </tr>
                                  </thead>
                              </table>
                      </div>
              </div>
        </div>
        </div>
      <script src="assets/datatables/jquery.dataTables.js"></script>
      <script src="assets/datatables/dataTables.bootstrap4.js"></script> 
      <script>   

          $(document).ready(function(){
               
                  var dataTable = $('#dataTable').DataTable( {
                                  "processing": true,
                                  "serverSide": true,
                                  "searching" : true,
                                  "ajax":{
                                    url :"phpscript/registerAccount/userList.php", // json datasource
                                    
                                    error: function(){  // error handling
                                      $(".employee-grid-error").html("");
                                      $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                      $("#employee-grid_processing").css("display","none");
                                      
                                    }
                                  }
                                } );  


          });
      </script>

      </main>

      
<?php require_once('layout/footer.php');?>      
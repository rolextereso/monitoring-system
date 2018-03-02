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
<?php if($_SESSION['user_type']==1){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='setting.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Setting </a> </li>
              </ol>
              <ul class="nav nav-tabs">
                          <li class="nav-item">
                               <a class="nav-link " href="owner-info.php"><i class="fa fa-hand-pointer-o" ></i> Owner Information</a>
                          </li>
                          <li class="nav-item">
                              <a class=" nav-link" href="user-role.php"> <i class="fa fa-male" ></i> User Role</a>
                          </li>
                          <li class="nav-item">
                              <a class=" active nav-link" href="bundle-remittance.php"> <i class="fa fa-cubes" ></i> Bundle Remittance</a>
                          </li>
                         
              </ul>
           </nav>

         <br/>
         <div class="card">
              <div class="card-header">
               
                    <a href='bundle-remittance-add-op.php' type="button" class="btn btn-info" style="float:right;"><i class="fa fa-plus" aria-hidden="true"></i> Add OP Number</a>
              </div>
              <div class="card-body">
                       <div class="table-responsive">                               

                               <table class="table table-striped table-hover table-bordered" id="dataTable" width="100%" cellpadding="0" cellspacing="0">
                                  <thead class="thead-dark">
                                        <tr>  <th>OP Number</th>
                                              <th>Products Involved</th>
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
                                    url :"phpscript/bundle-remittance/bundle_remittance_list.php"
                                  }
                                } );  


          });
      </script>
<?php }else{ echo UnauthorizedOpenTemp(); } ?>
      </main>

      
<?php require_once('layout/footer.php');?>      
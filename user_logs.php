<?php require_once('layout/header.php');?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if(access_role("User Logs","view_page",$_SESSION['user_type'])){?> 
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='setting.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to setting</a> / User Activity </li>
              </ol>
           </nav>

           <div class="table-responsive">                          
                    <table class="table table-hover" id="dataTable" width="100%" cellpadding="0" cellspacing="0">
                      <thead class="thead-dark">
                            <tr> 
                                  <th>User Activity</th>
                                  <th>User</th>
                                  <th>Date &amp; Time</th>
                                  
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
                                              url :"phpscript/user_logs/user_log_list.php" 
                                            },
                                    
                                            columnDefs: [ {
                                                targets: [0,1,2], // column or columns numbers
                                                orderable: false,  // set orderable for selected columns
                                            }]
                                });  
          });
      </script>
 <?php }else{ echo UnauthorizedOpenTemp(); } ?>
      </main>
     
<?php require_once('layout/footer.php');?>      
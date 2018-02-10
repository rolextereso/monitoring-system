<?php require_once('layout/header.php');?> 
<?php
    require_once('layout/header.php');    
?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">


<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if(access_role("Rented Items","view_page",$_SESSION['user_type'])){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-list" aria-hidden="true"></i> Rented Items</li>
                     
              </ol>
           </nav>
         
           <div class="table-responsive"> 
                    
                    <input type="hidden" value="<?php echo $project_id;?>" id="id" />                         
                    <table class="table table-hover" id="dataTable" width="100%" cellpadding="0" cellspacing="0">
                      <thead class="thead-dark">
                            <tr> 
                                  <th>Transaction ID</th>
                                  <th>Customer Name</th>
                                  <th>Customer Address</th>
                                  <th>Rented Items</th>
                                  <th>Date Rented</th>                                  
                                  <th>Command</th>
                            </tr>
                      </thead>
                  </table>
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
                                                      "bLengthChange": true,
                                                      "ajax":{
                                                        url :"phpscript/rental/rentalToReturnList.php",
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
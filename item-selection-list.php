<?php require_once('layout/header.php');?> 
<?php
    require_once('layout/header.php');    
?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">


<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-list" aria-hidden="true"></i> Selection List</li>
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
                                  <th>Commands</th>
                            </tr>
                      </thead>
                  </table>
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
                                                      "bLengthChange": true,
                                                      "ajax":{
                                                        url :"phpscript/savePayment/selectionList.php",
                                                      },
                                                      columnDefs: [ {
                                                              targets: [3], // column or columns numbers
                                                              orderable: false,  // set orderable for selected columns
                                                      }]
                                  });  
                 
          });
      </script>
<?php require_once('layout/footer.php');?>      
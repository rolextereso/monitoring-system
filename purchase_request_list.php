<?php require_once('layout/header.php');?> 
<?php
    require_once('layout/header.php');    
?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">


<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
        <?php if(access_role("Rental Item List","view_page",$_SESSION['user_type'])){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-files-o"> </i> Purchase Requests</li>
                     
              </ol>
           </nav>
          <a href='purchase_request.php' class="btn btn-success" style="margin-left: 17px;" ><i class="fa fa-plus" aria-hidden="true"></i> Create new request</a>
           <br/><br/> 
           <div class="table-responsive"> 
                                        
                    <table class="table table-hover" id="dataTable" width="100%" cellpadding="0" cellspacing="0">
                      <thead class="thead-dark">
                            <tr> 
                                  <th>Purchase Request No.</th>
                                  <th>Entity Name</th>
                                  <th>Project</th>
                                  <th>Purpose</th>
                                  <th>Requested by</th>
                                  <th>Created on</th>     
                                  <th>Updated on</th>     
                                  <th>Status</th> 

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
                                                        url :"phpscript/purchase_request/purchase_request_list.php",
                                                      },
                                                      columnDefs: [ {
                                                              targets: [3, 4,5,6,7], // column or columns numbers
                                                              orderable: false,  // set orderable for selected columns
                                                      }]
                                  });  
                 
          });
      </script>

      <?php }else{ echo UnauthorizedOpenTemp(); } ?>

      </main>
      
<?php require_once('layout/footer.php');?>      
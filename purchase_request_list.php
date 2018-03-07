<?php require_once('layout/header.php');?> 
<?php
    require_once('layout/header.php');    
?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
<style>
    .warning, .info, .dark, .success, .danger{
        height: 7px;
        width: 5px;
        cursor: pointer;
    }


</style>

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
        <?php if(access_role("Purchase Requests","view_page",$_SESSION['user_type'])){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-files-o"> </i> Purchase Requests</li>
                     
              </ol>
           </nav>
           <?php if(access_role("Purchase Requests","add_command",$_SESSION['user_type'])){?>
                  <a href='purchase_request.php' class="btn btn-success" style="margin-left: 17px;" ><i class="fa fa-plus" aria-hidden="true"></i> Create New Purchase Request</a>
          <?php } ?>
           <br/><br/>
           <div style="text-align: center;">
           <span class="badge badge-warning warning" title="Waiting for the Fund's Certification">&nbsp;</span><label id="warning"> &nbsp;Waiting for Fund's Certification</label>&nbsp;
           <span class="badge badge-info info" title="Waiting for Campus Dean's Approval">&nbsp;</span><label id="info"> &nbsp;Waiting for Campus Dean's Approval</label>&nbsp;
           <span class="badge badge-dark dark" title="Waiting for PR Number">&nbsp;</span><label id="dark"> &nbsp;Waiting for PR Number</label>&nbsp;
           <span class="badge badge-success success" title="Completed">&nbsp;</span><label id="success"> &nbsp;Completed</label>&nbsp;
           <span class="badge badge-danger danger" title="Disapproved">&nbsp;</span><label id="danger"> &nbsp;Disapproved</label>
           <label style="color: red;font-style: italic;"> Note: This module was based on the actual process of the Purchase Request</label>
         </div>
           <div class="table-responsive"> 
                                        
                    <table class="table table-hover" id="dataTable" width="100%" cellpadding="0" cellspacing="0">
                      <thead class="thead-dark">
                            <tr> 
                                  <th>PR Transaction No.</th>
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
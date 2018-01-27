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

    tr[role='row'] td small {
        display: none;
    }

    tr.group.group-start td {
        background: #e9ecef;
        font-weight: bold;
    }  

    tr.group.group-start td small {
        color:blue;
        font-style: italic;
    }    

</style>

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if(access_role("Gate Pass","view_page",$_SESSION['user_type'])){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-key" aria-hidden="true"></i> Gate Pass</li>
              </ol>
           </nav>

           <div class="table-responsive">                          
                    <table class="table table-hover" id="dataTable" width="100%" cellpadding="0" cellspacing="0">
                      <thead class="thead-dark">
                            <tr> 
                                  <th>OR Number</th>
                                  <th>Customer Name</th>
                                  <th>Customer Address</th>     
                                  <th>Date Saved</th>                                              
                                  <th>Printing Status</th>                                  
                                  <th>Commands</th>
                            </tr>
                      </thead>
                  </table>
          </div>
              
        </div>
      <script src="assets/datatables/jquery.dataTables.js"></script>
      <script src="assets/datatables/dataTables.bootstrap4.js"></script> 

      <script>   
         var dataTable;
          $(document).ready(function(){
               
                  dataTable = $('#dataTable').DataTable( {
                                      "processing": true,
                                      "serverSide": true,
                                      "searching" : true,
                                      "stateSave": true,
                                      "ajax":{
                                        url :"phpscript/gatePass/gatePassList.php", 
                                      },
                                      columnDefs: [ {
                                              targets: [3, 4], // column or columns numbers
                                              orderable: false,  // set orderable for selected columns
                                      }]
                                } );  
          });

          
          var windowClose= function (){
              dataTable.ajax.reload();
          }

      </script>
<?php }else{ echo UnauthorizedOpenTemp(); } ?>
      </main>
      
<?php require_once('layout/footer.php');?>      
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
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-key" aria-hidden="true"></i> Gate Pass</li>
              </ol>
           </nav>

           <div class="table-responsive">                          
                    <table class="table table-hover" id="dataTable" width="100%" cellpadding="0" cellspacing="0">
                      <thead class="thead-dark">
                            <tr> 
                                  <th>Product Name</th>
                                  <th>Project Name</th>
                                  <th>Project Description</th>                                             
                                  <th>Project In-Charge</th>
                                  <th>Status</th>
                                  <th>Price</th>
                                  <th>Commands</th>
                            </tr>
                      </thead>
                  </table>
          </div>
              
        </div>
      </main>
      <script src="assets/datatables/jquery.dataTables.js"></script>
      <script src="assets/datatables/dataTables.bootstrap4.js"></script> 
      <script src="assets/dataTables.rowGroup.min.js"></script> 
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
                                  },
                                      columns: [
                                          { data: 0 },
                                          { data: 1 },
                                          { data: 2 },
                                          { data: 3 },
                                          { data: 4 },
                                          { data: 5 },
                                          { data: 6 },
                                   
                                      ],
                                      order: [[1, 'asc']],
                                      rowGroup: {
                                          dataSrc: 1
                                      },
                                      columnDefs: [ {
                                          targets: [4, 5, 6], // column or columns numbers
                                          orderable: false,  // set orderable for selected columns
                                      }]
                                } );  
          });
      </script>
<?php require_once('layout/footer.php');?>      
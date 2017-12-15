<?php require_once('layout/header.php');?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
 <link href="assets/bootstrap-datepicker3.min.css" rel="stylesheet">
 <style>
      #dateto, #datefrom{
        background: white;
      }
</style>
<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"> <i class="fa fa-file-text" ></i> Reports</li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                    <div class="row">
                        
                           <div class="form-group col-sm-12">
                                  <label> <b>Search by date:</b></label>                                                     
                                         <div class="input-daterange input-group" id="datepicker">
                                            <input type="text" readonly="" data-date-format="yyyy-mm-dd" class="input-sm form-control form-control-sm" name="start" id="datefrom" placeholder="Date From" />
                                            <span class="input-group-addon"> &nbsp;to&nbsp; </span>
                                            <input type="text" readonly="" data-date-format="yyyy-mm-dd" class="input-sm form-control form-control-sm" name="end" id="dateto" placeholder="Date To" />
                                            <span class="input-group-btn">
                                               <button class="btn btn-secondary" type="button" >Search</button>
                                            </span>
                                            <span class="input-group-btn">
                                               <button class="btn btn-secondary" type="button" id="print"><i class="fa fa-print"></i> </button>
                                            </span>
                                        </div>
                          </div>
                       </div>    
              </div>
              <div class="card-body">
                       <div class="table-responsive"> 
                               <table class="table table-striped table-hover table-bordered" id="dataTable" width="100%">
                                  <thead>
                                        <tr>
                                              <th>Employee name</th>
                                              <th>Salary</th>
                                              <th>Age</th>
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
      <script src="assets/bootstrap-datepicker.min.js"></script>
      <script>    

          $(document).ready(function(){
                  $('#dateto, #datefrom').datepicker({
                      autoclose: true,
                   
                  });
                  var dataTable = $('#dataTable').DataTable( {
                                  "processing": true,
                                  "serverSide": true,
                                  "searching" : true,
                                  "ajax":{
                                    url :"grid-data.php", // json datasource
                                    
                                    error: function(){  // error handling
                                      $(".employee-grid-error").html("");
                                      $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                      $("#employee-grid_processing").css("display","none");
                                      
                                    }
                                  }
                                } );
                $('#datefrom').on( 'change', function () {                 
                    var v =$(this).val();  // getting search input value
                    dataTable.columns(1).search(v).draw();
                } );

                $('#dateto').on( 'change', function () {                 
                    var v =$(this).val();  // getting search input value
                    dataTable.columns(2).search(v).draw();
                } );                
          });
      </script>
<?php require_once('layout/footer.php');?>      
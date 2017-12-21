<?php require_once('layout/header.php');?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
 <link href="assets/bootstrap-datepicker3.min.css" rel="stylesheet">
 <style>
      #dateto, #datefrom{
        background: white;
      }

      .table .tfoot-dark td{
        color: #fff;
        background-color: #212529;
        border-color: #32383e;
      }

      .table{
        background: white;
      }

      .card-body h2, .card-body h6{
        margin-bottom: 0px;
        width: 100%;
        text-align: center;
        font-family: Arial;
      }

      .parent{
        background-color: silver;
        overflow: auto !important;
      }

      .shadow {
        -moz-box-shadow:    2px 2px 3px 1px #9a9a9a;
        -webkit-box-shadow: 2px 2px 3px 1px #9a9a9a;
        box-shadow:         2px 2px 3px 1px #9a9a9a;
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
                        
                           <div class="form-group col-sm-4">
                                  <label> <b>Category:</b></label>
                                  <div class="">
                                   <select name="category" class="form-control form-control-sm" style="border-color: #ced4da;" >
                                              <option value="Projects">Projects</option>
                                              <option value="Products" selected="">Products</option>
                                            </select>
                                  </div>
                          </div>
                          <div class="form-group col-sm-8">
                                  <label> <b>Search by date:</b></label>                                                     
                                         <div class="input-daterange input-group" id="datepicker">
                                            <select name="report_type" style="border-color: #ced4da;" >
                                              <option value="year">Year</option>
                                              <option value="month" selected="">Month</option>
                                            </select>
                                            <input type="text" readonly="" data-date-format="yyyy-mm-dd" class=" form-control form-control-sm" name="start" id="datefrom" placeholder="Date From" />
                                              <span>&nbsp;</span>
                                            <input type="text" readonly="" data-date-format="yyyy-mm-dd" class=" form-control form-control-sm" name="end" id="dateto" placeholder="Date To" />
                                            <span class="input-group-btn">
                                               <button class="btn btn-secondary" type="button" onclick="searchReport();">Search</button>
                                            </span>
                                            <span class="input-group-btn">
                                               <button class="btn btn-secondary" type="button" id="print"><i class="fa fa-print"></i> </button>
                                            </span>
                                            &nbsp;
                                            <div class="buttons">
                                              <button class="zoom-in btn btn-secondary" title="Zoom In"><i class="fa fa-search-plus"></i></button>
                                              <button class="zoom-out btn btn-secondary" title="Zoom out"><i class="fa fa-search-minus"></i></button>
                                             <!--  <input type="range" class="zoom-range"> -->
                                              <button class="reset btn btn-secondary" title="Reset"><i class="fa fa-undo" aria-hidden="true"></i></button>
                                            </div>
                                        </div>

                          </div>
                       </div>    
              </div>
              <div class="parent" style="height: 457px;">
                  <div class="card-body shadow" style="background:white;">                    
                         
                                   
                       
                  </div>
             </div>
        </div>
        </div>
      </main>

      <script src="assets/jquery.panzoom.min.js"></script>
      <script src="assets/bootstrap-datepicker.min.js"></script>
      <script>    

          $(document).ready(function(){
                  $('#dateto, #datefrom').datepicker({
                      autoclose: true,
                      clearBtn: true
                  });

                  $('.card-body').panzoom({
                      $zoomIn: $(".zoom-in"),
                      $zoomOut: $(".zoom-out"),
                      // $zoomRange: $(".zoom-range"),                     
                      $reset: $(".reset"),
                      startTransform: 'scale(0.9)'
                    })

                   report();   
             
                // $('#datefrom').on( 'change', function () {                 
                //     var v =$(this).val();  // getting search input value
                //     dataTable.columns(1).search(v).draw();
                // } );

                // $('#dateto').on( 'change', function () {                 
                //     var v =$(this).val();  // getting search input value
                //     dataTable.columns(2).search(v).draw();
                // } );                
          });

          function searchReport(){

            if($("#datefrom").val()=="" || $("#datefrom").val()==""){
                 $('.alert').removeClass('alert-success, alert-danger')
                             .addClass('alert-danger')
                             .html("<b>Date From</b> and <b>Date To</b> must be filled")
                             .fadeIn(100,function(){
                                 $(this).fadeOut(5000);
                             });

            }else if(validateDate()){
                 $('.alert').removeClass('alert-success, alert-danger')
                             .addClass('alert-danger')
                             .html("<b>Date From</b> must be greater than <b>Date To</b>")
                             .fadeIn(100,function(){
                                 $(this).fadeOut(5000);
                             });
            }else{
                report();   
            }
          }

          function report(){
                 $.ajax({
                    type: "POST",
                    url: "phpscript/report/getReportData.php",
                    dataType   : 'json',
                    data: {category:$("[name='category']").val(), report_type: $("[name='report_type']").val(), datefrom:$("#datefrom").val(), dateto: $("#dateto").val()},
                    success: function (data)
                    {
                          if(data.fetch){
                                    var table ="<br/><h2 style='margin-bottom:0px;'>COLLECTION REPORT</h2>";
                                    table    +="<h6 style='margin-bottom:0px;'>"+data.range+"</h6><br/><br/>";
                                    table    += " <table class='table table-striped table-hover table-sm' width='100%' id='dataTable'> ";
                                    table    += " <thead class='thead-dark'> ";    
                                    table    += " <th>Products</th>";                                       
                                            $.each(data.date, function(key, value){                                                     
                                                      table+="<th>"+value+"</th>";                                
                                            });
                                    table    += " </th> ";
                                    table    += " </thead> ";
                                    table    += " <tfoot class='tfoot-dark' > ";    
                                              table+="<tr>";
                                              table+="  <td> Total </td>";   
                                            $.each(data.total, function(key, value){
                                                                                                       
                                                      table+="  <td>"+value+"</td>";
                                            });
                                              table+="</tr>";                                          
                                    table    += " </tfoot> ";
                                    table    += " <tbody> ";
                                            $.each(data.data, function(key, value){                                                     
                                                      table+="<tr>";  
                                                      table+="  <td>"+key+"</td>";
                                                      $.each(value, function(key, value){                                                     
                                                             table+="  <td>"+value+"</td>";                                                                        
                                                       });
                                                      table+="</tr>";                                
                                            });     
                                                              
                                    table    += " </tbody> ";                                    
                                    table    += " </table> ";
                                    $(".card-body").html(table);
                          }
                    }
                });
          }

          function validateDate(){
                var $from=$("#datefrom").datepicker('getDate');
                var $to =$("#dateto").datepicker('getDate');

                var error=false;
                if($from > $to){
                    error=true;
                }
               
                return error;
            }
      </script>
<?php require_once('layout/footer.php');?>      
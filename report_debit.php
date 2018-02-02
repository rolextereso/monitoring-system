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
<?php if(access_role("Reports","view_page",$_SESSION['user_type'])){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"> <i class="fa fa-file-text" ></i> Reports</li>
              </ol>
           </nav>
          <ul class="nav nav-tabs">
                          <li class="nav-item">
                               <a class="nav-link" href="report.php">Collection Report</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link active" href="report_debit.php">Expenses Breakdown Report</a>
                          </li>
                         
          </ul>
          <br/>
        
         <div class="card">
              <div class="card-header">
                    <div class="row">
                        
                           <div class="form-group col-sm-2">
                                  <label> <b>Category:</b></label>
                                  <div class="">
                                      <select name="category" class="form-control form-control-sm" style="border-color: #ced4da;" >
                                              <option value="">Select Category</option>
                                              <option value="EXPENSES">Expenses</option>
                                              
                                              
                                      </select>                                    
                                  </div>
                          </div>

                          <div class="form-group col-sm-2">
                                  <label> <b>Search by:</b></label>
                                  <div class="">
                                       <select name="search_by" class="form-control form-control-sm" style="border-color: #ced4da;" >
                                              <option value="">All</option>
                                              
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
                                               <button class="btn btn-secondary" disabled="disabled" onclick="printReport();" type="button" id="print"><i class="fa fa-print"></i> </button>
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
         <script src="assets/jquery.panzoom.min.js"></script>
      <script src="assets/bootstrap-datepicker.min.js"></script>
      <script>    

          $(document).ready(function(){
                  $('#dateto, #datefrom').datepicker({
                      autoclose: true,
                      clearBtn: true
                  });

                  $('.card-body').hide();

                  $('.card-body').panzoom({
                      $zoomIn: $(".zoom-in"),
                      $zoomOut: $(".zoom-out"),
                      // $zoomRange: $(".zoom-range"),                     
                      $reset: $(".reset"),
                      startTransform: 'scale(0.9)'
                    });

                  $("select, input").change(function(){
                      $("#print").attr("disabled","disabled");
                  });

                  $('[name="category"]').change(function(){
                        search_by($(this))
                  });

                            
          });

          function printReport(){
              WindowPopUp('phpscript/report/printExpensesReport.php?datefrom='+$("#datefrom").val()+'&dateto='+$("#dateto").val()+"&search_by="+$("[name='search_by']").val()+'&category='+$("[name='category']").val()+'&report_type='+$("[name='report_type']").val(),'print','900','650');
          }

          function searchReport(){


            if($("[name='category']").val()==""){
                   $('.alert').removeClass('alert-success, alert-danger')
                             .addClass('alert-danger')
                             .html("<b>Please select category</b> of the report")
                             .fadeIn(100,function(){
                                 $(this).fadeOut(5000);
                             });
            }else if($("#datefrom").val()=="" || $("#datefrom").val()==""){
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
                $('.card-body').html("<img src='assets/img/spinner.gif'/> Please wait while system gathering records...").show();
                
                report();   
            }
          }

         
          function report(){
                 $.ajax({
                    type: "POST",
                    url: "phpscript/report/getExpensesReportData.php",
                    dataType   : 'json',
                    data: {search_by:$("[name='search_by']").val(),category:$("[name='category']").val(), report_type: $("[name='report_type']").val(), datefrom:$("#datefrom").val(), dateto: $("#dateto").val()},
                    success: function (data)
                    {
                          $("#print").removeAttr("disabled");
                  
                          if(data.data.length>0){
                                    var header ="<br/><h2 style='margin-bottom:0px;'>"+data.title+"</h2>";
                                    header    +="<h6 style='margin-bottom:0px;'>"+data.range+"</h6><br/><br/>";

                                   var  table = " <table class='table table-striped table-hover table-sm' width='100%' id='dataTable'> ";
                                        table    += " <thead class='thead-dark'> ";    
                                        table       += " <th>Item Description</th><th>Quantity</th><th>Amount Per Unit</th><th>Unit Cost</th>";
                                        table    += " </thead> ";
                                        table    += " <tfoot class='tfoot-dark' > ";    
                                                  table+="<tr>";
                                                  table+="  <td colspan='3'> Total </td><td>"+data.total+"</td>";                                           
                                                  table+="</tr>";                                          
                                        table    += " </tfoot> ";
                                        table    += " <tbody> ";    
                                                var date_approved="";                                       
                                                $.each(data.data, function(key, value){ 
                                                   
                                                    if(date_approved!=value[4]){
                                                        table+="<tr>";
                                                              table+="  <td class='green' colspan='4'><b>"+value[4]+"</b></td>";                                                                      
                                                        table+="</tr>";
                                                        table+="<tr>";
                                                              table+="  <td>"+value[0]+"</td>";
                                                              table+="  <td>"+value[1]+"</td>";
                                                              table+="  <td>"+value[2]+"</td>";
                                                              table+="  <td>"+value[3] +"</td>";             
                                                        table+="</tr>";
                                                         date_approved=value[4];  
                                                    }else if(date_approved==value[4]){
                                                        table+="<tr>";
                                                              table+="  <td>"+value[0]+"</td>";
                                                              table+="  <td>"+value[1]+"</td>";
                                                              table+="  <td>"+value[2]+"</td>";
                                                              table+="  <td>"+value[3]+"</td>";             
                                                        table+="</tr>";
                                                    } 
                                                     console.log(date_approved);
                                                   
                                                                                  
                                                });                        
                                        table    += " </tbody> ";                                    
                                        table    += " </table> ";
                                    $(".card-body").html(header+" "+table);
                          }else{
                              $(".card-body").html("<span class='green'><b>No Record was found</b></span>");
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

          function search_by($el){                          
                 $.ajax({
                    type: "POST",
                    url: "phpscript/report/getSearchby.php",
                    dataType   : 'json',
                    data: {search_by:$($el).val()},
                    success: function (data)
                    {     var $option="";
                          $('.option').remove();
                          $.each(data, function(key, value){                                                     
                               $option+="<option class='option' value='"+value[0]+"'>"+value[1]+"</option>";                                                    
                          });  
                          $("[name='search_by']").append($option);
                    }
                });
          }
      </script>
<?php }else{ echo UnauthorizedOpenTemp(); } ?>
      </main>

     
<?php require_once('layout/footer.php');?>      
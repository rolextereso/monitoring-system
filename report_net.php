<?php 

  require_once('layout/header.php');
  require_once('classes/Crud.php');
  $crud = new Crud();    
  
  $user_id=specific_user(access_role("Reports","view_command",$_SESSION['user_type']));
  $projects = $crud->getData("SELECT p.*,pd.project_duration_id FROM projects p                          
                              LEFT JOIN project_duration pd ON pd.project_id=p.project_id
                              WHERE pd.status='Y' AND (p.project_incharge $user_id )
                              ");

?>   
 
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
                              <a class="nav-link" href="report_debit.php">Expenses Breakdown Report</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link active" href="report_net.php">Net Profit</a>
                          </li>
                         
          </ul>
          <br/>
        
         <div class="card">
              <div class="card-header">
                    <div class="row">
                        
                          
                          <div class="form-group col-sm-4">
                                  <label> <b>Search by:</b></label>
                                  <div class="">
                                       <select name="search_by" class="form-control form-control-sm" style="border-color: #ced4da;" >
                                             <option value="">Select project</option>
                                                          <?php foreach ($projects as $proj){?>
                                                            <option value="<?php echo $proj['project_id'];?>"><?php echo $proj['project_name'];?>
                                                            </option>
                                                          <?php } ?>
                                              
                                        </select>                                     
                                  </div>
                          </div>

                          <div class="form-group col-sm-8">
                                  <label> <b>&nbsp;</b></label>                                                     
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

                            
          });

          function printReport(){
              WindowPopUp('phpscript/report/printNetReport.php?datefrom='+$("#datefrom").val()+'&dateto='+$("#dateto").val()+"&search_by="+$("[name='search_by']").val()+'&category=PRODUCTS&report_type='+$("[name='report_type']").val()+'&proj_name='+$("[name='search_by'] option:selected").html(),'print','900','650');
          }

          function searchReport(){

             if($("[name='search_by']").val()==""){
                 $('.alert').removeClass('alert-success, alert-danger')
                             .addClass('alert-danger')
                             .html("Please select a project")
                             .fadeIn(100,function(){
                                 $(this).fadeOut(5000);
                             });
             }else if($("#datefrom").val()=="" || $("#datefrom").val()=="" || $("[name='search_by']").val()==""){
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
                    url: "phpscript/report/getNetReportData.php",
                    dataType   : 'json',
                    data: {search_by:$("[name='search_by']").val(),category:'PRODUCTS', report_type: $("[name='report_type']").val(), datefrom:$("#datefrom").val(), dateto: $("#dateto").val()},
                    success: function (data)
                    {
                          $("#print").removeAttr("disabled");
                        
                          var expenses_total=0;
                          var total_sales=0;
                        
                                    var header ="<br/><h2 style='margin-bottom:0px;'>"+data.title+"</h2>";
                                    header    +="<h6 style='margin-bottom:0px;'>"+data.range+"</h6><br/><br/><br/>";

                                   var table    =" <div class='row'>"
                                       table    += " <div class='col-md-12'>"; 
                                       table    += " <label>Project Name: </label><span><b>"+$("[name='search_by'] option:selected").html()+"</b></span>"; 

                                       table    += "<table class='table table-striped table-hover table-sm' width='100%' id='dataTable'> ";
                                    table    += " <thead class='thead-dark'> ";    
                                    table    += " <th>"+data.search+"</th>";                                       
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
                                 
                                    if(data.total.length>0){
                                            $.each(data.data, function(key, value){                                                     
                                                      table+="<tr>";  
                                                      table+="  <td>"+key+"</td>";
                                                      $.each(value, function(key, value){      

                                                             table+="  <td>"+value+"</td>";
                                                             total_sales+=parseFloat(value.replace(/,/g,''));                                 
                                                       });
                                                      table+="</tr>";                                
                                            });   
                                    }else{
                                             table+="<tr>";  
                                             table+="  <td> No sale on this date</td>";                                                     
                                            table+="</tr>";
                                    }  
                                                              
                                    table    += " </tbody> ";                                    
                                    table    += " </table> </div></div>";

                                    var table2    =" <div class='row'>"
                                        table2    += " <div class='col-md-6'> <table class='table table-striped table-hover table-sm' width='100%' id='dataTable'> ";
                                        table2    += " <thead class='thead-dark'> ";    
                                        table2    += " <th> Expenses </th> <th>Amount</th>";
                                        table2    += " </thead> ";
                                        
                                        table2    += " <tbody> ";
                                                $.each(data.expenses, function(key, value){        
                                                          expenses_total+=parseFloat(value[1]);                                             
                                                          table2+="<tr>";  
                                                          table2+="  <td>"+value[0]+"</td>";
                                                          table2+="  <td>"+value[1]+"</td>";                                                         
                                                          table2+="</tr>";                                
                                                });     
                                                                  
                                        table2    += " </tbody> ";                                    
                                        table2    += " </table> </div>";

                                        table2    += " <div class='col-md-6'> <table class='table table-striped table-hover table-sm' width='100%' id='dataTable'> ";
                                        table2    += " <thead class='thead-dark'> ";    
                                        table2    += " <th> Description </th> <th>Amount</th>";
                                        table2    += " </thead> ";
                                        
                                        table2    += " <tbody> ";
                                                table2+="<tr>";  
                                                          table2+="  <td> Total Sales </td>";
                                                          table2+="  <td>"+total_sales+"</td>";
                                                table2+="</tr>";  
                                                table2+="<tr>";  
                                                          table2+="  <td> Total Expenses </td>";
                                                          table2+="  <td>"+expenses_total+"</td>";
                                                table2+="</tr>";
                                                var net=(parseFloat(total_sales)-parseFloat(expenses_total));
                                                var color=(net<0)?"red":"#9bdca9";
                                                table2+="<tr>";  
                                                          table2+="  <td> Net Profit</td>";
                                                          table2+="  <td style='font-size:23px;color:"+color+";'> &#8369; "+net+"</td>";
                                                table2+="</tr>";
                                        table2    += " </tbody> ";                                    
                                        table2    += " </table> </div>";

                                        table2    += " </div>";

                                    $(".card-body").html(header+" "+table+" "+table2);
                         
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
<?php }else{ echo UnauthorizedOpenTemp(); } ?>
      </main>

     
<?php require_once('layout/footer.php');?>      
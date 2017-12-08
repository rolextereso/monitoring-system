<?php require_once('layout/header.php');?>   
 

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
                    <li class="breadcrumb-item active" aria-current="page">Chart List</li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                 <label> <b>Search by date:</b></label>                                                     
                               <div class="input-daterange input-group" id="datepicker">
                                  <input type="text" readonly="" data-date-format="yyyy-mm-dd" class="input-sm form-control form-control-sm" name="start" id="datefrom" />
                                  <span class="input-group-addon"> &nbsp;to&nbsp; </span>
                                  <input type="text" readonly="" data-date-format="yyyy-mm-dd" class="input-sm form-control form-control-sm" name="end" id="dateto" />
                                  <span class="input-group-btn">
                                     <button class="btn btn-secondary" type="button">Search</button>
                                  </span>
                                   <span class="input-group-btn">
                                     <button class="btn btn-secondary" type="button" id="print"><i class="fa fa-print"></i> </button>
                                  </span>
                              </div>
                             
              </div>
              <div class="card-body">
                        <div id="chartContainer" style="height: 400px; width: 100%;"></div> 
              </div>
        </div>
        </div>
      </main>

      
      <script src="assets/bootstrap-datepicker.min.js"></script>
      <script>    

          $(document).ready(function(){
                $('#dateto, #datefrom').datepicker({
                      autoclose: true,
                   
                });
                chartRender('Earthquake ');

                $('#print').on('click',function(){
                    chartRender('ss');
                });
               
                 
                              
          });

          function chartRender(text){
                 var chart = new CanvasJS.Chart("chartContainer",
                {

                  title:{
                  text: text
                  },
                   data: [
                  {
                    type: "line",

                    dataPoints: [
                    { x: new Date(2012, 00, 1), y: 450 },
                    { x: new Date(2012, 01, 1), y: 414 },
                    { x: new Date(2012, 02, 1), y: 520 },
                    { x: new Date(2012, 03, 1), y: 460 },
                    { x: new Date(2012, 04, 1), y: 450 },
                    { x: new Date(2012, 05, 1), y: 500 },
                    { x: new Date(2012, 06, 1), y: 480 },
                    { x: new Date(2012, 07, 1), y: 480 },
                    { x: new Date(2012, 08, 1), y: 410 },
                    { x: new Date(2012, 09, 1), y: 500 },
                    { x: new Date(2012, 10, 1), y: 480 },
                    { x: new Date(2012, 11, 1), y: 510 }
                    ]
                  }
                  ]
                });

                chart.render();
              
          }
      </script>
      <script type="text/javascript" src="assets/canvasjs.min.js"></script>
     
<?php require_once('layout/footer.php');?>      
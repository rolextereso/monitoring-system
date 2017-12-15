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
                    <div class="card-header ">
                        <b>Gross Profit Percentage of Every Project</b>                                  
                    </div>
                    <div class="card-body">
                        <div id="piechartContainer" style="height: 350px; width: 100%;"></div> 
                    </div>
              </div>
              <br/>
               <div class="card">
                    <div class="card-header ">
                      <div class="row">
                            <div class="form-group col-sm-4">
                                  <label for="exampleInputEmail1"><b>By Product</b></label>
                                  <select required class="form-control form-control-sm" id="access_role" name="access_role">
                                        <option value="">Select type of role</option>
                                        <option value="1">Project In-Charge</option>
                                        <option value="2">Campus Dean</option>
                                        <option value="3">Accounting</option>
                                  </select>
                           </div>
                           <div class="form-group col-sm-7">
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
                       </div>                                   
                    </div>
                    <div class="card-body">
                              <div id="chartContainer" style="height: 400px; width: 100%;"></div> 
                    </div>
              </div>
              <div>
        </div>
      </main>

      
      <script src="assets/bootstrap-datepicker.min.js"></script>
      <script>    
   
            var datapoint = [];
            var _data = [];
            $(document).ready(function(){
               
                pieChart();
                lineGraphByProduct();               
                    

                $('#datefrom, #dateto').datepicker({
                    autoclose: true,    
                    todayHighlight: true,       
                });
            });         
            function toogleDataSeries(e){
                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                      e.dataSeries.visible = false;
                    } else{
                      e.dataSeries.visible = true;
                    }
                    chart.render();
            }

            function lineGraphByProduct(){
                $.getJSON("phpscript/dashboardGraph/linegraphData.php", function(data) {
                           
                            $.each(data, function(key,value){
                               var object={
                                    type:"line",
                                    name:"",
                                    showInLegend: true,
                                    xValueFormatString: "DD MMM, YYYY",
                                    dataPoints:[]
                                } 

                                object.title=value.title;
                                object.name=value.name;
                                $.each(value.data, function(key, value){                  
                                      object.dataPoints.push({x:  new Date(value[0]), y: parseInt(value[1])});
                                       
                                });
                                
                                _data.push(object);   
                            });

                           //console.log(_data);
                            var chart = new CanvasJS.Chart("chartContainer", {
                                animationEnabled: true,
                                exportEnabled: true,
                                theme: "light2",
                                title:{
                                  text: "Site Traffic"
                                },
                                axisX:{
                                  valueFormatString: "MMM YY",
                                  crosshair: {
                                    enabled: true,
                                    snapToDataPoint: true
                                  }
                                },
                                axisY: {
                                  title: "Number of Visits",
                                  crosshair: {
                                    enabled: true
                                  }
                                },
                                toolTip:{
                                  shared:true
                                },  
                                legend:{
                                  cursor:"pointer",
                                  verticalAlign: "bottom",
                                  horizontalAlign: "left",
                                  dockInsidePlotArea: true,
                                  itemclick: toogleDataSeries
                                },
                                data: _data,
                            });

                            chart.render();
                  });
            }

            function pieChart(){

              var chart = new CanvasJS.Chart("piechartContainer", {
                            exportEnabled: true,
                            animationEnabled: true,
                            title:{
                              text: "State Operating Funds"
                            },
                            legend:{
                              cursor: "pointer",
                              itemclick: explodePie
                            },
                            data: [{
                              type: "pie",
                              showInLegend: true,
                              toolTipContent: "{name}: <strong>{y}%</strong>",
                              indexLabel: "{name} - {y}%",
                              dataPoints: [
                                { y: 26, name: "School Aid", exploded: true },
                                { y: 20, name: "Medical Aid" },
                                { y: 5, name: "Debt/Capital" },
                                { y: 3, name: "Elected Officials" },
                                { y: 7, name: "University" },
                                { y: 17, name: "Executive" },
                                { y: 22, name: "Other Local Assistance"}
                              ]
                            }]
                          });
                      
                      chart.render();            
            }

            function explodePie (e) {
                  if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
                    e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
                  } else {
                    e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
                  }
                  e.chart.render();
            }
  
                  
</script>
      </script>
      <script type="text/javascript" src="assets/canvasjs.min.js"></script>
     
<?php require_once('layout/footer.php');?>      
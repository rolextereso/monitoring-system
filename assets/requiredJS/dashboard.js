$(document).ready(function(){
               
                pieChart();
                lineGraph("","","");               
                    

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
                var product=$("#product").val();
                var datefrom=$("#datefrom").val();
                var dateto=$("#dateto").val();

                if(validateFromToDates()  || (datefrom=="" && dateto=="")){
                       $('.alert').removeClass('alert-success, alert-danger')
                                                               .addClass('alert-danger')
                                                               .html("<b>Please make sure the following:</b> 1. <b>Date To</b> must be greater than <b>Date From</b>  2. <b>Project Name</b> should not empty ")
                                                               .fadeIn(100,function(){
                                                                   $(this).fadeOut(5000);
                                                               });
                }else{
                    lineGraph(product, datefrom, dateto);
                }
            }

            function lineGraph(product, datefrom, dateto){
              var datapoint = [];
              var _data = [];

              var title=(product=="")?"All Products": product;

              $.getJSON("phpscript/dashboardGraph/linegraphData.php?p="+product+"&df="+datefrom+"&dt="+dateto, function(data) {
                               
                                $.each(data, function(key,value){
                                    object={
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

                                var chart = new CanvasJS.Chart("chartContainer", {
                                    animationEnabled: true,
                                    exportEnabled: true,
                                    theme: "light2",
                                    title:{
                                      text: title+" Revenue"
                                    },
                                    axisX:{
                                      valueFormatString: "MMM YY",
                                      crosshair: {
                                        enabled: true,
                                        snapToDataPoint: true
                                      }
                                    },
                                    axisY: {
                                      title: "Total Amount",
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
              var _data = [];

              $.getJSON("phpscript/dashboardGraph/piechartData.php", function(data) {
                    $.each(data, function(key,value){
                                    object={
                                        type:"pie",
                                        showInLegend: true,
                                        toolTipContent: "<span style='\"'color: {color};'\"'>{name}</span>: &#8369; {y} (#percent%)",
                                  
                                        dataPoints:[]
                                    }  

                                    $.each(value.data, function(key, value){                                                     
                                          object.dataPoints.push({y: parseFloat(value[2]),indexLabel: value[0]+" ("+value[1]+"%)", name: value[0]});                                    
                                    });
                                    
                                    _data.push(object);   

                                });
                  

                    var chart = new CanvasJS.Chart("piechartContainer", {
                                  exportEnabled: true,
                                  animationEnabled: true,
                                  title:{
                                    text: "Project Wise Revenue For "+$("#current_year").text()
                                  },
                                  legend:{
                                    cursor: "pointer",
                                    itemclick: explodePie
                                  },
                                  data: _data
                                });
                            
                            chart.render();  
                            setTimeout(function(){pieChart()}, 60000);
              });          
            }

            function explodePie (e) {
                  if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
                    e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
                  } else {
                    e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
                  }
                  e.chart.render();
            }

            function validateFromToDates(){
                var $from=$("#datefrom").datepicker('getDate');
                var $to =$("#dateto").datepicker('getDate');

                var error=false;
                if($from > $to){
                    error=true;
                }              

                return error;
            }
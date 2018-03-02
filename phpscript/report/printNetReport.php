<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Expenses Report</title>
</head>
<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
 <link href="../../assets/bootstrap.css" rel="stylesheet">
<style>
	body{		
		padding: 0;
		font-family: 'Slabo 27px', serif;
		font-size: 14px;
	}
	.container{
		margin: 0 auto;
		width: 80%;		
	}

	#body{
		text-align: center;
	}

	table {
	    border-collapse: collapse;
	    margin: 0 auto;
	    border-color: silver;
	    width: 80%;
	}

	#customer_info, #footer, #header{
		 margin: 0 auto;
		 width: 80%;
		
	}

	h4,p{
		padding: 0;
		margin:0;
	}

	.clearfix{
		content:"";
		clear:both;
		display: table;
	}

	.card-body h2, .card-body h6{
        margin-bottom: 0px;
        width: 100%;
        text-align: center;
        font-family: Arial;
    }

    table th{
	  font-weight: normal;
	}
</style>
<?php    
     

    include_once("../../classes/Crud.php");
	include_once("netReportData.php");

	$header=header_info();

	$out=netReport($_GET['datefrom'], $_GET['dateto'], $_GET['category'], $_GET['report_type'],$_GET["search_by"]);

?>  
<body>
		<div class="container">
			<br/>
			<br/>
			<div id="content" >
				<div id="header">
					<img src="<?php echo "../../".$header['logo'];?>" width="50" height="50" style="float:left;margin-right:6px;">
					<div style="float:left;line-height: 19px;" >
						<h4><?php echo $header['company_name'];?></h4>
						<p> <?php echo $header['company_address'];?></p>
						<p> <?php echo $header['contact_no'];?></p>
					</div>
				</div>
				<div class="clearfix"></div>
				<br/>
				<div class="card-body">
					<br/><h2 style='margin-bottom:0px;'><?php echo "PROJECTS NET PROFIT REPORT";?></h2>
                                    
                                    <h6 style='margin-bottom:0px;'><?php echo $out['range'];?></h6>
                                    <br/><br/>

                                    <div class="row">
                                    	<div class="col-md-12">
			                                    <label>Project Name:</label> <span><b><?php echo $_GET["proj_name"];?></b></span>
			                                    <table class='table table-striped table-hover table-sm' width='100%' id='dataTable'>
			                                    <thead class='thead-dark'>    
			                                    <th><?php echo $out['category'];?></th>                                     
			                                            
			                                            <?php 
			                                            if(count($out['date'])>0){
			                                            	foreach($out['date'] as $date){                                               
			                                                      echo "<th>$date</th>";
			                                                }
			                                            }else{
			                                            	echo "<th>&nbsp;</th>";
			                                            }                                
			                                            ?>
			                                    </th>
			                                   </thead>
			                                    <tfoot class='tfoot-dark' >  
			                                              <tr  style="background-color: lightgray;">
			                                              <td> Total </td> 
			                                              
			                                             <?php 
			                                             $total_sales=0;
			                                             foreach($out['total'] as $total){      
			                                             	                                              
			                                                      echo "<td>$total</td>"; 
			                                                      $total_sales+=str_replace(",","",$total);
			                                             }                               
			                                             ?>
			                                             </tr>                                        
			                                    </tfoot> 
			                                    <tbody> 
			                                           
			                                            <?php 
			                                            	if(count($out['total'])>0){
			                                            	   foreach($out['data'] as $key=>$value){                                              
			                                                      echo "<tr>";    
			                                                      echo "  <td>$key</td>";
			                                                      foreach($value as $i_key=>$i_value){
			                                                      		echo "  <td>$i_value</td>";
			                                                      }   
			                                                     echo "</tr>"; 
			                                                  }
			                                                }else{
			                                                	echo "<tr>";    
			                                                    echo "  <td colspan='2'> No sale on this date</td>";
			                                                    echo "</tr>"; 
			                                                }                         
			                                             ?>   
			                                                              
			                                    </tbody>                                    
			                                    </table>
	                                  </div>
	                              </div>
	                              <div class="row">
                                    	<div class="col-md-6">
			                                   
		                                    <table class='table table-striped table-hover table-sm' width='100%' id='dataTable'>
		                                    <thead class='thead-dark'>    
		                                    	<th>Expenses</th>
		                                    	<th>Amount</th>
		                                    </thead>
		                                    <tbody> 		                                           
		                                            <?php 
		                                            $total_expenses=0;
		                                            foreach($out['expenses'] as $key=>$value){      
		                                             		$total_expenses+=$value[1];                                      
		                                                      echo "<tr>";    
		                                                      echo "  <td>{$value[0]}</td>";
		                                                      echo "  <td>{$value[1]}</td>";
		                                                      echo "</tr>"; 
		                                                  }                         
		                                             ?>               
		                                    </tbody>                                    
		                                    </table>
	                                  </div>
	                                  <div class="col-md-6">
			                                   
		                                    <table class='table table-striped table-hover table-sm' width='100%' id='dataTable'>
		                                    <thead class='thead-dark'>    
		                                    	<th>Description</th>
		                                    	<th>Amount</th>
		                                    </thead>
		                                    <tbody> 		                                           
		                                       	<tr>
		                                       		<td>Total Sales</td>
		                                       		<td><?php echo number_format($total_sales,2);?> </td>

		                                       	</tr>  
		                                       	<tr>
		                                       		<td>Total Expenses</td>
		                                       		<td><?php echo number_format($total_expenses,2); ?> </td>
		                                       		
		                                       	</tr>  
		                                       	<tr>
		                                       		<td>Net Profit</td>
		                                       		<?php 
		                                       			$net=$total_sales-$total_expenses;
		                                       			$color=($net<0)?"red":"#9bdca9";
		                                       		?>
		                                       		<td style='font-size:23px;color:<?php echo $color;?>'> &#8369; <?php echo number_format(($total_sales-$total_expenses),2); ?> </td>
		                                       		
		                                       	</tr>                
		                                    </tbody>                                    
		                                    </table>
	                                  </div>
	                              </div>
                                    
				</div>
				<br/>
				<br/>
				<div id="footer">
					<label>Printed by: </label><span><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname'];?></span><br/>
					<label>Date &amp; Time Printed:</label><span><?php echo date('F d, Y h:i:s a');?> </span><br/>
				</div>
		</div>

</body>
</html>
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

    require_once('../../classes/function.php');
    require_once('expensesReportData.php');

  
    $header=header_info();   

    $out=(expensesDebit($_GET['datefrom'], $_GET['dateto'], $_GET['category'], $_GET['report_type'],$_GET["search_by"]));

	
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
					<br/><h2 style='margin-bottom:0px;'><?php echo $_GET['category']." BREAKDOWN REPORT";?></h2>
                                    <h6 style='margin-bottom:0px;'><?php echo $out['range'];?></h6>
                                    <br/><br/>
                                    <label>Project Name:</label> <span><b><?php echo $_GET["proj_name"];?></b></span>
                                    <table class='table table-striped table-hover table-sm' width='100%' id='dataTable'>
                                    <thead class='thead-dark'>    
                                   		 <th>Item Description</th>
                                   		 <th>Quantity</th>
                                   		 <th>Amount Per Unit</th>
                                   		 <th>Unit Cost</th>
                                   	</thead>
                                    <tfoot class='tfoot-dark' >  
                                        <tr style="background-color: lightgray;">
                                              <td colspan="3"> Total </td> 
                                              <td> <?php echo $out["total"];?> </td>  
                                        </tr>                                        
                                    </tfoot> 
                                    <tbody> 
                                           <tr>
                                            <?php 
                                            	  $date_approved="";
                                            	  foreach($out['data'] as $key=>$value){     
                                            	  		if($date_approved!=$value[4]){
                                            	  			echo "<tr><td class='green' colspan='4'><b>".$value[4]."</b></td></tr>";
                                            	  			echo "<tr>";
                                            	  			echo "  <td>".$value[0]."</td>";
                                            	  			echo "  <td>".$value[1]."</td>";
                                            	  			echo "  <td>".$value[2]."</td>";
                                            	  			echo "  <td>".$value[3]."</td>";
                                            	  			echo "</tr>";
                                            	  			$date_approved=$value[4];
                                            	  		}else if($date_approved==$value[4]){
															echo "<tr>";
                                            	  			echo "  <td>".$value[0]."</td>";
                                            	  			echo "  <td>".$value[1]."</td>";
                                            	  			echo "  <td>".$value[2]."</td>";
                                            	  			echo "  <td>".$value[3]."</td>";
                                            	  			echo "</tr>";
														}
                                                  }                         
                                             ?>  
                                             </tr> 
                                                              
                                    </tbody>                                    
                                    </table>
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
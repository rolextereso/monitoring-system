<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Collection Report</title>
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
    require_once('collectionReportData.php');

  
    $header=header_info();   

    $out=(collectionReportData($_GET['datefrom'], $_GET['dateto'], $_GET['category'], $_GET['report_type'],$_GET["search_by"]));

	
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
						<p> <?php echo $header['compContact'];?></p>
					</div>
				</div>
				<div class="clearfix"></div>
				<br/>
				<div class="card-body">
					<br/><h2 style='margin-bottom:0px;'><?php echo $out['category']." COLLECTION REPORT";?></h2>
                                    <h6 style='margin-bottom:0px;'><?php echo "for the ".$out['report_type']." of <u>".$out['from_date']."</u> to <u>".$out['to_date']."</u>"?></h6>
                                    <br/><br/>
                                    <table class='table table-striped table-hover table-sm' width='100%' id='dataTable'>
                                    <thead class='thead-dark'>    
                                    <th><?php echo $out['category'];?></th>                                     
                                           
                                            <?php foreach($out['date'] as $date)                                               
                                                      echo "<th>$date</th>";                                
                                            ?>
                                    </th>
                                   </thead>
                                    <tfoot class='tfoot-dark' >  
                                              <tr  style="background-color: lightgray;">
                                              <td> Total </td> 
                                           
                                             <?php foreach($out['total'] as $total)                                               
                                                      echo "<td>$total</td>";                                
                                             ?>
                                             </tr>                                        
                                    </tfoot> 
                                    <tbody> 
                                           
                                            <?php foreach($out['data'] as $key=>$value){                                              
                                                      echo "<tr>";    
                                                      echo "  <td>$key</td>";
                                                      foreach($value as $i_key=>$i_value){
                                                      		echo "  <td>$i_value</td>";
                                                      }   
                                                     echo "</tr>"; 
                                                  }                         
                                             ?>   
                                                              
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
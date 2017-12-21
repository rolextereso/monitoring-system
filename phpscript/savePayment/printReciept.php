<!DOCTYPE html>
<html>
<head>
	<title>Print Official Reciept</title>
</head>
<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
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
</style>
<?php 
   
    require_once('../../classes/Crud.php');

    $crud = new Crud();
    
    if(isset($_GET['or']) && isset($_GET['a'])){
        //getting id from url
        $id = $crud->escape_string($_GET['or']);
        $amount_tendered=$crud->escape_string(str_replace(',','',$_GET['a']));

        if(is_numeric($id) && $id!=''){
       
            //selecting data associated with this particular id
            $result = $crud->getData("SELECT ".
									"	p.product_name, ".
									"		sp.quantity, ".							
									"		sp.amount  ".
									"		FROM sales_specific sp ".
									"		INNER JOIN sales_record sr ON sp.or_number=sr.sales_id ".
									"		INNER JOIN customer c ON c.customer_id =sr.customer_id ".
									"		INNER JOIN products p ON p.product_id=sp.product_id ".
									"		WHERE sr.or_number=".$id);
  
             $customer = $crud->getData("SELECT ".
									"	sr.or_number, ".
									"		c.customer_name, ".							
									"		c.customer_address  ".
									"		FROM sales_record sr ".							
									"		INNER JOIN customer c ON c.customer_id =sr.customer_id ".							
									"		WHERE sr.or_number=".$id." LIMIT 1");  
            
        }
    }
?>  
<body>
		<div class="container">
			
			<div id="content" >
				<div id="header">
					<img src="../../img/setting_assets/logo.png" width="50" height="50" style="float:left;">
					<div style="float:right;" >
						<h4>SOUTHERN LEYTE STATE UNIVERSITY-HINUNANGAN</h4>
						<p> College of Agricultural and Environment Sciences</p>
						<p> Hinunangan, Southern Leyte</p>
					</div>
				</div>
				<div class="clearfix"></div>
				<br/>
				<div id="customer_info">
					<label>Customer Name:</label><span> <b><?php echo $customer[0]['customer_name'];?></b>  </span><br/>
					<label>Customer Address:</label><span><b> <?php echo $customer[0]['customer_address'];?></b></span><br/>
					<label>OR #:</label><span> <b><?php echo $customer[0]['or_number'];?> </b></span>					
				</div>
				<div id="body">
					<h3>OFFICIAL RECEIPT</h3>
				</div>
				<table border="1">
					<tr>
						<th> Particulars</th>
						<th> Quantity </th>
						<th> Amount </th>
					</tr>
					<?php   
						$total_amount=0;
						foreach ($result as $res) {?>
					<tr>
						<td>&nbsp;<?php echo $res['product_name'];?></td>
						<td>&nbsp;<?php echo $res['quantity'];?> </td>
						<td style="text-align: center;">&#8369;&nbsp;<?php echo $res['amount'];?></td>
					</tr>
					<?php 
						$total_amount+=$res['amount'];
					 	} 
					 ?>
					<tr>
						<td colspan="2"> Total</td>
						<td style="text-align: center;">&#8369;&nbsp;<?php echo $total_amount;?></td>
					</tr>
					<tr>
						<td colspan="2"> Amount Tendered:</td>
						<td style="text-align: center;">&#8369;&nbsp;<?php echo $amount_tendered;?></td>
					</tr>
					<tr>
						<td colspan="2"> Change:</td>
						<td style="text-align: center;">&#8369;&nbsp;<?php echo number_format($amount_tendered-$total_amount,2);?></td>
					</tr>
				</table>
				<br/>
				<br/>
				<div id="footer">
					<label>Printed by: </label><span> ROLLY TERESO </span><br/>
					<label>Date &amp; Time Printed:</label><span><?php echo date('Y-m-d H:i:s');?> </span><br/>
				</div>
		</div>

</body>
</html>
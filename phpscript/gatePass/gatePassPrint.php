<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Gate Pass</title>
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
    require_once('../../classes/function.php');

    $crud = new Crud();
    
    if(isset($_GET['or'])){
        //getting id from url
        $id = $crud->escape_string($_GET['or']);    
        $paid_for = $crud->escape_string($_GET['specific']);   

        if($id!=''){
		       		if($paid_for=="sales"){
				            //selecting data associated with this particular id
				             $result = $crud->getData("SELECT ".
													"	p.product_name, ".
													"		sp.quantity, ".							
													"		sp.amount  ".
													"		FROM sales_specific sp ".
													"		INNER JOIN sales_record sr ON sp.or_number=sr.sales_id ".
													"		INNER JOIN customer c ON c.customer_id =sr.customer_id ".
													"		INNER JOIN products p ON p.product_id=sp.product_id ".
													"		WHERE sr.or_number='$id'");
				       
		             } else if($paid_for=="rental"){

		             	       $result=$crud->getData("SELECT                                 
						                                  ri.item_name,
						                                  ri.item_description,
						                                  ri.rental_fee,
						                                  ri.per_day,
						                                  rs.rental_fee_amount,
						                                  rs.no_of_days			                                  
					                                  FROM rental_items ri
					                                LEFT JOIN rental_specific rs ON rs.rental_id=ri.rental_id
					                                LEFT JOIN sales_record sr ON sr.sales_id=rs.sales_id
					                                WHERE  sr.or_number='$id'");
		             	    

		             }     
		            
		             $customer = $crud->getData("SELECT 
												    sr.or_number, 
													CASE WHEN count(sr.or_number)>1 THEN CONCAT(c.customer_name,' etc.') ELSE c.customer_name END  AS customer_name, 
													CASE WHEN count(sr.or_number)>1 THEN CONCAT(c.customer_address,' etc.') ELSE c.customer_address END  AS customer_address
													FROM sales_record sr 						
													INNER JOIN customer c ON c.customer_id =sr.customer_id							
													WHERE sr.or_number='".$id."' LIMIT 1");  
		             //update printing_status to printed or 'Y'
					$crud->execute("UPDATE sales_record SET printing_status='Y' WHERE or_number=".$id);            
        }
    }
?>  
<body>
		<div class="container">
			
			<div id="content">
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
					<h3>GATE PASS</h3>
				</div>
				<table border="1">
					<tr>
						<th> Particulars</th>
						<th><?php echo ($paid_for=="rental")?"# of day(s)":"Quantity";?></th>
						<th> Amount </th>
					</tr>
					<?php   
						$total_amount=0;
						foreach ($result as $res) {?>
					<tr>
						 <?php if($paid_for=="sales"){ ?>
							<td>&nbsp;<?php echo $res['product_name'];?></td>
							<td>&nbsp;<?php echo $res['quantity'];?> </td>
							<td style="text-align: center;">&#8369;&nbsp;<?php echo number_format($res['amount'],2);?></td>
							<?php $total_amount+=$res['amount']; ?>
						 <?php } else if($paid_for=="rental"){ ?>
						 	<td>&nbsp;<?php echo $res['item_name']."(".$res['item_description'].")";?></td>
							<td>&nbsp;<?php echo $res['no_of_days'];?> </td>
							<td style="text-align: center;">&#8369;&nbsp;<?php echo number_format($res['rental_fee_amount'],2);?></td>
							<?php $total_amount+=$res['rental_fee_amount']; ?>

						 <?php } ?>
					</tr>
					<?php 
						
					 	} 
					 ?>
					<tr>
						<td colspan="2"> Total</td>
						<td style="text-align: center;">&#8369;&nbsp;<?php echo number_format($total_amount,2);?></td>
					</tr>
				</table>
				<br/>
				<br/>

				<div id="footer">
					<label>Printed by: </label><span><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname'];?></span><br/>
					<label>Date &amp; Time Printed:</label><span><?php echo date('F d, Y h:i:s a');?> </span><br/>
					


			</div>
		</div>

</body>
</html>
<?php session_start(); ?>
<?php 
   
    require_once('../../classes/Crud.php');
    require_once('../../classes/function.php');

   

    $crud = new Crud();

     $header=header_info();
    
    if(isset($_GET['id']) && isset($_GET['for'])){
        //getting id from url
        $id = $crud->escape_string($_GET['id']);
        $paid_for = $crud->escape_string($_GET['for']);
       
             

            if($paid_for=="rental"){
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
			                                WHERE  rs.transaction_id='".$id."'");

             	        $customer = $crud->getData("SELECT ".
									"	rs.transaction_id, ".
									"		c.customer_name, ".							
									"		c.customer_address  ".
									"		FROM rental_specific rs ".							
									"		INNER JOIN customer c ON c.customer_id =rs.customer_id ".
													
									"		WHERE rs.transaction_id='".$id."' LIMIT 1"); 

             }else{
					    //selecting data associated with this particular id
			            $result = $crud->getData("SELECT ".
												"	p.product_name, ".
												"		sp.quantity, ".							
												"		sp.amount  ".
												"		FROM sales_specific sp ".
												"		INNER JOIN sales_record sr ON sp.or_number=sr.sales_id ".
												"		INNER JOIN customer c ON c.customer_id =sr.customer_id ".
												"		INNER JOIN products p ON p.product_id=sp.product_id ".
												"		WHERE sp.transaction_id='".$id."'");

			              $customer = $crud->getData("SELECT ".
									"	sp.transaction_id, ".
									"		c.customer_name, ".							
									"		c.customer_address  ".
									"		FROM sales_record sr ".							
									"		INNER JOIN customer c ON c.customer_id =sr.customer_id ".
									"		INNER JOIN sales_specific sp ON sp.or_number=sr.sales_id  ".							
									"		WHERE sp.transaction_id='".$id."' LIMIT 1"); 
             }
  
            
            
?>
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


<body>
		<div class="container">
		
			<div id="content" >
				<div id="header">
					<img src="<?php echo "../../".$header['logo'];?>" width="50" height="50" style="float:left;">
					<div style="float:right;" >
						<h4><?php echo $header['company_name'];?></h4>
						<p> <?php echo $header['company_address'];?></p>
						<p> <?php echo $header['contact_no'];?></p>
					</div>
				</div>
				<div class="clearfix"></div>
				<br/>
				<div id="customer_info">
					<label>Customer Name:</label><span> <b><?php echo $customer[0]['customer_name'];?></b>  </span><br/>
					<label>Customer Address:</label><span><b> <?php echo $customer[0]['customer_address'];?></b></span><br/>
					<label>Transaction #:</label><span> <b><?php echo $customer[0]['transaction_id'];?> </b></span>					
				</div>
				<div id="body">
					<h3>Certification</h3>
				</div>
				<table border="1">
					<tr>
						<th> Particulars</th>
						<th> <?php echo ($paid_for=="rental")?"# of day(s)":"Quantity";?> </th>
						<th> Amount </th>
					</tr>
					<?php   
						$total_amount=0;
						foreach ($result as $res) {?>
					<tr>
						<?php if($paid_for!="rental"){ ?>
							<td>&nbsp;<?php echo $res['product_name'];?></td>
							<td>&nbsp;<?php echo $res['quantity'];?> </td>
							<td style="text-align: center;">&#8369;&nbsp;<?php echo number_format($res['amount'],2);?></td>
							<?php $total_amount+=$res['amount']; ?>
						 <?php } else { ?>
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
		

				<div style="border-bottom: 1px solid silver;
						    margin: 0 auto;
						    width: 80%;
						    height: 81px;
						    padding:3px;
    						""><small>Please write th OR Number of the Official Reciept <br/>(Countersigned by the cashier)</small>
					&nbsp;
				</div>
				<br/>
				<div id="footer">
					<label>Printed by: </label><span><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname'];?></span><br/>
					<label>Date &amp; Time Printed:</label><span><?php echo date('Y-m-d H:i:s');?> </span><br/>
				</div>
		</div>

</body>
</html>
<?php
    }
?> 
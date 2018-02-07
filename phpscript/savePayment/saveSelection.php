<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();

if(isset($_POST['product_id'])){

		$amount         = $_POST['amount'];
		$product_id     =$_POST['product_id'];
	    $quantity       = $_POST['quantity'];
	    $lastInsertedId = 0;

		$customer_name     = $crud->escape_string($_POST['customer_name']);
		$customer_address  = $crud->escape_string($_POST['customer_address']);
		$transaction_id    = $crud->escape_string($_POST['transaction_id']);
		// $mode_payment  = $crud->escape_string($_POST['mode-payment']);
		// $amount_tendered  = str_replace(',', '', $crud->escape_string($_POST['amount_tendered']));
		$total_amount  = str_replace(',', '', $crud->escape_string($_POST['total_amount']));

		 $c_id=$crud->getData("SELECT customer_id as c_id FROM customer 
		 				 WHERE customer_name='$customer_name' 
		 				 AND customer_address='$customer_address' LIMIT 1;");


		 if(count($c_id)==0){
		 	$result[]=$crud->executeUnAutoCommit("INSERT INTO customer(customer_name, customer_address) ".
							 	   "VALUES ('$customer_name', '$customer_address');");
		 
		    $insert_id= $crud->getData("SELECT LAST_INSERT_ID() AS insert_id");
		    $lastInsertedId= $insert_id[0]['insert_id'];

		 }else{
		 	$lastInsertedId= $c_id[0]['c_id'];
		 }

		 if($lastInsertedId>0){

		 		$lastId=$lastInsertedId;
		 		$result = $crud->executeUnAutoCommit("INSERT INTO sales_record(or_number, total_amount, mode_of_payment,user_id,customer_id) ".
					" VALUES ('', '$total_amount', '', '{$_SESSION['user_id']}','$lastId');");


				$or_id= $crud->getData("SELECT LAST_INSERT_ID() AS insert_id");
				$or_id=$or_id[0]['insert_id'];
				$i=0;
				while($i<count($product_id)){
					$result = $crud->executeUnAutoCommit("INSERT INTO sales_specific(product_id, quantity, amount,or_number,transaction_id) ".
					" VALUES ('{$product_id[$i]}', '{$quantity[$i]}', '{$amount[$i]}', '$or_id','$transaction_id');");

					$i++;
				}
				
				
		 }	 
         if(user_activity("Made product selection with transaction id: $transaction_id",$_SESSION['user_id'])){
			 echo print_message($result, '<strong>Success:</strong> Product selected successfully save.','<strong>Error:</strong> Payment not saved, please contact the developer.');	
		 }else{
		 	echo print_message(false, '','<strong>Error:</strong> Something wrong with activity log, Please contact the developer.');	
		 }

}
?>

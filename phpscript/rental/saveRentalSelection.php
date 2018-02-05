<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();

if(isset($_POST['rental_id'])){

		$amount          = $_POST['amount'];
		$rental_id       = $_POST['rental_id'];
	    $number_of_days  = $_POST['no_of_days'];
	    $date_to_return  = $_POST['date_to_return'];

		$customer_name  = $crud->escape_string($_POST['customer_name']);
		$customer_address  = $crud->escape_string($_POST['customer_address']);
		$transaction_id  = $crud->escape_string($_POST['transaction_id']);		
		$total_amount  = str_replace(',', '', $crud->escape_string($_POST['total_amount']));

		$result=array();		

	
		 $result[]=$crud->executeUnAutoCommit("INSERT INTO customer(customer_name, customer_address) ".
							 	   "VALUES ('$customer_name', '$customer_address');");
		 
		 $lastInsertedId= $crud->getData("SELECT LAST_INSERT_ID() AS insert_id");

		 if($lastInsertedId>0){

		 		$customer_id = $lastInsertedId[0]['insert_id'];

		 		$i=0;
				while($i<count($rental_id)){
					$result[] = $crud->executeUnAutoCommit("UPDATE rental_items SET availability='N',transaction_id='{$transaction_id}' WHERE rental_id='{$rental_id[$i]}';");

					$i++;
				}

				$result[] = $crud->executeUnAutoCommit("INSERT INTO sales_record(or_number, total_amount, mode_of_payment,user_id,customer_id) ".
					" VALUES ('', '$total_amount', '', '1','$customer_id');");


				$or_id= $crud->getData("SELECT LAST_INSERT_ID() AS insert_id");
				$or_id=$or_id[0]['insert_id'];
				
				$i=0;
				while($i<count($rental_id)){
					$result[] = $crud->executeUnAutoCommit("INSERT INTO rental_specific(rental_id, date_return, rental_fee_amount,created_by,customer_id,transaction_id,sales_id,no_of_days) ".
					    " VALUES ('{$rental_id[$i]}', '{$date_to_return[$i]}', '{$amount[$i]}', '{$_SESSION['user_id']}','$customer_id','$transaction_id','$or_id','$number_of_days[$i]');");
					$i++;
				}
				
				
		 }	 

		if(user_activity("Made rental selection with transaction id: $transaction_id",$_SESSION['user_id'])){
		 		echo print_message(!in_array("", $result), '<strong>Success:</strong> Rental  selected successfully save.','<strong>Error:</strong> Rental not saved, please contact the developer.');	
		}else{
		 		echo print_message(false, '','<strong>Error:</strong> Something wrong with activity log, Please contact the developer.');	
		 }

}
?>

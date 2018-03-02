<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();

if(isset($_POST['remittance_id'])){

		$op = $crud->escape_string($_POST['op']);
		$prod_involve  = $crud->escape_string($_POST['prod_involved']);
		

		$status='N';
		if(isset($_POST['status'])){
			$status='Y';
		}		
		
		if($_POST['remittance_id']!=''){
			 $result=$crud->executeUnAutoCommit("UPDATE bundle_remittance SET order_payment_id='$op',
			 									 product_involve='$prod_involve',
			 								     created_by='{$_SESSION['user_id']}',
			 								     status='$status' 
			 								     WHERE remittance_id=".$_POST['remittance_id']);								
		
			 

		}else{
			 $result=$crud->executeUnAutoCommit("INSERT INTO bundle_remittance(order_payment_id, product_involve,status, 	
			 										created_by) 
								                 VALUES ('$op','$prod_involve','$status','{$_SESSION['user_id']}');");

			
		}
		 

		echo print_message($result, '<strong>Success:</strong> Successfully save OP Number.','<strong>Error:</strong> OP Number not saved, please contact the developer.');	

}
?>
<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();

if(isset($_POST['item_code'])){
		
		$item_code = $crud->escape_string($_POST['item_code']);
		$item_name = $crud->escape_string($_POST['item_name']);
		$item_desc  = $crud->escape_string($_POST['item_description']);
		$unit  = $crud->escape_string($_POST['unit']);
		$rental_fee  = str_replace(',', '', $crud->escape_string($_POST['rental_fee']));
		

		$status='N';
		if(isset($_POST['status'])){
			$status='Y';
		}

		$gate_pass='N';
		if(isset($_POST['gate_pass'])){
			$gate_pass='Y';
		}

		$per_day='N';
		if(isset($_POST['per_day'])){
			$per_day='Y';
		}
		
		if(isset($_POST['item_id'])){
			$item_id  = $crud->escape_string($_POST['item_id']);	
					 		
			 		$result = $crud->executeUnAutoCommit("UPDATE rental_items SET item_name='$item_name',
			 																	  item_code='$item_code',
			 																	  item_description= '$item_desc',
			 																	  rental_fee='$rental_fee',
			 																	  unit='$unit', 
			 																	  per_day= '$per_day', 
			 																	  need_gate_pass='$gate_pass', 
			 																	  created_by='{$_SESSION['user_id']}', 
			 																	  status='$status' WHERE rental_id='$item_id'");			
			 
		}else{
			
			 		$result = $crud->executeUnAutoCommit("INSERT INTO rental_items(item_name,
			 																	  item_code,
			 																	  item_description,
			 																	  rental_fee,
			 																	  unit, 
			 																	  per_day, 
			 																	  need_gate_pass, 
			 																	  created_by, 
			 																	  status) ".
																			 "VALUES ('$item_name', 
																			          '$item_code',  
																			          '$item_desc',
																			          '$rental_fee',
																			          '$unit',
																			          '$per_day',
																			      	  '$gate_pass',
																			      	  '{$_SESSION['user_id']}',
																			      	  '$status');");		
			 
		}
		 

		 echo print_message($result, '<strong>Success:</strong> Rental Item successfully save.','<strong>Error:</strong> Product not saved, please contact the developer.');	

}
?>
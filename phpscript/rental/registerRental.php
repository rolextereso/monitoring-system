<?php
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();

if(isset($_POST['item_code'])){
		$item_code = $crud->escape_string($_POST['item_code']);
		$item_name = $crud->escape_string($_POST['item_name']);
		$item_desc  = $crud->escape_string($_POST['item_desc']);
		$measurement  = $crud->escape_string($_POST['measurement']);
		$rental  = str_replace(',', '', $crud->escape_string($_POST['rental']));
		

		$status='N';
		if(isset($_POST['status'])){
			$status='Y';
		}
		
		if(isset($_POST['product_id'])){
			 $result=$crud->executeUnAutoCommit("UPDATE product_price SET price='$price', created_by='' WHERE price_id=".$_POST['price_id']);								
		
			 if($result){			 		
			 		$result = $crud->executeUnAutoCommit("UPDATE products SET product_name='$product_name', ".
			 											 " product_price=".$_POST['price_id'].", ".
			 											 " project_id='$project', ".
			 											 " unit_of_measurement='$measurement', ".
			 											 " product_status='$status' WHERE product_id= ".$_POST['product_id']);				
			 }

		}else{
			 $result=$crud->executeUnAutoCommit("INSERT INTO product_price(price, created_by) ".
								 "VALUES ('$rental', '');");

			 $lastInsertedId= $crud->getData("SELECT LAST_INSERT_ID() AS insert_id");

			 
			 if(count($lastInsertedId)>0){
			 		$lastId=$lastInsertedId[0]['insert_id'];
			 		$result = $crud->executeUnAutoCommit("INSERT INTO products(product_name,product_price,  unit_of_measurement,product_status,item_code, item_description) ".
									 "VALUES ('$item_name', '$lastId',  '$measurement','$status','$item_code','$item_desc');");		
			 }
		}
		 

		 echo print_message($result, '<strong>Success:</strong> Product successfully save.','<strong>Error:</strong> Product not saved, please contact the developer.');	

}
?>
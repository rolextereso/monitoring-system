<?php

//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();

if(isset($_POST['sales_id'])){



		$sales_id  = $crud->escape_string($_POST['sales_id']);
		$OR  = $crud->escape_string($_POST['or']);
		$mode_payment  = $crud->escape_string($_POST['mode-payment']);
		$selection_for  = $crud->escape_string($_POST['selection_for']);
		

		$result=$crud->executeUnAutoCommit("UPDATE sales_record SET mode_of_payment='$mode_payment', or_number='$OR'".
											" WHERE sales_id='$sales_id';");

		if($selection_for=="sales"){
			
			 if($result){
			 	$result=$crud->executeUnAutoCommit("UPDATE sales_specific SET paid='Y' ".
												   " WHERE or_number='$sales_id';");		
			 }
		}else if($selection_for=="rental"){
					
			 if($result){
			 	$result=$crud->executeUnAutoCommit("UPDATE rental_specific SET paid='Y' ".
												   " WHERE sales_id='$sales_id';");		
			 }	
		}
		 

		 echo print_message($result, '<strong>Success:</strong> Payment successfully save.','<strong>Error:</strong> Payment not saved, please contact the developer.');	

}
?>

<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();

$result=array();

if(isset($_POST['sales_id'])){



		$sales_id  = $crud->escape_string($_POST['sales_id']);
		$OR  = $crud->escape_string($_POST['or']);
		$year_semester  = semester_year();
		$selection_for  = $crud->escape_string($_POST['selection_for']);
		

		$result[]=$crud->executeUnAutoCommit("UPDATE sales_record SET mode_of_payment='Cash', or_number='$OR'".
											" WHERE sales_id='$sales_id';");
		$result[]=$crud->executeUnAutoCommit("UPDATE paid_assess{$year_semester} SET sales_id='$sales_id' ".
											" WHERE ORNo='$OR';");

		if($selection_for=="sales"){
			
			 //if($result){
			 	$result[]=$crud->executeUnAutoCommit("UPDATE sales_specific SET paid='Y' ".
												   " WHERE or_number='$sales_id';");		
			// }
		}else if($selection_for=="rental"){
					
			 //if($result){
			 	$result[]=$crud->executeUnAutoCommit("UPDATE rental_specific SET paid='Y' ".
												   " WHERE sales_id='$sales_id';");		
			 //}	
		}
		 
		if(user_activity("Saved payment for $selection_for selection with OR number: $OR",$_SESSION['user_id'])){
		 		echo print_message(!in_array("", $result), '<strong>Success:</strong> Payment successfully save.','<strong>Error:</strong> Payment not saved, please contact the developer.');	
		}else{
				echo print_message(false, '','<strong>Error:</strong> Something wrong with activity log, Please contact the developer.');
		}

}
?>

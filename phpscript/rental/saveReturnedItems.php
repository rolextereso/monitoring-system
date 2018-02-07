<?php

//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();

if(isset($_POST['transaction_id'])){

		$rental_specific_id = $_POST['rental_specific_id'];
		$result=array();
		$rental_id=array();

		$paid= $crud->getData("SELECT count(*) as unpaid FROM rental_specific
		 								  WHERE transaction_id='".$_POST['transaction_id']."' 
		 								  AND paid='N';");

		if($paid[0]['unpaid']>=1){
			 echo print_message(false, '','<strong>Unable to process:</strong> Pay first the rental fee before to return an item.',$rental_id);

		}else{
			$i=0;
			while($i<count($rental_specific_id)){
				$result[] = $crud->executeUnAutoCommit("UPDATE rental_specific SET date_returned=DATE(now()) 
													    WHERE rental_specific_id='{$rental_specific_id[$i]}';");
				$rental_id[]=$rental_specific_id[$i];

				$i++;
			}

			$remaining= $crud->getData("SELECT count(*) as total_rented_remaining FROM rental_specific
			 								  WHERE transaction_id='".$_POST['transaction_id']."' 
			 								  AND (date_returned IS NULL OR date_returned = '');");

	        if($remaining[0]['total_rented_remaining']==0){
	        	$result[] = $crud->executeUnAutoCommit("UPDATE rental_items
	        											SET availability='Y', transaction_id='' 
													    WHERE transaction_id='".$_POST['transaction_id']."';");

	        }					
				
		    echo print_message(!in_array("", $result), '<strong>Success:</strong> Returned selected item successfully save.','<strong>Error:</strong> Return item not saved, please contact the developer.',$rental_id);	
		} 		

}
?>

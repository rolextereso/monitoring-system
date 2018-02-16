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

		$gate_pass=array();
		$sql="SELECT ss.sales_specific_id as sales, rsp.rental_specific_id as rental
				FROM sales_record sr
				LEFT JOIN  sales_specific ss  ON ss.or_number=sr.sales_id 
				LEFT JOIN customer c ON c.customer_id =sr.customer_id 
				LEFT JOIN  rental_specific rsp ON rsp.sales_id=sr.sales_id
				LEFT JOIN  products p ON p.product_id=ss.product_id     
		        LEFT JOIN  rental_items rit ON rit.rental_id=rsp.rental_id     
				WHERE (ss.paid='Y' OR  rsp.paid='Y') AND sr.or_number ='$OR' AND (p.for_gate_pass='Y' OR rit.need_gate_pass='Y')";

		$gate = $crud->getData($sql);
     
		if(count($gate)==0){
			$gate_pass[]='no_gate_pass';
		}else{
			if($gate[0]['sales']==''){
				$gate_pass[]='rental';
			}else{
				$gate_pass[]='sales';
			}
		}
					
		$gate_pass[]="$OR";
		
		if(user_activity("Saved payment for $selection_for selection with OR number: $OR",$_SESSION['user_id'])){
		 		echo print_message(!in_array("", $result), '<strong>Success:</strong> Payment successfully save.','<strong>Error:</strong> Payment not saved, please contact the developer.',$gate_pass);	
		}else{
				echo print_message(false, '','<strong>Error:</strong> Something wrong with activity log, Please contact the developer.');
		}

}
?>

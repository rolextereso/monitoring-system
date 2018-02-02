<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();
$result=array();

if(isset($_POST['or']) && isset($_POST['unit_cost'])){

		$or = $_POST['or'];
		$unit_cost = $_POST['unit_cost'];
		$id=$_POST['id'];

		$i=0;
		while($i<count($or)){
			$unit_cost_=str_replace(",","","$unit_cost[$i]");
			$result[] = $crud->executeUnAutoCommit("UPDATE expenses_breakdown SET ORNumber='{$or[$i]}', 
														 amount_per_unit='{$unit_cost_}' 
													WHERE id='{$id[$i]}'");
			$i++;
		}		

		echo print_message(!in_array("", $result), '<strong>Success:</strong> Purchased Request detail successfully save.','<strong>Error:</strong> Purchased Request detail not saved, please contact the developer.');	

}
?>
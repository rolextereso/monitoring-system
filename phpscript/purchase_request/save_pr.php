<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();

if(isset($_POST['pr_no'])){

		$entity_name = $crud->escape_string($_POST['entity_name']);
		$project_id  = $crud->escape_string($_POST['projects']);
		$purpose     = $crud->escape_string($_POST['purpose']);
		$created_by  =$_SESSION['user_id'];
		$pr_no	     = $crud->escape_string($_POST['pr_no']);
		$unit        = $_POST['unit'];
		$item_description       = $_POST['item_description'];
		$quantity       = $_POST['quantity'];

		$result=array();

		$result[] = $crud->executeUnAutoCommit("INSERT INTO purchase_request(entity_name, project_duration_id, purpose, created_by, 
												pr_no) VALUES('$entity_name','$project_id','$purpose','$created_by','$pr_no');");

		$pr_id= $crud->getData("SELECT LAST_INSERT_ID() AS insert_id");
		$pr_id=$pr_id[0]['insert_id'];

		$i=0;
		while($i<count($unit)){
			$result[] = $crud->executeUnAutoCommit("INSERT INTO expenses_breakdown(item_description, qty, 
													unit, purchase_request_id)
													VALUES('{$item_description[$i]}','{$quantity[$i]}','{$unit[$i]}',
													       '$pr_id');");

				
			$i++;
		}

		 echo print_message(!in_array("", $result), '<strong>Success:</strong> Purchased Request successfully save.','<strong>Error:</strong> Purchased Request not saved, please contact the developer.');	

}
?>
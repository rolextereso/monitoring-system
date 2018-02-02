<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();
$data=array();

if(isset($_POST['pr_id_'])){

		$approval_stat = $crud->escape_string($_POST['approval_stat']);
		$pr_id = $crud->escape_string($_POST['pr_id_']);
		
		$result = $crud->executeUnAutoCommit("UPDATE purchase_request SET approved='{$approval_stat}', updated_on=now() 
												WHERE pr_no='{$pr_id}'");
		if($result){
			$data[]=$approval_stat;
		}

		echo print_message($result, '<strong>Success:</strong> Purchased Request status successfully save.','<strong>Error:</strong> Purchased Request status not saved, please contact the developer.',$data);	

}
?>
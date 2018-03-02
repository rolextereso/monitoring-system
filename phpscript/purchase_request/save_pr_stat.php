<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();
$data=array();

if(isset($_POST['pr_id_'])){
	$pr_id = $crud->escape_string($_POST['pr_id_']);


			$approval_stat = $crud->escape_string($_POST['approval_stat']);
			

			$funds = "";
			$target_exp = "";
			if($approval_stat=='F'){
				$funds = $crud->escape_string($_POST['funds']);
				$target_exp = $crud->escape_string($_POST['target_exp']);

				$result = $crud->executeUnAutoCommit("UPDATE purchase_request SET approved='{$approval_stat}', 
																			 
																			  funds='{$funds}',
																			  project_budget_id='{$target_exp}'
													 WHERE pr_no='{$pr_id}'");
			}elseif($approval_stat=='Y' || $approval_stat=='N' ){
				$result = $crud->executeUnAutoCommit("UPDATE purchase_request SET approved='{$approval_stat}'
													 WHERE pr_no='{$pr_id}'");
			}elseif($approval_stat=='C'){
				$purchase_request_number = $crud->escape_string($_POST['pr_number']);

				$result = $crud->executeUnAutoCommit("UPDATE purchase_request 
													SET purchase_request_number='{$purchase_request_number}',
														updated_on=now(),
													    approved='C'
													WHERE pr_no='{$pr_id}'");
				if($result){
					$data[]='C';
				}
			}
			
			
			
			if($result){
				$data[]=$approval_stat;
			}

			echo print_message($result, '<strong>Success:</strong> Purchased Request status successfully save.','<strong>Error:</strong> Purchased Request status not saved, please contact the developer.',$data);	
	

}
?>
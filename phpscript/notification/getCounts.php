<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();
$add_where=" IS NOT NULL";
$add_where_upaid="";
if($_SESSION['user_type']!=1){
	$add_where= "='".$_SESSION['user_id']."'";
	$add_where_upaid="AND user_id ".specific_user(access_role("Transaction List","view_command",$_SESSION['user_type']));
}

$rented_items     =$crud->getData("SELECT count(rental_specific_id) as rented_item 
	                               FROM rental_specific rs 
	                               INNER JOIN rental_items ri ON ri.rental_id=rs.rental_id 
	                               WHERE date_returned IS NULL AND ri.created_by $add_where;");

$onprocess_request=$crud->getData("SELECT count(purchase_request_id) as onprocess_request 
	                               FROM purchase_request pr
								   INNER JOIN project_duration pd ON pd.project_duration_id=pr.project_duration_id
								   INNER JOIN projects p ON p.project_id = pd.project_id
									WHERE approved='O' AND p.project_incharge $add_where;");

$unpaid_transaction =$crud->getData("SELECT count(sales_id) as unpaid_transaction 
	                               FROM sales_record WHERE or_number='' $add_where_upaid;");


$data=array('rented_items'=>$rented_items[0]['rented_item'],
			'onprocess_request'=>$onprocess_request[0]['onprocess_request'],
			'unpaid_transaction'=>$unpaid_transaction[0]['unpaid_transaction']);
echo json_encode($data);


		
?>
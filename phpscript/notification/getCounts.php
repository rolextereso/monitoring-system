<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();



$add_where_rented=" ".specific_user(access_role("Rented Items","view_command",$_SESSION['user_type']));
$add_where_pr=" ".specific_user(access_role("Purchase Requests","view_command",$_SESSION['user_type']));
$add_where_upaid="AND user_id ".specific_user(access_role("Transaction List","view_command",$_SESSION['user_type']));
$user_id=" ".specific_user(access_role("Rented Items","view_command",$_SESSION['user_type']));


$rented_items     =$crud->getData("SELECT count(DISTINCT rs.transaction_id) as rented_item 
	                               FROM rental_specific rs 
	                               INNER JOIN rental_items ri ON ri.rental_id=rs.rental_id 
	                               WHERE date_returned IS NULL AND canceled='N' AND ri.created_by $add_where_rented;");
// O -ongoing , F-funded, C-Completed , Y-approved, N-disapproved  -->
$stat="'O','F','Y'";
if($_SESSION['user_type']==5){
	$stat="'C'";
}elseif($_SESSION['user_type']==6){
	$stat="'Y'";
}elseif($_SESSION['user_type']==3){
	$stat="'F'";
}
$onprocess_request=$crud->getData("SELECT count(purchase_request_id) as onprocess_request 
	                               FROM purchase_request pr
								   INNER JOIN project_duration pd ON pd.project_duration_id=pr.project_duration_id
								   INNER JOIN projects p ON p.project_id = pd.project_id
								   WHERE approved IN($stat) AND p.project_incharge $add_where_pr;");

$unpaid_transaction =$crud->getData("SELECT (count(DISTINCT ss.transaction_id)+count(DISTINCT rsp.transaction_id)) 
										as unpaid_transaction
										FROM sales_record sr
										LEFT JOIN  sales_specific ss  ON ss.or_number=sr.sales_id 	
										LEFT JOIN  rental_specific rsp ON rsp.sales_id=sr.sales_id
								        LEFT JOIN  rental_items rit ON rit.rental_id=rsp.rental_id
								        WHERE sr.or_number='' AND (ss.canceled='N' OR rsp.canceled='N') $add_where_upaid;");

$over_due_rented =$crud->getData("SELECT 
									COUNT(DISTINCT transaction_id) AS number_overdue FROM
									rental_specific WHERE paid='Y' AND canceled='N' AND created_by $user_id AND date_returned IS NULL AND date_return<=NOW();");



$data=array('rented_items'=>$rented_items[0]['rented_item'],
			'onprocess_request'=>$onprocess_request[0]['onprocess_request'],
			'unpaid_transaction'=>$unpaid_transaction[0]['unpaid_transaction'],
			'over_due_rented'=>$over_due_rented[0]['number_overdue']);
echo json_encode($data);


		
?>
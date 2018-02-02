<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

function getData($result){
		$record=array();
		foreach($result as $key =>$row){

			$row_data=array();		     		    
				$row_data[]=$row["amount"];
				$row_data[]=$row["project_name"] ;    
				$record[]= $row_data;
			    
		}
		return $record;
}

$budget_query = "SELECT SUM(amount) as amount, p.project_name FROM projects p
					INNER JOIN project_duration pd ON p.project_id= pd.project_id
					INNER JOIN project_budget pb ON pb.project_specific_id = pd.project_specific_id 
					WHERE pd.status='Y' GROUP BY p.project_id ORDER BY p.project_id;";   

$budget = $crud->getData($budget_query);

$expenses_query = "SELECT 
					CASE WHEN SUM(qty*amount_per_unit) IS NULL THEN 0 ELSE SUM(qty*amount_per_unit) END as amount ,
				    p.project_name
					FROM project_duration pd 
				    LEFT JOIN  purchase_request pr ON pd.project_duration_id=pr.project_duration_id
					LEFT JOIN expenses_breakdown eb ON eb.purchase_request_id=pr.purchase_request_id 
				    INNER JOIN projects p ON p.project_id= pd.project_id  
					WHERE  pd.status='Y' GROUP BY pd.project_duration_id ORDER BY pd.project_id;";   

$expenses = $crud->getData($expenses_query);



$json_data = array(array("budget"=> getData($budget),"expenses"=>getData($expenses)));
echo json_encode($json_data);

?>
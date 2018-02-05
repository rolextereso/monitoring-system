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

$sales_query = "SELECT SUM(amount) as amount, p.project_name FROM projects p
					INNER JOIN  products pd ON pd.project_id=p.project_id	
					INNER JOIN  sales_specific ss ON ss.product_id=pd.product_id	
					INNER JOIN sales_record sr ON sr.sales_id = ss.or_number
					WHERE sr.or_number!='' OR sr.or_number IS NOT NULL GROUP BY p.project_id ORDER BY p.project_id;";   

$sales = $crud->getData($sales_query);

$expenses_query = "SELECT 
					CASE WHEN SUM(qty*amount_per_unit) IS NULL THEN 0 ELSE SUM(qty*amount_per_unit) END as amount ,
				    p.project_name
					FROM project_duration pd 
				    LEFT JOIN  purchase_request pr ON pd.project_duration_id=pr.project_duration_id
					LEFT JOIN expenses_breakdown eb ON eb.purchase_request_id=pr.purchase_request_id 
				    INNER JOIN projects p ON p.project_id= pd.project_id  
					WHERE  pd.status='Y' GROUP BY pd.project_duration_id ORDER BY pd.project_id;";   

$expenses = $crud->getData($expenses_query);



$json_data = array(array("sales"=> getData($sales),"expenses"=>getData($expenses)));
echo json_encode($json_data);

?>
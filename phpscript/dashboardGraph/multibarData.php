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
		return (count($record)>0)? $record : 0;
}

$sales_query = "SELECT 
					CASE WHEN 
							(SELECT SUM(amount) FROM projects ps
										LEFT JOIN  products pd ON pd.project_id=ps.project_id	
										LEFT JOIN  sales_specific ss ON ss.product_id=pd.product_id	
										LEFT JOIN sales_record sr ON sr.sales_id = ss.or_number AND sr.or_number !=''
										WHERE sr.or_number!='' AND ps.project_id=p.project_id ) != 0 	
							THEN 
										(SELECT SUM(amount) FROM projects ps
										LEFT JOIN  products pd ON pd.project_id=ps.project_id	
										LEFT JOIN  sales_specific ss ON ss.product_id=pd.product_id	
										LEFT JOIN sales_record sr ON sr.sales_id = ss.or_number AND sr.or_number !=''
										WHERE sr.or_number!='' AND ps.project_id=p.project_id ) 
						ELSE 
										0
						END
					as amount,
					p.project_name
		            FROM projects p
							LEFT JOIN  products pd ON pd.project_id=p.project_id	
							LEFT JOIN  sales_specific ss ON ss.product_id=pd.product_id	
							LEFT JOIN sales_record sr ON sr.sales_id = ss.or_number
							LEFT JOIN project_duration pds ON pds.project_id=p.project_id
							WHERE pds.project_duration_id IS NOT NULL
							GROUP BY p.project_id ORDER BY p.project_id;";   

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
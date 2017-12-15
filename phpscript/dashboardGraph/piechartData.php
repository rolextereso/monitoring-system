<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

$query = "SELECT product_name as product, ".
			 "  SUM(ss.amount) as amount, ". 
			 "	ROUND((SUM(ss.amount)/total_revenue_all_project()*100), 2) as percentage FROM products p  ".
			 "	INNER JOIN sales_specific ss ON ss.product_id=p.product_id  ".
			 "	INNER JOIN sales_record sr ON ss.or_number=sr.sales_id ".
			 "	WHERE YEAR(sr.sold_date)=YEAR(CURRENT_DATE()) ".
			 "	GROUP BY product_name;";
    

$result = $crud->getData($query);
$record=array();

foreach($result as $key =>$row){

	$row_data=array();
     		    
		$row_data[]=$row["product"];
		$row_data[]=$row["percentage"] ;    
		$row_data[]=$row["amount"] ;    

		$record[]= $row_data;
	    
}

$json_data = array(array("data"=> $record));
echo json_encode($json_data);

?>
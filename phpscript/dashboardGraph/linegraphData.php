<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

if(isset($_GET['p']) && isset($_GET['df']) && isset($_GET['dt'])){

	$from=(empty($_GET['df']))?'2015-11-12': $crud->escape_string($_GET['df']);
	$to =(empty($_GET['dt']))?'2017-12-18': $crud->escape_string($_GET['dt']);
	$product=(empty($_GET['p']))?"":"OR p.product_name='". $crud->escape_string($_GET['p'])."'";

	$query = "SELECT product_name as product, ".
				"SUM(ss.amount)  as amount, ".
				"DATE(sr.sold_date) as sold_date FROM products p ".
				"INNER JOIN sales_specific ss ON ss.product_id=p.product_id ".
				"INNER JOIN sales_record sr ON ss.or_number=sr.sales_id ".
				"WHERE sr.sold_date>='".$from."' AND sr.sold_date<='".$to."' ".$product.
				" GROUP BY product_name, MONTH(sr.sold_date), YEAR(sr.sold_date);";
    //echo $query;
}

$result = $crud->getData($query);
$record=array();

$found=array();
foreach($result as $row){
	$row_data=array();
     	if(!in_array($row["product"],$found)){
     		    array_push($found,$row["product"]);
		    	$row_data['name']=$row["product"];
				$row_data['data'][]=array($row["sold_date"],$row["amount"]);
	       		$record[] = $row_data;
	    }elseif(in_array($row["product"],$found)){		
		    	$index =array_keys($found, $row["product"]);

				$record[$index[0]]["data"][]=array($row["sold_date"],$row["amount"]);			
		}  
	    
}
echo json_encode($record);

?>
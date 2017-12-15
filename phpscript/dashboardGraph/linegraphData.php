<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


//fetching data in descending order (lastest entry first)
$query = "SELECT product_name as product, ".
		"SUM(ss.amount)  as amount, ".
		"DATE(sr.sold_date) as sold_date FROM products p ".
		"INNER JOIN sales_specific ss ON ss.product_id=p.product_id ".
		"INNER JOIN sales_record sr ON ss.or_number=sr.sales_id ".
		"WHERE sr.sold_date>='2015-11-12' AND sr.sold_date<='2017-12-18' ".
		" GROUP BY product_name, MONTH(sr.sold_date), YEAR(sr.sold_date);";

$result = $crud->getData($query);

$record=array();
$i=0;

$found=array();
foreach($result as $row){
	$row_data=array();
     
	    if(!isset($row_data['name'])){
	    	$row_data['name']=$row["product"];
			$row_data['data']=array($row["sold_date"],$row["amount"]); 	
	    
	    }elseif($row_data['name']==$row["product"]){		
	    	array_push($found,$row["product"]);
	    	$key=array_search($row["product"], $found); 

			array_push($record[$key]["data"],array($row["sold_date"],$row["amount"]));	
	    }else{
	    	$row_data['name']=$row["product"];
			$row_data['data']=array($row["sold_date"],$row["amount"]); 	
	    }

  	  
	    $record[] = $row_data;

	      $i++;
}


echo json_encode($record);


?>
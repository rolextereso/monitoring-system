<?php
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();

function insert($array, $proj_id,$find_expr,$created_by){
			global $crud;

	   		$desc="";
	   		$result=false;
			foreach($array as $value) {
				foreach($value as $key => $val) {
					if($key==$find_expr){
						$desc=$val;
					}else{				
						 $insert="INSERT INTO project_duration(project_id, description, month,amount,created_by) ".
						 "VALUES ('{$proj_id}', '".$crud->escape_string($desc)."', '{$key}', '{$val}','{$created_by}');";

					     $result = $crud->executeUnAutoCommit($insert);		
					}			
				}				
			}
			return $result;			
}

function insertPriceForProduct($product_price,$project_id,$created_by){
	$product_name="";
		$prices=0;
		$unit="";
		global $crud;

	foreach($product_price as $value) {
				foreach($value as $key => $val) {
					if($key=="items"){
						$product_name=$val;
					}elseif($key=="prices"){
						$prices=$val;
					}elseif($key=="unit of measurement"){
						$unit=$val;
					}		
				}
				 $result=$crud->executeUnAutoCommit("INSERT INTO product_price(price, created_by) ".
								 "VALUES ('$prices', '$created_by');");

				 $product_id= $crud->getData("SELECT LAST_INSERT_ID() AS insert_id");
				 if(count($product_id)>0){
				 		$lastId=$product_id[0]['insert_id'];
				 		$result = $crud->executeUnAutoCommit("INSERT INTO products(product_name,product_price, 	project_id, unit_of_measurement,created_by) ".
									 "VALUES ('$product_name', '$lastId', '$project_id', '$unit','$created_by');");		
				 }				
	}
	return $result;
}

//adding project into the database
if(isset($_POST['proj_name'])){

		$project_name = $crud->escape_string($_POST['proj_name']);
		$project_description  = $crud->escape_string($_POST['proj_desc']);
		$project_incharge  = $crud->escape_string($_POST['proj_incharge']);
		$production_cost = $_POST['prod_cost'];
		$expenses = $_POST['expenses'];
		$product_price = $_POST['prod_price'];
		$created_by=1;

		


		$insert="INSERT INTO projects(project_name, project_description, project_incharge) ".
				"VALUES ('$project_name', '$project_description','$project_incharge');";

		$result=$crud->executeUnAutoCommit($insert);

		$project_id= $crud->getData("SELECT LAST_INSERT_ID() AS insert_id");

		$result=insert($production_cost,$project_id[0]['insert_id'],'production costs',$created_by);
		$result=insert($expenses,$project_id[0]['insert_id'],'expenses',$created_by);
		$result=insertPriceForProduct($product_price,$project_id[0]['insert_id'],$created_by);

		echo print_message($result, '<strong>Success:</strong> Project information and Project budget successfully save.','<strong>Error:</strong> Not saved, please contact the developer.');	

}
?>
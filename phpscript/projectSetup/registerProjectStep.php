<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();

function insert($array, $proj_id,$find_expr,$created_by,$spec_id){
			global $crud;

	   		$desc="";
	   		$result=false;
			foreach($array as $value) {
				foreach($value as $key => $val) {
					if($key==$find_expr){
						$desc=$val;
					}else{		
						 $extra=($find_expr=='production costs')?"(production costs)":"";		
						 $insert="INSERT INTO project_budget(project_specific_id,project_id, description,amount,created_by) VALUES('$spec_id','{$proj_id}', '".$crud->escape_string($desc)." $extra',  '".str_replace(",","",$val)."','{$created_by}');";
						  
					     $result = $crud->executeUnAutoCommit($insert);		
					}			
				}				
			}
			return $result;			
}

function insertPriceForProduct($product_price,$project_id,$created_by,$spec_id){
	    $product_name="";
		$prices=0;
		$unit="";
		$for_gate_pass="";
		global $crud;

	foreach($product_price as $value) {
				foreach($value as $key => $val) {
					if($key=="items"){
						$product_name=$val;
					}elseif($key=="prices"){
						$prices=str_replace(",","",$val);
					}elseif($key=="unit of measurement"){
						$unit=$val;
					}elseif($key=="gate pass value"){
						$for_gate_pass=$val;
					}		
				}
				 $result=$crud->executeUnAutoCommit("INSERT INTO product_price(price, created_by) ".
								 "VALUES ('$prices', '$created_by');");

				 $product_id= $crud->getData("SELECT LAST_INSERT_ID() AS insert_id");
				 if(count($product_id)>0){
				 		$lastId=$product_id[0]['insert_id'];
				 		$result = $crud->executeUnAutoCommit("INSERT INTO products(product_name,product_price, 	project_id, unit_of_measurement,created_by,project_specific_id,for_gate_pass) VALUES ('$product_name', '$lastId', '$project_id', '$unit','$created_by','$spec_id','$for_gate_pass');");		
				 }				
	}
	return $result;
}


$result=array();
//adding project into the database
if(isset($_POST['proj_name'])){

		$project_name = $crud->escape_string($_POST['proj_name']);
		$project_description  = $crud->escape_string($_POST['proj_desc']);
		$project_incharge  = $crud->escape_string($_POST['proj_incharge']);
		$project_type  = $crud->escape_string($_POST['proj_type']);
		$project_started  = $crud->escape_string($_POST['proj_started']);
		$project_ended = $crud->escape_string($_POST['proj_ended']);
		$production_cost = $_POST['prod_cost'];
		$expenses = $_POST['expenses'];
		$product_price = $_POST['prod_price'];
		$created_by=$_SESSION['user_id'];		
		$spec_id=date('y-mdsi');

		//add new project
		$project_id_=$_POST['project_id'];

		if($_POST['project_id']==""){

			$insert="INSERT INTO projects(project_type,project_name, project_description, project_incharge,created_by)
					 VALUES ('$project_type','$project_name', '$project_description','$project_incharge','$created_by');";

			$result[]=$crud->executeUnAutoCommit($insert);

			$project_id= $crud->getData("SELECT LAST_INSERT_ID() AS insert_id");
			$project_id_=$project_id[0]['insert_id'];

			$insert_duration="INSERT INTO project_duration(project_specific_id,from_date, to_date, 
										created_by,project_id)  
			         VALUES ('$spec_id','$project_started', '$project_ended','$created_by','$project_id_');";

			$result[]=$crud->executeUnAutoCommit($insert_duration);

			

			$result[]=insert($production_cost,$project_id_,'production costs',$created_by,$spec_id);
			$result[]=insert($expenses,$project_id_,'expenses',$created_by,$spec_id);
			$result[]=insertPriceForProduct($product_price,$project_id_,$created_by,$spec_id);
		}else{

			$update_current="UPDATE project_duration SET status='N' WHERE project_id='$project_id_';";

			$result[]=$crud->executeUnAutoCommit($update_current);

			$insert_duration="INSERT INTO project_duration(project_specific_id,from_date, to_date, 
										created_by,project_id)  
			         		  VALUES ('$spec_id','$project_started', '$project_ended','$created_by','$project_id_');";

			$result[]=$crud->executeUnAutoCommit($insert_duration);

			$result[]=insert($production_cost,$project_id_,'production costs',$created_by,$spec_id);
			$result[]=insert($expenses,$project_id_,'expenses',$created_by,$spec_id);
			$result[]=insertPriceForProduct($product_price,$project_id_,$created_by,$spec_id);
		}
		

		echo print_message(!in_array("", $result), '<strong>Success:</strong> Project information and Project budget successfully save.','<strong>Error:</strong> Not saved, <br/>1. Check if the project already exists. <br/>If it is still occur, please contact the developer.');	

}
?>
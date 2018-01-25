<?php
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$query = "SELECT * FROM location_marks";    

$result = $crud->getData($query);

$data=array();
foreach($result as $row){
	$row_data=array();  
	$establisment=$row["establisment_name"];
	$row_data['id_marks']=$row['id_marks'];   	
	$row_data['position_marks']=$row["position_marks"];
	$row_data['image']		   =$row["image"];
	$row_data['establisment']  =$establisment; 
	$data[]=$row_data;
	    
}
echo json_encode($data);
?>
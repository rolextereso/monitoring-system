<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
//search variable for project status value 'Y' or 'N'
$search="";

$columns = array( 
// datatable column index  => database column name
	0 =>'item_code', 
	1 =>'item_name', 
	2 =>'rental_fee', 
	
);

//this will get the total row of the query;
$sql = "SELECT * FROM rental_items ";

$result = $crud->getData($sql);
$totalData= count($result);
$totalFiltered = $totalData;


$sql = "SELECT * FROM rental_items ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter	
	$sql.=" WHERE (item_name LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR item_code LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rental_fee LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR item_description LIKE '".$requestData['search']['value']."%' )";
	
}

$result = $crud->getData($sql);
$totalFiltered = $totalData;; 

$sql.="  ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$result = $crud->getData($sql);

$data=array();
$count=1;
foreach($result as $key =>$row){
	$nestedData=array(); 

	$nestedData[] = $row["item_code"];    
	$nestedData[] =$row["item_name"]."(".$row['item_description'].")";
	$nestedData[] =$row["rental_fee"];
	$nestedData[] =($row["availability"]=='Y')?"<span class='badge badge-success'>Available</span>":"<span class='badge badge-danger'>Unavailable</span>";
	$nestedData[] =($row["per_day"]=='Y')?'<i class="fa fa-check green"></i>':'<i class="fa fa-times red"></i>';
	$nestedData[] =($row["need_gate_pass"]=='Y')?'<i class="fa fa-check green"></i>':'<i class="fa fa-times red"></i>';
	$nestedData[] =($row["status"]=='Y')?'<i class="fa fa-check green"></i>':'<i class="fa fa-times red"></i>';
	$nestedData[] = "<a href='rental-register.php?r_id=".$row['rental_id']."'><i class='fa fa-pencil'></i></a>";
	
	$data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

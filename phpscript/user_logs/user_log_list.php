<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
//search variable for project status value 'Y' or 'N'
$search="";

$columns = array( 
// datatable column index  => database column name
	0 => 'msg', 
	1 => 'created_on',
	
);


$sql = "SELECT msg, ul.created_on, firstname, lastname
		FROM user_log ul 
		INNER JOIN users u ON u.user_id= ul.user_id 
		WHERE u.user_id ".specific_user(access_role("User Logs","view_command",$_SESSION['user_type']));


$result = $crud->getData($sql);
$totalData= count($result);
$totalFiltered=$totalData;

$sql=$sql;

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	if($requestData['search']['value']=='active'){
		$search='Y';
	}else{
		$search='N';
	}
	$sql.=" AND (msg LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR ul.created_on LIKE '".$requestData['search']['value']."%' )";
}

$result = $crud->getData($sql);
$totalFiltered=$totalData;

$sql.=" ORDER BY ul.created_on DESC , ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";


$result = $crud->getData($sql);
$data=array();

foreach($result as $key =>$row){
	
	$nestedData=array(); 

	$nestedData[] = $row["msg"];
	$nestedData[] = $row["firstname"]." ".$row['lastname'];
   	$nestedData[] = Date('F d, Y H:i:s a', strtotime($row["created_on"]));
	
	$data[] = $nestedData;
}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

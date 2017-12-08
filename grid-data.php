
<?php
//including the database connection file
include_once("classes/Crud.php");
 
$crud = new Crud();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'employee_name', 
	1 => 'employee_salary',
	2=> 'employee_age'
);

//fetching data in descending order (lastest entry first)
$query = "SELECT * FROM employee";
$result = $crud->getData($query);

$totalData= count($result);
$totalFiltered=$totalData;

$sql = "SELECT employee_name, employee_salary, employee_age ";
$sql.=" FROM employee WHERE 1=1";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( employee_name LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR employee_salary LIKE '".$requestData['search']['value']."%' ";

	$sql.=" OR employee_age LIKE '".$requestData['search']['value']."%' )";
}

$result = $crud->getData($sql);
$totalFiltered = count($result); 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$result = $crud->getData($sql);

$data=array();

foreach($result as $key =>$row){
	$nestedData=array(); 

	$nestedData[] = $row["employee_name"];
	$nestedData[] = $row["employee_salary"];
	$nestedData[] = $row["employee_age"];
	
	$data[] = $nestedData;
}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

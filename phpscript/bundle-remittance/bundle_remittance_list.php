<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'order_payment_id'
	
);


//fetching data in descending order (lastest entry first)
$query = "SELECT *  FROM bundle_remittance WHERE status='Y'  ";
$result = $crud->getData($query);

$totalData= count($result);
$totalFiltered=$totalData;

$sql = $query;

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND order_payment_id LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR product_involve LIKE '".$requestData['search']['value']."%' ";
	
}

$result = $crud->getData($sql);
$totalFiltered = count($result); 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$result = $crud->getData($sql);

$data=array();


$command="";
foreach($result as $key =>$row){
	$nestedData=array(); 
  
	$nestedData[] = $row["order_payment_id"];
	$nestedData[] = $row["product_involve"];
	$nestedData[] = ($row["status"]=='Y')?'<i class="fa fa-check green"></i>':'<i class="fa fa-times red"></i>';


	if($_SESSION['user_type']=='1'){
		$command = "<a title='Edit ID' href='bundle-remittance-add-op.php?id=".$row["remittance_id"]."' class='edit btn btn-primary'><i class='fa fa-pencil'></i></a> ";
	}

	$nestedData[] = $command;
	
	$data[] = $nestedData;
}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format


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
	0 =>'transaction_id', 
	1 =>'customer_name', 
	2 =>'customer_address', 
	
);

//this will get the total row of the query;
$sql = "SELECT 
			    ri.transaction_id,   
				c.customer_name,
				c.customer_address,
                GROUP_CONCAT(ri.item_name,'(',ri.item_description,')') as rented_items
                FROM rental_items ri
LEFT JOIN rental_specific rs ON rs.rental_id=ri.rental_id
INNER JOIN customer c ON c.customer_id=rs.customer_id 
WHERE ri.availability='N' AND ri.created_by={$_SESSION['user_type']} AND (date_returned IS NULL OR date_returned ='') ";

$result = $crud->getData($sql);
$totalData= count($result);
$totalFiltered = $totalData;


$sql = $sql;

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter	
	$sql.=" AND (ri.item_name LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR c.customer_name LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR c.customer_address LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR ri.transaction_id LIKE '".$requestData['search']['value']."%' )";
	
}

$result = $crud->getData($sql);
$totalFiltered = $totalData;; 

$sql.=" GROUP BY ri.transaction_id  ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";


$result = $crud->getData($sql);

$data=array();
$count=1;

$access=access_role("Rented Items","view_command",$_SESSION['user_type']);

foreach($result as $key =>$row){
	$nestedData=array(); 

	$nestedData[] = $row["transaction_id"];
	$nestedData[] = $row["customer_name"];        
	$nestedData[] = $row["customer_address"];
	$nestedData[] = $row["rented_items"];                
	$nestedData[] = ($access)?"<a href='rental-return.php?t_id=".$row['transaction_id']."' title='Return Items'><i class='fa fa-arrow-left'></i></a>":"";
	
	$data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

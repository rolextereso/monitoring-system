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
	0 =>'transaction_id', 
	1 =>'customer_name', 
	2 =>'customer_address', 
	
);

//this will get the total row of the query;
$sql = "SELECT sr.sales_id,transaction_id, customer_name, customer_address FROM sales_specific ss "
		."INNER JOIN sales_record sr ON ss.or_number=sr.sales_id "
		."INNER JOIN customer c ON c.customer_id =sr.customer_id "
		."WHERE ss.paid='N' AND sr.or_number ='' GROUP BY ss.transaction_id ";

$result = $crud->getData($sql);
$totalData= count($result);
$totalFiltered = $totalData;


$sql = "SELECT sr.sales_id,transaction_id, customer_name, customer_address FROM sales_specific ss "
		."INNER JOIN sales_record sr ON ss.or_number=sr.sales_id "
		."INNER JOIN customer c ON c.customer_id =sr.customer_id "
		."WHERE ss.paid='N' AND sr.or_number ='' ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter	
	$sql.=" AND (transaction_id LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR customer_name LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR customer_address LIKE '".$requestData['search']['value']."%' )";
	
}

$result = $crud->getData($sql);
$totalFiltered = $totalData;; 

$sql.=" GROUP BY ss.transaction_id ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$result = $crud->getData($sql);

$data=array();
$count=1;
foreach($result as $key =>$row){
	$nestedData=array(); 

	$nestedData[] = $row["transaction_id"];    
	$nestedData[] =$row["customer_name"];
	$nestedData[] =$row["customer_address"];

	
	$nestedData[] = "<a href='item-buy.php?transaction_id=".$row['transaction_id']."'><i class='fa fa-money'></i></a>";
	
	$data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

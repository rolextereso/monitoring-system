
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
	0 =>'or_number', 
	1 => 'customer_name',
	2=> 'customer_address'
);

//fetching data in descending order (lastest entry first)
$query = "SELECT or_number FROM sales_record sr ".
		 "INNER JOIN customer c ON c.customer_id =sr.customer_id";
$result = $crud->getData($query);

$totalData= count($result);
$totalFiltered=$totalData;

$sql = "SELECT sales_id, or_number, customer_name, customer_address, printing_status FROM sales_record sr ".
	   "INNER JOIN customer c ON c.customer_id =sr.customer_id ";
$sql.=" WHERE 1=1";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	if($requestData['search']['value']=='active'){
		$search='Y';
	}else{
		$search='N';
	}
	$sql.=" AND ( customer_name LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR customer_address LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR printing_status LIKE '".$search."%' ";
	$sql.=" OR or_number LIKE '".$requestData['search']['value']."%' )";
}


$result = $crud->getData($sql);
$totalFiltered = count($result); 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$result = $crud->getData($sql);

$data=array();
$count=1;
foreach($result as $key =>$row){
	$nestedData=array(); 

	$nestedData[] = $row["or_number"];
    $nestedData[] = $row["customer_name"];
	$nestedData[] = $row["customer_address"];

	$nestedData[] = ($row["printing_status"]=='Y')?'<i class="fa fa-check green"></i>':'<i class="fa fa-times red"></i>';
	
	$nestedData[] = "<a href='javascript:void(0);' onclick=WindowPopUp('phpscript/gatepass/gatePassPrint.php?or_id=".$row['sales_id']."','print','480','450',windowClose)><i class='fa fa-paper-plane'></i></a>";
	
	$data[] = $nestedData;
}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

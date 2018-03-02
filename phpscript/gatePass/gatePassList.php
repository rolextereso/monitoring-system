
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
	0 =>'sr.or_number', 
	1 => 'customer_name',
	2=> 'customer_address'
);

// $sql = "SELECT sales_id, or_number, customer_name, customer_address, printing_status, date_save FROM sales_record sr ".
// 	   "INNER JOIN customer c ON c.customer_id =sr.customer_id ";
// $sql.=" WHERE or_number!='' ";


$sql = "SELECT sr.sales_id,
		sr.or_number, 
		sr.printing_status, 
		sr.date_save,
        customer_name, 
        customer_address,
        sr.date_save,
        rit.transaction_id
		FROM sales_record sr
		LEFT JOIN  sales_specific ss  ON ss.or_number=sr.sales_id 
		LEFT JOIN customer c ON c.customer_id =sr.customer_id 
		LEFT JOIN  rental_specific rsp ON rsp.sales_id=sr.sales_id
		LEFT JOIN  products p ON p.product_id=ss.product_id     
        LEFT JOIN  rental_items rit ON rit.rental_id=rsp.rental_id     
		WHERE (ss.paid='Y' OR  rsp.paid='Y') AND sr.or_number !='' AND (p.for_gate_pass='Y' OR rit.need_gate_pass='Y') ";

$result = $crud->getData($sql);
$totalData= count($result);
$totalFiltered = $totalData; 

$sql = $sql;
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( customer_name LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR customer_address LIKE '".$requestData['search']['value']."%' ";	
	$sql.=" OR sr.or_number LIKE '".$requestData['search']['value']."%' )";
}

$result = $crud->getData($sql);
$totalData= count($result);
$totalFiltered = $totalData; 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$result = $crud->getData($sql);


$data=array();
$count=1;
foreach($result as $key =>$row){
	$nestedData=array(); 
	$target_gate_pass= ($row['transaction_id']=='')?"sales":"rental";
	$nestedData[] = $row["or_number"];
    $nestedData[] = $row["customer_name"];
	$nestedData[] = $row["customer_address"];
	$nestedData[] = date_format(date_create($row['date_save']), 'F d, Y h:i:s a');

	$nestedData[] = ($row["printing_status"]=='Y')?'<i class="fa fa-check green"></i>':'<i class="fa fa-times red"></i>';
	
	$nestedData[] = "<a href='javascript:void(0);' onclick=WindowPopUp('phpscript/gatepass/gatePassPrint.php?or=".$row['or_number']."&specific=".$target_gate_pass."','print','480','450',windowClose)><i title='Print Gate Pass' class='fa fa-print'></i></a>";
	
	$data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

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
	0 =>'ss.transaction_id', 
	1 =>'customer_name', 
	2 =>'customer_address', 
	
);
$authorized_view=" AND user_id ".specific_user(access_role("Transaction List","view_command",$_SESSION['user_type']));
//this will get the total row of the query;
$sql = "SELECT sr.sales_id,
		ss.transaction_id as sales_transaction_id, 
		rsp.transaction_id as rental_transaction_id, 
        customer_name, 
        customer_address 
		FROM sales_record sr
		LEFT JOIN  sales_specific ss  ON ss.or_number=sr.sales_id 
		LEFT JOIN customer c ON c.customer_id =sr.customer_id 
		LEFT JOIN  rental_specific rsp ON rsp.sales_id=sr.sales_id
        LEFT JOIN  rental_items rit ON rit.rental_id=rsp.rental_id
      
		WHERE (ss.paid='N' OR  rsp.paid='N' ) AND (rsp.canceled='N' or ss.canceled='N') AND sr.or_number ='' $authorized_view GROUP BY ss.transaction_id, rsp.transaction_id ";

$result = $crud->getData($sql);
$totalData= count($result);
$totalFiltered = $totalData;


$sql = "SELECT sr.sales_id,
		c.customer_id,
		ss.transaction_id as sales_transaction_id, 
		rsp.transaction_id as rental_transaction_id, 
        CASE WHEN count(ss.transaction_id)>1 THEN CONCAT(customer_name,' etc.') ELSE customer_name END  AS customer_name, 
        CASE WHEN count(ss.transaction_id)>1 THEN CONCAT(customer_address,' etc.') ELSE customer_address END  AS customer_address,
		(CASE WHEN rit.rental_id IS NOT  NULL THEN 'rental' ELSE 'sales' END) AS specific_,
		bm.order_payment_id
		FROM sales_record sr
		LEFT JOIN  sales_specific ss  ON ss.or_number=sr.sales_id 
		LEFT JOIN customer c ON c.customer_id =sr.customer_id 
		LEFT JOIN  rental_specific rsp ON rsp.sales_id=sr.sales_id
        LEFT JOIN  rental_items rit ON rit.rental_id=rsp.rental_id 
        LEFT JOIN  bundle_remittance bm ON bm.order_payment_id=ss.transaction_id    
		WHERE (ss.paid='N' OR  rsp.paid='N' ) AND (rsp.canceled='N' or ss.canceled='N') AND sr.or_number ='' $authorized_view ";



if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter	
	$sql.=" AND (ss.transaction_id LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rsp.transaction_id LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR customer_name LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR customer_address LIKE '".$requestData['search']['value']."%' )";
	
}

$result = $crud->getData($sql);
$totalData= count($result);
$totalFiltered = $totalData; 

$sql.="  GROUP BY 
			(case when ss.transaction_id = (SELECT order_payment_id FROM bundle_remittance WHERE remittance_id=1) then CONCAT(c.customer_id , ss.transaction_id) else ss.transaction_id end),
			(case when rsp.transaction_id = (SELECT order_payment_id FROM bundle_remittance WHERE remittance_id=1)  then CONCAT(c.customer_id , rsp.transaction_id) else rsp.transaction_id end)

          ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

//echo $sql;

$result = $crud->getData($sql);

$data=array();
$count=1;
foreach($result as $key =>$row){
	$nestedData=array(); 

	$access=access_role("Transaction List","save_changes",$_SESSION['user_type']);
	
	
	$transaction_id_row=($row["sales_transaction_id"]!=null)?$row["sales_transaction_id"]
						:$row["rental_transaction_id"];
	$transaction_id_link=($row["sales_transaction_id"]!=null)?$row["sales_transaction_id"].'@:'.$row['customer_id']
						:$row["rental_transaction_id"].'@:'.$row['customer_id'];
	$url=($row['specific_']=="sales")?	"item-selection":"item-selection-rental";				
	$cancel=($row['order_payment_id']!=null)?"": " | <a href='$url.php?transaction_id=".$transaction_id_row."'><i title='Click to modify transaction' class='fa fa-pencil'></i></a>";
	
	$nestedData[] =$transaction_id_row;    
	$nestedData[] =$row["customer_name"];
	$nestedData[] =$row["customer_address"];
	$nestedData[] = ($access)?
							"<a href='item-buy.php?transaction_id=".$transaction_id_link."'><i title='Click to open Transaction' class='fa fa-money'></i></a> |
							 <a href='javascript:void(0);' onclick=WindowPopUp('phpscript/savePayment/printCertification.php?id=".$transaction_id_link."&for=".$row['specific_']."','print','480','450')><i title='Click to view or print Order of Payment Receipt' class='fa fa-file-text'></i></a> ".$cancel

							
							 : 
							   "<a href='javascript:void(0);' onclick=WindowPopUp('phpscript/savePayment/printCertification.php?id=".$transaction_id_link."&for=".$row['specific_']."','print','480','450')><i title='Click to print receipt' class='fa fa-file-text'></i></a> ".$cancel;
	
	$data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

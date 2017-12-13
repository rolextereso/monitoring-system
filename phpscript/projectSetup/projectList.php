
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
	0 =>'project_name', 
	1 => 'project_description',
	2=> 'project_status', 
	3=> 'project_incharge'
);

//fetching data in descending order (lastest entry first)
$query = "SELECT * FROM projects";
$result = $crud->getData($query);

$totalData= count($result);
$totalFiltered=$totalData;

$sql = "SELECT pd.product_id,pr.project_id, price, product_name, project_name, project_description, CONCAT(firstname,' ',lastname) AS incharge, pd.product_status  ";
$sql.=" FROM projects pr";
$sql.=" INNER JOIN products pd ON pd.project_id= pr.project_id ";
$sql.=" INNER JOIN product_price pc ON pc.price_id= pd.product_price ";
$sql.=" INNER JOIN users u ON u.user_id= pr.project_incharge ";
$sql.=" WHERE 1=1";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	if($requestData['search']['value']=='active'){
		$search='Y';
	}else{
		$search='N';
	}
	$sql.=" AND ( project_name LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR project_description LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR project_status LIKE '".$search."%' ";
	$sql.=" OR project_incharge LIKE '".$requestData['search']['value']."%' )";
}


$result = $crud->getData($sql);
$totalFiltered = count($result); 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$result = $crud->getData($sql);

$data=array();
$count=1;
foreach($result as $key =>$row){
	$nestedData=array(); 

	$nestedData[] = $row["product_name"];
    $nestedData[] = $row["project_name"]." <small><a href='project-register.php?edit=".$row['project_id']."'>[edit]</a></small>";
	$nestedData[] = $row["project_description"];
	$nestedData[] = $row["incharge"];
	$nestedData[] = ($row["product_status"]=='Y')?'<i class="fa fa-check green"></i>':'<i class="fa fa-times red"></i>';
	$nestedData[] = "&#8369; ".$row["price"];
	$nestedData[] = "<a href='product-register.php?edit=".$row['product_id']."'><i class='fa fa-pencil'></i></a>";
	
	$data[] = $nestedData;
}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

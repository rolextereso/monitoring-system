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
	0 =>'project_name', 
	1 => 'project_type',
	2=> 'project_status', 
	3=> 'project_incharge'
);


$sql = "SELECT pd.product_id,pr.project_id, price, product_name, project_name, project_type, CONCAT(firstname,' ',lastname) AS incharge, pd.product_status  ";
$sql.=" FROM projects pr";
$sql.=" INNER JOIN products pd ON pd.project_id= pr.project_id ";
$sql.=" INNER JOIN project_duration pr_d ON pr_d.project_specific_id=pd.project_specific_id";
$sql.=" INNER JOIN product_price pc ON pc.price_id= pd.product_price ";
$sql.=" INNER JOIN account u ON u.user_id= pr.project_incharge WHERE pr_d.status='Y' AND ( pr.created_by ".specific_user(access_role("Project List","view_command",$_SESSION['user_type'] ))." OR pr.project_incharge ".specific_user(access_role("Project List","view_command",$_SESSION['user_type'])).")";



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
	$sql.=" AND (project_name LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR project_description LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR project_status LIKE '".$search."%' ";
	$sql.=" OR u.LastName LIKE '".$requestData['search']['value']."%'  ";
	$sql.=" OR u.FirstName LIKE '".$requestData['search']['value']."%')  ";
}

$result = $crud->getData($sql);
$totalData= count($result);
$totalFiltered=$totalData;

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";


$result = $crud->getData($sql);


$data=array();
$count=1;

$access_edit=access_role("Project List","edit_command",$_SESSION['user_type']);


foreach($result as $key =>$row){
	$edit_project=($access_edit)?" <small><a href='project-register.php?edit=".$row['project_id']."'>[edit]</a></small>":"";
    $edit_product=($access_edit)?" <a href='product-register.php?edit=".$row['product_id']."'><i class='fa fa-pencil'></i></a>":"";

	$nestedData=array(); 

	$nestedData[] = $row["product_name"];
    $nestedData[] = $row["project_name"].$edit_project.
    				"<span class='view-project'>".
    					"<a title='View Budgeted List' href='project-list-spec.php?id=".$row['project_id']."'>".
    						"<i class='fa fa-ellipsis-h'></i>".
    					"</a></span>";
	$nestedData[] = $row["project_type"];
	$nestedData[] = $row["incharge"];
	$nestedData[] = ($row["product_status"]=='Y')?'<i class="fa fa-check green"></i>':'<i class="fa fa-times red"></i>';
	$nestedData[] = "&#8369; ".number_format($row["price"],2);
	$nestedData[] = "$edit_product";
	
	$data[] = $nestedData;
}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

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
	2 => 'project_incharge'
);


$sql = "SELECT project_id,project_name,project_type, project_description, CONCAT(firstname,' ',lastname) AS incharge, project_status  ";
$sql.=" FROM projects pr";
$sql.=" INNER JOIN account u ON u.user_id= pr.project_incharge WHERE pr.project_status='Y' AND ( pr.created_by ".specific_user(access_role("Project List","view_command",$_SESSION['user_type'] ))." OR pr.project_incharge ".specific_user(access_role("Project List","view_command",$_SESSION['user_type'])).")";



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
	$sql.=" OR FirstName LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR LastName LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR project_status LIKE '".$search."%' ";
	$sql.=" OR project_incharge LIKE '".$requestData['search']['value']."%')  ";
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
	$edit_project=($access_edit)?"<a href='project-register.php?edit=".$row['project_id']."&assigned=true'><i class='fa fa-pencil'></i></a>":"";
   

	$nestedData=array(); 

	$nestedData[] = $row["project_name"];
	$nestedData[] = $row["project_type"];
	$nestedData[] = $row["incharge"];
	$nestedData[] = ($row["project_status"]=='Y')?'<i class="fa fa-check green"></i>':'<i class="fa fa-times red"></i>';	
	$nestedData[] = "$edit_project";
	
	$data[] = $nestedData;
}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

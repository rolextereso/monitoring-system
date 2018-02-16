
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
	0 =>'project_specific_id', 
	
);

//fetching data in descending order (lastest entry first)
$sql = "SELECT pb.created_on, project_duration_id,p.project_id, pb.project_specific_id, to_date as date_to, from_date as date_from, CONCAT(firstname,' ',lastname) AS saved_by, pd.status";
$sql.=" FROM project_budget pb";
$sql.=" INNER JOIN project_duration pd ON pd.project_specific_id=pb.project_specific_id  ";
$sql.=" INNER JOIN projects p ON p.project_id=pb.project_id  ";
$sql.=" INNER JOIN account u ON u.user_id= pb.created_by ";
$sql.=" WHERE pb.project_id=".$requestData['id']." ";



$result = $crud->getData($sql);
$totalData= count($result);
$totalFiltered=$totalData;

$sql=$sql;

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter	 
	$sql.=" AND (project_specific_id LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR month LIKE '".$search."%')";
	
}

$result = $crud->getData($sql);
$totalFiltered=$totalData;

$sql.=" GROUP BY pd.project_specific_id ORDER BY pd.status ASC, ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$result = $crud->getData($sql);

$data=array();
$count=1;

$access_delete=access_role("Project List","delete_command",$_SESSION['user_type']);
foreach($result as $key =>$row){
	$nestedData=array(); 

	$delete_=($access_delete)?"<a onclick=deleteBudget('".$row['project_specific_id']."'); href='#'><i class='fa fa-trash-o'></i></a>":"";

	$nestedData[] = $row["project_specific_id"];
    
	$nestedData[] = date("M Y", strtotime($row["date_from"]));
	$nestedData[] = date("M Y", strtotime($row["date_to"]));
	$nestedData[] =$row["saved_by"];
	$nestedData[] =$row["created_on"];
	$nestedData[] =($row["status"]=="Y")?"<span class='green'><b>Current</b></span>":"<span>Archive</span>";

	
	$nestedData[] = "<a href='project-budget-spec.php?b_id=".$row['project_specific_id']."&p_id=".$row['project_id']."'><i class='fa fa-folder-open-o'></i></a> $delete_";
	
	$data[] = $nestedData;
}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

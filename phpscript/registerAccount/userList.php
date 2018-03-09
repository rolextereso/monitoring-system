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
	0 =>'FirstName', 
	1 => 'LastName',
	2=> 'username'
);
$where_="WHERE u.user_id=".$_SESSION['user_id']."  AND IGP='9' ";
if($_SESSION['user_type']=='1'){
	$where_=" WHERE IGP='9' ";
}else if($_SESSION['user_type']=='7'){
	$where_=" WHERE (u.user_id=".$_SESSION['user_id']."  OR u.user_type='2') AND IGP='9' ";
}

//fetching data in descending order (lastest entry first)
$query = "SELECT *  FROM account u LEFT JOIN user_type ut ON u.user_type=ut.user_type_id $where_";
$result = $crud->getData($query);

$totalData= count($result);
$totalFiltered=$totalData;

$sql = "SELECT u.*, ut.user_type as type_of_user ";
$sql.=" FROM account u LEFT JOIN user_type ut ON u.user_type=ut.user_type_id  $where_";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( FirstName LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR LastName LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR ut.user_type LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR username LIKE '".$requestData['search']['value']."%' )";
}

$result = $crud->getData($sql);
$totalFiltered = count($result); 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";


$result = $crud->getData($sql);
//echo $sql;

$data=array();



foreach($result as $key =>$row){
	$nestedData=array(); 
    $nestedData[] = "<img src='".($row["profile_pic"]==''?'img/pic_avatar.jpg':$row["profile_pic"])."' width='20' height='20'/>";
	$nestedData[] = $row["FirstName"];
	$nestedData[] = $row["LastName"];
	$nestedData[] = $row["username"];
	$nestedData[] = $row["type_of_user"];
	$nestedData[] = ($row["status"]=='Y')?'<i class="fa fa-check green"></i>':'<i class="fa fa-times red"></i>';


	$command= "<a title='Edit Profile' href='user-edit.php?u=".$row["userid"]."' class='edit btn btn-success'><i class='fa fa-pencil-square-o'></i></a>&nbsp;";

	if($_SESSION['user_type']=='1'){
		$command .= "<a title='Reset Password' href='user-reset-pass.php?u=".$row["userid"]."' class='edit btn btn-danger'><i class='fa fa-cog'></i></a> ";
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

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
	0 =>'pr_no', 
	1 =>'entity_name', 
	2 =>'purpose', 
	
);

$sql = "SELECT pr.*,p.project_name, CONCAT(u.firstname,' ',u.lastname) as user FROM purchase_request pr	 		
        INNER JOIN project_duration pd ON pd.project_duration_id=pr.project_duration_id       
		INNER JOIN projects p ON p.project_id= pd.project_id
		INNER JOIN account u ON u.user_id= pr.created_by  where p.project_incharge ".specific_user(access_role("Purchase Requests","view_command",$_SESSION['user_type']));


$result = $crud->getData($sql);
$totalData= count($result);
$totalFiltered = $totalData;


$sql=$sql;

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter	
	$sql.=" AND (entity_name LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR purpose LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR item_description LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR pr_no LIKE '".$requestData['search']['value']."%' )";
	
}

$result = $crud->getData($sql);
$totalFiltered = $totalData;; 

$sql.="  GROUP BY pr.pr_no  ORDER BY pr.created_on DESC, ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$result = $crud->getData($sql);

$data=array();
$count=1;
$approved="";

foreach($result as $key =>$row){
	$nestedData=array(); 

	//$access=access_role("Rental Item List","edit_command",$_SESSION['user_type']);
	$once_approved="";
	if($row['approved']=='O'){
		$approved='<span class="badge badge-warning">On Process</span>';
	}else if($row['approved']=='Y'){
		$approved='<span class="badge badge-success">Approved</span>';
		if(access_role("Purchase Requests","save_changes",$_SESSION['user_type'])){
			$once_approved="<a href='purchased_request_save_approved.php?pr_id=".$row['pr_no']."'><i class='fa fa-file-o'></i></a>";
	    }
	}else{
		$approved='<span class="badge badge-danger">Disapproved</span>';

	}

	$nestedData[] =$row["pr_no"];    
	$nestedData[] =$row["entity_name"];
	$nestedData[] =$row["project_name"];
	$nestedData[] =$row["purpose"];
	$nestedData[] =$row['user'];
	$nestedData[] =Date('F d, Y',strtotime($row['created_on']));
	$nestedData[] =($row['updated_on']!="")?Date('F d, Y',strtotime($row['updated_on'])):"";
	$nestedData[] =$approved;

	$nestedData[] = "<a href='view_pr_detail.php?pr_id=".$row['pr_no']."'><i class='fa fa-folder-open-o'></i></a> 
					 $once_approved";
	
	$data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

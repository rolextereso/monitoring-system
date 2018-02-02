<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("collectionReportData.php");
 
	$out=(collectionReportData($_POST['datefrom'], $_POST['dateto'], $_POST['category'], $_POST['report_type'],$_POST["search_by"]));
	$output=array("fetch"=>true,
			      "title"=>"COLLECTION REPORT OF ".$out['category'], 
			      "search"=>$out['category'],
			      "data"=>$out['data'], 
			      "date"=>$out['date'], "total"=>$out['total'],
				  "range"=> "for the ".$out['report_type']." of <u>".$out['from_date']."</u> to <u>".$out['to_date']."</u>");
	echo json_encode($output);

?>
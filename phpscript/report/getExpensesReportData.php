<?php

//including the database connection file
include_once("../../classes/Crud.php");
include_once("expensesReportData.php");
 


$data = expensesDebit($_POST['datefrom'], $_POST['dateto'], $_POST['category'], $_POST['report_type'],$_POST["search_by"]);
$output = array("fetch"=>true,
			      "title"=>"BREAKDOWN REPORT OF ".$_POST['category'], 			     
			      "data"=>$data['data'],
			      "total"=>$data['total'],
				  "range"=> "for the ".$_POST['report_type']." of <u>".date('F d, Y',strtotime($_POST['datefrom']))."</u> to <u>".date('F d, Y',strtotime($_POST['dateto']))."</u>");

echo json_encode($output);
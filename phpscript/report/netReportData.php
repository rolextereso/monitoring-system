<?php

//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
include_once("collectionReportData.php");

$crud = new Crud();

function netReport($datefrom, $dateto, $category, $report_type,$search_by){
	global $crud;
	
	$out=collectionReportData($datefrom, $dateto, $category, $report_type,$search_by,true);
    $filter=" YEAR(eb.updated_on) >=YEAR('".$datefrom."') AND YEAR(eb.updated_on)<=YEAR('".$dateto."') ";
    if($report_type=='month'){
    	$filter=" eb.updated_on >='".$datefrom."' AND eb.updated_on<='".$dateto."' ";
    }
	$query="SELECT 
                  CASE WHEN SUM(eb.qty*eb.amount_per_unit) IS NULL 
                         THEN 0 
                        ELSE SUM(eb.qty*eb.amount_per_unit) 
                        END AS expenses_tendered,
				  pb.description FROM project_budget pb
                  LEFT JOIN project_duration pd ON pb.project_specific_id =pd.project_specific_id
                  LEFT JOIN purchase_request pr ON pr.project_budget_id=pb.project_budget_id
                  LEFT JOIN expenses_breakdown eb ON eb.purchase_request_id=pr.purchase_request_id
                  WHERE (pd.project_id='".$search_by."' 
                  AND pd.status='Y' AND $filter ) OR (eb.updated_on IS NULL AND pd.project_id='".$search_by."')
                  GROUP BY pb.project_budget_id 
                  ORDER BY pb.project_budget_id ASC;";
    //echo $query;
    $expenses = $crud->getData($query);        

    $actual_expenses=array();

	foreach($expenses as $key =>$row){
		$nestedData=array(); 
		$nestedData[] = $row["description"];    
		$nestedData[] = $row["expenses_tendered"];   	
		$actual_expenses[] = $nestedData;

	}


	$output=array("fetch"=>true,
				  'category'=>$out['category'],
			      "title"=>"PROJECT NET PROFIT REPORT", 
			      "search"=>$out['category'],
			      "total"=>$out['total'],
			      "data"=>$out['data'], 
			      "date"=>$out['date'], "total"=>$out['total'],
			      "expenses"=>$actual_expenses,
				  "range"=> "for the ".$out['report_type']." of <u>".$out['from_date']."</u> to <u>".$out['to_date']."</u>");
	return ($output);

}



?>
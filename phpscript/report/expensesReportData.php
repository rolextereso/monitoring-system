<?php

//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();

function expensesDebit($dateFrom, $dateTo, $category, $report_type,$searchBy){
	  global $crud;
	  if(isset($dateFrom) && isset($dateTo)){
		$search_by=$searchBy;
		$search_val="";
		if($category=='EXPENSES' && $search_by!=""){		
			$search_val=" AND p.project_id=".$search_by;
		}


		$where=($dateFrom!='' && $dateTo!='')?" WHERE DATE(pr.updated_on)>='".$dateFrom."' AND DATE(pr.updated_on)<='".$dateTo."'  ".$search_val:" ";

		$approved_date="";
		$date_format="";
					if($report_type=='month'){
						$approved_date=" DATE_FORMAT(pr.updated_on,'%b. %Y') as approved_date";
						$date_format="F d, Y ";
					}else{
						$approved_date=" YEAR(pr.updated_on) as approved_date";
						$date_format="Y";
					}
	
		$sql = "SELECT 	item_description as item_description, 	
					eb.qty, 
					eb.amount_per_unit,
					qty*amount_per_unit as unit_cost, 		
					 $approved_date	
					FROM projects p        
					LEFT JOIN project_duration pd ON pd.project_id=p.project_id			
					LEFT JOIN purchase_request pr ON pr.project_duration_id=pd.project_duration_id
					LEFT JOIN expenses_breakdown eb ON eb.purchase_request_id=pr.purchase_request_id
					$where 		
					GROUP BY  eb.id, MONTH(pr.updated_on), YEAR(pr.updated_on) 
					ORDER BY item_description, pr.updated_on;";

        

		$result = $crud->getData($sql);

		$data=array();
		$total=0;
		$date_approved_="";
		foreach($result as $key =>$row){
			$nestedData=array(); 		
		    
			$total+=$row["unit_cost"];
			$nestedData[] = $row["item_description"];   
			$nestedData[] = $row["qty"];   
			$nestedData[] = number_format($row["amount_per_unit"],2);   
			$nestedData[] = number_format($row["unit_cost"],2);    
			$nestedData[] = $row["approved_date"];    
			
			
			$data[] = $nestedData;
		}

		$result=array('data'=>$data,'total'=>number_format($total,2));
		return $result;
	}
}


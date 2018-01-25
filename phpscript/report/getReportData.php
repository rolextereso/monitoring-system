<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

if(isset($_POST['datefrom']) && isset($_POST['dateto']) ){

	$where=($_POST['datefrom']!='' && $_POST['dateto']!='')?" WHERE DATE(sr.date_save)>='".$_POST['datefrom']."' AND DATE(sr.date_save)<='".$_POST['dateto']."'":" ";

	$sold_date="";
	$date_format="";
	if($_POST['report_type']=='month'){
		$sold_date=" DATE_FORMAT(sr.date_save,'%b. %Y') as sold_date";
		$date_format="F d, Y ";
	}else{
		$sold_date=" YEAR(sr.date_save) as sold_date";
		$date_format="Y";
	}

	if($_POST['category']=='PRODUCTS'){

		$query= "SELECT ".
				"	 product_name as product, ".
				"	 report_product_by_month_year(p.product_id,sr.date_save) as amount, ".
				"		".$sold_date.", ".
				"		DATE(sr.date_save) as date ".
				"		FROM products p ".
				"		CROSS JOIN sales_specific ss ".
				"		CROSS JOIN sales_record sr ".
						$where
				."		GROUP BY  p.product_name, MONTH(sr.date_save), YEAR(sr.date_save) ORDER BY product_name,sr.date_save;";
	}elseif ($_POST['category']=='PROJECTS'){

		$query= "SELECT ".
				"	 project_name as product, ".
				"	 report_project_by_month_year(p.project_id,sr.date_save) as amount, ".
				"		".$sold_date.", ".
				"		DATE(sr.date_save) as date ".
				"		FROM projects p ".
				"       LEFT JOIN products pd ON pd.project_id=p.project_id	".
				"		CROSS JOIN sales_specific ss ".
				"		CROSS JOIN sales_record sr ".
						$where
				."		GROUP BY  p.project_id, MONTH(sr.date_save), YEAR(sr.date_save) ORDER BY project_name, sr.date_save;";

	}elseif($_POST['category']=='RENTAL'){
		 $query="SELECT 
						CONCAT(ri.item_name,'( ',ri.item_description,' )') as product, 	
						report_rental_by_month_year(ri.rental_id,sr.date_save) as amount, ".		
						 $sold_date.", 	
						DATE(sr.date_save) as date 
						FROM  sales_record sr	
						LEFT JOIN  rental_specific rs ON sr.sales_id=rs.sales_id
						CROSS JOIN  rental_items ri ". 
							$where."	
						GROUP BY  ri.rental_id, MONTH(sr.date_save), YEAR(sr.date_save) ORDER BY rs.updated_on;";
	}

	$result = $crud->getData($query);
	
	$storage_date=array();
	$storage_data=array();
	$collected_amount=array();
	$total_amount=array();

	function ifExistsOnArray($value,$amount="",$type="value"){
		global $storage_date,$storage_data;
		if(!in_array($value, $storage_date) && $type=="date"){
			array_push($storage_date,$value );	  
		}
		if(!array_key_exists($value, $storage_data) && $type=="value"){
			$storage_data[$value]=array();	  
		}

		if(array_key_exists($value, $storage_data) && $type=="value"){
			$storage_data[$value][]=number_format($amount,1);
			
		}

	}

	$i=0;
	$startDate="";
	$endDate="";
	while(count($result)>$i){
		ifExistsOnArray($result[$i]['sold_date'],"","date");
		ifExistsOnArray($result[$i]['product'],$result[$i]['amount']);

		if($startDate==""){
			$startDate=$result[$i]['date'];
		}else{
			$endDate=$result[$i]['date'];
		}

		$i++;
	}

	foreach($storage_data as $key=>$value){
		$i=0;
		for($y=0; $y<count($storage_data[$key]);$y++){
			if($y==$i){						    
			    $collected_amount[$y][]=$storage_data[$key][$y];
			}			
			$i++;
		}
		$i=0;
		
	}

	foreach($collected_amount as $amount){
		$total_amount[]=number_format(array_sum(str_replace(",","",$amount)),1);
	}
	
	$datefrom=($_POST['datefrom']=='')?$startDate:$_POST['datefrom'];
	$dateto=($_POST['dateto']=='')?$endDate:$_POST['dateto'];

	$datefrom=date_create($datefrom);
	$dateto=date_create($dateto);

	$output=array("fetch"=>true,
			      "title"=>"COLLECTION REPORT OF ".$_POST['category'], 
			      "search"=>$_POST['category'],
			      "data"=>$storage_data, 
			      "date"=>$storage_date, "total"=>$total_amount,
				  "range"=> "for the ".$_POST['report_type']." of <u>".date_format($datefrom,$date_format)."</u> to <u>".date_format($dateto,$date_format)."</u>");
	echo json_encode($output);

}
?>
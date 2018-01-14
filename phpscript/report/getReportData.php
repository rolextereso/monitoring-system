<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

if(isset($_POST['datefrom']) && isset($_POST['dateto']) ){

	$where=($_POST['datefrom']!='' && $_POST['dateto']!='')?" WHERE DATE(sr.sold_date)>='".$_POST['datefrom']."' AND DATE(sr.sold_date)<='".$_POST['dateto']."'":" ";

	$query= "SELECT ".
			"	 product_name as product, ".
			"	 report_product_by_month_year(p.product_id,sr.date_save) as amount, ".
			"		DATE_FORMAT(sr.date_save,'%b. %Y') as sold_date ,".
			"		DATE(sr.date_save) as date ".
			"		FROM products p ".
			"		CROSS JOIN sales_specific ss ".
			"		CROSS JOIN sales_record sr ".
					$where
			."		GROUP BY  p.product_name, MONTH(sr.date_save), YEAR(sr.date_save) ORDER BY sr.date_save;";
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
			$storage_data[$value][]=$amount;
			
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
		$total_amount[]=array_sum($amount);
	}
	
	$datefrom=($_POST['datefrom']=='')?$startDate:$_POST['datefrom'];
	$dateto=($_POST['dateto']=='')?$endDate:$_POST['dateto'];

	$datefrom=date_create($datefrom);
	$dateto=date_create($dateto);

	$output=array("fetch"=>true,"data"=>$storage_data, "date"=>$storage_date, "total"=>$total_amount,
				  "range"=> "for the month of <u>".date_format($datefrom,'F d, Y')."</u> to <u>".date_format($dateto,'F d, Y')."</u>");
	echo json_encode($output);

}
?>
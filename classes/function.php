<?php
include_once("Crud.php");
$crud = new Crud();
date_default_timezone_set('Asia/Manila');

function print_message($result, $success_msg, $error_msg, $data=array()){
	global $crud;
	if($result){
			$crud->commit();
			$response = array('type' => 'alert-success', 'message' => $success_msg, 'data'=>$data);
			return json_encode($response);
	}else{
			$response = array('type' => 'alert-danger', 'message' => $error_msg, 'data'=>$data);
			return json_encode($response);
	}
}

function header_info(){
	global $crud;

	 $signatories = $crud->getData("SELECT * FROM signatories LIMIT 1"); 

	 $info=array("company_name"   => $signatories[0]["compName"],
				 "company_address"=> $signatories[0]['compAddress'],
				 "compContact"     => $signatories[0]['compContact'],
				 "logo"           => $signatories[0]['logo']);
	 return $info;
}

function access_role($module,$access_role,$user_type_id){
	global $crud;

	$access = $crud->getData("SELECT $access_role as access FROM user_role_igpms ur
								INNER JOIN user_type ut ON ut.user_type_id =ur.user_type_id
								INNER JOIN module m ON ur.module_id =m.module_id
								WHERE ur.user_type_id='$user_type_id' AND module_name='$module' LIMIT 1;"); 

	if($access[0]['access']=='N'){
		return false;
	}else{
		return true;
	}

}

function UnauthorizedOpenTemp(){
	return " <br/><h2 style='text-align: center;width: 100%;'><span style='color:red;'>
					<i class='fa fa-hand-paper-o'></i>
					Unauthorized Access:</span>
					<br/>
			 <small>Sorry your account is not authorize to view this page.</small></h2>";
}

function specific_user($access=false){
	$user="";
	if($access==true){
		 $user=" IS NOT NULL";
    }else{
    	  $user="='".$_SESSION['user_id']."'";
    }

    return $user;
}

function user_activity($msg="",$user_id){
	global $crud;

	$result = $crud->executeUnAutoCommit("INSERT INTO user_log(msg,user_id)
									      VALUES ('$msg', '$user_id');");
	
	return $result;

}

function semester_year(){
	global $crud;

	 	$current_year=2017;//$current_year=date("Y");
        $year_semester="";

        $exists_semester2 = $crud->getData("SHOW TABLES LIKE 'paid_assess".$current_year."2';");
        $exists_semester1 = $crud->getData("SHOW TABLES LIKE 'paid_assess".$current_year."1';");

        if(count($exists_semester2)==1){
          $year_semester="{$current_year}2";
        }elseif(count($exists_semester1)==1){
          $year_semester="{$current_year}1";
        }else{
          $current_year=$current_year-1;
          $year_semester="{$current_year}2";
        }
    return $year_semester;
}


function customer_change_selection($transaction_id){
	global $crud;
   
    $found=false;
    $sales_id="";
    $selection_for="";
    $total_amount=0;

    if($transaction_id!=""){
        //getting id from url
        $id = $crud->escape_string($transaction_id);
        //selecting data associated with this particular id
        $sales = $crud->getData("SELECT sr.sales_id, "
                                 ."           customer_name,"
                                 ."           customer_address,"
                                 ."           p.product_name,"
                                 ."           pp.price,"
                                 ."           p.unit_of_measurement,"
                                 ."           ss.amount,"
                                 ."           ss.sales_specific_id,"
                                 ."           pp.price,"
                                 ."           ss.quantity FROM sales_specific ss"
                                 ."   INNER JOIN sales_record sr ON ss.or_number=sr.sales_id"
                                 ."   INNER JOIN customer c ON c.customer_id =sr.customer_id"
                                 ."   INNER JOIN products p ON p.product_id=ss.product_id"
                                 ."   INNER JOIN product_price pp ON pp.price_id=p.product_price"
                                 ."  WHERE ss.paid='N' AND sr.or_number ='' AND ss.canceled='N' AND transaction_id='$id';");
        
        $rental=$crud->getData("SELECT  
                                  ri.transaction_id,   
                                  ri.item_name,
                                  ri.item_description,
                                  ri.rental_fee,
                                  ri.rental_id,
                                  ri.per_day,
                                  rs.rental_fee_amount,
                                  rs.no_of_days,
                                  rs.date_return,
                                  rs.rental_specific_id,
                                  c.customer_name,
                                  c.customer_address,
                                  rs.sales_id
                                  FROM rental_items ri
                                LEFT JOIN rental_specific rs ON rs.rental_id=ri.rental_id
                                LEFT JOIN customer c ON c.customer_id=rs.customer_id 
                                WHERE rs.paid='N' AND rs.canceled='N' AND ri.transaction_id='$id';");

        if(count($sales)>=1){
            $found=true;
            $selection_for="sales";           

            foreach($sales as $res_){
                $total_amount+=$res_['amount'];
                $sales_id=$res_['sales_id'];
            } 
        }else if(count($rental)>=1){
            $found=true;            
            $selection_for="rental";

            foreach($rental as $res_){
                $total_amount+=$res_['rental_fee_amount'];
                $sales_id=$res_['sales_id'];
            } 
        }
    }

    $data=array('sales_id'=>$sales_id,
			    'total_amount'=>$total_amount,
			    'selection_for'=>$selection_for,
				'sales'=>$sales,
				'rental'=>$rental);

    return $data;
}


?>
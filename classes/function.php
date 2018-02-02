<?php
include_once("Crud.php");
$crud = new Crud();

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

	 $owner_info = $crud->getData("SELECT * FROM owner_info LIMIT 1"); 

	 $info=array("company_name"   => $owner_info[0]["owner_name"],
				 "company_address"=> $owner_info[0]['owner_address'],
				 "contact_no"     => $owner_info[0]['contact_no'],
				 "logo"           => $owner_info[0]['logo']);
	 return $info;
}

function access_role($module,$access_role,$user_type_id){
	global $crud;

	$access = $crud->getData("SELECT $access_role as access FROM user_role ur
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

function specific_user($text="",$access=false){
	$user="";
	if($text=="" && $access==true){
		 $user="";
    }else{
    	  $user=$text."".$_SESSION['user_id'];
    }

    return $user;
}



?>
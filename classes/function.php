<?php
include_once("Crud.php");
$crud = new Crud();

function print_message($result, $success_msg, $error_msg){
	global $crud;
	if($result){
			$crud->commit();
			$response = array('type' => 'success', 'message' => $success_msg);
			return json_encode($response);
	}else{
			$response = array('type' => 'danger', 'message' => $error_msg);
			return json_encode($response);
	}
}


?>
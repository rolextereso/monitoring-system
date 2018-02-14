<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

//code below is for update user account info
if(isset($_POST['newpassword'])){
		

			$userid   = $crud->escape_string($_POST['userid']);
			$newpassword  = $crud->escape_string($_POST['newpassword']);
			
			$result = $crud->execute("UPDATE account SET ".
										 "password= '$newpassword' ".
										 "WHERE userid='$userid';");
		if($result){
			$response = array('type' => 'success', 'message' => '<strong>Success:</strong> Password successfully saved.');
			echo json_encode($response);
		}else{
			$response = array('type' => 'danger', 'message' => '<strong>Error:</strong> Account not saved, please contact the developer.');
			echo json_encode($response);
		}

}


?>
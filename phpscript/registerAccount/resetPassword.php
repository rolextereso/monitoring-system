<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

//code below is for update user account info
if(isset($_POST['newpassword'])){
		

			$user_id   = $crud->escape_string($_POST['user_id']);
			$newpassword  = $crud->escape_string($_POST['newpassword']);
			
			$result = $crud->execute("UPDATE users SET ".
										 "password= AES_ENCRYPT('$newpassword',username) ".
										 "WHERE user_id=$user_id;");
		if($result){
			$response = array('type' => 'success', 'message' => '<strong>Success:</strong> Password successfully saved.');
			echo json_encode($response);
		}else{
			$response = array('type' => 'danger', 'message' => '<strong>Error:</strong> Account not saved, please contact the developer.');
			echo json_encode($response);
		}

}


?>
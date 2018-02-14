<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

if(isset($_POST['username'])){

		$firstname = $crud->escape_string($_POST['firstname']);
		$lastname  = $crud->escape_string($_POST['lastname']);
		$username  = $crud->escape_string($_POST['username']);
		$password  = $crud->escape_string($_POST['password']);
		$hint	   = $crud->escape_string($_POST['hint']);
		$access_role  = $crud->escape_string($_POST['access_role']);
		$userid=date('Ymdshi');

		$found_username= $crud->getData("SELECT username FROM account WHERE username='$username' LIMIT 1");

		$result = $crud->execute("INSERT INTO account(userid, FirstName,LastName, username, password, hint,user_type,IGP) ".
								 "VALUES ('$userid','$firstname', '$lastname', '$username', '$password', '$hint','$access_role','9');");


		if($result){
			$response = array('type' => 'success', 'message' => '<strong>Success:</strong> Account successfully save.');
			echo json_encode($response);
		}else{
			if(count($found_username)>=1){
				$response = array('type' => 'danger', 'message' => '<strong>Error:</strong> Username is already taken.');
			  
			}else{
				$response = array('type' => 'danger', 'message' => '<strong>Error:</strong> Account not saved, please contact the developer.');
				
			}
			  echo json_encode($response);
			
		}

}
?>
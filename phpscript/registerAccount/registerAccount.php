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

		$result = $crud->execute("INSERT INTO users(firstname,lastname, username, password, hint,user_type) ".
								 "VALUES ('$firstname', '$lastname', '$username', AES_ENCRYPT('$password',username), '$hint','$access_role');");

		if($result){
			$response = array('type' => 'success', 'message' => '<strong>Success:</strong> Account successfully save.');
			echo json_encode($response);
		}else{
			$response = array('type' => 'danger', 'message' => '<strong>Error:</strong> Account not saved, please contact the developer.');
			echo json_encode($response);
		}

}
?>
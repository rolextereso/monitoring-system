<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

//code below is for update user account info
if(isset($_POST['username'])){
		$correct_oldpassword=true;
		$result=false;
		$status='N';

		$user_id   = $crud->escape_string($_POST['user_id']);	
		$firstname = $crud->escape_string($_POST['firstname']);
		$lastname  = $crud->escape_string($_POST['lastname']);
		$username  = $crud->escape_string($_POST['username']);
		$access_role  = $crud->escape_string($_POST['access_role']);

		if(isset($_POST['account_status'])){
			$status='Y';
		}

		if(isset($_POST['check'])){
			$oldpassword  = $crud->escape_string($_POST['oldpassword']);
			$password  = $crud->escape_string($_POST['password']);
			$hint	   = $crud->escape_string($_POST['hint']);

			$query = "SELECT * FROM users WHERE user_id=$user_id AND password=AES_ENCRYPT('$oldpassword',username) LIMIT 1;";

			$checkResult = $crud->getData($query);

			$correct_oldpassword=(count($checkResult)==1)?true:false;

			if($correct_oldpassword){
				$result = $crud->execute("UPDATE users SET firstname='$firstname', ".
										 "lastname= '$lastname', ".
										 "username= '$username', ".
										 "user_type='$access_role',".
										 "password= AES_ENCRYPT('$password',username),".
										 "hint= '$hint', status='$status' WHERE user_id=$user_id;");

			}

		}else{
			$result = $crud->execute("UPDATE users SET firstname='$firstname', ".
										 "lastname= '$lastname', ".
										 "user_type='$access_role',".
										 "username= '$username', status='$status' WHERE user_id=$user_id;");
		}
		

		if(!$correct_oldpassword){
			$response = array('type' => 'danger', 'message' => '<strong>Unable to change password</strong> Old password is incorrect.');
			echo json_encode($response);
		}else if($result){
			$response = array('type' => 'success', 'message' => '<strong>Success:</strong> Account successfully edited.');
			echo json_encode($response);
		}else{
			$response = array('type' => 'danger', 'message' => '<strong>Error:</strong> Account not saved, please contact the developer.');
			echo json_encode($response);
		}

}


// Code below is use for profile pic upload
if(is_array($_FILES) && isset($_FILES['userImage']['tmp_name'])) {
	if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
		$sourcePath = $_FILES['userImage']['tmp_name'];
		$targetPath = "../../img/".$_FILES['userImage']['name'];
		$imagePath  = "img/".$_FILES['userImage']['name'];
		if(move_uploaded_file($sourcePath,$targetPath)) {
				$result = $crud->execute("UPDATE users SET profile_pic='$imagePath' where user_id={$_POST['user_id']};");
				if($result){
					$response = array('type' => 'success', 'message' => '<strong>Success:</strong> Profile picture saved.');
					echo json_encode($response);
				}else{
					$response = array('type' => 'danger', 'message' => '<strong>Error:</strong> Not saved, please contact the developer.');
					echo json_encode($response);
				}
		
		}
	}
}
?>
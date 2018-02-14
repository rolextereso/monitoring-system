<?php
//including the database connection file
include_once("../../classes/Crud.php");
 
$crud = new Crud();

//code below is for update user account info
if(isset($_POST['username'])){
		$correct_oldpassword=true;
		$result=false;
		$status='N';

		$userid   = $crud->escape_string($_POST['userid']);	
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

			$query = "SELECT * FROM account WHERE userid='$userid' AND password='$oldpassword' LIMIT 1;";

			$checkResult = $crud->getData($query);

			$correct_oldpassword=(count($checkResult)==1)?true:false;

			if($correct_oldpassword){
				$result = $crud->execute("UPDATE account SET FirstName='$firstname', ".
										 "LastName= '$lastname', ".
										 "username= '$username', ".
										 "user_type='$access_role',".
										 "password= '$password',".
										 "hint= '$hint', status='$status' WHERE userid='$userid';");

			}

		}else{
			$result = $crud->execute("UPDATE account SET FirstName='$firstname', 
										  LastName= '$lastname', 
										  user_type='$access_role',
										
										  username= '$username' , status='$status' WHERE userid='$userid';");
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
				$result = $crud->execute("UPDATE account SET profile_pic='$imagePath' where userid='{$_POST['userid']}';");
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
<?php
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();

//code below is for update user account info
if(isset($_POST['owner_name'])){
		$correct_oldpassword=true;
		$result=false;
		$status='N';

		$id   = $crud->escape_string($_POST['id']);	
		$owner_name = $crud->escape_string($_POST['owner_name']);
		$owner_address  = $crud->escape_string($_POST['owner_address']);
		$contact_no  = $crud->escape_string($_POST['contact_no']);	
		
		$result = $crud->execute("UPDATE owner_info SET owner_name='$owner_name', ".
										 "owner_address= '$owner_address', ".
										 "contact_no='$contact_no' ".
										 " WHERE id=$id;");

		echo print_message($result, '<strong>Success:</strong> Owner info successfully save.','<strong>Error:</strong> Nothing saved, please contact the developer.');
		

}


// Code below is use for profile pic upload
if(is_array($_FILES) && isset($_FILES['logoImage']['tmp_name'])) {
	if(is_uploaded_file($_FILES['logoImage']['tmp_name'])) {
		$sourcePath = $_FILES['logoImage']['tmp_name'];
		$targetPath = "../../img/setting_assets/".$_FILES['logoImage']['name'];
		$imagePath  = "img/setting_assets/".$_FILES['logoImage']['name'];
		if(move_uploaded_file($sourcePath,$targetPath)) {
				$result = $crud->execute("UPDATE owner_info SET logo='$imagePath' where id={$_POST['id']};");
				echo print_message($result, '<strong>Success:</strong> Logo successfully save.','<strong>Error:</strong> Nothing saved, please contact the developer.');
		
		}
	}
}
?>
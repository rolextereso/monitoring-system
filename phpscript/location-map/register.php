<?php
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

if(isset($_POST['establisment'])){
	$imagePath="";
	$location_marks=$_POST["location-mark"];

	$validSize=true;//set to true because image is not required
	if(is_array($_FILES)) {
		if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
			$sourcePath = $_FILES['userImage']['tmp_name'];
			$targetPath = "../../img/location_map_pic/".str_replace(" ","_",$_FILES['userImage']['name']);
			
			$validSize=false;
			if($_FILES['userImage']['size']<=1000000){
				$validSize=true;
			}

			if(move_uploaded_file($sourcePath,$targetPath) || $validSize) {
					$imagePath  = "img/location_map_pic/".str_replace(" ","_",$_FILES['userImage']['name']);		
			}
		}
	}

	$result=$crud->executeUnAutoCommit("INSERT INTO location_marks(position_marks, image, establisment_name)         
										VALUES ('$location_marks', '$imagePath','{$_POST['establisment']}');");

	$lastInsertedId= $crud->getData("SELECT LAST_INSERT_ID() AS insert_id");

	$data=array("image"=>"$imagePath","establisment"=>$_POST['establisment'], "id"=>$lastInsertedId[0]['insert_id']);

	echo print_message(($result && $validSize), '<strong>Success:</strong> Location mark successfully save.','<strong>Error:</strong> Location marks not saved, please check if the image is more than 1MB otherwise contact the developer.',$data);	
}

//this code below is when you delete
if(isset($_POST['indicator'])){
	$result=$crud->executeUnAutoCommit("DELETE FROM location_marks WHERE id_marks='".$_POST['id']."';");

	echo print_message(($result), '<strong>Success:</strong> Mark successfully deleted.','<strong>Error:</strong> Please contact the developer.');
}
?>
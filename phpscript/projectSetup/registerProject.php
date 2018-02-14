<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();

//adding project into the database
if(isset($_POST['project_name'])){

		$project_name = $crud->escape_string($_POST['project_name']);
		$project_description  = $crud->escape_string($_POST['project_description']);
		$project_incharge  = $crud->escape_string($_POST['project_incharge']);
		$project_type = $crud->escape_string($_POST['project_type']);
		$created_by=$_SESSION['user_id'];

		$status='N';
		if(isset($_POST['project_status'])){
			$status='Y';
		}
		
		//editing project into the database
		if(isset($_POST['project_id'])){
			$result = $crud->execute("UPDATE projects SET project_name='$project_name',".
									 "project_description ='$project_description', ".
									 "project_status='$status', ".
									 "project_incharge='$project_incharge', ".
									 "project_type='$project_type' ".
									 " WHERE project_id=".$_POST['project_id']);  
	    }else{
			$result = $crud->execute("INSERT INTO projects(
													project_name,
													project_description, 
													project_status, 
													project_incharge, 
													project_type,
												    created_by) ".
								 "VALUES ('$project_name', 
								 		  '$project_description', 
								 		  '$status', 
								 		  '$project_incharge',
								 		  '$project_type',
								 		  '$created_by');");
		}

		echo print_message($result,'<strong>Success:</strong> Project successfully save.','<strong>Error:</strong> Project not saved: Check if the project name already exist, if still occur please contact the developer.');

}
?>
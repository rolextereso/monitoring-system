<?php
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");
 
$crud = new Crud();

//adding project into the database
if(isset($_POST['project_specific_id'])){

		$project_specific_id = $crud->escape_string($_POST['project_specific_id']);

		$result = $crud->execute("DELETE FROM project_duration WHERE project_specific_id='$project_specific_id'"); 
		if($result){
			$result = $crud->execute("DELETE FROM products WHERE project_specific_id='$project_specific_id'"); 
		} 

		echo print_message($result,'<strong>Success:</strong> Budget successfully deleted.','<strong>Error:</strong> Project Budget not deleted, please contact the developer.');

}
?>
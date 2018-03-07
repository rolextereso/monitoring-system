<?php
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();

if(isset($_POST['user_type'])){
		$user_type_id=$_POST['user_type'];
		$save=$_POST['save'];


		$access_rights=array(
								1=>"view_page",
								2=>"view_command",
								3=>"edit_command",
								4=>"add_command",
								5=>"delete_command",
								6=>"save_changes",
								7=>"edit_changes"
							);

		$result=array();

		for ( $row = 0; $row < count($save); $row++ )
		{	
		    for ( $col=1; $col <= count($save[$row]); $col++ )
		    { 
		    	//if(isset($save[$row][$col])){
		    		$user_role=explode("_",$save[$row][$col]);

			    	$access_right_value=$user_role[0];
			    	$user_role_id=$user_role[1];		    	

			    	$result[] = $crud->executeUnAutoCommit("UPDATE user_role_igpms SET $access_rights[$col]='$access_right_value' 
			    											WHERE user_role=$user_role_id;");
			    	
		    	//}
		    	
		    }
		}

		echo print_message(!in_array("", $result), '<strong>Success:</strong> User role successfully save.','<strong>Error:</strong> User role not saved, please contact the developer.');	
	
}
?>
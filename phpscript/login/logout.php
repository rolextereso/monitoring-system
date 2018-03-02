<?php
    session_start();
    require_once("../../classes/Crud.php");
	require_once("../../classes/function.php");

	$crud = new Crud();

	if(isset($_SESSION['user_id'])){


		if(user_activity("Logout",$_SESSION['user_id'])){
			$crud->commit();
			
			session_destroy(); // Is Used To Destroy All Sessions
			unset($_SESSION['user_id']);
			unset($_SESSION['firstname']);
			unset($_SESSION['lastname']);
			unset($_SESSION['username']);
			unset($_SESSION['user_type']);
			echo "logout";
		}
	}

?>

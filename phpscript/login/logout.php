<?php
   session_start();
	session_destroy(); // Is Used To Destroy All Sessions

	if(isset($_SESSION['user_id'])){

		unset($_SESSION['user_id']);
		unset($_SESSION['firstname']);
		unset($_SESSION['lastname']);
		unset($_SESSION['username']);
		unset($_SESSION['user_type']);

		echo "logout";
	}

?>
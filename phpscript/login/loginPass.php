<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("../../classes/function.php");

$crud = new Crud();

if(isset($_POST['username']) && isset($_POST['password'])){

		$username = $crud->escape_string($_POST['username']);
		$password  =$crud->escape_string($_POST['password']);
		
		$found= $crud->getData("SELECT u.* FROM account u
								LEFT JOIN user_type ut ON ut.user_type_id=u.user_type WHERE password='$password'
								AND username='$username' AND u.status='Y' LIMIT 1");

		       
		if(count($found)==1){

				foreach($found as $key =>$row){
					$_SESSION['user_id']=$row['user_id'];
					$_SESSION['user_id_']=$row['userid'];
					$_SESSION['firstname']=$row['FirstName'];
					$_SESSION['lastname']=$row['LastName'];
					$_SESSION['middlename']=$row['MiddleName'];
					$_SESSION['username']=$row['username'];
					$_SESSION['user_type']=$row['user_type'];
					$_SESSION['pic']=$row['profile_pic'];
				}
				if(user_activity("Login",$_SESSION['user_id'])){
						$crud->commit();
						$r=array("status"=>true);
						echo json_encode($r);
				}
				
		}else{
			$hint= $crud->getData("SELECT * FROM account WHERE username='$username' LIMIT 1");
			
			if(count($hint)==1){
				$r=array("status"=>false,"hint"=>"<strong>Hint: </strong>".$hint[0]['hint']);
				echo json_encode($r);
			}else{
				$r=array("status"=>false,"hint"=>"");
				echo json_encode($r);
			}
			
			
		} 


}
?>

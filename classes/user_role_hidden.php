<!DOCTYPE html>
<html>
<head>
	<title>User role</title>
</head>
<?php
   require_once('Crud.php');

     $crud = new Crud();

     $user_type_ = $crud->getData("SELECT * FROM user_type WHERE status='Y' "); 

     if(isset($_POST['submit'])){
     	$id=$_POST['access_role'];

     	$sql= " DELETE FROM user_role WHERE user_type_id='$id';";

     	$result = $crud->executeUnAutoCommit("$sql");
     	echo $result;
     	if($result){

		        $sql= " INSERT INTO user_role(module_id, 
										      view_page, 
										      view_command, 
										      edit_command, 
										      add_command, 
										      delete_command, 
										      save_changes, 
										      edit_changes, 
										      user_type_id)
						VALUES (1,'Y','X','X','Y','Y','Y','X','$id'),
							   (2,'Y','Y','X','X','X','Y','X','$id'),
							   (3,'Y','X','X','X','X','Y','X','$id'),
							   (4,'Y','Y','Y','Y','Y','Y','Y','$id'),
							   (5,'Y','Y','Y','Y','X','Y','Y','$id'),
							   (6,'Y','Y','X','X','X','Y','X','$id'),
							   (7,'Y','Y','X','X','X','X','X','$id'),
							   (8,'Y','X','X','X','X','X','X','$id'),
							   (9,'Y','Y','Y','Y','X','Y','Y','$id'),
							   (10,'Y','X','X','X','X','Y','X','$id'),
							   (11,'Y','Y','X','Y','X','Y','X','$id'),
							   (12,'Y','Y','X','X','X','X','X','$id');";

		     	$result = $crud->executeUnAutoCommit("$sql");

		     	
        }
     	echo ($result)?$crud->commit().'. <strong>Success:</strong> User role successfully save.':'<strong>Error:</strong> User role not saved, please contact the developer.';	
	
     }

?>
<body>
	<form method="post" action="">
		<label  >Access Role*</label>
	      <select required  id="access_role" name="access_role">
	            <option value="">Select type of role</option>
	            <?php 
	                  foreach($user_type_ as $user){
	            ?>
	                    <option value="<?php echo $user['user_type_id'] ?>" >
	                      <?php echo $user['user_type'] ?>
	                    </option>

	            <?php
	                  }
	            ?>
	      </select>

	      <input type="submit" name="submit" value="Go">

	</form>

</body>
</html>
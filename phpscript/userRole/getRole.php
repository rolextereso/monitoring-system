<?php
//including the database connection file
include_once("../../classes/Crud.php");

$crud = new Crud();

if(isset($_POST['user_type'])){
		$user_type_id=$_POST['user_type'];

		$sql="SELECT m.module_name,ur.* FROM user_role ur
				INNER JOIN module m ON m.module_id=ur.module_id
				WHERE ur.user_type_id=".$user_type_id.";";

		$result = $crud->getData($sql);


		$data=array();

		foreach($result as $key =>$row){
			$nestedData=array(); 

			$nestedData[] = $row["module_name"];
			$nestedData[] = ($row["view_page"]=='Y')? "<input type='checkbox' name='save[]' checked/>" 
								:  "<input type='checkbox' name='save[]'/>";
			$nestedData[] = ($row["view_command"]=='Y')? "<input type='checkbox' name='save[]' checked/>" 
								:  "<input type='checkbox' name='save[]'/>";
			$nestedData[] = ($row["edit_command"]=='Y')? "<input type='checkbox' name='save[]' checked/>" 
								:  "<input type='checkbox' name='save[]'/>";
			$nestedData[] = ($row["add_command"]=='Y')? "<input type='checkbox' name='save[]' checked/>" 
								:  "<input type='checkbox' name='save[]'/>";
			$nestedData[] = ($row["delete_command"]=='Y')? "<input type='checkbox' name='save[]' checked/>" 
								:  "<input type='checkbox' name='save[]'/>";
			$nestedData[] = ($row["save_changes"]=='Y')? "<input type='checkbox' name='save[]' checked/>" 
								:  "<input type='checkbox' name='save[]'/>";
			$nestedData[] = ($row["edit_changes"]=='Y')? "<input type='checkbox' name='save[]' checked/>" 
								:  "<input type='checkbox' name='save[]'/>";

			
			$data[] = $nestedData;
		}

		$output=array(
						"fetch"=>true,			     
					    "data"=>$data, 
					  );

		echo json_encode($output);
}
?>
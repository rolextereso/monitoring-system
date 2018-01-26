<?php
//including the database connection file
include_once("../../classes/Crud.php");

$crud = new Crud();

if(isset($_POST['user_type'])){
		$user_type_id=$_POST['user_type'];

		$sql="SELECT m.module_name,
					 view_page,
					 view_command,
					 edit_command,
					 add_command,
					 delete_command,
					 save_changes,
					 edit_changes,
					 ur.user_role
					 FROM user_role ur
				INNER JOIN module m ON m.module_id=ur.module_id
				WHERE ur.user_type_id=".$user_type_id.";";

		$result = $crud->getData($sql);	

		$data=array();
		$uncheck_checkbox ="";
		$check_checkbox   ="";	
		for ( $row = 0; $row < count($result); $row++ )
		{			
		    $nestedData=array(); 
		 
		    for ( $col=0; $col < count($result[$row]); $col++ )
		    { 
		    	$save="save[$row][$col]";
		    	$uncheck_checkbox ="<input type='hidden' name='$save' value='N_".$result[$row]["user_role"]."'/><input type='checkbox' name='$save' uncheck='N_".$result[$row]["user_role"]."' class='check' value='Y_".$result[$row]["user_role"]."'/>";
				$check_checkbox   ="<input type='checkbox' class='check' uncheck='N_".$result[$row]["user_role"]."' name='$save' checked='checked' value='Y_".$result[$row]["user_role"]."'/>";
				
				if($col==0)
					 $nestedData[] = $result[$row]["module_name"];
				elseif($col==1)
		  		     $nestedData[] = ($result[$row]["view_page"]=='Y')	? $check_checkbox : $uncheck_checkbox;
		  		elseif($col==2)
				    $nestedData[] = ($result[$row]["view_command"]=='Y')	? $check_checkbox : $uncheck_checkbox;
				elseif($col==3)
					$nestedData[] = ($result[$row]["edit_command"]=='Y')	? $check_checkbox : $uncheck_checkbox;
				elseif($col==4)
					$nestedData[] = ($result[$row]["add_command"]=='Y')	? $check_checkbox : $uncheck_checkbox;
				elseif($col==5)
					$nestedData[] = ($result[$row]["delete_command"]=='Y')?$check_checkbox : $uncheck_checkbox;
				elseif($col==6)
					$nestedData[] = ($result[$row]["save_changes"]=='Y')	? $check_checkbox : $uncheck_checkbox;
				elseif($col==7)
					$nestedData[] = ($result[$row]["edit_changes"]=='Y')	? $check_checkbox : $uncheck_checkbox;	    	
		    	  
		    }
			$data[] = $nestedData;
		     
		}

		$output=array(
						"fetch"=>true,			     
					    "data"=>$data, 
					  );
		echo json_encode($output);		
}
?>
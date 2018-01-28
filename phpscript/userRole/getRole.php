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

				$disable_checkbox   ="<input type='hidden' name='$save' value='X_".$result[$row]["user_role"]."'/><input type='checkbox' name='$save' uncheck='X_".$result[$row]["user_role"]."' class='check' value='X_".$result[$row]["user_role"]."' disabled='disabled'/>";
				
				if($col==0){
					 $nestedData[] = $result[$row]["module_name"];
				}elseif($col==1){

		  		     if($result[$row]["view_page"]=='Y'){
		  		     	 $nestedData[] = $check_checkbox;
		  		     }elseif($result[$row]["view_page"]!='X'){
		  		     	 $nestedData[] = $uncheck_checkbox;
		  		     }else{
		  		     	 $nestedData[] = $disable_checkbox;
		  		     } 
		  		}elseif($col==2){
				   
					if($result[$row]["view_command"]=='Y'){
		  		     	 $nestedData[] = $check_checkbox;
		  		    }elseif($result[$row]["view_command"]!='X'){
		  		     	 $nestedData[] = $uncheck_checkbox;
		  		    }else{
		  		     	 $nestedData[] = $disable_checkbox;
		  		    } 
				}elseif($col==3){
					
					if($result[$row]["edit_command"]=='Y'){
		  		     	 $nestedData[] = $check_checkbox;
		  		    }elseif($result[$row]["edit_command"]!='X'){
		  		     	 $nestedData[] = $uncheck_checkbox;
		  		    }else{
		  		     	 $nestedData[] = $disable_checkbox;
		  		    } 
				}elseif($col==4){
					
					if($result[$row]["add_command"]=='Y'){
		  		     	 $nestedData[] = $check_checkbox;
		  		    }elseif($result[$row]["add_command"]!='X'){
		  		     	 $nestedData[] = $uncheck_checkbox;
		  		    }else{
		  		     	 $nestedData[] = $disable_checkbox;
		  		    } 
				}elseif($col==5){
					
					if($result[$row]["delete_command"]=='Y'){
		  		     	 $nestedData[] = $check_checkbox;
		  		    }elseif($result[$row]["delete_command"]!='X'){
		  		     	 $nestedData[] = $uncheck_checkbox;
		  		    }else{
		  		     	 $nestedData[] = $disable_checkbox;
		  		    } 
				}elseif($col==6){
				
					if($result[$row]["save_changes"]=='Y'){
		  		     	 $nestedData[] = $check_checkbox;
		  		    }elseif($result[$row]["save_changes"]!='X'){
		  		     	 $nestedData[] = $uncheck_checkbox;
		  		    }else{
		  		     	 $nestedData[] = $disable_checkbox;
		  		    }
				}elseif($col==7){
					
					if($result[$row]["edit_changes"]=='Y'){
		  		     	 $nestedData[] = $check_checkbox;
		  		    }elseif($result[$row]["edit_changes"]!='X'){
		  		     	 $nestedData[] = $uncheck_checkbox;
		  		    }else{
		  		     	 $nestedData[] = $disable_checkbox;
		  		    }	    	
		    	}  
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
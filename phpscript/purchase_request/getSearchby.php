<?php 
   session_start();
   include_once("../../classes/Crud.php");
   include_once("../../classes/function.php");

    $crud = new Crud(); 



    if(isset($_POST['proj_id'])){
         $project_id=explode("_", $_POST["proj_id"]);
         $query = "SELECT pb.project_budget_id, description FROM project_duration pd
                    INNER JOIN project_budget pb ON pb.project_specific_id =pd.project_specific_id
                    WHERE pd.status='Y' and pd.project_id=".$project_id[1];
         
      
         $result = $crud->getData($query);

         $data=array();
            
         foreach($result as $key =>$row){
                $nestedData=array();               
                $nestedData[] =$row['project_budget_id'];
                $nestedData[] =$row['description'];
                
                $data[] = $nestedData;
         }
         echo json_encode($data); 
    }
       
    


?>  
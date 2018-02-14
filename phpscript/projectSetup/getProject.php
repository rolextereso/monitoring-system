<?php 
   session_start();
   include_once("../../classes/Crud.php");
   include_once("../../classes/function.php");

    $crud = new Crud(); 

    if(isset($_POST['query'])){
        $request=$crud->escape_string($_POST['query']);
        $query = "SELECT * FROM projects pr 
                                  WHERE pr.project_id='$request' ";
                 
        $result = $crud->getData($query);
        
        $data = array();
        foreach ($result as $row) {
           $data[] = array(
                'id'=>$row['project_id'],
                'project_type'=>$row["project_type"],
                'project_description'=>$row['project_description'],
                'project_name'=>$row['project_name']
            );
          
        }
        echo json_encode($data); 
    }
       
    


?>  
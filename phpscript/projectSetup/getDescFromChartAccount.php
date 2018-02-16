<?php 
   session_start();
   include_once("../../classes/Crud.php");
   include_once("../../classes/function.php");

    $crud = new Crud(); 

    if(isset($_GET['query'])){
        $request=$crud->escape_string($_GET['query']);
        $type =$crud->escape_string($_GET['type']);
        if($type=='production_name'){
           $query = "SELECT DISTINCT Description as data FROM chartaccount WHERE Description LIKE '%".$_GET['query']."%' LIMIT 5";
        }else{
          $query = "SELECT DISTINCT unit_of_measurement as data FROM products WHERE unit_of_measurement LIKE '%".$_GET['query']."%' LIMIT 5";
        }                 
            
        $result = $crud->getData($query);
        
       
        $data = array();
        foreach ($result as $row) {
           $data[] = $row['data'];
          
        }
        echo json_encode($data); 
    }
       
    


?>  
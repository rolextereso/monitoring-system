<?php 
   session_start();
   include_once("../../classes/Crud.php");
   include_once("../../classes/function.php");

    $crud = new Crud(); 

    if(isset($_GET['query']) && isset($_GET['type'])){
        $request=$crud->escape_string($_GET['query']);
        $type =$crud->escape_string($_GET['type']);
        if($type=='name'){
          $query = "SELECT DISTINCT customer_name as data FROM customer WHERE customer_name LIKE '%".$_GET['query']."%' LIMIT 10";
        }else{
          $query = "SELECT DISTINCT customer_address as data FROM customer WHERE customer_address LIKE '%".$_GET['query']."%' LIMIT 10";
        }
                 
            
        $result = $crud->getData($query);
        
       
        $data = array();
        foreach ($result as $row) {
           $data[] = $row['data'];
          
        }
        echo json_encode($data); 
    }
       
    


?>  
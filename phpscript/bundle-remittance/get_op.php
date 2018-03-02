<?php 
   session_start();
   include_once("../../classes/Crud.php");
   include_once("../../classes/function.php");

    $crud = new Crud(); 

    if(isset($_GET['query']) ){
        $request=$crud->escape_string($_GET['query']);
       
          $query = "SELECT DISTINCT order_payment_id as data FROM bundle_remittance WHERE order_payment_id LIKE '%".$_GET['query']."%' LIMIT 10";
             
            
        $result = $crud->getData($query);
        
       
        $data = array();
        foreach ($result as $row) {
           $data[] = $row['data'];
          
        }
        echo json_encode($data); 
    }
       
    


?>  
<?php 
   session_start();
   include_once("../../classes/Crud.php");
    include_once("../../classes/function.php");


    $crud = new Crud(); 

    if(isset($_GET['query'])){
        $request=$crud->escape_string($_GET['query']);
        $query = "SELECT rental_id,
                         item_name,
                         item_description,
                         item_code, 
                         rental_fee,
                         unit,
                         per_day, 
                         unit,
                         availability FROM rental_items   
                         WHERE status='Y' AND created_by ".specific_user(access_role("Rented Items","view_command",$_SESSION['user_type']))." AND (item_name LIKE '%$request%' OR item_description LIKE '%$request%')";


    
        $result = $crud->getData($query);
        
       
        $data = array();
        foreach ($result as $row) {
           $data[] = array(
                'id'=>$row['rental_id'],
                'item_name'=>$row["item_name"],
                'item_description'=>$row["item_description"],
                'rental_fee'=>number_format($row["rental_fee"],2),
                'unit'=>$row['unit'],
                'item_code'=>$row['item_code'],
                'per_day'=>$row['per_day'],
                'availability'=>($row["availability"]=='Y')?"Available":"Unavailable"
               
            );
          
        }
        echo json_encode($data); 
    }
       
    


?>  
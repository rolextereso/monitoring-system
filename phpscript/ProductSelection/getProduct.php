<?php 
   session_start();
   include_once("../../classes/Crud.php");
   include_once("../../classes/function.php");

    $crud = new Crud(); 

    if(isset($_GET['query'])){
        $request=$crud->escape_string($_GET['query']);
        $query = "SELECT p.product_id,p.product_name,price, unit_of_measurement, project_name FROM products p
                  INNER JOIN product_price pp ON p.product_price=pp.price_id
                  INNER JOIN projects pj ON p.project_id =pj.project_id  
                  INNER JOIN project_duration pd ON pd.project_specific_id=p.project_specific_id
                  WHERE p.product_status='Y' AND pd.status='Y' AND pj.project_incharge ".specific_user(access_role("Rental or Product Selection","view_command",$_SESSION['user_type']))." AND (product_name LIKE '%$request%' OR project_name LIKE '%$request%')";
             // echo $query;
            
        $result = $crud->getData($query);
        
       
        $data = array();
        foreach ($result as $row) {
           $data[] = array(
                'id'=>$row['product_id'],
                'product_name'=>$row["product_name"],
                'price'=>number_format($row["price"],2),
                'unit_of_measurement'=>$row['unit_of_measurement'],
                'project_name'=>$row['project_name']
            );
          
        }
        echo json_encode($data); 
    }
       
    


?>  
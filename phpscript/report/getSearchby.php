<?php 
   session_start();
   include_once("../../classes/Crud.php");
   include_once("../../classes/function.php");

    $crud = new Crud(); 



    if(isset($_POST['search_by'])){
        $search_by=$crud->escape_string($_POST['search_by']);
         if($search_by=='PROJECTS' || $search_by=='NET INCOME' || $search_by=='EXPENSES'){
             $query = "SELECT project_id as item_id, project_name as item_name FROM projects WHERE created_by=".specific_user();
         }elseif($search_by=='PRODUCTS'){
             $query = "SELECT product_id as item_id, product_name as item_name FROM products  WHERE created_by=".specific_user();
         }elseif($search_by=='RENTAL ITEMS'){
              $query = "SELECT rental_id as item_id, CONCAT(item_name,'(',item_description,')') as item_name FROM rental_items WHERE created_by=".specific_user();
         }
      
         $result = $crud->getData($query);

         $data=array();
            
         foreach($result as $key =>$row){
                $nestedData=array();               
                $nestedData[] =$row['item_id'];
                $nestedData[] =$row['item_name'];
                
                $data[] = $nestedData;
         }
         echo json_encode($data); 
    }
       
    


?>  
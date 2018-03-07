<?php 
   session_start();
   include_once("../../classes/Crud.php");
   include_once("../../classes/function.php");

    $crud = new Crud(); 

    if(isset($_GET['query'])){
        $request=$crud->escape_string($_GET['query']);
       
        $year_semester=semester_year();

        if($year_semester!=""){

            $query = "SELECT ORNo, payor, item_name,ps.Amount,ps.date_paid FROM old_paid_assess pa
                      INNER JOIN old_paid_assess_sub ps ON ps.paid_assess_id=pa.ORcode
                      WHERE pa.ORNo LIKE '%$request%' AND (pa.sales_id IS NULL OR pa.sales_id ='') GROUP BY ORNo";
       
                
            $result = $crud->getData($query);
            
           
            $data = array();
            foreach ($result as $row) {
               $data[] = array(
                
                    'ORNo'=>$row["ORNo"],
                    'payor'=>$row["payor"],
                    'amount'=>number_format($row["Amount"],2),
                    'item_name'=>$row['item_name'],
                    'date_paid'=>date("F d, Y",strtotime($row['date_paid']))
                );
              
            }
        echo json_encode($data);
        } 
    }elseif(isset($_POST['exact_id'])){
        $request=$crud->escape_string($_POST['exact_id']);
       
        $year_semester=semester_year();

        if($year_semester!=""){

            $query = "SELECT ORNo, payor, item_name,ps.Amount,ps.date_paid FROM old_paid_assess pa
                      INNER JOIN old_paid_assess_sub ps ON ps.paid_assess_id=pa.ORcode
                      WHERE pa.ORNo = '$request'";
       
                
            $result = $crud->getData($query);
            
           
            $data = array();
            foreach ($result as $row) {
               $data[] = array(
                
                    'ORNo'=>$row["ORNo"],
                    'payor'=>$row["payor"],
                    'amount'=>number_format($row["Amount"],2),
                    'item_name'=>$row['item_name'],
                    'date_paid'=>date("F d, Y",strtotime($row['date_paid']))
                );
              
            }
        echo json_encode($data);
        } 

    }
       
    


?>  
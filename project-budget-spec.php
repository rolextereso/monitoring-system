
<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

    $from= "";
    $to="";
    $found=false;  
    $project_name="";
    $date_header="";

    /*function datesPopulate($array){
         $dates=array();
           
         foreach($array as $row){ 
                  if(!in_array($row["dates"],$dates)){
                        array_push($dates,$row["dates"]);
                     
                  }                 
          }
          return $dates;
    }*/

    function populateRecord($array){
            $record=array();
            
            $found=array();
            foreach($array as $row){
              $row_data=array();

                  if(!in_array($row["description"],$found)){
                        array_push($found,$row["description"]);
                      $row_data['name']=$row["description"];
                    $row_data['data'][]=$row["amount"];
                        $record[] = $row_data;
                  }elseif(in_array($row["description"],$found)){    
                      $index =array_keys($found, $row["description"]);

                  $record[$index[0]]["data"][]=$row["amount"];      
                }  
                  
            }
            return $record;
    }

    if(isset($_GET['b_id']) && isset($_GET['p_id'])){
       $b_id = $crud->escape_string($_GET['b_id']);
       $p_id= $crud->escape_string($_GET['p_id']);
    
            $duration = $crud->getData("SELECT  project_duration_id, to_date,  from_date,status FROM project_duration WHERE project_specific_id='$b_id';");

            $project = $crud->getData("SELECT  project_name FROM projects WHERE project_id='$p_id';");

            $duration_data = $crud->getData("SELECT  description, amount FROM project_budget WHERE project_specific_id='$b_id';");

   
            

            $found=(count($duration)==1 &&  count( $project)==1)?true:false;

            $project_duration_id=$duration[0]['project_duration_id'];
            $to=date("M Y", strtotime($duration[0]['to_date']));
            $from=date("M Y", strtotime($duration[0]['from_date']));
            $project_name=$project[0]['project_name'];

            // $total_expenses = $crud->getData("SELECT 
            //                             CASE WHEN SUM(qty*amount_per_unit) IS NULL THEN 0 ELSE SUM(qty*amount_per_unit) END as total_expenses 
            //                             FROM purchase_request pr
            //                             LEFT JOIN expenses_breakdown eb ON eb.purchase_request_id=pr.purchase_request_id
            //                             WHERE project_duration_id=$project_duration_id");
                  
            $actual_expenses = $crud->getData("SELECT 
                                              CASE WHEN SUM(eb.qty*eb.amount_per_unit) IS NULL 
                                                     THEN 0 
                                                    ELSE SUM(eb.qty*eb.amount_per_unit) 
                                                    END AS expenses_tendered FROM project_budget pb
                                              LEFT JOIN project_duration pd ON pb.project_specific_id =pd.project_specific_id
                                              LEFT JOIN purchase_request pr ON pr.project_budget_id=pb.project_budget_id
                                              LEFT JOIN expenses_breakdown eb ON eb.purchase_request_id=pr.purchase_request_id
                                              WHERE pd.project_specific_id='$b_id' 
                                              AND pd.status='{$duration[0]['status']}' 
                                              GROUP BY pb.project_budget_id 
                                              ORDER BY pb.project_budget_id ASC;");

           

            

          
    }
    
?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
 <style>
    .planned_budget{
          font-size: 26px;
          color: #a6eea0;
          background: #186c25;
    }

    .present_expenses{
        font-size: 26px;
        color: #f7bbbb;
        background: #b22b2b;
    }
</style>

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='project-list-spec.php?id=<?php echo $p_id;?>'><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Project Budget List</a> </li>
              </ol>
           </nav>
           <?php if($found){?>
                <div style="text-align: center;">
                    <h3 style="text-transform: uppercase;">PROJECT BUDGET OF <?php echo $project_name;?></h3>
                    <span>for the month <?php echo $from;?> to <?php echo $to;?></span>
                </div>
                <br/>
                 <table class="table table-sm table-light table-striped">
                    <tr>
                        <th>Expenses</th>
                        <th>Planned Budget</th>
                        <th>Actual Expenses</th>
                    </tr>
                    
                        <?php $total=0;
                              $total_actual_expenses=0;
                              $record=populateRecord($duration_data);
                           
                              for($i=0;$i<count($record);$i++){
                                    echo "<tr>";
                                    echo "<td>".$record[$i]['name']."</td>";
                                    for($y=0; $y<count($record[$i]['data']);$y++){
                                      $total+=$record[$i]['data'][0];
                                      $total_actual_expenses+=$actual_expenses[$i]['expenses_tendered'];
                                      echo "<td>".number_format($record[$i]['data'][0],2)."</td>";
                                      echo "<td>".number_format($actual_expenses[$i]['expenses_tendered'],2)."</td>";
                                    }
                                    echo "</tr>";
                              }
                        ?>
                    <tr>
                        <td class="planned_budget">Total Planned Budget Expenses: </td>
                        <td class="planned_budget"><?php echo number_format($total,2);?></td>
                        <td class="planned_budget"></td>

                    </tr>
                    <tr>
                        <td class="present_expenses">Total Actual Expenses: </td>
                        <td class="present_expenses"></td>
                        <td class="present_expenses"><?php echo number_format($total_actual_expenses,2);?></td>

                    </tr>
                  
                  </table>
     
           <?php }else{?>
                         <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>ID Not Found, maybe because budget is not exist.</small></h2>


           <?php } ?>
              
        </div>
      </main>
     

     
<?php require_once('layout/footer.php');?>      
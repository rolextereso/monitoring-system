<?php require_once('layout/header.php');?> 
<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

    $from= "";
    $to="";
    $found=false;  
    $project_name="";
    $date_header="";

    function datesPopulate($array){
         $dates=array();
           
         foreach($array as $row){ 
                  if(!in_array($row["dates"],$dates)){
                        array_push($dates,$row["dates"]);
                     
                  }                 
          }
          return $dates;
    }

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
    
            $duration = $crud->getData("SELECT  max(month) as to_date, min(month) as from_date FROM project_duration WHERE project_specific_id='$b_id';");
            $project = $crud->getData("SELECT  project_name FROM projects WHERE project_id='$p_id';");
            $duration_data = $crud->getData("SELECT  description, DATE_FORMAT(month,'%M %Y') as dates, amount FROM project_duration WHERE project_specific_id='$b_id';");
            

            $found=(count($duration)==1 &&  count( $project)==1)?true:false;

            $to=date("M Y", strtotime($duration[0]['to_date']));
            $from=date("M Y", strtotime($duration[0]['from_date']));
            $project_name=$project[0]['project_name'];
                  
    }
    
?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">


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
                 <table class="table table-sm table-dark table-striped">
                    <tr>
                        <th>Expenses</th>
                        <?php
                            foreach(datesPopulate($duration_data) as $dates){
                               echo "<th>{$dates}</th>";
                            }
                        ?>
                    </tr>
                    
                        <?php
                              $record=populateRecord($duration_data);
                              for($i=0;$i<count($record);$i++){
                                    echo "<tr>";
                                    echo "<td>".$record[$i]['name']."</td>";
                                    for($y=0; $y<count($record[$i]['data']);$y++){
                                      echo "<td>".$record[$i]['data'][$y]."</td>";
                                    }
                                    echo "</tr>";
                              }
                        ?>
                  
                  </table>
     
           <?php }else{?>
                         <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>ID Not Found, maybe because budget is not exist.</small></h2>


           <?php } ?>
              
        </div>
      </main>
     

     
<?php require_once('layout/footer.php');?>      
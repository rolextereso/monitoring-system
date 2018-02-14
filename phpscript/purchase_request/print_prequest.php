<?php
    require_once('../../classes/Crud.php');

     $crud = new Crud();

    $found        =false;
    $entity_name  = "";
    $project_name = "";
    $purpose      = "";
    $date_created = "";
    $created_by   = "";
    $designation  = "";
    $status_request ="";
    $pr_id="";


    if(isset($_GET['pr_id'])){
      
             $pr_id= $crud->escape_string($_GET['pr_id']);  

             $sql = "SELECT pr.*,eb.*,p.project_name, f.funds,pb.description as target_expenses,
                            CONCAT(u.firstname,' ',u.lastname) as user_created,
                            ut.user_type as designation FROM purchase_request pr 
                      INNER JOIN expenses_breakdown eb ON eb.purchase_request_id=pr.purchase_request_id 
                      INNER JOIN project_duration pd ON pd.project_duration_id=pr.project_duration_id

                      INNER JOIN projects p ON p.project_id= pd.project_id
                      INNER JOIN users u ON u.user_id= pr.created_by                  
                      INNER JOIN user_type ut ON ut.user_type_id=u.user_type
                      INNER JOIN funds f ON f.id=pr.funds
                      INNER JOIN project_budget pb ON pb.project_budget_id=pr.project_budget_id
                      WHERE pr.pr_no='$pr_id' ";  
          
             $pr = $crud->getData($sql);
             $found=(count($pr)>=1)?true:false;

             foreach($pr as $row){
                $entity_name   = $row['entity_name'];
                $project_name  = $row['project_name'];
                $purpose       = $row['purpose'];
                $date_created  = $row['created_on'];
                $created_by    = $row['user_created'];
                $designation   = $row['designation'];
                $status_request =$row['approved'];
             }

             $sql = "SELECT CONCAT(u.firstname,' ',u.lastname) as name,
                             ut.user_type as designation FROM users u             
                      INNER JOIN user_type ut ON ut.user_type_id=u.user_type
                      WHERE ut.user_type='Campus Dean' AND u.status='Y' LIMIT 1;";
             $campus_dean = $crud->getData($sql);
    }
    
    
?>   
<!DOCTYPE html>
<html>
<head>
    <title>Purchase Request</title>
</head>
<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
<link href="../../assets/bootstrap.css" rel="stylesheet">
<style>
    #page{
      width: 1060.33px;
      margin: 0 auto;

      padding: 2.5rem 2.0rem;
    }
    .container{

       padding: 1.5rem;

    }
    table{
      border: 2px solid;
      width: 989px;
    }   

    table td{
      border-top:none !important;
    }
    .center{
      text-align: center;
    }
    .border-t{
      border-top:1px solid black!important;
    }

    .border-l{
      border-left:1px solid black!important;
    }
</style>
<body>
         <div class="container">

                <div class="page">
                
                         <table class="table table-sm" >
                            <tr>
                                <td colspan="7" style="text-align: right;">Appendix 60</td>                               
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: center;"><h2>PURCHASE REQUEST</h2></td>                    
                            </tr>                           
                            <tr>
                                <td style="width:10%;"><b>Entity name:</b></td>   
                                <td colspan="4">&nbsp;<?php echo $entity_name; ?></td> 
                                <td style="width:18%;">Fund Cluster:</td> 
                                <td>&nbsp;</td>                                    
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                            <tr>
                                <td class="border-t" style="width:10%;">Office/Section:</td>   
                                <td colspan="2"  class="border-t">&nbsp;<?php echo $project_name; ?></td> 
                                <td  class="border-t" style="width:5%;">PR No:</td> 
                                <td  class="border-t">&nbsp;</td>  
                                <td  class="border-t border-l" colspan="2">Date:&nbsp;<?php echo date("F d, Y", strtotime($date_created)); ?></td>                                     
                            </tr>
                            <tr>
                                <td>Responsibility Center Code:</td>   
                                <td colspan="4">&nbsp;</td>                      
                                <td colspan="2" class="border-l">&nbsp;</td>                                                       
                            </tr>
                            <tr>
                                <td class="border-t border-l center">Stock/Property No.</td>   
                                <td class="border-t border-l center">Unit</td>                      
                                <td colspan="2" class="border-t border-l center" style="width:30%;">Item Description</td>   
                                <td class="border-t border-l center"> Quantity</td>   
                                <td class="border-t border-l center">Unit Cost</td>   
                                <td class="border-t border-l center">Total Cost</td>                                                        
                            </tr>
                            <?php foreach($pr as $rows){?>
                              <tr>
                                  <td class="border-t border-l">&nbsp;</td>   
                                  <td class="border-t border-l">&nbsp;<?php echo $rows['unit'];?></td>                      
                                  <td colspan="2" class="border-t border-l" style="width:30%;">&nbsp;<?php echo $rows['item_description'];?></td>   
                                  <td class="border-t border-l"> &nbsp;<?php echo $rows['qty'];?></td>   
                                  <td class="border-t border-l">&nbsp;</td>   
                                  <td class="border-t border-l">&nbsp;</td>                                                        
                              </tr>
                            <?php } ?>
                            <tr>
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                      
                                <td colspan="2" class="border-t border-l" style="width:30%;">&nbsp;</td>   
                                <td class="border-t border-l"> &nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                                                        
                            </tr>
                            <tr>
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                      
                                <td colspan="2" class="border-t border-l" style="width:30%;">&nbsp;</td>   
                                <td class="border-t border-l"> &nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                                                        
                            </tr>
                            <tr>
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                      
                                <td colspan="2" class="border-t border-l" style="width:30%;">&nbsp;</td>   
                                <td class="border-t border-l"> &nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                                                        
                            </tr>
                            <tr>
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                      
                                <td colspan="2" class="border-t border-l" style="width:30%;">&nbsp;</td>   
                                <td class="border-t border-l"> &nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                                                        
                            </tr>
                            <tr>
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                      
                                <td colspan="2" class="border-t border-l" style="width:30%;">&nbsp;</td>   
                                <td class="border-t border-l"> &nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                                                        
                            </tr>
                            <tr>
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                      
                                <td colspan="2" class="border-t border-l" style="width:30%;">&nbsp;</td>   
                                <td class="border-t border-l"> &nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                                                        
                            </tr>
                            <tr>
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                      
                                <td colspan="2" class="border-t border-l" style="width:30%;">&nbsp;</td>   
                                <td class="border-t border-l"> &nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                                                        
                            </tr>
                            <tr>
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                      
                                <td colspan="2" class="border-t border-l" style="width:30%;">&nbsp;</td>   
                                <td class="border-t border-l"> &nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>   
                                <td class="border-t border-l">&nbsp;</td>                                                        
                            </tr>
                            <tr>
                                                    
                                <td colspan="4" class="border-t border-l" style="width:30%;">&nbsp;Budget Taken: <?php echo $pr[0]['target_expenses']; ?></td>   
                                <td class="border-t border-l" colspan="3"> &nbsp;Funds Taken: <?php echo $pr[0]['funds']; ?></td>   
                                                                                       
                            </tr>
                            <tr>
                                <td class="border-t">Purpose:</td>
                                <td colspan="6" class="border-t" style="height: 90px;">&nbsp;<?php echo $purpose; ?></td>
                            </tr>
                            <tr>
                                <td class="border-t" colspan="4">Requested by:</td>
                                <td class="border-t" colspan="3">Approved by:</td>
                            </tr>
                            <tr>
                                <td>Signature:</td>
                                <td  colspan="3"></td>
                              
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td>Printed Name:</td>
                                <td  colspan="3" style="text-transform: uppercase;"><?php echo $created_by; ?></td>
                                <td colspan="3" style="text-transform: uppercase;"><?php echo $campus_dean[0]['name'];?></td>
                            </tr>
                            <tr>
                                <td>Designation:</td>
                                <td  colspan="3"><?php echo $designation;?></td>
                                <td colspan="3" ><?php echo $campus_dean[0]['designation'];?></td>
                            </tr>
                          </table>
                </div>
           </div>

</body>
</html>
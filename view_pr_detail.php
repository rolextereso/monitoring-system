<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

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

             $sql = "SELECT pr.*,eb.*,p.project_name, 
                            CONCAT(u.firstname,' ',u.lastname) as user_created,
                            ut.user_type as designation FROM purchase_request pr 
                      INNER JOIN expenses_breakdown eb ON eb.purchase_request_id=pr.purchase_request_id 
                      INNER JOIN project_duration pd ON pd.project_duration_id=pr.project_duration_id

                      INNER JOIN projects p ON p.project_id= pd.project_id
                      INNER JOIN users u ON u.user_id= pr.created_by                  
                      INNER JOIN user_type ut ON ut.user_type_id=u.user_type
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
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">

 <style>
    .page{
      width: 1060.33px;
      margin: 0 auto;
      background: white;
      padding: 2.5rem 2.0rem;
    }
    .container{
       background-color: #999a9b;
       padding: 1.5rem;
       overflow: auto;
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

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='purchase_request_list.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Purchase Request List</a> </li>
              </ol>
           </nav>
           <?php if($found){?>
          
           <div id="approval_stat">
                <?php if($status_request=='O'){ ?>
                     <?php if(access_role("Purchase Requests","view_command",$_SESSION['user_type'])){?>
                            <button class="btn btn-success approval_stat" stat='Y'>Approved</button>&nbsp;
                            <button class="btn btn-danger approval_stat" stat='N'>Disapproved</button>
                      <?php } ?>
                <?php }elseif($status_request=='Y'){ ?>                  
                        <h3 class="green" style="display: inline;">This request is <b>APPROVED</b></h3>                    
                        <button class="btn btn-success" onclick="printPR();" style="float:right;">Print Purchase Request</button>
                <?php }elseif($status_request=='N'){?>                      
                        <h3 class="red">This request is <b>REJECTED</b></h3>                     
                <?php } ?>

           </div>
          
           <input type="hidden" id="pr_id" value='<?php echo $pr_id;?>'>
           <br/>
       
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
     
           <?php }else{?>
                         <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>ID Not Found, maybe because it is not exist.</small></h2>


           <?php } ?>
              
        </div>
      </main>
      <script>
          $(document).ready(function(){
              $(".approval_stat").click(function(){
                      var parent=this;
                       bootbox.confirm({
                        size: "small",                                         
                        message: "Are you sure?", 
                        callback: function(result) { 
                                 if(result){
                                        var status=$(parent).attr('stat')
                                        var pr_id =$("#pr_id").val();
                                         $.ajax({
                                                type: "POST",
                                                url: "phpscript/purchase_request/save_pr_stat.php",
                                                dataType   : 'json',
                                                data: { approval_stat:status, pr_id_:pr_id },
                                                success: function (data)
                                                {
                                                  $('.alert').removeClass('alert-success, alert-danger')
                                                             .addClass(data.type)
                                                             .html(data.message)
                                                             .fadeIn(100,function(){
                                                                 $(this).fadeOut(5000);
                                                             });
                                                   if(data.type=="alert-success"){
                                                      if(data.data[0]=='Y'){
                                                            $("#approval_stat").html('<h3 class="green" style="display: inline;">'+
                                                                                     'This request is <b>APPROVED</b></h3>'+
                                                                                     '<button class="btn btn-success" onclick="printPR();" style="float:right;">Print Purchase Request</button>');
                                                      }else{
                                                            $("#approval_stat").html(' <h3 class="red">This request is <b>REJECTED</b></h3>');
                                                      }
                                                   }

                                                      
                                                }
                                        });
                                }
                      }

                    });
                  });
           });

          function printPR(){
              WindowPopUp("phpscript/purchase_request/print_prequest.php?pr_id=<?php echo $pr_id;?>",'print','900','650');
          }
      </script>
     

     
<?php require_once('layout/footer.php');?>      
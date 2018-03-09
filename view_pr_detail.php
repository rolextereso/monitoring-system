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
    $funds_cluster="";
    $pr_id="";
    $project_id="";
    $purchase_request_number="";
    $pr_no="";

    if(isset($_GET['pr_id'])){
      
             $pr_id= $crud->escape_string($_GET['pr_id']);  

             $sql = "SELECT pr.*,pr.updated_on as date_,pr.funds as fund_cluster,eb.*,p.project_id, p.project_name, pb.description as target_expenses,
                            CONCAT(u.firstname,' ',u.lastname) as user_created,
                            ut.user_type as designation,

                            pr.purchase_request_number FROM purchase_request pr 
                      INNER JOIN expenses_breakdown eb ON eb.purchase_request_id=pr.purchase_request_id 
                      INNER JOIN project_duration pd ON pd.project_duration_id=pr.project_duration_id

                      INNER JOIN projects p ON p.project_id= pd.project_id
                      INNER JOIN account u ON u.user_id= pr.created_by                  
                      INNER JOIN user_type ut ON ut.user_type_id=u.user_type
                      LEFT JOIN funds f ON f.id=pr.funds
                      LEFT JOIN project_budget pb ON pb.project_budget_id=pr.project_budget_id
                      WHERE pr.pr_no='$pr_id' ";  
          
             $pr = $crud->getData($sql);
             $found=(count($pr)>=1)?true:false;

             foreach($pr as $row){
                $project_id    = $row['project_id'];
                $entity_name   = $row['entity_name'];
                $project_name  = $row['project_name'];
                $purpose       = $row['purpose'];
                $date_created  = $row['date_'];
                $created_by    = $row['user_created'];
                $designation   = $row['designation'];
                $status_request =$row['approved'];
                $funds_cluster=$row['fund_cluster'];
                $purchase_request_number=$row['purchase_request_number'];
                $pr_no=$row['pr_no'];
             }

             $sql = "SELECT CONCAT(u.firstname,' ',u.lastname) as name,
                             ut.user_type as designation FROM account u             
                      INNER JOIN user_type ut ON ut.user_type_id=u.user_type
                      WHERE ut.user_type='Campus Dean' AND u.status='Y' LIMIT 1;";
             $campus_dean = $crud->getData($sql);

             $funds = $crud->getData("SELECT * FROM funds");

             $target_expenses=$crud->getData("SELECT pb.project_budget_id, description FROM project_duration pd
                    INNER JOIN project_budget pb ON pb.project_specific_id =pd.project_specific_id
                    WHERE pd.status='Y' and pd.project_id='$project_id';");
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
    .table{   
      border: 2px solid;      
      
    }
    table{
      width: 989px;
    }   

    table td{
      font-family: Cambria;
      font-size:14px;
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
          <!-- O -ongoing , F-funded, C-Completed , Y-approved, N-disapproved  -->
           <div id="approval_stat">
                <?php if($status_request=='O'){ ?>
                        <?php if($_SESSION['user_type']==4) {?>
                             <div class="row">
                                    <div class="form-group col-md-4">
                                          <label >Funds:</label>
                                          <select class="form-control form-control-sm" name="funds" >
                                              <option value="">Select funds</option>
                                            <?php foreach ($funds as $fund_){?>
                                              <option value="<?php echo $fund_['id'];?>"><?php echo $fund_['id'];?>
                                              </option>
                                            <?php } ?>
                                          </select>
                                    </div>  
                                    <div class="form-group col-md-4">
                                          <label >Target Expenses:</label>
                                          <select class="form-control form-control-sm" name="target_expenses" required="">
                                              <option value="">Select Expenses</option>
                                            <?php foreach ($target_expenses as $exp){?>
                                              <option value="<?php echo $exp['project_budget_id'];?>"><?php echo $exp['description'];?>
                                              </option>
                                            <?php } ?>
                                          </select>
                                    </div> 
                                    <div class="form-group col-md-3"> 
                                             <label>&nbsp;</label>
                                              <button class="btn btn-primary btn-block approval_stat" stat='F'> Save</button>&nbsp;
                                       </div>
                              </div>
                        <?php }else{ ?>
                                       <h3 class="green" style="display: inline;">Waiting for the accounting's funding </h3>
                                       <button class="btn btn-success" onclick="printPR();" style="float:right;">Print Purchase Request</button>  
                        <?php } ?>
                <?php }elseif($status_request=='F'){ ?>   

                            <?php if($_SESSION['user_type']==3) {?>
                                 <button class="btn btn-success approval_stat" stat='Y'>Approved</button>&nbsp;
                                 <button class="btn btn-danger approval_stat" stat='N'>Disapproved</button>
                             <?php }else{ ?>
                                       <h3 class="green" style="display: inline;">Waiting for the Campus Dean's Approval </h3> 
                                       <button class="btn btn-success" onclick="printPR();" style="float:right;">Print Purchase Request</button> 
                             <?php } ?>
                <?php }elseif($status_request=='Y'){ ?>   

                            <?php if($_SESSION['user_type']==6) {?>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                              <label >Purchase Request No.:</label>
                                              <input type="text" name="pr_number" class="form-control form-control-sm" id="pr_number"/>
                                        </div> 
                                        <div class="form-group col-md-2"> 
                                             <label>&nbsp;</label>
                                              <button class="btn btn-primary btn-block approval_stat" stat='C'> Save</button>&nbsp;
                                       </div>
                                    </div>

                             <?php }else{ ?>
                                       <h3 class="green" style="display: inline;">Waiting for the PR Number by the Supply Officer </h3> 
                                       <button class="btn btn-success" onclick="printPR();" style="float:right;">Print Purchase Request</button> 
                             <?php } ?>            
                <?php }elseif($status_request=='C'){ ?>                  
                        <h3 class="green" style="display: inline;">Purchase Request <b>Complete</b></h3>                  
                        <button class="btn btn-success" onclick="printPR();" style="float:right;">Print Purchase Request</button>
                <?php }elseif($status_request=='N'){?>                      
                        <h3 class="red">This request is <b>Rejected</b></h3>                     
                <?php }else{ ?>
                        <h3 class="red" style="display: inline;">&nbsp; </h3>         
                          <button class="btn btn-success" onclick="printPR();" style="float:right;">Print Purchase Request</button>
                <?php } ?>
           </div>
          
           <input type="hidden" id="pr_id" value='<?php echo $pr_id;?>'>
           <br/>
       
           <div class="container">

                <div class="page">
                
                        
                               <table class="table table-sm" >                                
                
                            <tr style="border-style: hidden;">
                                <td colspan="7" style="text-align: right;">Appendix 60</td>                               
                            </tr>
                            
                            <tr style="border-style: hidden;">
                                <td colspan="7" style="text-align: center;"><h2>PURCHASE REQUEST</h2></td>                    
                            </tr> 
                            
                            <tr style="border-style: hidden;"> <td></td>
                            </tr>
                            
                            <tr style="border-style: hidden;"><td></td>
                            </tr> 
                                                                                                               
                            <tr style="border-bottom-style: solid;border-left-style: hidden;border-right-style: hidden;">
                                <td style="width:10%;">Entity name:</td>   
                                <td colspan="4">&nbsp;<?php echo $entity_name; ?></td> 
                                <td style="width:18%;">Fund Cluster:&nbsp;<span id="cluster"><?php echo ($funds_cluster==0)?"":$funds_cluster;?></span></td> 
                                <td>&nbsp;</td>                                    
                            </tr>      
               
                            <tr >
                                <td rowspan="2" style="border-right-style: hidden;">Office/Section:</td>   
                                <td rowspan="2" class="border-t" style="text-decoration: underline;">&nbsp;<?php echo $project_name; ?></td> 
                                <td class="border-t" colspan="3" style="border-bottom-style: hidden;border-style: hidden;"  >PR No:
                                        <span id="pr_number_no"><?php echo $purchase_request_number; ?></span>
                                </td>
                                 
                                <td  class="border-t border-l" style="border-left-style: hidden;" rowspan="2"colspan="2">Date:&nbsp;<?php echo ($date_created!="")? date("F d, Y", strtotime($date_created)): ""; ?></td>                                     
                                    
                            </tr>
                            <tr >
                               <td  colspan="2"style="border-right-style: hidden;">Responsibility Center Code:</td>   
                                <td colspan="2" style="border-right-style: hidden;"class="border-l" >&nbsp;</td>  
                                                                
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
                                  <td class="border-t border-l"> &nbsp;<?php echo number_format($rows['qty'],2);?></td>   
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
                                <td class="border-t" style="border-right-style: hidden;">Purpose:</td>
                                <td colspan="6" class="border-t" style="height: 50px;">&nbsp;<?php echo $purpose; ?></td>
                            </tr>
                            <tr>
                                <td class="border-t" style="border-right-style: hidden; text-align: left;"colspan="4">Requested by:</td>
                                <td class="border-t" colspan="3">Approved by:</td>
                            </tr>
                            <tr>
                                <td>Signature:</td>
                                <td  colspan="3">________________________</td>
                              
                                <td colspan="3">________________________</td>
                            </tr>
                            <tr>
                                <td>Printed Name:</td>
                                <td  colspan="3" style="text-transform: uppercase;text-decoration: underline;"><?php echo $created_by; ?></td>
                                <td colspan="3" style="text-transform: uppercase;text-decoration: underline;"><?php echo $campus_dean[0]['name'];?></td>
                            </tr>
                            <tr>
                                <td>Designation:</td>
                                <td  colspan="3" style="text-decoration: underline;"><?php echo $designation;?></td>
                                <td colspan="3" style="text-decoration: underline;"><?php echo $campus_dean[0]['designation'];?></td>
                            </tr>
                           
                              <tr ><td colspan="7"></td>
                          
                             </tr>
                             <tr>
                                                    
                                <td colspan="7" class="border-t" style="width:30%;border-style: hidden;">&nbsp;*Budget Taken: <span id="budget_taken"><?php echo $pr[0]['target_expenses']; ?></span></td>   
                               </tr>
                               <tr>
                                <td colspan="7" class="border-t" style="width:30%;border-style: hidden;">&nbsp;*PR Transaction No: <span id="pr_no"><?php echo $pr[0]['pr_no']; ?></span></td>   
                               
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
                      var stat=$(parent).attr('stat');
                      if(stat=='F'){
                          if( $('[name="target_expenses"]').val()!="" 
                            && $('[name="funds"]').val()!=""){
                                call_( $('[name="target_expenses"]').val(),$('[name="funds"]').val(),stat,'');
                           }else{
                              alert("Please select funds and target expenses");
                           }
                      }else if(stat=='Y' || stat =='N'){
                             call_('','',stat,'');
                      }else if(stat=='C'){
                           if($('#pr_number').val()!=""){
                                var $pr=$('[name="pr_number"]').val();
                                
                               call_('','',stat,$pr);
                           }else{
                               alert("Please fill the PR Number ");
                           }
                      }
                     


                  });
           });

          function printPR(){
              WindowPopUp("phpscript/purchase_request/print_prequest.php?pr_id=<?php echo $pr_id;?>",'print','900','650');
          }

          function message_alert(msg,type){
            return '<h3 class="'+type+'" style="display: inline;">'+msg+'</h3><button class="btn btn-success" onclick="printPR();" style="float:right;">Print Purchase Request</button>';
          }

          function call_($target, $funds,$status,$pr_number){
                           bootbox.confirm({
                        size: "small",                                         
                        message: "Are you sure?", 
                        callback: function(result) { 
                                 if(result){
                                        var status=$status;
                                        var pr_id =$("#pr_id").val();                                     
                                         $.ajax({
                                                type: "POST",
                                                url: "phpscript/purchase_request/save_pr_stat.php",
                                                dataType   : 'json',
                                                data: { approval_stat:status, 
                                                        pr_id_:pr_id, 
                                                        target_exp:$target,
                                                        funds:  $funds,
                                                        pr_number:$pr_number
                                                        },
                                                success: function (data)
                                                {
                                                  $('.alert').removeClass('alert-success, alert-danger')
                                                             .addClass(data.type)
                                                             .html(data.message)
                                                             .fadeIn(100,function(){
                                                                 $(this).fadeOut(5000);
                                                             });
                                                   if(data.type=="alert-success"){
                                                      if(data.data[0]=='F'){
                                                            var msg='Waiting for the Campus Head Approval';

                                                            $("#cluster").html($funds);
                                                            $("#budget_taken").html($("[name='target_expenses'] option:selected").html());
                                                            $("#approval_stat").html(message_alert(msg,'green'));
                                                      }else if(data.data[0]=='Y'){
                                                            var msg='Waiting for the PR Number by the Supply Officer';
                                                            $("#pr_number_no").html($("[name='pr_number']").val());
                                                            $("#approval_stat").html(message_alert(msg,'green'));
                                                            
                                                      }else if(data.data[0]=='N'){
                                                            var msg='This request is rejected';
                                                            $("#approval_stat").html(message_alert(msg,'red'));
                                                      }else if(data.data[0]=='C'){
                                                             var msg='This request is completed';
                                                            $("#approval_stat").html(message_alert(msg,'green'));
                                                      }
                                                   }

                                                      
                                                }
                                      
                                        });
                                      
                                }
                      }

                    });
          }
      </script>
     

     
<?php require_once('layout/footer.php');?>      
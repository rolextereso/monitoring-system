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

         
    }
    
?>   
 
 <link href="assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if(access_role("Purchase Requests","save_changes",$_SESSION['user_type'])){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='purchase_request_list.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Purchase Request List</a> </li>
              </ol>
           </nav>
           <?php if($found){?>
           
         
           <input type="hidden" id="pr_id" value='<?php echo $pr_id;?>'>
           <br/>
       
           <div class="container">
                <div class="row">
                        <div class="col-md-12">
                               <form  role="form" id="form">
                                      <div class="form-row">
                                             
                                              <div class="col-md-12">
                                              
                                                        <label><b>PR No.:</b></label>
                                                        <span><?php echo $pr_id;?></span>
                                                        <br/> 
                                                        <label><b>Entity Name:</b></label>
                                                        <span><?php echo $entity_name;?>
                                                        <br/>
                                                        <label><b>Projects:</b></label>
                                                        <span><?php echo $project_name; ?>
                                                        <br/>
                                                       <label><b>Purpose:</b></label>
                                                       <span> <?php echo $purpose; ?>                                             
                                                        <br/>                                                
                                              </div>

                                              <div class="col-md-12">
                                                 <div class="form-group">
                                                      <table class="table">
                                                          <thead class="thead-light">
                                                            <tr>
                                                              <th scope="col" style="width:18%;">OR Number</th>
                                                              <th scope="col" style="width:10%;">Unit</th>
                                                              <th scope="col">Item Description </th>
                                                              <th scope="col" style="width:10%;">Quantity</th>
                                                              <th scope="col" style="width:10%;">Unit Cost</th>                                                    
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                            <?php foreach($pr as $row){ ?>
                                                              <tr>
                                                                  <td>
                                                                     <input type="hidden" name="id[]" value="<?php echo $row['id'];?>" >
                                                                    <input type='text' 
                                                                    value="<?php echo $row['ORNumber'];?>" required 
                                                                    class='form-control-sm form-control' 
                                                                    name='or[]'/>
                                                                  </td>
                                                                  <td><?php echo $row['unit'];?></td>
                                                                  <td><?php echo $row['item_description'];?></td>
                                                                  <td><?php echo $row['qty'];?></td>
                                                                  <td>
                                                                    <input type='text' required 
                                                                    class='form-control-sm form-control unit_cost'  name='unit_cost[]'
                                                                    value="<?php echo number_format($row['amount_per_unit'],2);?>"/>
                                                                 </td>
                                                              </tr> 
                                                            <?php } ?>      
                                                          </tbody>
                                                      </table>
                                                  </div>

                                              </div>
                                        </div>                                  
                                        <div class="form-group">
                                          <div class="form-row">
                                              <div class="col-md-4">
                                                <?php if(access_role("Purchase Requests","save_changes",$_SESSION['user_type'])){?>
                                                  <button type="submit" name="submit" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                                <?php } ?>
                                              </div>
                                              <br/><br/>
                                        
                                          </div>

                                       </div>
                              </form> 
                              <br/>
                      </div>                     
                  </div>                
           </div>
     
           <?php }else{?>
                         <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>ID Not Found, maybe because it is not exist.</small></h2>
           <?php } ?>              
      </div>
       <script src='assets/validator.min.js'></script>
       <script src='assets/numberFormat.js'></script>
      <script>
          $(document).ready(function(){

              $('.unit_cost').keyup(function (event) {
                      // skip for arrow keys
                      if (event.which >= 37 && event.which <= 40) {
                          event.preventDefault();
                      }
                      var currentVal = ($(this).val()=="")? '0.00':$(this).val();                    

                      var testDecimal = testDecimals(currentVal);
                      if (testDecimal.length > 1) {
                          console.log("You cannot enter more than one decimal point");
                          currentVal = currentVal.slice(0, -1);                      }

                      $(this).val(replaceCommas(currentVal));
              });

              $('#form').validator();
              $('#form').on('submit', function (e) {
              // if the validator does not prevent form submit
                   if (!e.isDefaultPrevented()) {
                      bootbox.confirm({
                                        size: "small",                                         
                                        message: "Are you sure?", 
                                        callback: function(result){ 
                                          
                                              if(result){
                                                    var url = "phpscript/purchase_request/save_approve_detail_pr.php";

                                                    // POST values in the background the the script URL
                                                    $.ajax({
                                                        type: "POST",
                                                        url: url,
                                                        dataType   : 'json',
                                                        data: $("#form").serialize(),
                                                        success: function (data)
                                                        {
                                                            $('.alert').removeClass('alert-success, alert-danger')
                                                                       .addClass(data.type)
                                                                       .html(data.message)
                                                                       .fadeIn(100,function(){
                                                                           $(this).fadeOut(5000);
                                                                       });
                                                            if(data.type=='alert-success'){
                                                                $("[type='submint']").remove();
                                                            }

                                                        }
                                                    });
                                              }
                                       }
                                    });
                             return false;
                    }              
          });
        });     
      </script> 
      
       <?php }else{ echo UnauthorizedOpenTemp(); } ?>

      </main>
     
     
<?php require_once('layout/footer.php');?>      
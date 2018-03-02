<?php 
  require_once('layout/header.php'); 
  require_once('classes/function.php'); 

  $customer_name="";
  $customer_address="";
  $total_amount=0.00;
  $rental=array();
  $selection_for="";

  $found=true;
  $cancel=false;
  if(isset($_GET['transaction_id'])){
      $out=customer_change_selection($_GET['transaction_id']);
      $op=$_GET['transaction_id'];
      if(count($out['rental'])>0){
          $cancel=true;
          $customer_name=($out['selection_for']=="sales")? $out['sales'][0]['customer_name']:$out['rental'][0]['customer_name'];
          $customer_address=($out['selection_for']=="rental")? $out['rental'][0]['customer_address']:$out['sales'][0]['customer_address'];
          $total_amount=$out['total_amount'];
          $rental=$out['rental'];
          $sales_id=$out['rental'][0]['sales_id'];
          $selection_for=$out['selection_for'];
      }else{
        $found=false;
      }
     

  }
?>
   
   <!-- <script type="text/javascript" src="https://www.tutorialrepublic.com/examples/js/typeahead/0.11.1/typeahead.bundle.js"></script>
   <script type="text/javascript" src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script> -->
   <script type="text/javascript" src="assets/typeahead.bundle.js"></script>
   <script type="text/javascript" src="assets/handlebars.js"></script>
     <script src="assets/moment.min.js"></script>
   <script type="text/javascript" src="assets/typeahead-rental.js"></script>
   <link href="assets/typeahead.css" rel="stylesheet">
    <link href="assets/bootstrap-datepicker3.min.css" rel="stylesheet">  
    <script src="assets/bootstrap-datepicker.min.js"></script>

   <style>
      #total_and_change h1{
        border-bottom:none;
        margin-bottom: 0px;
        text-align: center;
      }

      .form-group{
        margin-bottom: 0px;
      }

      #total_amount_cont{
        background: black;
        color: #28a745;
        border-radius:5px;
        border: 2px solid #28a745;
      }
   </style>
<?php require_once('layout/nav.php');?>

 
    <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if($found){ ?>
<?php if(access_role("Rental or Product Selection","view_page",$_SESSION['user_type'])){?>
                 <nav aria-label="breadcrumb" role="navigation">
                  <?php if($cancel){?>
                       <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><a href='item-selection-list.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Transaction List</a> / Cancelation of Transaction</li>
                      </ol>
                    <?php } ?>

                     <?php if ($cancel && $selection_for=='rental'){ ?>
                        <ul class="nav nav-tabs">
                           
                              <li class="nav-item">
                                  <a class="nav-link active"> <i class="fa fa-hand-pointer-o" ></i> Rental Selection</a>
                              </li>                         
                          </ul>
                     
                    <?php }else{ ?>
                        <ul class="nav nav-tabs">
                              <li class="nav-item ">
                                   <a class="nav-link active" href="item-selection-rental.php"><i class="fa fa-hand-pointer-o" ></i> Rental Selection</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link " href="item-selection.php"> <i class="fa fa-hand-pointer-o" ></i> Product Selection</a>
                              </li>                         
                          </ul>

                    <?php } ?>
                </nav>
          <br/>
           <form data-toggle="validator" role="form" id="form">
             <div class="row">
                <div class="col-sm-8">
                  <div class="row">
                     <div class="col-sm-6 form-group">
                          <label>Customer Name:</label>
                          <input <?php echo ($cancel)?"disabled":"";?> autocomplete="off" data="name" type="text" name="customer_name" placeholder="Type here.." class="form-control form-control-sm" required value="<?php echo $customer_name;?>" />
                                               
                    </div>
                    <div class="col-sm-6 form-group">
                          <label>Customer Address:</label>
                          <input <?php echo ($cancel)?"disabled":"";?> autocomplete="off" type="text" data="address" name="customer_address" placeholder="Type here.." class="form-control form-control-sm" value="<?php echo $customer_address;?>" />    
                          <br/>                

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                          <label>Enter Rental Item</label>
                          <input <?php echo ($cancel)?"disabled":"";?>  autocomplete="off" type="text" class="typeahead tt-query form-control form-control-sm"  spellcheck="false" data-provide="typeahead" placeholder="Type here.." />
                          <img class="Typeahead-spinner" src="assets/img/spinner.gif" >
                           <br/>
                    </div>
                    <div class="col-sm-6">
                          <label>Date Return (YYYY-MM-DD)</label>
                          <input <?php echo ($cancel)?"disabled":"";?>  style="background:white;" readonly="" type="text" data-date-format="yyyy-mm-dd" class="date_return form-control form-control-sm"  placeholder="" />
                    </div>
                  </div>            

                </div>
                <div class="col-sm-3" id="total_and_change">
                  <br/><br/>
                     <div class="col-sm-12" id="total_amount_cont">
                        <span>Total Amount</span>
                        <h1 id="total_amount" >&#8369; <?php echo number_format($total_amount,2);?></h1>
                        <input type='hidden' id="total_amount_" name="total_amount">                 
                     </div>
                      <br/>
                </div>
              </div>
                
                <div class="row">
                    <div class="table-responsive col-sm-8" style="height: 386px;overflow-y:auto;">
                            <table class="table table-hover table-dark table-striped" id="dataTable">
                              <thead class="thead-dark">
                                <tr>
                                  <th></th>
                                  <th>Description</th>
                                  <th>Unit Price</th>
                                  <th colspan="2"># of Days</th>
                                  <th>Amount</th>
                                  <th>Date Return</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                    $i=2;
                                    foreach($rental as $res){
                                ?>                          
                                <tr id="row<?php echo $i;?>" row="_<?php echo $i;?>" num="<?php echo $i;?>">
                                      <td>
                                        <input type="hidden" value="<?php echo $res['rental_specific_id'];?>" name="rental_specific_id[]">
                                        <input type="hidden" value="<?php echo $res['rental_id'];?>" name="rental_id[]">
                                        <h5 class="close_item" onclick="remove_selected(<?php echo $i;?>,<?php echo $res['rental_specific_id'];?>)">&Cross;</h5>
                                      </td>
                                      <td><?php echo $res['item_name']."(".$res['item_description'].")";?></td>
                                      <td><?php echo number_format($res['rental_fee'],2);?>/<?php echo ($res['per_day']=='Y')?'day':'rent';?></td>
                                      <td  colspan="2">                                  
                                        <div id="_<?php echo $i;?>"><?php echo $res['no_of_days'];?></div>
                                      </td>
                                      <input type="hidden" id="a_<?php echo $i;?>" name="amount[]" value="<?php echo $res['rental_fee_amount'];?>"/>
                                      <td class="amount" amount="<?php echo $res['rental_fee_amount'];?>"><?php echo number_format($res['rental_fee_amount'],2);?></td>
                                      <td><?php echo date('M d, Y',strtotime($res['date_return']));?></td>                                
                                      
                                </tr>
                                <?php $i++; } ?>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="2"></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                               
                                                      
                              </tbody>
                            </table>
                    </div>
                    <div class="col-sm-3" style="height: 221px;border:1px solid silver;background: #f8f9f5e6;">   
                        <br/>               
                        <label> Transaction ID:</label>
                        <div class="form-group">                
                          <input style="font-weight: bolder;" autocomplete="off" readonly="" type="text" class="form-control"  name="transaction_id" value="<?php echo "RE".date('ymd-si');?>" >
                          
                        </div>
                        <hr/>
                           <?php if($cancel){?>

                            <table style="display: none;" id="data_canceled">

                            </table>
                             <div id="cancelation">
                                <div id="product_canceled_id" style="display: none;"></div>
                                <input type="hidden" name="cancel" value="cancel"/>
                                <input type="hidden" name="cancel_op" value="<?php echo $op;?>"/>
                                <input type="hidden" name="sales_id_sales_or" value="<?php echo $sales_id;?>"/>
                                <button type="submit" name="submit" class="btn btn-danger btn-block" style="padding: .375rem .75rem;font-size: 1rem;" ><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save Changes</button>
                                <span id="rollback" onclick="rollback()" class="btn btn-primary btn-block" style="padding: .375rem .75rem;font-size: 1rem;display: none;" >&nbsp;Rollback 1 Canceled</span>
                            </div>
                      <?php }else{ ?>
                        <?php if(access_role("Rental or Product Selection","save_changes",$_SESSION['user_type'])){?> 
                               <button type="submit" name="submit" class="btn btn-primary btn-block" style="padding: .375rem .75rem;font-size: 1rem;" ><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save Selection</button>
                        <?php 
                          }
                        } 
                        ?>
                       
                      
                    </div>
                  </div>
                </form>

                <script src='assets/validator.min.js'></script>   
                <script src='assets/numberFormat.js'></script>   
                <script id="empty-template" type="text/x-handlebars-template">
                      <div class="EmptyMessage">Your search turned up 0 results. Maybe because the item is out of stock </div>
                </script>

                <script id="result-template" type="text/x-handlebars-template">
                       <div style="border-bottom: 1px solid silver;">                        
                                    <strong style="width:60%">{{item_name}}</strong>
                                    <label>{{item_description}}</label>
                                    <h6 style="float:right;">&#8369; {{rental_fee}}/{{unit}}</h6>

                              <br/>
                              <small>ITEM CODE: {{item_code}}</small> 
                              <small class="{{#if_eq availability 'Available'}} badge badge-success {{else}} badge badge-danger {{/if_eq}}" style="float:right;">{{availability}}</small>           
                       </div>
                </script>
                <script src="assets/requiredJS/rental-selection.js"></script>
                <script>

                  $(document).ready(function(){

                    $('.date_return').datepicker({
                            autoclose: true,
                            clearBtn: true,
                            todayHighlight: true,
                            startDate: new Date()    
                    });
                  })

                   Handlebars.registerHelper('if_eq', function(a, b, opts) {
                        if (a == b) {
                            return opts.fn(this);
                        } else {
                            return opts.inverse(this);
                        }
                    }); 
                
                </script>
                <script src="assets/requiredJS/auto_complete_input.js"></script>
<?php }else{ echo UnauthorizedOpenTemp(); } ?>
<?php }else{ ?>
      <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>Transaction Not Found, maybe because it is not exist.</small></h2>
<?php } ?>
  </main>
          
<?php require_once('layout/footer.php');?>      
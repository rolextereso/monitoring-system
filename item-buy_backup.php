<?php 
   require_once('layout/header.php');
   require_once('classes/Crud.php');
   require_once('classes/function.php');

    $crud = new Crud();     
    $found=false;
    $sales_id="";
    $selection_for="";

    if(isset($_GET['transaction_id'])){
        //getting id from url
        $id = $crud->escape_string($_GET['transaction_id']);
        //selecting data associated with this particular id
        $sales = $crud->getData("SELECT sr.sales_id, "
                                 ."           customer_name,"
                                 ."           customer_address,"
                                 ."           p.product_name,"
                                 ."          pp.price,"
                                 ."           p.unit_of_measurement,"
                                 ."           ss.amount,"
                                 ."          ss.quantity FROM sales_specific ss"
                                 ."   INNER JOIN sales_record sr ON ss.or_number=sr.sales_id"
                                 ."   INNER JOIN customer c ON c.customer_id =sr.customer_id"
                                 ."   INNER JOIN products p ON p.product_id=ss.product_id"
                                 ."  INNER JOIN product_price pp ON pp.price_id=p.product_price"
                                 ."  WHERE ss.paid='N' AND sr.or_number ='' AND transaction_id='$id';");
        
        $rental=$crud->getData("SELECT 
                                  ri.transaction_id,   
                                  ri.item_name,
                                  ri.item_description,
                                  ri.rental_fee,
                                  ri.per_day,
                                  rs.rental_fee_amount,
                                  rs.no_of_days,
                                  c.customer_name,
                                  c.customer_address,
                                  rs.sales_id
                                  FROM rental_items ri
                                LEFT JOIN rental_specific rs ON rs.rental_id=ri.rental_id
                                LEFT JOIN customer c ON c.customer_id=rs.customer_id 
                                WHERE rs.paid='N' AND ri.transaction_id='$id';");

       

        if(count($sales)>=1){
            $found=true;
            $selection_for="sales";
            $total_amount=0;

            foreach($sales as $res_){
                $total_amount+=$res_['amount'];
                $sales_id=$res_['sales_id'];
            } 
        }else if(count($rental)>=1){
            $found=true;
            $total_amount=0;
            $selection_for="rental";

            foreach($rental as $res_){
                $total_amount+=$res_['rental_fee_amount'];
                $sales_id=$res_['sales_id'];
            } 
        }
       
       
    }
?>
   
   <!-- <script type="text/javascript" src="https://www.tutorialrepublic.com/examples/js/typeahead/0.11.1/typeahead.bundle.js"></script>
   <script type="text/javascript" src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script> -->
   <script type="text/javascript" src="assets/typeahead.bundle.js"></script>
   <script type="text/javascript" src="assets/handlebars.js"></script>
   <script type="text/javascript" src="assets/typeahead.js"></script>
   <link href="assets/typeahead.css" rel="stylesheet">  
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
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <a href="item-selection-list.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Selection List</a>
                    <li class="breadcrumb-item active" aria-current="page"></li>
              </ol>
          </nav>
    <?php 
        if(!access_role("Transaction List","view_page",$_SESSION['user_type'])){
    ?>
           <h2 style="text-align: center;width: 100%;"><span style='color:red;'>Unauthorized Access:</span><br/><small>You don't have permission to open this page.</small></h2>
    <?php }else if($found){ ?>
     <form data-toggle="validator" role="form" id="form">
       <div class="row">
          <div class="col-sm-8">
            <div class="row">
               <div class="col-sm-6 form-group">
                    <label>Customer Name:</label>
                    <input  <?php echo ($found)?"readonly":"";?> autocomplete="off" type="text" name="customer_name" placeholder="Type here.." class="form-control form-control-sm" required value="<?php echo ($selection_for=="sales")?$sales[0]['customer_name']:$rental[0]['customer_name'];?>" />
                                         
              </div>
              <div class="col-sm-6 form-group">
                    <label>Customer Address:</label>
                    <input  <?php echo ($found)?"readonly":"";?> autocomplete="off" type="text" name="customer_address" placeholder="Type here.." class="form-control form-control-sm" required value="<?php echo ($selection_for=="sales")?$sales[0]['customer_address']:$rental[0]['customer_address'];?>"/>    
                    <br/>                

              </div>
            </div>
            <div class="row">
              <input type="hidden" name="selection_for" value="<?php echo $selection_for;?>"/>
              <input type="hidden" name="sales_id" value="<?php echo $sales_id;?>">
              <div class="col-sm-12">
                    <label>Enter Product Item</label>
                    <input <?php echo ($found)?"readonly":"";?> autocomplete="off" type="text" class="typeahead tt-query form-control form-control-sm" autocomplete="off" spellcheck="false" placeholder="Type here.." />
                    <img class="Typeahead-spinner" src="assets/img/spinner.gif" >
                     <br/>
              </div>
            </div>            

          </div>
          <div class="col-sm-3" id="total_and_change">
               <div class="col-sm-12" id="total_amount_cont">
                  <span>Total Amount</span>
                  <h1 id="total_amount" >&#8369; <?php echo number_format($total_amount,2);?></h1>
                  <input type='hidden' id="total_amount_" name="total_amount" value="<?php echo $total_amount;?>">                 
               </div>
              <div class="col-sm-12" style="display:none;">
                  <span>Change:</span>
                  <h1 id="change">&#8369; 0.00</h1>                 
               </div>
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
                            <th colspan="2"><?php echo ($selection_for=="sales")?"Quantity":"# of days";?></th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php if($selection_for=="sales"){ ?>
                                        <?php
                                            $i=2;
                                            foreach($sales as $res){
                                        ?>                          
                                        <tr id="row<?php echo $i;?>" row="_<?php echo $i;?>" num="<?php echo $i;?>">
                                              <td></td>
                                              <td><?php echo $res['product_name'];?></td>
                                              <td><?php echo number_format($res['amount'],2);?>/<?php echo $res['unit_of_measurement'];?></td>
                                              <td>                                  
                                                <div id="_<?php echo $i;?>"><?php echo $res['quantity'];?></div>
                                              </td>
                                              <td></td>                                
                                              <td><?php echo number_format($res['amount'],2);?></td>
                                        </tr>
                                        <?php $i++; } ?>

                          <?php } else if($selection_for=="rental"){?>
                                       <?php
                                            $i=2;
                                            foreach($rental as $res){
                                        ?>                          
                                        <tr id="row<?php echo $i;?>" row="_<?php echo $i;?>" num="<?php echo $i;?>">
                                              <td></td>
                                              <td><?php echo $res['item_name']."(".$res['item_description'].")";?></td>
                                              <td><?php echo number_format($res['rental_fee'],2);?>/<?php echo ($res['per_day']=='Y')?'day':'rent';?></td>
                                              <td>                                  
                                                <div id="_<?php echo $i;?>"><?php echo $res['no_of_days'];?></div>
                                              </td>
                                              <td></td>                                
                                              <td><?php echo number_format($res['rental_fee_amount'],2);?></td>
                                        </tr>
                                        <?php $i++; } ?>

                          <?php } ?>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>
                           <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>
                           <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                          </tr>                       
                        </tbody>
                      </table>
              </div>
              <div class="col-sm-3" style="border:1px solid silver;background: #f8f9f5e6;">                  
                  <label> OR Number:</label>
                  <div class="input-group form-group">                
                    <input autocomplete="off" type="text" class="form-control" placeholder="xxxx-xxx-xxx" name="or" required >
                  </div>
                  <hr/>
                  <label> Amount Tendered:</label>
                  <div class="input-group form-group">
                    <span class="input-group-addon" id="basic-addon1">&#8369;</span>
                    <input autocomplete="off" type="text" id="amount" name="amount_tendered" class="form-control" placeholder="0.00"  required>
                  </div>
                  <hr/>
                  <label> Mode of Payment:</label>
                  <div class="input-group form-group">
                      <select name="mode-payment" class="form-control">
                          <option value="cash">Cash</option>
                          <option value="check">Check</option>
                      </select>
                  </div>
                  <hr/>
                   <?php if(access_role("Transaction List","Save_changes",$_SESSION['user_type'])){?>
                         <button type="submit" name="submit" class="btn btn-primary btn-block" style="padding: .375rem .75rem;font-size: 1rem;" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Save Payment</button>   

                    <?php } ?>              
                
              </div>
            </div>
          </form>
          <?php } else { ?>
                        <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>Transaction Not Found, maybe because it is not exist.</small></h2>

          <?php } ?>
        </main>
          <script src='assets/validator.min.js'></script>   
          <script src='assets/numberFormat.js'></script>   
          <script id="empty-template" type="text/x-handlebars-template">
                <div class="EmptyMessage">Your search turned up 0 results. Maybe because the item is out of stock </div>
          </script>

          <script id="result-template" type="text/x-handlebars-template">
                 <div style="border-bottom: 1px solid silver;">                        
                              <strong style="width:60%">{{product_name}}</strong>
                              <h6 style="float:right;">&#8369; {{price}}/{{unit_of_measurement}}</h6>
                        <br/>
                        <small>Project Name: {{project_name}}</small>            
                 </div>
          </script>
          <script src="assets/requiredJS/buy.js"></script>
<?php require_once('layout/footer.php');?>      
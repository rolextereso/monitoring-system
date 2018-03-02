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
        $exploded = explode("@:",$crud->escape_string($_GET['transaction_id']));

        $id=$exploded[0];
        $customer_id_=(isset($exploded[1]))?$exploded[1]:"";

        $get = $crud->getData("SELECT order_payment_id as salary_deduction
                                FROM bundle_remittance WHERE remittance_id=1 ");
        $etc="etc.";
        $salary_deduction="false";
        if($id==$get[0]['salary_deduction']){
                    $etc="";
                    $salary_deduction="true";
        }



        //selecting data associated with this particular id
        $sales = $crud->getData("SELECT sr.sales_id, 
                                          CASE WHEN count(ss.transaction_id)>1 THEN CONCAT(customer_name,' $etc') ELSE customer_name END  AS customer_name, 
                                          CASE WHEN count(ss.transaction_id)>1 THEN CONCAT(customer_address,' $etc') ELSE customer_address END  AS customer_address,
                                          p.product_name,
                                          pp.price,
                                          p.unit_of_measurement,
                                          ss.amount,
                                          GROUP_CONCAT(sr.sales_id) as sales_id_,
                                          ss.quantity FROM sales_specific ss
                                    INNER JOIN sales_record sr ON ss.or_number=sr.sales_id
                                    INNER JOIN customer c ON c.customer_id =sr.customer_id
                                    INNER JOIN products p ON p.product_id=ss.product_id
                                    INNER JOIN product_price pp ON pp.price_id=p.product_price
                                    WHERE ss.paid='N' AND sr.or_number ='' AND transaction_id='$id' AND c.customer_id=$customer_id_;");
        
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

       

        if(count($sales)>=1 && $sales[0]['sales_id']!=""){
            $found=true;
            $selection_for="sales";
            $total_amount=0;

            foreach($sales as $res_){
                $total_amount+=$res_['amount'];
                $sales_id=$res_['sales_id_'];
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
   <script type="text/javascript" src="assets/or_number_search.js"></script>
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

      #mark_saved{
        text-align: center;
        border: 1px solid #63ab63;
        padding: 17px;
        color: green;
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
                    <input  <?php echo ($found)?"readonly":"";?> autocomplete="off" type="text" name="customer_address" placeholder="Type here.." class="form-control form-control-sm"  value="<?php echo ($selection_for=="sales")?$sales[0]['customer_address']:$rental[0]['customer_address'];?>"/>    
                    <br/>                

              </div>
            </div>
            <div class="row">
              <input type="hidden" name="selection_for" value="<?php echo $selection_for;?>"/>
              <input type="hidden" name="sales_id" value="<?php echo $sales_id;?>">
              <input type="hidden" name="salary_deduction" value="<?php echo $salary_deduction; ?>">
              <div class="col-sm-12">
                    <label>Enter OR Number of the paid item(s)</label>
                    <input autocomplete="off" type="text" class="typeahead tt-query form-control form-control-sm" autocomplete="off" spellcheck="false" placeholder="Type here.."  id="or_number_input"  />
                    <img class="Typeahead-spinner" src="assets/img/spinner.gif" >
                     <br/>
              </div>
            </div>            

          </div>
          <div class="col-sm-3" id="total_and_change">
               <div class="col-sm-12" id="total_amount_cont">
                  <span>Total Amount Paid in the Cashier</span>
                  <h1 id="total_amount" >&#8369; <span>0</span></h1>
                  <input type='hidden' id="total_amount_" name="total_amount" value="<?php echo $total_amount;?>">                 
               </div>
             
          </div>
        </div>
          
          <div class="row">
              <div class="table-responsive col-sm-8" style="height: 386px;overflow-y:auto;">
                      <table class="table table-hover table-dark table-striped" id="dataTable">
                        <thead class="thead-dark">
                          <tr>
                           
                            <th>OR Number</th>
                            <th>Item Name/Description</th>
                            <th>Amount</th>
                            <th>Date Paid</th>
                          </tr>
                        </thead>
                        <tbody>

                         
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                           
                            <td></td>
                          </tr>
                           <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                           
                            <td></td>
                          </tr>
                           <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                           
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                           
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                          
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                           
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                           
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                           
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                           
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                           
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                           
                            <td></td>
                          </tr>                       
                        </tbody>
                      </table>
              </div>
              <div class="col-sm-3" style="border:1px solid silver;background: #f8f9f5e6;">                  
                  <label> OR Number:</label>
                  <div class="input-group form-group">                
                    <input readonly autocomplete="off" type="text" class="form-control" placeholder="xxxx-xxx-xxx" name="or" required >
                  </div>
               
                  <hr/>
                  <div id="save_changes_">
                   <?php if(access_role("Transaction List","Save_changes",$_SESSION['user_type'])){?>
                         <button type="submit" name="submit" class="btn btn-primary btn-block" style="padding: .375rem .75rem;font-size: 1rem;" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Mark as Paid</button>   

                    <?php } ?>  
                  </div>            
                
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
                <div class="EmptyMessage">Your search turned up 0 results. Maybe because the OR Number not exists </div>
          </script>

          <script id="result-template" type="text/x-handlebars-template">
                 <div style="border-bottom: 1px solid silver;">                        
                              OR Number: <strong style="width:60%">{{ORNo}}</strong>
                             
                        <br/>
                        <small>Date Paid: {{date_paid}}</small>            
                 </div>
          </script>
          <script src="assets/requiredJS/buy.js"></script>
<?php require_once('layout/footer.php');?>      
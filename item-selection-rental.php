<?php 
  require_once('layout/header.php'); 
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

<?php if(access_role("Rental or Product Selection","view_page",$_SESSION['user_type'])){?>
                 <nav aria-label="breadcrumb" role="navigation">
                    <ul class="nav nav-tabs">
                          <li class="nav-item">
                               <a class="nav-link active" href="item-selection-rental.php"><i class="fa fa-hand-pointer-o" ></i> Rental Selection</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="item-selection.php"> <i class="fa fa-hand-pointer-o" ></i> Product Selection</a>
                          </li>
                         
                    </ul>
                </nav>
          <br/>
           <form data-toggle="validator" role="form" id="form">
             <div class="row">
                <div class="col-sm-8">
                  <div class="row">
                     <div class="col-sm-6 form-group">
                          <label>Customer Name:</label>
                          <input autocomplete="off" data="name" type="text" name="customer_name" placeholder="Type here.." class="form-control form-control-sm" required />
                                               
                    </div>
                    <div class="col-sm-6 form-group">
                          <label>Customer Address:</label>
                          <input autocomplete="off" type="text" data="address" name="customer_address" placeholder="Type here.." class="form-control form-control-sm" required/>    
                          <br/>                

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                          <label>Enter Rental Item</label>
                          <input  autocomplete="off" type="text" class="typeahead tt-query form-control form-control-sm"  spellcheck="false" data-provide="typeahead" placeholder="Type here.." />
                          <img class="Typeahead-spinner" src="assets/img/spinner.gif" >
                           <br/>
                    </div>
                    <div class="col-sm-6">
                          <label>Date Return (YYYY-MM-DD)</label>
                          <input required="" style="background:white;" readonly="" type="text" data-date-format="yyyy-mm-dd" class="date_return form-control form-control-sm"  placeholder="" />
                    </div>
                  </div>            

                </div>
                <div class="col-sm-3" id="total_and_change">
                  <br/><br/>
                     <div class="col-sm-12" id="total_amount_cont">
                        <span>Total Amount</span>
                        <h1 id="total_amount" >&#8369; 0.00</h1>
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
                    <div class="col-sm-3" style="height: 184px;border:1px solid silver;background: #f8f9f5e6;">   
                        <br/>               
                        <label> Transaction ID:</label>
                        <div class="input-group form-group">                
                          <input style="font-weight: bolder;" autocomplete="off" readonly="" type="text" class="form-control"  name="transaction_id" value="<?php echo "RE".date('ymd-si');?>" >
                          
                        </div>
                        <hr/>
                        <?php if(access_role("Rental or Product Selection","save_changes",$_SESSION['user_type'])){?> 
                               <button type="submit" name="submit" class="btn btn-primary btn-block" style="padding: .375rem .75rem;font-size: 1rem;" ><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save Selection</button>
                        <?php } ?>
                       
                      
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
    </main>
          
<?php require_once('layout/footer.php');?>      
<?php 
    require_once('layout/header.php');
    require_once('classes/Crud.php');
    $crud = new Crud();
    $products = $crud->getData("SELECT product_id, product_name FROM products;"); 
?>   

 <link href="assets/bootstrap-datepicker3.min.css" rel="stylesheet">
 <style>
      #dateto, #datefrom{
        background: white;
      }
 </style>
 
<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
              </ol>
           </nav>

               <div class="card">
                    <div class="card-header ">
                        <b>Product Wise Revenue of Project</b> 
                        <button onclick="pieChart()" title="Refresh" style="float:right;" class="btn btn-secondary" type="button" id="print"><i class="fa fa-refresh"></i> </button>                                 
                    </div>
                    <div class="card-body">
                        <div id="piechartContainer" style="height: 350px; width: 100%;"></div> 
                    </div>
              </div>
              <br/>
               <div class="card">
                    <div class="card-header ">
                      <div class="row">
                            <div class="form-group col-sm-4">
                                  <label for="exampleInputEmail1"><b>By Product</b></label>
                                  <select required class="form-control form-control-sm" id="product" name="access_role">
                                        <option value=""> Select All Products</option>
                                                              <?php
                                                                  foreach ($products as $res) {
                                                              ?>
                                                              <option value="<?php echo $res['product_name'];?>">
                                                                <?php echo $res['product_name'];?></option>                                                                         
                                                              <?php } ?>
                                  </select>
                           </div>
                           <div class="form-group col-sm-7">
                                  <label> <b>Search by date:</b></label>                                                     
                                         <div class="input-daterange input-group" id="datepicker">
                                            <input type="text" readonly="" data-date-format="yyyy-mm-dd" class="input-sm form-control form-control-sm" name="start" id="datefrom" placeholder="Date From" />
                                            <span class="input-group-addon"> &nbsp;to&nbsp; </span>
                                            <input type="text" readonly="" data-date-format="yyyy-mm-dd" class="input-sm form-control form-control-sm" name="end" id="dateto" placeholder="Date To" />
                                            <span class="input-group-btn">
                                               <button class="btn btn-secondary" type="button" onclick="lineGraphByProduct()">Search</button>
                                            </span>
                                            <span class="input-group-btn">
                                               <button class="btn btn-secondary" type="button" id="print"><i class="fa fa-print"></i> </button>
                                            </span>
                                        </div>
                          </div>
                       </div>                                   
                    </div>
                    <div class="card-body">
                              <div id="chartContainer" style="height: 400px; width: 100%;"></div> 
                    </div>
              </div>
              <div>
        </div>
      </main>

      
      <script src="assets/bootstrap-datepicker.min.js"></script>
      <script src="assets/requiredJS/dashboard.js"></script>
 
      <script type="text/javascript" src="assets/canvasjs.min.js"></script>
     
<?php require_once('layout/footer.php');?>      
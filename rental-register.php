<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

    

    $item_id   = "";
    $item_name = "";
    $item_code = "";
    $rental= "";
    $item_description="";
    $price_id="";
    $unit_of_measurement ="";
    $status="";
    $found=false;
    $add=true;

    if(isset($_GET['edit'])){

        $id = $crud->escape_string($_GET['edit']);

       if(is_numeric($id) && $id!=''){
              $products = $crud->getData("SELECT * FROM products p ".
                                         "INNER JOIN product_price pp ON pp.price_id= p.product_price WHERE product_id=".$_GET['edit']);

              $found=(count($products)==1)?true:false;

              $add=false;
              
              foreach ($products as $res) {
                  $item_id      = $res['product_id'];
                  $item_name    = $res['product_name'];
                  $rental       =$res['price'];
                  $price_id     = $res['product_price'];
                  $item_code    = $res['item_code'];
                  $unit_of_measurement =$res['unit_of_measurement'];
                  $product_status =$res['product_status'];
                  
              }
        }
    }  
?>   
<link href="assets/bootstrap-datepicker3.min.css" rel="stylesheet">
<style>

  .has-error .form-control {
    border-color: #a94442;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
  }

</style>

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='setting.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Setting</a> / Rental /<h2><?php echo  $item_name;?></h2> </li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                    <i class="fa fa-cube" aria-hidden="true"></i>  <?php echo($add)?'Add':'Edit';?> Item for Rental
              </div>
              <div class="card-body">
                 <?php if($found || $add){?>
                      <div class="row">
                        <div class="col-md-12">
                               <form data-toggle="validator" role="form" id="form">
                                        <?php 
                                          if($found){
                                        ?>
                                            <input id="item_id" type="hidden" name="item_id" value="<?php echo $item_id;?>">
                                            <input type="hidden" name="price_id" value="<?php echo $price_id;?>">
                                        <?php } ?>

                                        
                                        <div class="form-row">
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                        <label>Item Code </label>
                                                        <input type="text"  class="form-control form-control-sm" readonly="" name="item_code" value="<?php echo date('yms-is');?>">
                                                  </div>
                                                  <div class="form-group">
                                                        <label >Machinery or Facilities *</label>
                                                        <input class="form-control form-control-sm" id="item_name" name="item_name" type="text"  placeholder="Enter here" required 
                                                        value="<?php echo $item_name;?>">
                                                  </div>

                                                   <div class="form-group">
                                                   <label>Item Description</label>
                                                        <textarea  rows="5" class="form-control " id="item_desc" name="item_desc" style="margin-top: 0px; margin-bottom: 0px;">
                                                          <?php echo($item_description=='')?'':$item_description;?></textarea>
                                                  </div>

                                                  <div class="form-group">
                                                        <label >Unit *</label>
                                                        <input class="form-control form-control-sm" id="measurement" name="measurement" type="text"  placeholder="example: set" required value="<?php echo $unit_of_measurement;?>">
                                                  </div>

                                                  <div class="form-group">
                                                        <label >Rental Fee*</label>
                                                        <input class="form-control form-control-sm" id="rental" name="rental" type="text"  placeholder="0.00" required value="<?php echo $rental;?>">
                                                  </div>

                                                 
                                                  <div class="form-group">
                                                              <label for="check">Status</label>                                                  
                                                              <input  id="status" name="status" type="checkbox"
                                                              <?php echo($status=='Y')?'checked':'';?> />
                                                              <span id="stat" class="italic <?php echo($status=='Y')?'green':'red';?>"><?php echo($status=='Y')?'(Active)':'(Unactive)';?></span>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                      <label>Item per Unit</label>
                                                      <h1><span id="rental_"><?php echo ($rental=="")?'Rental Fee':$rental;?></span>/<span id="measurement_"><?php echo ($unit_of_measurement=="")?'Unit':$unit_of_measurement;?></span></h1>
                                                  </div>

                                              </div>
                                        </div>
                                      
                                       
                                       
                                        <div class="form-group">
                                          <div class="form-row">
                                              <div class="col-md-6">
                                                  <button type="submit" name="submit" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Register</button>
                                              </div>
                                              <br/><br/>
                                        
                                              <div class="col-md-6">
                                                  <button id="cancel" class="btn btn-danger btn-block" data-toggle="confirmation" ><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
                                              </div>
                                          </div>

                                      </div>
                              </form> 
                              <br/>
                      </div>
                     
                  </div>

                  <?php }else{?>
                         <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>Machinery or Equipment Not Found, maybe because it is not exist.</small></h2>


                  <?php } ?>
              </div>
        </div>
        </div>
      </main>


<script src='assets/validator.min.js'></script>
<script src="assets/bootstrap-datepicker.min.js"></script>   
<script src="assets/numberFormat.js"></script>  
<script src="assets/requiredJS/rental-register.js"></script>
<?php require_once('layout/footer.php');?>      
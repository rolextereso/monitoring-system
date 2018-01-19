<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

    
    $item_id   = "";
    $item_name="";
    $item_code = "";
    $item_description= "";
    $rental_fee="";
    $unit_of_measurement   = "";
    $per_day ="";
    $need_gate_pass="";
    $status="";
    $found=false;
    $add=true;

    if(isset($_GET['r_id'])){

        $id = $crud->escape_string($_GET['r_id']);

       if(is_numeric($id) && $id!=''){
              $rental = $crud->getData("SELECT * FROM rental_items r ".
                                         " WHERE rental_id=".$id);

              $found=(count($rental)==1)?true:false;

              $add=false;
              
              foreach ($rental as $res) {
                $item_id=$res['rental_id'];
                $item_name=$res['item_name'];
                $item_code=$res['item_code'];
                $item_description=$res['item_description'];
                $rental_fee=$res['rental_fee'];
                $unit_of_measurement=$res['unit'];
                $status=$res['status'];
                $per_day=$res['per_day'];
                $need_gate_pass=$res['need_gate_pass'];
                  
                  
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
                    <li class="breadcrumb-item active" aria-current="page"><a href='rental-list.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Rental Item List</a> / Rental /<h2><?php echo  $item_name;?></h2> </li>
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
                                         
                                        <?php } ?>

                                        
                                        <div class="form-row">
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                        <label>Item Code </label>
                                                        <input type="text"  class="form-control form-control-sm" readonly="" name="item_code" value="<?php  echo($item_code=="")?date('yms-is'):$item_code;?>">
                                                  </div>
                                                  <div class="form-group">
                                                        <label >Machinery or Facilities *</label>
                                                        <input class="form-control form-control-sm" id="item_name" name="item_name" type="text"  placeholder="Enter here" required 
                                                        value="<?php echo $item_name;?>">
                                                  </div>

                                                   <div class="form-group">
                                                   <label>Item Description</label>
                                                        <textarea  rows="5" cols="1" class="form-control " id="item_description" name="item_description" ><?php echo($item_description=='')?'': $item_description;?></textarea>
                                                  </div>

                                                  <div class="form-group">
                                                        <label >Unit *</label>
                                                        <input class="form-control form-control-sm" id="measurement" name="unit" type="text"  placeholder="example: set" required value="<?php echo $unit_of_measurement;?>">
                                                  </div>

                                                  <div class="form-group">
                                                        <label >Rental Fee*</label>
                                                        <input class="form-control form-control-sm" id="rental_fee" name="rental_fee" type="text"  placeholder="0.00" required value="<?php echo $rental_fee;?>">
                                                  </div>

                                                 
                                                  <div class="form-group">
                                                              <label for="check">Status</label>                                                  
                                                              <input  id="status" name="status" type="checkbox"
                                                              <?php echo($status=='Y')?'checked':'';?> />
                                                              <span id="stat" class="italic <?php echo($status=='Y')?'green':'red';?>"><?php echo($status=='Y')?'(Active)':'(Unactive)';?></span>


                                                              <label for="check">Need Gate Pass?</label>                                                  
                                                              <input  id="gate_pass" name="gate_pass" type="checkbox"
                                                              <?php echo($need_gate_pass=='Y')?'checked':'';?> />
                                                              <span id="gpass" class="italic <?php echo($need_gate_pass=='Y')?'green':'red';?>"><?php echo($need_gate_pass=='Y')?'(Yes)':'(No)';?></span>

                                                              <label for="check">Rental Fee Per Day?</label>                                                  
                                                              <input  id="per_day" name="per_day" type="checkbox"
                                                              <?php echo($per_day=='Y')?'checked':'';?> />
                                                              <span id="perD" class="italic <?php echo($per_day=='Y')?'green':'red';?>"><?php echo($per_day=='Y')?'(Yes)':'(No)';?></span>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                      <label>Item per Unit</label>
                                                      <h1><span id="rental_"><?php echo ($rental_fee=="")?'Rental Fee':$rental_fee;?></span>/<span id="measurement_"><?php echo ($unit_of_measurement=="")?'Unit':$unit_of_measurement;?></span></h1>
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
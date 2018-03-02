<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

    $projects = $crud->getData("SELECT * FROM projects;");  

    $product_id   = "";
    $product_name = "";
    $price= "";
    $price_id="";
    $project_id   = "";
    $unit_of_measurement ="";
    $product_status="";
    $for_gate_pass="";
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
                  $product_id   = $res['product_id'];
                  $product_name = $res['product_name'];
                  $price        =$res['price'];
                  $price_id     = $res['product_price'];
                  $project_id   = $res['project_id'];
                  $unit_of_measurement =$res['unit_of_measurement'];
                  $product_status =$res['product_status'];
                  $for_gate_pass=$res['for_gate_pass'];
                  
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
                    <li class="breadcrumb-item active" aria-current="page"><a href='project-list.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> / Product /<h2><?php echo  $product_name;?></h2> </li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                    <i class="fa fa-cube" aria-hidden="true"></i>  <?php echo($add)?'Add':'Edit';?> Product
              </div>
              <div class="card-body">
                 <?php if($found || $add){?>
                      <div class="row">
                        <div class="col-md-12">
                               <form data-toggle="validator" role="form" id="form">
                                        <?php 
                                          if($found){
                                        ?>
                                            <input id="product_id" type="hidden" name="product_id" value="<?php echo $product_id;?>">
                                            <input type="hidden" name="price_id" value="<?php echo $price_id;?>">
                                        <?php } ?>

                                        
                                        <div class="form-row">
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                        <label >Product name*</label>
                                                        <input class="form-control form-control-sm" id="product_name" name="product_name" type="text"  placeholder="Enter product name" required 
                                                        value="<?php echo $product_name;?>">
                                                  </div>

                                                   <div class="form-group">
                                                  <label>Under of *:</label>
                                                        <select required class="form-control form-control-sm" id="project" name="project">
                                                              <option value=""> Select Project Name</option>
                                                              <?php
                                                                  foreach ($projects as $res) {
                                                              ?>
                                                              <option value="<?php echo $res['project_id'];?>"
                                                                <?php echo($res['project_id']==$project_id)?'Selected':'';?>
                                                                ><?php echo $res['project_name'];?></option>                                                                         
                                                              <?php } ?>
                                                        </select>
                                                  </div>

                                                  <div class="form-group">
                                                        <label >Unit of measurement*</label>
                                                        <input class="form-control form-control-sm" id="measurement" name="measurement" type="text"  placeholder="example: kilo" required value="<?php echo $unit_of_measurement;?>">
                                                  </div>

                                                  <div class="form-group">
                                                        <label >Product price*</label>
                                                        <input class="form-control form-control-sm" id="price" name="price" type="text"  placeholder="0.00" required value="<?php echo $price;?>">
                                                  </div>

                                                 
                                                  <div class="form-group">
                                                              <label for="check">Product Status</label>                                                  
                                                              <input  id="product_status" name="product_status" type="checkbox"
                                                              <?php echo($product_status=='Y')?'checked':'';?> />
                                                              <span id="stat" class="italic <?php echo($product_status=='Y')?'green':'red';?>"><?php echo($product_status=='Y')?'(Active)':'(Inactive)';?></span>
                                                              &nbsp;

                                                              <label for="check">For Gate Pass</label>                                                  
                                                              <input  id="for_gate_pass" name="for_gate_pass" type="checkbox"
                                                              <?php echo($for_gate_pass=='Y')?'checked':'';?> />
                                                              <span id="stat" class="italic <?php echo($for_gate_pass=='Y')?'green':'red';?>"><?php echo($for_gate_pass=='Y')?'(Active)':'(Inactive)';?></span>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                      <label for="exampleInputLastName">Product per Unit of Measurement</label>
                                                      <h1><span id="price_"><?php echo ($price=="")?'Price':$price;?></span>/<span id="measurement_"><?php echo ($unit_of_measurement=="")?'Measurement':$unit_of_measurement;?></span></h1>
                                                  </div>

                                              </div>
                                        </div>
                                      
                                       
                                       
                                        <div class="form-group">
                                          <div class="form-row">
                                              <div class="col-md-6">
                                                  <button type="submit" name="submit" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Register Product</button>
                                              </div>
                                              <br/><br/>
                                        
                                              <div class="col-md-6">
                                                  <button id="cancel" class="btn btn-danger btn-block" ><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
                                              </div>
                                          </div>

                                      </div>
                              </form> 
                              <br/>
                      </div>
                     
                  </div>

                  <?php }else{?>
                         <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>Product Not Found, maybe because product is not exist.</small></h2>


                  <?php } ?>
              </div>
        </div>
        </div>
      </main>


<script src='assets/validator.min.js'></script>
<script src="assets/bootstrap-datepicker.min.js"></script>   
<script src="assets/numberFormat.js"></script>  
<script>
          $(function() {

                  
                  $('#form').validator();
                  // when the form is submitted
                  $('#form').on('submit', function (e) {
                      // if the validator does not prevent form submit
                      if(!e.isDefaultPrevented() ) {
                                       bootbox.confirm({
                                          size: "small",                                         
                                          message: "Are you sure?", 
                                          callback: function(result){ 
                                                   if(result){
                                                        var url = "phpscript/productSetup/registerProduct.php";
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
                                                                      
                                                                      if($("#product_id").length==0){
                                                                          $("#measurement_").html("Measurement");
                                                                          $("#price_").html("Price");
                                                                          $("#stat").html("(Inactive)").removeClass("green").removeClass("red").addClass("red");
                                                                          $('#form')[0].reset();
                                                                      }                                           

                                                                  }
                                                              });                                    
                                                    } 
                                          }
                                       });                                    
                                       return false;
                                  }                    
                  });

                  $('#cancel').on('click',function(){
                       $("#measurement_").html("Measurement");
                       $("#price").html("Price");
                       $('#form')[0].reset();
                  });

                   //script for the checkbox account status
                  $('#product_status, #for_gate_pass').on('change',function(){
                      if($(this).is(':checked')){
                          $(this).next().removeClass('red').addClass('green');
                          $(this).next().text('(Active)');
                      }else{
                          $(this).next().removeClass('green').addClass('red');
                          $(this).next().html('(Inactive)');
                         
                      }
                  });

                  $("input#measurement").keyup(function(e){
                      $("#measurement_").html(($(this).val()=="")?"Measurement":$(this).val());
                  });

                

                  $('input#price').keyup(function (event) {
                    // skip for arrow keys
                    if (event.which >= 37 && event.which <= 40) {
                        event.preventDefault();
                    }

                    var currentVal = $(this).val();
                    var testDecimal = testDecimals(currentVal);
                    if (testDecimal.length > 1) {
                        console.log("You cannot enter more than one decimal point");
                        currentVal = currentVal.slice(0, -1);
                    }
                    $(this).val(replaceCommas(currentVal));

                    $("#price_").html(($(this).val()=="")?"Price":$(this).val());

                });
            });



           

</script>

<?php require_once('layout/footer.php');?>      
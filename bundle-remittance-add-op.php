<?php 
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();
     $remittance_id      = "";
     $order_payment_id   = "";
     $product_involve    = "";
     $status             = "";
    
     $found=false;
     $edit=false;

    if(isset($_GET['id'])){
        //getting id from url
        $id = $crud->escape_string($_GET['id']);
         
        //selecting data associated with this particular id
        $result = $crud->getData("SELECT * FROM bundle_remittance WHERE remittance_id='$id' LIMIT 1");
        $edit=true;
        $found=(count($result)==1)?true:false;
       
        foreach ($result as $res) {
            $remittance_id     = $res['remittance_id'];
            $order_payment_id  = $res['order_payment_id'];
            $product_involve   = $res['product_involve'];
            $status            = $res['status'];          
          
        }
    }else{
       $found=true;
    }


?>  

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if($_SESSION['user_type']==1){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='bundle-remittance.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> to Bundle Remittance</li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
               
              </div>
              <div class="card-body">
                <?php if($found){ ?>
                      <div class="row">
                        <div class="col-md-6">
                               <form id="form" >
                                        <input type="hidden" name="remittance_id" value="<?php echo $remittance_id;?>">
                                       <h4><?php echo($edit)? "Edit existing OP Number": "Add new OP Number"; ?></h4>
                                        <hr/>
                                        <div class="form-group">
                                                  <label >Order of Payment(OP) Number*</label>
                                                  <input class="form-control form-control-sm" id="op" name="op" type="text"  placeholder="xxxxxxxx-xxxx" required maxlength="20" required 
                                                    value="<?php echo ($order_payment_id=="")?"":$order_payment_id;?>">
                                        </div>
                                        <div class="form-group">
                                                  <label >Description</label>
                                                  <textarea  rows="5" cols="1" class="form-control " name="prod_involved" ><?php echo ($product_involve=="")?"":$product_involve;?></textarea>
                                        </div>
                                        <div class="form-group">
                                                  <label for="status">Status</label>                                                  
                                                  <input  id="status" name="status" type="checkbox" <?php echo($status=='Y')?'checked':'';?> />
                                                  <span id="stat" class="italic <?php echo($status=='Y')?'green':'red';?>"><?php echo($status=='Y')?'(Active)':'(Inactive)';?></span>
                                        </div>

                                        
                                        <div class="form-group">
                                          <input type="submit" name="submit" class="btn btn-primary btn-block" value="Save"/> 
                                        </div>
                              </form> 
                              <br/>
                      </div>
                      <div class="col-md-6">
                               <h5>Setup OP Number:</h5>
                               <p> *Setup Order of Payment(OP) Number for those products that required bundle remittance. This is useful to avoid printing OP Number for lesser amount of payment. eg. Printing and etc.
                      </div>
               
                  </div>
                  <?php } else { ?>
                        <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>OP Number not found, maybe because user is not exist.</small></h2>

                  <?php } ?>
              </div>
        </div>
        </div>
<script src='assets/validator.min.js'></script>   
<script>
          $(document).ready(function(){

                  var url = "phpscript/bundle-remittance/save_op.php";
                  $('#form').validator();
                
                  // when the form is submitted
                  $('#form').on('submit', function (e) {
                      // if the validator does not prevent form submit
                      if (!e.isDefaultPrevented()) {                                
                               bootbox.confirm({
                                          size: "small",                                         
                                          message: "Are you sure?", 
                                          callback: function(result){                                            
                                                if(result){
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

                                                          }
                                                      });  
                                                 }
                                         } 
                            });  
                             return false;                            
                      }
                     
                  });
                 //script for the checkbox account status
                  $('#status').on('change',function(){
                      if($(this).is(':checked')){
                          $('#stat').removeClass('red').addClass('green');
                          $('#stat').text('(Active)');
                      }else{
                          $('#stat').removeClass('green').addClass('red');
                          $('#stat').html('(Inactive)');
                         
                      }
                  });
        });

                  
</script>

<?php }else{ echo UnauthorizedOpenTemp(); } ?>
      </main>




<?php require_once('layout/footer.php');?>      
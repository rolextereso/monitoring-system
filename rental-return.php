<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

    
    $customer_name   = "";
    $customer_address="";
    $transaction_id = "";
    
    $found=false;

    if(isset($_GET['t_id'])){
        $tid = $crud->escape_string($_GET['t_id']);

       if($tid!=''){
              $rental = $crud->getData("SELECT ri.transaction_id, 
                                               c.customer_name, 
                                               c.customer_address, 
                                               ri.item_name, 
                                               ri.item_code, 
                                               ri.item_description,
                                               rs.rental_specific_id,
                                               rs.date_return FROM rental_specific rs 
                                               INNER JOIN customer c ON c.customer_id=rs.customer_id 
                                               INNER JOIN rental_items ri ON ri.rental_id=rs.rental_id 
                                               WHERE rs.transaction_id='".$tid."' AND date_returned IS NULL");
              $found=(count($rental)>=1)?true:false;
              
              $add=false;
              
              foreach ($rental as $res) {
                $customer_name=$res['customer_name'];
                $customer_address=$res['customer_address'];
                $transaction_id=$res['transaction_id'];
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
                    <li class="breadcrumb-item active" aria-current="page"><a href='rental-to-return-list.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Rented Items</a> </li>
              </ol>
           </nav>

      
         <div class="card">
              <div class="card-header">
                    <i class="fa fa-cube" aria-hidden="true"></i>  Return Rented Items
              </div>
              <div class="card-body">
                 <?php if($found){?>
                      <div class="row">
                        <div class="col-md-12">
                               <form  role="form" id="form">
                                                                             
                                        <div class="form-row">

                                              <div class="col-md-4">
                                                 <h5>Customer Information</h5>
                                                 
                                                 <div class="form-group">
                                                        <label>Customer Name:</label>
                                                        <input type="text"  class="form-control form-control-sm" readonly=""   value="<?php  echo $customer_name;?>">
                                                  </div>
                                                  <div class="form-group">
                                                        <label >Customer Address:</label>
                                                        <input class="form-control form-control-sm" type="text" readonly 
                                                        value="<?php echo $customer_address; ?>">
                                                  </div>  
                                                  <div>
                                                      <p style="padding: 9px;background: #fdf3f3;border: 1px solid silver;">
                                                          Just <b>CHECK</b> the checkbox on the returned item on the left, then click save
                                                      </p>
                                                  </div>                                                 
                                              </div>

                                              <div class="col-md-8">
                                                 <div class="form-group">
                                                      <label>Transaction ID:</label>
                                                      <h1><?php echo $transaction_id; ?></h1>
                                                      <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>"/>
                                                      <table class="table">
                                                          <thead class="thead-light">
                                                            <tr>
                                                              <th scope="col"></th>
                                                              <th scope="col">Item Code</th>
                                                              <th scope="col">Rented Item(s)</th>
                                                              <th scope="col">Date To Return</th>                                                     
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                            <?php foreach($rental as $row){ ?>
                                                                  <tr id="row_<?php echo $row['rental_specific_id'];?>">
                                                                      <td>
                                                                        <input type="checkbox" class="checkboxes" name="rental_specific_id[]" 
                                                                               value="<?php echo $row['rental_specific_id'];?>">
                                                                      </td>
                                                                      <td><?php echo $row['item_code'];?></td>
                                                                      <td><?php echo $row['item_name'].'('.$row['item_description'].')';?></td>
                                                                      <td><?php echo date('F d, Y', strtotime($row['date_return']));?></td>
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
                                                  <button type="submit" name="submit" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                              </div>
                                              <br/><br/>
                                        
                                          </div>

                                      </div>
                              </form> 
                              <br/>
                      </div>
                     
                  </div>

                  <?php }else{?>
                         <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>Record for the rented items not found, maybe because it is not exist or it is already returned.</small></h2>


                  <?php } ?>
              </div>
        </div>
        </div>
      </main>
 
<script src="assets/requiredJS/return-rental-item.js"></script>
<?php require_once('layout/footer.php');?>      
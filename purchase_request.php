<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');
    $crud = new Crud();    
    
    $projects = $crud->getData("SELECT * FROM projects;");
    $found=true;      
?>   

<style>
  .has-error .form-control {
    border-color: #a94442;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
  }

  .delete{
    cursor:pointer;
    font-size: 20px;
  }

</style>

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Purchase Request </li>
              </ol>
           </nav>

      
         <div class="card">
              <div class="card-header">
                   
              </div>
              <div class="card-body">
              
                      <div class="row">
                        <div class="col-md-12">
                               <form  role="form" id="form">
                                                                             
                                        <div class="form-row">

                                              <div class="col-md-4">
                                                <div class="form-group">
                                                        <label>PR No.:</label>
                                                        <input type="text"  class="form-control form-control-sm" readonly="" name="pr_no" value="<?php echo date('yms-is');?>">
                                                  </div>
                                                                                            
                                                 <div class="form-group">
                                                        <label>Entity Name:</label>
                                                        <input type="text" required=""  class="form-control form-control-sm" name="entity_name">
                                                  </div>
                                                  <div class="form-group">
                                                        <label >Projects:</label>
                                                        <select class="form-control form-control-sm" name="projects" required="">
                                                          <?php foreach ($projects as $proj){?>
                                                            <option value="<?php echo $proj['project_id'];?>"><?php echo $proj['project_name'];?>
                                                            </option>
                                                          <?php } ?>
                                                        </select>
                                                  </div>  
                                                  <div class="form-group">
                                                     <label>Purpose:</label>
                                                     <textarea required="" rows="5" cols="1" class="form-control " name="purpose" ></textarea>
                                                  </div> 
                                                  <br/>                                                
                                              </div>

                                              <div class="col-md-8">
                                                 <div class="form-group">
                                                      
                                                      <button type="button" class="btn btn-primary" id="add_item">Add item</button>
                                                      <br/>
                                                      <br/>

                                                      <table class="table">
                                                          <thead class="thead-light">
                                                            <tr>
                                                              <th scope="col" style="width:10%;"></th>
                                                              <th scope="col" style="width:18%;">Unit</th>
                                                              <th scope="col">Item Description </th>
                                                              <th scope="col" style="width:20%;">Quantity</th>                                                     
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                            
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
              </div>
        </div>
        </div>
      </main>
 <script src='assets/validator.min.js'></script>  
<script>
  $(document).ready(function(){

    $("#add_item").click(function(){
        var body=$(".table tbody"),
            type="text",
            classes="form-control-sm form-control",
            $unit=" <input type='"+type+"' required class='"+classes+"' name='unit[]'/> ",
            $item=" <input type='"+type+"' required class='"+classes+"' name='item_description[]'/> ",
            $quantity=" <input type='"+type+"' required class='"+classes+"' name='quantity[]'/> ",
            $delete="<span class='red delete'>&Cross;</span>";

        var $temp="<tr>"+
                    " <td>"+$delete+"</td>"+
                    " <td>"+$unit+"</td>"+
                    " <td>"+$item+"</td>"+
                    " <td>"+$quantity+"</td>"+
                  "</tr>";
        $(body).prepend($temp);

         $(".delete").click(function(){
            var p=$(this).parent().parent();
            p.remove();
        });

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
                                                      var url = "phpscript/registerAccount/registerAccount.php";

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
                                                              $('#form')[0].reset();

                                                          }
                                                      });
                                                }
                                         }
                                      });
                                return false;
                      }
                  });
    });





  });

</script>
<?php require_once('layout/footer.php');?>      
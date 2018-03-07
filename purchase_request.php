<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');
    $crud = new Crud();    
    
    $user_id=specific_user(access_role("Purchase Requests","view_command",$_SESSION['user_type']));
    $projects = $crud->getData("SELECT p.*,pd.project_duration_id FROM projects p                          
                                LEFT JOIN project_duration pd ON pd.project_id=p.project_id
                                WHERE pd.status='Y' AND (p.project_incharge $user_id )
                                ");
    //$funds = $crud->getData("SELECT * FROM funds");
         
    
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
<?php if(access_role("Purchase Requests","view_page",$_SESSION['user_type'])){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="purchase_request_list.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Purchase Requests</a>
                    </li>
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
                                                        <label>PR Transaction No.:</label>
                                                        <input type="text"  class="form-control form-control-sm" readonly="" name="pr_no" value="<?php echo date('yms-is');?>">
                                                  </div>
                                                                                            
                                                 <div class="form-group">
                                                        <label>Entity Name:</label>
                                                        <input type="text" required="" value="Southern Leyte State University-CAFES" class="form-control form-control-sm" name="entity_name">
                                                  </div>
                                                  <!-- <div class="form-group">
                                                        <label >Funds:</label>
                                                        <select class="form-control form-control-sm" name="funds" >
                                                            <option value="">Select funds</option>
                                                          <?php //foreach ($funds as $fund_){?>
                                                            <option value="<?php //echo $fund_['id'];?>"><?php //echo $fund_['funds'];?>
                                                            </option>
                                                          <?php //} ?>
                                                        </select>
                                                  </div>   -->
                                                  <div class="form-group">
                                                        <label >Projects:</label>
                                                        <select class="form-control form-control-sm" name="projects" required="">
                                                            <option value="">Select project</option>
                                                          <?php foreach ($projects as $proj){?>
                                                            <option value="<?php echo $proj['project_duration_id']."_".$proj['project_id'];?>"><?php echo $proj['project_name'];?>
                                                            </option>
                                                          <?php } ?>
                                                        </select>
                                                  </div> 
                                                  
                                                  <!-- <div class="form-group" style="display: none;" id="target_expenses">
                                                        <label >Target Expenses:</label>
                                                        <select class="form-control form-control-sm" name="target_expenses" required="">
                                                               <option value="">Select target expenses</option>
                                                          
                                                        </select>
                                                  </div>  -->
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
                                                       <div class="form-group">
                                          <div class="form-row">
                                              <div class="col-md-4">
                                                <?php if(count($projects)>=1 && access_role("Purchase Requests","save_changes",$_SESSION['user_type'])){?>
                                                  <button type="submit" name="submit" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                                <?php } else{ ?>
                                                <div class="un_authorized">
                                                    Note: Unable to create project request because:
                                                      <ul>
                                                          <li>User account does'nt have assigned project(s)</li>
                                                          <li>User account did'nt create budget to the assigned project(s)</li>
                                                          <li>User account is not authorized to save PR.</li>


                                                      </ul>
                                                      Please ask assistance to the authorized personnel.
                                                </div>
                                                <?php } ?>
                                              </div>
                                              <br/><br/>
                                        
                                          </div>

                                      </div>
                                                  </div>

                                              </div>
                                        </div>                                  
                                       
                              </form> 
                              <br/>
                      </div>
                     
                  </div>                  
              </div>
        </div>
        </div>
  <script>
  $(document).ready(function(){   
   
            $("#add_item").click(function(){   
                             

                    var body=$(".table tbody"),
                        type="text",
                        classes="form-control-sm form-control",
                        $unit=" <input type='"+type+"' required class='"+classes+"' name='unit[]'/> ",
                        $item=" <input type='"+type+"' required class='"+classes+"' name='item_description[]'/> ",
                        $quantity=" <input type='"+type+"' required class='"+classes+" quantity_p' name='quantity[]'/> ",
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

                      $('.quantity_p').keyup(function (event) {
                            // skip for arrow keys
                            if (event.which >= 37 && event.which <= 40) {
                                event.preventDefault();
                            }
                            var currentVal = ($(this).val()=="")? '0.00':$(this).val();                    

                            var testDecimal = testDecimals(currentVal);
                            if (testDecimal.length > 1) {
                                console.log("You cannot enter more than one decimal point");
                                currentVal = currentVal.slice(0, -1);                      }

                            $(this).val(replaceCommas(currentVal));
                    });  
              
            });
            
           

            $('#form').on('submit', function (e) {
              // if the validator does not prevent form submit
                   if($(".table tbody tr").length==0){
                      alert("Please add an item");

                   }else if (!e.isDefaultPrevented()) {
                      bootbox.confirm({
                                        size: "small",                                         
                                        message: "Are you sure?", 
                                        callback: function(result){ 
                                          
                                              if(result){
                                                    var url = "phpscript/purchase_request/save_pr.php";

                                                    // POST values in the background the the script URL
                                                    $.ajax({
                                                        type: "POST",
                                                        url: url,
                                                        dataType :'json',
                                                        data: $("#form").serialize(),
                                                        success: function (data)
                                                        {
                                                            $('.alert').removeClass('alert-success, alert-danger')
                                                                       .addClass(data.type)
                                                                       .html(data.message)
                                                                       .fadeIn(100,function(){
                                                                           $(this).fadeOut(5000);
                                                                       });

                                                            

                                                            if(data.type=='alert-success'){
                                                                        var d=new Date(),
                                                                        day=d.getHours(),
                                                                        minute=d.getMinutes(),
                                                                        seconds=d.getSeconds(),
                                                                        month=d.getMonth(),
                                                                        year=d.getFullYear(),
                                                                        prev_op_num=$("[name='pr_no']").val();

                                                                         $('#form')[0].reset();
                                                                        
                                                                         $("[name='pr_no']").val(""+seconds+year+day+"-"+minute+seconds);

                                                                          bootbox.confirm({
                                                                              size: "small",                                         
                                                                              message: "Would you like to print the purchase request?", 
                                                                              callback: function(result){ 
                                                                                       if(result){
                                                                                          WindowPopUp('phpscript/purchase_request/print_prequest.php?pr_id='+prev_op_num,'print','914','650');
                                                                                       }
                                                                              }
                                                                          });

                                                           }

                                                        }
                                                    });
                                              }
                                       }
                                    });
                            
                    }
                    return false;
              
            });

            // $('[name="projects"]').change(function(){
            //       search_by($(this))
            // });   

});

  // function search_by($el){    
  //       if($($el).val()==""){
  //           $("#target_expenses").hide();
  //       }else{
  //          $("#target_expenses").show();
  //             $.ajax({
  //                   type: "POST",
  //                   url: "phpscript/purchase_request/getSearchby.php",
  //                   dataType   : 'json',
  //                   data: {proj_id:$($el).val()},
  //                   success: function (data)
  //                   {     var $option="";
  //                         $('.option').remove();
  //                         $.each(data, function(key, value){                                                     
  //                              $option+="<option class='option' value='"+value[0]+"'>"+value[1]+"</option>";                                                    
  //                         });  
  //                         $("[name='target_expenses']").append($option);
  //                   }
  //               });
  //       }                         
                 
  // }

</script>
<?php } else { echo UnauthorizedOpenTemp(); } ?>
      </main>
 <script src='assets/validator.min.js'></script>  
 <script src='assets/numberFormat.js'></script>

<?php require_once('layout/footer.php');?>      
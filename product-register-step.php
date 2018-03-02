r<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');
    require_once('classes/function.php');

    $crud = new Crud();

    $user_id="WHERE IGP ='9' ";
    if($_SESSION['user_type']!=1){
      $user_id=" WHERE user_id=".$_SESSION['user_id']." AND IGP='9'";
    }

    $users = $crud->getData("SELECT * FROM account $user_id;");

    $project_id= "";
    $project_name= "";
    $project_description  = "";
    $project_incharge ="";
    $project_type="";
    $found=false;
    $found_project=false;

    $add_item=false;
    $disabled="";

    if(isset($_GET['p_id'])){

       $id = $crud->escape_string($_GET['p_id']);

       if(is_numeric($id) && $id!=''){

            
            $projects = $crud->getData("SELECT * FROM projects WHERE project_id=".$id);

            $found=(count($projects)==1)?true:false;
            $found_project=(count($projects)==1)?true:false;

            $disabled="";
            $add_item=true;
            
            foreach ($projects as $res) {
                $project_id   = $res['project_id'];
                $project_name = $res['project_name'];
                $project_description  = $res['project_description'];                
                $project_incharge =$res['project_incharge'];
                $project_type =$res['project_type'];                   
            }
      }
    }else if(!isset($_GET['p_id'])){
       $projects = $crud->getData("SELECT * FROM projects pr 
                                  WHERE pr.project_status='Y' 
                                  AND (  pr.project_incharge ".
                                  specific_user(access_role("Project List","view_command",$_SESSION['user_type'])).")");
      
        $found=(count($projects)>=1)?true:false;

    }else{
       $found=true;
    }
    
?>     
<link href="assets/bootstrap-datepicker3.min.css" rel="stylesheet">
<link href="assets/project-register-step.css" rel="stylesheet">
<style>
    table .form-group {
         margin-bottom: 0 !important; 
    }
    .amount_total{
          background: transparent!important;
          border: none;
          font-size: 19px;
          font-weight: bolder;
    }
    .btn-primary {
         padding: .5rem 1rem !important;
    }
   
</style>

<?php require_once('layout/nav.php');?>


        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if(access_role("Project List","view_page",$_SESSION['user_type'])){?> 
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='<?php echo ($add_item)? "project-list-spec.php?id=$project_id":"setting.php";?>'><i class="fa fa-arrow-left" aria-hidden="true"></i><?php echo ($add_item)? " Go back ":" Go to Setting";?> </a> / Project /<h2></h2> </li>
              </ol>
           </nav>

         <?php if($found){?>
         <div class="card">
              <div class="card-header">
                    <i class="fa fa-cube" aria-hidden="true"></i>   Project Setup
              </div>
              <div class="card-body">
                    <?php if($found_project){ ?>
                      <div class="un_authorized">
                          <b>Note: </b>The newly created budget will be the current budget and the other will become archive.
                      </div>
              
                    <?php } ?>
                    <?php if(count($projects)==0){ ?>
                      <div class="un_authorized">
                          <b>Note: </b>Unable to proceed to step 2 in project budget setup because you don't have project assigned to you.
                          <br/>
                          Please ask assistance to the authorized personnel.
                      </div>
              
                    <?php } ?>
                      <br/>
                      <div class="stepwizard col-md-offset-3">
                          <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step">
                              <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                              <p>Step 1</p>
                            </div>
                            <div class="stepwizard-step">
                              <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                              <p>Step 2</p>
                            </div>
                            <div class="stepwizard-step">
                              <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                              <p>Step 3</p>
                            </div>
                             <div class="stepwizard-step">
                              <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                              <p>Step 4</p>
                            </div>
                          </div>
                        </div>
                        
                        <form role="form" action="" method="post" id="form">
                          <div class="row setup-content" id="step-1">
                            <div class="col-md-12 col-md-offset-3 ">
                              
                                <h5> Step 1 : Enter Project Information</h5><br/>
                                 <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label">Project Name *</label>
                                   <select <?php echo $disabled;?> id="proj_name" name="proj_name" class="form-control form-control-sm" required="required">
                                      <option value="">Select Project Name</option>
                                      <?php
                                          foreach ($projects as $row) {
                                      ?>
                                      <option value="<?php echo $row['project_id'];?>"
                                        <?php echo($row['project_id']==$project_id)?'Selected':'';?>>
                                        <?php echo $row['project_name']; ?></option>                                                                         
                                      <?php } ?>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label class="control-label">Project Type *</label>
                                  <select <?php echo $disabled;?> id="project_type" name="project_type" class="form-control form-control-sm" required="required">
                                      <option value="">Select type</option>
                                      <option value="Agricultural" <?php echo($project_type=='Agricultural')?'Selected':'';?> >Agricultural</option>
                                      <option value="Non-Agricultural" <?php echo($project_type=='Non-Agricultural')?'Selected':'';?>>Non-Agricultural</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label class="control-label">Project In-charge*</label>
                                  <select <?php echo $disabled;?>  class="form-control form-control-sm" id="project_incharge" name="project_incharge" required="required">
                                                              <option value=""> Select Person In-charge</option>
                                                              <?php
                                                                  foreach ($users as $res) {
                                                              ?>
                                                              <option value="<?php echo $res['user_id'];?>"
                                                                <?php echo($res['user_id']==$project_incharge)?'Selected':'';?>
                                                                ><?php echo $res['FirstName'].' '.$res['LastName'];?></option>                                                                         
                                                              <?php } ?>
                                  </select>
                                </div>
                                <div class="form-group">
                                    <label >Project Started* (yyyy-mm-dd)</label>
                                    <input class="form-control form-control-sm" id="project_started" name="project_started" type="text"  placeholder="Date Started" data-date-format="yyyy-mm-dd" required value="">
                                </div>
                                <div class="form-group">
                                    <label >Project Ended (yyyy-mm-dd)</label>
                                    <input required data-date-format="yyyy-mm-dd" class="form-control form-control-sm" id="project_ended" name="project_ended" type="text"  placeholder="Date Ended" value="">
                                </div>

                              
                               
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                      <label>Project Description</label>
                                      <textarea <?php echo $disabled;?> rows="5" class="form-control " id="proj_desc" name="project_description" style="margin-top: 0px; margin-bottom: 0px;"><?php echo($project_description=='')?'':$project_description;?></textarea>
                                  </div>

                              </div>
                            </div>
                               <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                            </div>
                          </div>
                          <div class="row setup-content" id="step-2">
                            <div class="col-md-12 col-md-offset-3">
                              <div class="col-md-12">
                                 <h5 style="float:left;"> Step 2 : Set budget for Production Cost</h5>
                                 <button type="button" class="btn btn-success" id="production_cost" style="float:right;">Add item</button>
                                 <br/>
                                 <div id="step2" class="clearfix">
                                       <div> 
                                              <br/>
                                              <table class="table table-striped table-sm" id="production_cost_table">
                                                  <thead class="thead-dark">
                                                    <tr>
                                                      <th scope="col" style="width:2%;"></th>           
                                                      <th scope="col">Product Name </th>
                                                      <th scope="col" style="width:20%;">Planned Budget</th>                                                     
                                                    </tr>
                                                  </thead>
                                                  <tfoot>
                                                     <tr class="table-active">
                                                      <th></th>
                                                      <th style="text-align: right;line-height: 37px;">Total:</th>
                                                      <th><input type="text" readonly="" class="form-control-sm form-control amount_total" id="production_cost_total" value="0"></th>
                                                    </tr>
                                                  </tfoot>
                                                  <tbody>
                                                      <tr>
                                                          <td></td> 
                                                          <td>
                                                              <div class="form-group"> 
                                                                  <input type="text" required="" class="form-control-sm form-control" name="production_cost[]" data="production_name"> 
                                                              </div>
                                                          </td> 
                                                          <td>
                                                            <div class="form-group"> 
                                                                <input type="text" required="" class="form-control-sm form-control amount_ " data="production_cost_total"  name="production_cost_amount[]" value="0"> 
                                                            </div> 
                                                          </td>
                                                      </tr>
                                                  </tbody>

                                              </table>
                                        </div>
                                 </div>
                                 <br/>
                                 <button class="btn btn-primary prevBtn btn-lg pull-left" type="button">Previous</button>
                                 <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                              </div>
                            </div>
                          </div>
                          <div class="row setup-content" id="step-3">
                            <div class="col-md-12 col-md-offset-3">
                              <div class="col-md-12">
                                <h5  style="float:left;"> Step 3 : Set budget for Expenses</h5> 
                                <button type="button" class="btn btn-success" id="expenses" style="float:right;">Add item</button>
                                <br/>
                                <div id="step3"  class="clearfix">
                                   <div >                                                  
                                            <br/>
                                            <table class="table table-striped table-sm" id="expenses_table">
                                                <thead class="thead-dark">
                                                  <tr>
                                                    <th scope="col" style="width:2%;"></th>            
                                                    <th scope="col">Expenses</th>
                                                    <th scope="col" style="width:20%;">Planned Budget</th>                                                     
                                                  </tr>
                                                </thead>
                                                <tfoot>
                                                     <tr class="table-active">
                                                      <th></th>
                                                      <th style="text-align: right;line-height: 37px;">Total:</th>
                                                      <th><input type="text" readonly="" class="form-control-sm form-control amount_total" id="expenses_total" value="0"></th>
                                                    </tr>
                                                  </tfoot>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                    </div>

                                 </div>
                                 <br/>
                                 <button class="btn btn-primary prevBtn btn-lg pull-left" type="button">Previous</button>
                                 <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Next</button>
                              </div>
                            </div>
                          </div>
                          <div class="row setup-content" id="step-4">
                            <div class="col-md-12 col-md-offset-3">
                              <div class="col-md-12">
                                <h5> Step 4 : Set Product Price</h5><br/>
                                <div id="step4">
                                      <div >                                                  
                                            <br/>
                                            <table class="table table-striped table-sm" id="price_table">
                                                <thead class="thead-dark">
                                                  <tr>
                                                    <th scope="col" style="width:40%;">Product Description</th>            
                                                    <th scope="col" style="width:10%;">Price</th>
                                                    <th scope="col" style="width:10%;">Unit of Measurement</th>
                                                    <th scope="col" style="width:10%;">For Gate Pass</th>                                                     
                                                  </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                    </div>

                                 </div>
                                 <br/>
                                <button id="last_prev" class="btn btn-primary prevBtn btn-lg pull-left" type="button">Previous</button>
                                <?php if(access_role("Project List","save_changes",$_SESSION['user_type'])){?> 
                                     <button class="btn btn-success submitBtn btn-lg pull-right" type="button">Submit</button>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </form>
              </div>
        </div>
          <?php }else{?>
          <div>
                          <h2 style="width: 65%;margin: 0 auto;display: block!important;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>
                             Reasons:
                             <ul>
                                <li>Project id not found, maybe because project is not exist</li>
                                <li>User account don't have assigned project(s)</li>
                                
                             </ul>
                             Please ask assistance to the authorized personnel.
                           </small>
                         </h2>

          </div>
           <?php } ?>
        </div>
<script type="text/javascript" src="assets/typeahead.bundle.js"></script>

<script src='assets/validator.min.js'></script>
<script src="assets/bootstrap-datepicker.min.js"></script>   
<script src="assets/numberFormat.js"></script>  
<link href="assets/typeahead.css" rel="stylesheet">  


<script>
  var $proj_started,$proj_ended;
  $(document).ready(function () {

        $('#project_started, #project_ended').datepicker({
                      autoclose: true,    
                      todayHighlight: true,       
        });  

       
        format_amount();  
        auto_complete();  

        $("#proj_name").change(function(){
           getProject_info($(this).val());
        });

        var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn');
                allPrevBtn = $('.prevBtn');
        var step2_, step3_;

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                    $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-default');
                $item.addClass('btn-primary');
                allWells.hide();
                $target.show();
                //$target.find('input:eq(0)').focus();
            }
        });
        //this method is trigger once previous button is clicked
        allPrevBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

                prevStepWizard.removeAttr('disabled').trigger('click');
        });

        //this method is trigger once next button is clicked
        allNextBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url'], select"),
                isValid = true;

            if(curStepBtn=="step-1"){
                 budget("production_cost");

            }else if(curStepBtn=="step-2"){
                 budget("expenses",true);                
            }else if(curStepBtn=="step-3"){

                 setup_price();
            }        
        
            
            $(".form-group").removeClass("has-error");
            for(var i=0; i<curInputs.length; i++){
                if(!curInputs[i].validity.valid){
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }               
            }

           if(validateDate()){
                  isValid = false;
                  //$(curInputs[i]).closest(".form-group").addClass("has-error");
                  alert("Make sure that project started is less than project ended");
            }

           if (isValid){
                 nextStepWizard.removeAttr("disabled").trigger('click');              
           }
            
        });

        $('div.setup-panel div a.btn-primary').trigger('click'); 

        $(".addNew").click(function(){
            document.location.reload(true);
        });

        $(".submitBtn").click(function(){
             bootbox.confirm({
                              size: "small",                                         
                              message: "Are you sure?", 
                              callback: function(result){                                 
                                    if(result){
                                          var url = "phpscript/projectSetup/registerProjectStep.php";
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
                                                     if(data.type=="alert-success"){
                                                        $(".submitBtn").remove();
                                                        $("#last_prev").after("<button onClick='document.location.reload(true)' class='btn btn-success btn-lg pull-right' type='button'>Add New</button>");
                                                     }
                                              }
                                          });
                                    }
                               }
                            });
          });
});
function format_amount(){
        $('.amount_').keyup(function () {               
              var currentVal = ($(this).val()=="")? '0.00':$(this).val();                   
              $(this).val(number_format(currentVal));
              total_amount(this);
        });
}

function validateDate(){
      var $from=$("#project_started").datepicker('getDate');
      var $to =$("#project_ended").datepicker('getDate');

      var error=false;
      if($from > $to){
          error=true;
      }
     
      return error;
}

function total_amount(el){
        var total=0.00;
        var id=$(el).attr('data');
        $("[data='"+id+"']").each(function() {             
                  total+=parseFloat($(this).val().replace(/,/g,''));                   
        });

        $("#"+id).val(number_format(total.toString()));
}

function setup_price(){
   var body=$("#price_table");

  
   var type="text",
       temp="",
       classes="form-control-sm form-control",
       $price="<div class='form-group'><input type='"+type+"' required class='"+classes+" amount_' name='price_amount[]' value='0'/></div> ";
       $unit_="<div class='form-group'><input type='"+type+"' autocomplete='off' required class='"+classes+"' data='unit' name='unit[]' value=''/></div> ";
       $check="<div class='form-group'><input type='checkbox' class='gate_pass'  name='gate_pass[]' value='Y'/>"+
                                      "<input type='checkbox' style='display:none;' checked  class='gate_pass'  name='gate_pass[]' value='N'/></div> ";

  if($("#price_table tbody tr").length==0){                                   
       $("[name='production_cost[]']").each(function() { 
           var $product="<div class='form-group'><input type='"+type+"' readonly class='"+classes+"' value='"+$(this).val()+"' name='product_desc[]' /> </div>";

           $temp ="<tr>"+
                  " <td>"+$product+"</td>"+                        
                  " <td>"+$price+"</td>"+
                  " <td>"+$unit_+"</td>"+
                  " <td>"+$check+"</td>"+
                "</tr>";          

            $(body).append($temp);

        });
    }
    format_amount();
    gate_pass();
    auto_complete();
}

function delete_row(){
   $(".delete").click(function(){
                  var p=$(this).parent().parent();
                  p.remove();
    });
}

function auto_complete(){
      $("[name='production_cost[]'],[name='unit[]']").typeahead({
                          hint: true,
                          highlight: true,
                          minLength: 1
                        },
                        {
                        limit: 12,
                        async: true,            
                        source: function (query, processSync, processAsync) {
                              var data=$(this.$el[0].parentElement.parentElement).children("input").first().attr("data");
                              return $.ajax({
                                      url: "phpscript/projectSetup/getDescFromChartAccount.php", 
                                      type: 'GET',
                                      data: {query: query,type:data},                               
                                      dataType: 'json',
                                      success: function (json) {
                                        // in this example, json is simply an array of strings
                                        return processAsync(json);
                                      }
                              });
                        }
      });
}

function getProject_info(value){
       $.ajax({
                    url: "phpscript/projectSetup/getProject.php", 
                    type: 'POST',
                    data: {query: value},
                    dataType: 'json',
                    success: function (data) {

                        $("#project_type option").removeAttr("selected");
                        $("#proj_desc").html("");
                     
                       if(data.length>=1){                     
                          $("#project_type option[value='"+data[0].project_type+"']").prop('selected', true)
                          $("#proj_desc").html(data[0].project_description);
                       }
                    }
            });
}

function gate_pass(){
   $(".gate_pass").change(function(){ 
                      
          if(this.checked){  
             $(this).attr("checked","checked");            
             $(this).next().removeAttr("checked");
          }else{             
             $(this).next().attr("checked","checked");
             $(this).removeAttr("checked");
          }
     });
}

function budget(name,expenses=false){ 

      var $temp="";
      var step2=["Marketing Expenses",
                  "Other Marketing Expenses",
                  "Other Related Marketing Expenses",
                  "Salaries other than Labor", 
                  "Other Administrative Expenses",
                  "Registration, Fees, Licenses",
                  "Others"];

      var specific=(name=="production_cost")?"data='production_name'": "";

      var body=$("#"+name+"_table"),
                  type="text",
                  classes="form-control-sm form-control",        
                  $item="<div class='form-group'><input "+specific+" type='"+type+"' required class='"+classes+"' name='"+name+"[]'/> </div>",
                  $amount="<div class='form-group'><input data='"+name+"_total' type='"+type+"' required class='"+classes+" amount_' name='"+name+"_amount[]' value='0'/></div> ",
                  $delete="<h5 class='red delete'>&Cross;</h5>";

      if(expenses){
          if($("#"+name+"_table tbody tr").length==0){
              step2.forEach(function(exp) {
                   $temp ="<tr>"+
                              " <td>"+$delete+"</td>"+                        
                              " <td><div class='form-group'><input type='"+type+"' required class='"+classes+"' name='"+name+"[]' value='"+exp+"'/> </div></td>"+
                              " <td>"+$amount+"</td>"+
                            "</tr>";
                  $(body).append($temp);
              
              }); 
          }         
          format_amount();
          delete_row();
      }

      $("#"+name+"").click(function(){
             $temp ="<tr>"+
                          " <td>"+$delete+"</td>"+                        
                          " <td>"+$item+"</td>"+
                          " <td>"+$amount+"</td>"+
                        "</tr>";
              $(body).prepend($temp);
              format_amount();
              auto_complete();  
              delete_row();

             
      }); 
}

</script>
<?php } else { echo UnauthorizedOpenTemp(); } ?>
      </main>

<?php require_once('layout/footer.php');?>      
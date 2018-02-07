<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

    $user_id="";
    if($_SESSION['user_type']!=1){
      $user_id=" WHERE user_id=".$_SESSION['user_id'];
    }

    $users = $crud->getData("SELECT * FROM users $user_id;");

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

            $disabled=($found)?"disabled":"";
            $add_item=true;
            
            foreach ($projects as $res) {
                $project_id   = $res['project_id'];
                $project_name = $res['project_name'];
                $project_description  = $res['project_description'];                
                $project_incharge =$res['project_incharge'];
                $project_type =$res['project_type'];                   
            }
      }
    }else{
       $found=true;
    }
    
?>     
<link href="assets/bootstrap-datepicker3.min.css" rel="stylesheet">
<link href="assets/project-register-step.css" rel="stylesheet">
<style>
.btn-default.disabled, .btn-default[disabled], fieldset[disabled] .btn-default, .btn-default.disabled:hover, .btn-default[disabled]:hover, fieldset[disabled] .btn-default:hover, .btn-default.disabled:focus, .btn-default[disabled]:focus, fieldset[disabled] .btn-default:focus, .btn-default.disabled.focus, .btn-default[disabled].focus, fieldset[disabled] .btn-default.focus, .btn-default.disabled:active, .btn-default[disabled]:active, fieldset[disabled] .btn-default:active, .btn-default.disabled.active, .btn-default[disabled].active, fieldset[disabled] .btn-default.active {
    background-color: #fff;
    border-color: #ccc;
}
.btn.disabled, .btn[disabled], fieldset[disabled] .btn {
    pointer-events: none;
    cursor: not-allowed;
    filter: alpha(opacity=65);
    -webkit-box-shadow: none;
    box-shadow: none;
    opacity: .65;
}
  .stepwizard-step p {
    margin-top: 10px;
  }
  .stepwizard-row {
      display: table-row;
  }
  .stepwizard {
      display: table;
      width: 100%;
      position: relative;
  }
  .stepwizard-step button[disabled] {
      opacity: 1 !important;
      filter: alpha(opacity=100) !important;
  }
  .stepwizard-row:before {
      top: 14px;
      bottom: 0;
      position: absolute;
      content: " ";
      width: 100%;
      height: 1px;
      background-color: #ccc;
      z-order: 0;
  }
  .stepwizard-step {
      display: table-cell;
      text-align: center;
      position: relative;
  }
  .btn-circle {
      width: 30px;
      height: 30px;
      text-align: center;
      padding: 6px 0;
      font-size: 12px;
      line-height: 1.428571429;
      border-radius: 15px;
  }

  .btn-default {
      color: #333;
      background-color: #fff;
      border-color: #ccc;
  }

  .btn-primary {
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
  }

  .tbl-error{
    border-bottom: 1px solid red !important;
    background: #2f1d1d;
  }

  #step2, #step3, #step4{
    overflow-x: scroll;
  }

  #note{
    font-size: 15px;
    background: #f3dbdb;
    color: #912d2d;
    padding: 15px;
    border-radius: 4px;
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
                      <div id="note">
                          <b>Note: </b>Successful setup for the new budget for the project means changing the status of current project to archive and the newly created budget is the current budget of the project.
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
                        
                        <form role="form" action="" method="post">
                          <div class="row setup-content" id="step-1">
                            <div class="col-md-12 col-md-offset-3 ">
                                <input type="hidden" id="proj_id" value="<?php echo $project_id;?>"/>
                                <h5> Step 1 : Enter Project Information</h5><br/>
                                 <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label">Project Name *</label>
                                  <input <?php echo $disabled;?> maxlength="100" type="text" required="required" class="form-control form-control-sm" placeholder="Enter project name"  id="proj_name" value="<?php echo $project_name;?>" />
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
                                                                ><?php echo $res['firstname'].' '.$res['lastname'];?></option>                                                                         
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

                                <!-- <div class="form-group">
                                          <label for="check">Project Status</label>                                                  
                                          <input  id="project_status" name="project_status" type="checkbox" 
                                          <?php //echo($project_status=='Y')?'checked':'';?> />
                                          <span id="stat" class="italic <?php //echo($project_status=='Y')?'green':'red';?>"><?php //echo($project_status=='Y')?'(Active)':'(Unactive)';?></span>
                                </div> -->
                               
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                      <label>Project Description</label>
                                      <textarea <?php echo $disabled;?> rows="5" class="form-control " id="proj_desc" name="project_description" style="margin-top: 0px; margin-bottom: 0px;">
                                        <?php echo($project_description=='')?'':$project_description;?></textarea>
                                  </div>

                              </div>
                            </div>
                               <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                            </div>
                          </div>
                          <div class="row setup-content" id="step-2">
                            <div class="col-md-12 col-md-offset-3">
                              <div class="col-md-12">
                                 <h5> Step 2 : Set budget for Production Cost</h5><br/>
                                 <div id="step2">
                                   

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
                                <h5> Step 3 : Set budget for Expenses</h5><br/>
                                <div id="step3">
                                   

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
                         <h2 style="text-align: center;width: 100%;"><span style='color:red;'>SYSTEM ERROR 404:</span><br/><small>ID Not Found, maybe because project is not exist.</small></h2>


           <?php } ?>
        </div>
        <script src='assets/validator.min.js'></script>
<script src="assets/bootstrap-datepicker.min.js"></script>   
<script src="assets/numberFormat.js"></script>  

<script src="assets/requiredJS/project-register-step.js"></script>
<script src="assets/moment.min.js"></script>
<script>
  var $proj_started,$proj_ended;
  $(document).ready(function () {

       //this is for the datepicker


         // var a = moment('2010-11-7','YYYY-DD-MM');
         //  var b = moment('2010-14-7','YYYY-DD-MM');
         //  var diffDays = b.diff(a, 'days');
         //  alert(diffDays);


        $('#project_started, #project_ended').datepicker({
                      autoclose: true,    
                      todayHighlight: true,       
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
               //this will render the table by calling the function
                renderTable('#step2','Production Costs',$('#project_started').val(),$('#project_ended').val(),1);                
            }else if(curStepBtn=="step-2"){
                step2_=collectData("#step2");//it will get the data in each row and column in the table
                renderTable('#step3','Expenses',$('#project_started').val(),$('#project_ended').val(),2);//this will render the table by calling the function for step 3
                
            }else if(curStepBtn=="step-3"){
                step3_=collectData("#step3");//it will get the data in each row and column in the table
                
                removeTable("#step4");
                var table=listProductForPricing("#step2");  
                $("#step4").prepend(table);

                check_for_gate_pass();//call function for gate pass checkbox
                
            }           
            
            $(".form-group").removeClass("has-error");
            for(var i=0; i<curInputs.length; i++){
                if (!curInputs[i].validity.valid){
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if(curStepBtn=="step-2"){
                isValid=validate("#step2");//call the function if empty table data is empty or total amount of column is 0
            }else if(curStepBtn=="step-3"){
                isValid=validate("#step3");//call the function if empty table data is empty or total amount of column is 0
            }

            if (isValid){
                nextStepWizard.removeAttr("disabled").trigger('click');              
            }

            //this will trigger to format the text when inputing price
            $('._price').keyup(function(){
                 var currentVal = ($(this).text()=="")? '0':$(this).text(); 
                 $(this).text(number_format(currentVal));
            });
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
                                              data: {
                                                     project_id:$('#proj_id').val(),
                                                     proj_name:$('#proj_name').val(),
                                                     proj_incharge:$('#project_incharge').val(),
                                                     proj_desc:$('#proj_desc').val(),  
                                                     proj_type:$('#project_type').val(),  
                                                     prod_cost:  step2_,                                            
                                                     expenses:  step3_,
                                                     prod_price: collectData("#step4"),
                                                     proj_started:$("#project_started").val(),
                                                     proj_ended: $("#project_ended").val()
                                                    },
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
// A few jQuery helpers for exporting only
jQuery.fn.pop = [].pop;
jQuery.fn.shift = [].shift;
//this function collect the data in the table
var collectData=function (selector) {
                var $rows = $(selector+" table").find('tr:not(:hidden):not(#total)');
                var headers = [];
                var data = [];
                
                // Get the headers (add special header logic here)
                $($rows.shift()).find('th:not(:empty)').each(function () {
                  headers.push($(this).attr('data').toLowerCase());
                });
                
                // Turn all existing rows into a loopable array
                $rows.each(function () {
                  var $td = $(this).find('td:not(.btn-remove)');
                  var h = {};
                  
                  // Use the headers from earlier to name our hash keys
                  headers.forEach(function (header, i) {
                    h[header] = $td.eq(i).text();


                  });
                   data.push(h);
                    
                });

                return data;
          
  }
 
  var validate=function(steps){
                var items=[];
                var itemDup=0;
                var itemfound = 0;
                var totalfound=0;
                 //loop through to find if the production cost and expenses is empty then add class tbl-error
                $(steps+" tbody tr:not(.hide) ._0").each(function(i, val) {
                  $(this).removeClass('tbl-error');
                  
                  var val=$(this).text();
                  if(items.indexOf(val)>=0){
                    
                      $(this).addClass('tbl-error');
                      itemDup++;
                  }else{
                    items.push(val);
                  }

                  if (val== '') {
                    $(this).addClass('tbl-error');
                    itemfound++;
                  }

                });
                //loop through to find if the total amount is 0 then add class tbl-error
                $(steps+" table tr#total td[class*='t_']").each(function(i, val) {
                  $(this).removeClass('tbl-error');
                  if ($(this).text() == "0") {  
                    $(this).addClass('tbl-error');                                  
                    totalfound++;
                  }
                });               
                
                if(itemfound>0){
                   alert("Please don't leave the an item blank");
                   return false;
                }else if(totalfound>0){
                   alert("Please set an amount in every month");
                   return false;
                }else if(itemDup>0){
                   alert("System don't allow duplicate name");
                   return false;
                }else{
                   return true;
                }
  }
  //this function get the product items from step 2 to display in step 4 for product pricing
  var listProductForPricing=function(steps){
           

          var edit="contenteditable='true'";
          var table="<table class='table table-sm table-dark table-striped'> <tr>";
              table+="  <th data='items'> Product Items </th><th data='Prices'> Prices </th><th data='Unit of Measurement'> Unit of Measurement </th><th data='for gate pass'> For Gate Pass</th><th data='gate pass value'>&nbsp;</th></tr>";
            
              $(steps+" tbody tr:not(.hide):not(#total) ._0").each(function(i, val) {
                    table+="<tr>";
                    table+="<td >"+$(this).text()+"</td><td "+edit+" class='_price'>0</td><td "+edit+"></td>";
                    table+="<td><input type='checkbox' class='gate_pass' /></td> <td style='opacity:0;'></td>"
                    table+="</tr>";
              });
             
              table+="</table>";
              return table;
  }

  var renderTable=function(steps, text, dateFrom, dateTo, no){
          removeTable(steps);
          $(steps).budget({
                text:text,
                dateFrom:dateFrom,
                dateTo:dateTo,
                steps:no
          }); 
  }

  var removeTable=function(steps){
     $(steps+' *').remove();
  }

  var check_for_gate_pass=function(){
     $(".gate_pass").change(function(){ 
          $(this).parent().next().text("");                    
          if(this.checked){                
             $(this).parent().next().text("Y");
          }else{             
             $(this).parent().next().text("N");
          }
     });
  }

</script>
<?php } else { echo UnauthorizedOpenTemp(); } ?>
      </main>

<?php require_once('layout/footer.php');?>      
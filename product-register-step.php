<?php
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();

    $users = $crud->getData("SELECT * FROM users ;");

    $project_id= "";
    $project_name= "";
    $project_description  = "";
    $project_status="";
    $project_incharge ="";
    $project_started ="";
    $project_ended ="";
    $found=false;
    $add=true;

    if(isset($_GET['edit'])){

       $id = $crud->escape_string($_GET['edit']);

       if(is_numeric($id) && $id!=''){
            $projects = $crud->getData("SELECT * FROM projects WHERE project_id=".$_GET['edit']);

            $found=(count($projects)==1)?true:false;

            $add=false;
            
            foreach ($projects as $res) {
                $project_id   = $res['project_id'];
                $project_name = $res['project_name'];
                $project_description  = $res['project_description'];
                $project_status  = $res['project_status'];
                $project_incharge =$res['project_incharge'];
                $project_started =$res['project_started'];
                $project_ended =$res['project_ended'];          
            }
      }
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

</style>

<?php require_once('layout/nav.php');?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='setting.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Setting</a> / Product /<h2></h2> </li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                    <i class="fa fa-cube" aria-hidden="true"></i>   Product
              </div>
              <div class="card-body">
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
                             
                                <h5> Step 1 : Enter Project Information</h5><br/>
                                 <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label">Project Name *</label>
                                  <input  maxlength="100" type="text" required="required" class="form-control form-control-sm" placeholder="Enter project name"  id="proj_name" />
                                </div>
                                <div class="form-group">
                                  <label class="control-label">Project In-charge*</label>
                                  <select  class="form-control form-control-sm" id="project_incharge" name="project_incharge" required="required">
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
                                    <input class="form-control form-control-sm" id="project_started" name="project_started" type="text"  placeholder="Date Started" data-date-format="yyyy-mm-dd" required value="<?php echo $project_started;?>">
                                </div>
                                <div class="form-group">
                                    <label >Project Ended (yyyy-mm-dd)</label>
                                    <input required data-date-format="yyyy-mm-dd" class="form-control form-control-sm" id="project_ended" name="project_ended" type="text"  placeholder="Date Ended" value="<?php echo ($project_ended=='0000-00-00')?'':$project_ended;?>">
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
                                      <textarea rows="5" class="form-control " id="proj_desc" name="project_description" style="margin-top: 0px; margin-bottom: 0px;">
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
                                <h5> Step 4 : Saving</h5><br/>
                                <button class="btn btn-primary prevBtn btn-lg pull-left" type="button">Previous</button>
                                <button class="btn btn-success submitBtn btn-lg pull-right" type="button">Submit</button>
                              </div>
                            </div>
                          </div>
                        </form>
              </div>
        </div>
        </div>
      </main>


<script src='assets/validator.min.js'></script>
<script src="assets/bootstrap-datepicker.min.js"></script>   
<script src="assets/numberFormat.js"></script>  

<script src="assets/requiredJS/project-register-step.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
<script>
  $(document).ready(function () {
1
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
                $target.find('input:eq(0)').focus();
            }
        });

        allPrevBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

                prevStepWizard.removeAttr('disabled').trigger('click');
        });

        allNextBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url']"),
                isValid = true;

            if(curStepBtn=="step-1"){
                $('#step2 table').remove();
                $('#step2').budget({
                      text:'Production Cost',
                      dateFrom:  $('#project_started').val(),
                      dateTo:$('#project_ended').val(),
                      steps:1
                }); 
                
                
            }else if(curStepBtn=="step-2"){
                step2_=collectData("#step2");
                
                $('#step3 table').remove();
                $('#step3').budget({
                      text:'Expenses',
                      dateFrom:  $('#project_started').val(),
                      dateTo:$('#project_ended').val(),
                      steps:2
                });  
                
            }else if(curStepBtn=="step-3"){
                step3_=collectData("#step3");               
                
            }

           
            
            $(".form-group").removeClass("has-error");
            for(var i=0; i<curInputs.length; i++){
                if (!curInputs[i].validity.valid){
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if(curStepBtn=="step-2"){
                isValid=validate("#step2");
            }else if(curStepBtn=="step-3"){
                isValid=validate("#step3");
            }

            if (isValid){
                nextStepWizard.trigger('click');              
            }

        });

        $('div.setup-panel div a.btn-primary').trigger('click');   

         $(".submitBtn").click(function(){
                var url = "phpscript/projectSetup/registerProjectStep.php";
                 // POST values in the background the the script URL
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType   : 'json',
                    data: {
                           proj_name:$('#proj_name').val(),
                           proj_incharge:$('#project_incharge').val(),
                           proj_desc:$('#proj_desc').val(),
                           prod_cost: step2_,
                           expenses:  step3_
                          },
                    success: function (data)
                    {
                          alert("Success");
                    }
                });
            });



});
// A few jQuery helpers for exporting only
jQuery.fn.pop = [].pop;
jQuery.fn.shift = [].shift;

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
                var itemfound = 0;
                var totalfound=0;
                $(steps+" tbody tr:not(.hide) ._0").each(function(i, val) {
                  if ($(this).text() == '') {
                    itemfound++;
                  }
                });

                $(steps+" table tr#total td[class*='t_']").each(function(i, val) {
                  console.log(($(this).text() == " 0"));
                  if ($(this).text() == " 0") {                  
                    totalfound++;
                  }
                });

               
                console.log(totalfound);
                if(itemfound>0){
                   alert("Please don't leave the an item blank");
                   return false;
                }else if(totalfound>0){
                   alert("Please set an amount in every month");
                   return false;
                }else{
                   return true;
                }
  }

</script>


<?php require_once('layout/footer.php');?>      
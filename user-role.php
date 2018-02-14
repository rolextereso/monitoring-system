<?php 
    require_once('layout/header.php');
    require_once('classes/Crud.php');

    $crud = new Crud();
    $result = $crud->getData("SELECT * FROM user_type WHERE user_type_id!=1; ");    
   
?>
    <style>
        .card p{
          font-size: 13px;
        }

    </style>
    <?php require_once('layout/nav.php');?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
<?php if(access_role("Admin Setting","view_page",$_SESSION['user_type'])){?>
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href='setting.php'><i class="fa fa-arrow-left" aria-hidden="true"></i> Go to Setting </a> </li>
              </ol>
              <ul class="nav nav-tabs">
                          <li class="nav-item">
                               <a class="nav-link " href="owner-info.php"><i class="fa fa-hand-pointer-o" ></i> Owner Information</a>
                          </li>
                          <li class="nav-item">
                              <a class="active nav-link" href="user-role.php"> <i class="fa fa-hand-pointer-o" ></i> User Role</a>
                          </li>
                         
              </ul>
           </nav>

         <br/>
         <div class="card">
              <div class="card-header">
                
              </div>
              <div class="card-body" style="overflow: auto;"> 
                     <div class="row">
                        <div class="col-md-12">
                               <form data-toggle="validator" role="form" id="form">
                                                                              
                                        <div class="form-row">
                                              <div class="col-md-4">                                                 
                                                  <div class="form-group">
                                                        <label >User type:</label>
                                                        <select name="user_type" class="form-control form-control-sm">
                                                            <option value=""> Select User Type</option>
                                                            <?php foreach($result as $row){?>
                                                                 <option value="<?php echo $row['user_type_id'];?>"> 
                                                                    <?php echo $row['user_type'];?> 
                                                                 </option>
                                                            <?php } ?>
                                                           
                                                        </select>
                                                  </div> 
                                              </div> 
                                              <div class="col-md-4">
                                                  <div class="form-row">
                                                     <label>&nbsp;</label>
                                                    <button type="submit" name="submit" disabled="disabled" class="btn btn-primary btn-block" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Save Changes</button>
                                                  </div>
                                             </div> 
                                        </div>
                                        <div class="col-md-12">
                                                  <table class="table table-striped table-hover" id="user_role_table">
                                                      <thead>
                                                        <tr>  
                                                            <th>Module</th> 
                                                            <th>View Page</th> 
                                                            <th>View Command</th>                                               
                                                            <th>Edit Command</th> 
                                                            <th>Add Command</th> 
                                                            <th>Delete Command</th> 
                                                            <th>Save Changes</th> 
                                                            <th>Edit Changes</th> 
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                      </tbody>    
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
            $("[name='user_type']").change(function(){
                if($(this).val==""){
                  $("[name='submit']").attr('disabled','disabled');
                }else{
                  $("[name='submit']").removeAttr('disabled');
                  user_role();
                }
                
            });

            $('#form').on('submit', function (e) {
                      // if the validator does not prevent form submit

                      if (!e.isDefaultPrevented()) {
                        bootbox.confirm({
                                          size: "small",                                         
                                          message: "Are you sure?", 
                                          callback: function(result){                                            
                                                if(result){
                                                      var url = "phpscript/userRole/saveRole.php";

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

        });

        function user_role(){
           $("#user_role_table tbody").html("");
           $.ajax({
                    type: "POST",
                    url: "phpscript/userRole/getRole.php",
                    dataType   : 'json',
                    data: {user_type: $("[name='user_type']").val()},
                    success: function (data)
                    {
                        
                        if(data.data.length>1){
                          var row="";                                     
                                $.each(data.data, function(key, value){  
                                          row+="<tr>";                                                             
                                          row+="<td>"+value[0]+"</td>";  
                                          row+="<td>"+value[1]+"</td>";                                       
                                          row+="<td>"+value[2]+"</td>";         
                                          row+="<td>"+value[3]+"</td>";         
                                          row+="<td>"+value[4]+"</td>";         
                                          row+="<td>"+value[5]+"</td>";  
                                          row+="<td>"+value[6]+"</td>";         
                                          row+="<td>"+value[7]+"</td>";  
                                        
                                          row+="</tr>";       
                                });
                                         
                                $("#user_role_table tbody").prepend(row);
                          checking_checkbox();
                         }else{
                              var row="";
                                        row+="<tr>";                                                             
                                        row+="<td colspan='8'> Please select the user type drop down list</td>"; 
                                        row+="</tr>"; 

                              $("#user_role_table tbody").prepend(row);      
                             
                         }
                          
                    }
                });

        }

        function checking_checkbox(){
                          $(".check:not(:checked)").prev().attr("checked","checked");//check the uncheck checkbox that is hidden

                          $('[type=checkbox]').change(function() {
                                  if(this.checked) {      
                                                        
                                     $(this).prev().remove();
                                     $(this).attr("checked","checked"); //add checked attribure to checkbox  
                                  }else{
                                     var temp_name=$(this).attr("name");
                                     var temp_value=$(this).attr("uncheck");
                                     var temp_input="<input type='hidden' name='"+temp_name+"' value='"+temp_value+"'/>";

                                     $(temp_input).insertBefore(this);
                                     $(this).removeAttr("checked");//remove check attr to checkbox  

                                  }                        
                          });
        }
      </script>
<?php }else{ echo UnauthorizedOpenTemp(); } ?>
      </main>
<?php require_once('layout/footer.php');?>      
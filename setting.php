<?php 
    require_once('layout/header.php'); 
    require_once('layout/nav.php');

?>
    <style>
        .card p{
          font-size: 13px;
        }

<?php 
$col_no=4;
if(access_role("Admin Setting","view_page",$_SESSION['user_type'])){
    $col_no=3;
}

?>
    </style>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                <i class='fa fa-cog'></i> System Settings
              </div>
              <div class="card-body">               
                    <div class="row">
                    
                        <div class="col-md-<?php echo $col_no;?>">
                            <div class="card">
                                <img class="card-img-top img-fluid" src="img/setting_assets/user-setting.jpg" alt="Card image cap">
                                <div class="card-body" style="text-align: center;">
                                      <h4 class="card-title">User Setup</h4>
                                      <p class="card-text">This module used to add, and set status to the user.<br/><br/></p>
                                      <a href="user-list.php" class="btn btn-primary"> View Setting</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-<?php echo $col_no;?>">
                          <div class="card " >
                              <img class="card-img-top img-fluid" src="img/setting_assets/project-setting.jpg" alt="Card image cap">
                              <div class="card-body" style="text-align: center;">
                                    <h4 class="card-title">Project Setup</h4>
                                    <p class="card-text">This module used to setup project together with its budgets.<br/><br/></p>
                                    <a href="product-register-step.php" class="btn btn-primary">View Setting</a>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-<?php echo $col_no;?>">
                            <div class="card " >
                                <img class="card-img-top img-fluid" src="img/setting_assets/product-setting.jpg" alt="Card image cap">
                                <div class="card-body" style="text-align: center;">
                                      <h4 class="card-title">User Activity</h4>
                                      <p class="card-text">This module used to record user activity in the system.<br/><br/></p>
                                      <a href="#" class="btn btn-primary">View Setting</a>
                                </div>
                            </div>
                        </div>
                        <?php if(access_role("Admin Setting","view_page",$_SESSION['user_type'])){ ?>
                            <div class="col-md-<?php echo $col_no;?>">
                              <div class="card ">
                                  <img class="card-img-top img-fluid" src="img/setting_assets/lock-setting.jpg" alt="Card image cap">
                                  <div class="card-body" style="text-align: center;">
                                        <h4 class="card-title">Admin Setting</h4>
                                        <p class="card-text">This module is used to setup company info and setup user access in the system.</p>
                                        <a href="owner-info.php" class="btn btn-primary">View Setting</a>
                                  </div>
                              </div>
                            </div>

                        <?php } ?>                    
                    </div>                  
              </div>
        </div>
        </div>
      </main>




<?php require_once('layout/footer.php');?>      
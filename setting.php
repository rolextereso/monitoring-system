<?php 
    require_once('layout/header.php'); 
    require_once('layout/nav.php');

?>
    <style>
        .card p{
          font-size: 13px;
        }

    </style>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
           <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Settings /</li>
              </ol>
           </nav>

        
         <div class="card">
              <div class="card-header">
                <i class='fa fa-cog'></i> System Settings
              </div>
              <div class="card-body">               
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <img class="card-img-top img-fluid" src="img/setting_assets/user-setting.jpg" alt="Card image cap">
                                <div class="card-body" style="text-align: center;">
                                      <h4 class="card-title">User Setup</h4>
                                      <p class="card-text">This module used to add, edit and set user role and status of the user.</p>
                                      <a href="user-list.php" class="btn btn-primary"> View Setting</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                          <div class="card " >
                              <img class="card-img-top img-fluid" src="img/setting_assets/project-setting.jpg" alt="Card image cap">
                              <div class="card-body" style="text-align: center;">
                                    <h4 class="card-title">Project Setup</h4>
                                    <p class="card-text">This module used to add, edit and set user role and status of the user.</p>
                                    <a href="project-register.php" class="btn btn-primary">View Setting</a>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card " >
                                <img class="card-img-top img-fluid" src="img/setting_assets/product-setting.jpg" alt="Card image cap">
                                <div class="card-body" style="text-align: center;">
                                      <h4 class="card-title">Product Setup</h4>
                                      <p class="card-text">This module used to add, edit and set user role and status of the user.</p>
                                      <a href="product-register.php" class="btn btn-primary">View Setting</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                          <div class="card ">
                              <img class="card-img-top img-fluid" src="img/setting_assets/user-setting.jpg" alt="Card image cap">
                              <div class="card-body" style="text-align: center;">
                                    <h4 class="card-title">User Setup</h4>
                                    <p class="card-text">This module used to add, edit and set user role and status of the user.</p>
                                    <a href="user-list.php" class="btn btn-primary">View Setting</a>
                              </div>
                          </div>
                        </div>

                        
                    
                    </div>                  
              </div>
        </div>
        </div>
      </main>




<?php require_once('layout/footer.php');?>      
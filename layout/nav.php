
<div class="container-fluid">
 <div class="row">

     <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
              <ul class="nav nav-pills flex-column ">
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="index.php")? 'active': '';?>"  href="index.php"><i class="fa fa-tachometer"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="item-selection.php") || (basename($_SERVER['PHP_SELF'])=="item-selection-rental.php")? 'active': '';?>" href="item-selection.php"  ><i class="fa fa-hand-pointer-o"></i>  Rental or Product Selection</a>                      
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="item-selection-list.php")? 'active': '';?>"  href="item-selection-list.php"><i class="fa fa-list"></i> Transaction List</a>
                </li>
                <?php if(basename($_SERVER['PHP_SELF'])=="item-buy.php"){ ?>
                  <li class="nav-item">
                        <a style="padding-left: 24px;" class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="item-buy.php") ? 'active': '';?>"  href="item-buy.php"><i class="fa fa-credit-card"></i>  Pay Bought and Rented Items</a>
                  </li>
                <?php } ?>
                
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="project-list.php") || (basename($_SERVER['PHP_SELF'])=="project-list-spec.php") || (basename($_SERVER['PHP_SELF'])=="project-register.php") || (basename($_SERVER['PHP_SELF'])=="product-register.php")? 'active': '';?>" href="project-list.php"><i class="fa fa-cube"></i> Project List </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="rental-list.php") || (basename($_SERVER['PHP_SELF'])=="rental-register.php")? 'active': '';?>" href="rental-list.php"><i class="fa fa-car"></i> Rental Item List</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="rental-to-return-list.php") || (basename($_SERVER['PHP_SELF'])=="rental-return.php")? 'active': '';?>" href="rental-to-return-list.php"><i class="fa fa-reply"></i> Rented Items</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="report.php")? 'active': '';?>" href="report.php"><i class="fa fa-file-text" ></i> Reports</a>
                </li>
               
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="gatepass.php")? 'active': '';?>" href="gatepass.php"><i class="fa fa-key" aria-hidden="true"></i> Gate Pass</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="setting.php") || (basename($_SERVER['PHP_SELF'])=="product-register-step.php") || (basename($_SERVER['PHP_SELF'])=="user-list.php") || (basename($_SERVER['PHP_SELF'])=="user-register.php") || (basename($_SERVER['PHP_SELF'])=="user-reset-pass.php") || (basename($_SERVER['PHP_SELF'])=="user-edit.php") ? 'active': '';?>" href="setting.php"><i class="fa fa-cog" aria-hidden="true"></i> Setting</a>
                </li>
              </ul>

              
    </nav>
    
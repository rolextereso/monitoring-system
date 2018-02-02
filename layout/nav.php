<?php
   include_once("classes/function.php");
?>

<div class="container-fluid">
 <div class="row">

     <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
              <ul class="nav nav-pills flex-column ">
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="index.php")? 'active': '';?>"  href="index.php"><i class="fa fa-tachometer"></i> Dashboard</a>
                </li>

                <?php if(access_role("Location Map","view_page",$_SESSION['user_type'])){?>
                         <li class="nav-item ">
                              <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="location-map.php")? 'active': '';?>"  href="location-map.php"><i class="fa fa-map-marker"></i> Location Map </a>
                         </li>
                <?php } ?>

                <?php if(access_role("Rental or Product Selection","view_page",$_SESSION['user_type'])){?>
                        <li class="nav-item">
                              <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="item-selection.php") || (basename($_SERVER['PHP_SELF'])=="item-selection-rental.php")? 'active': '';?>" href="item-selection.php"  ><i class="fa fa-hand-pointer-o"></i>  Rental or Product Selection</a>                      
                        </li>
                <?php } ?>


                <?php if(access_role("Transaction List","view_page",$_SESSION['user_type'])){?>
                      <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="item-selection-list.php")? 'active': '';?>"  href="item-selection-list.php"><i class="fa fa-list"></i> Transactions </a>
                      </li>

                      <?php if(basename($_SERVER['PHP_SELF'])=="item-buy.php"){ ?>
                        <li class="nav-item">
                              <a style="padding-left: 24px;" class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="item-buy.php") ? 'active': '';?>"  href="item-buy.php"><i class="fa fa-credit-card"></i>  Pay Bought and Rented Items</a>
                        </li>
                      <?php } ?>
                <?php } ?>


                <?php if(access_role("Transaction List","view_page",$_SESSION['user_type'])){?>                
                      <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="project-list.php") || (basename($_SERVER['PHP_SELF'])=="project-list-spec.php") || (basename($_SERVER['PHP_SELF'])=="project-register.php") || (basename($_SERVER['PHP_SELF'])=="product-register.php")? 'active': '';?>" href="project-list.php"><i class="fa fa-cube"></i> Projects  </a>
                      </li>
                <?php } ?>

                <?php if(access_role("Rental Item List","view_page",$_SESSION['user_type'])){?>
                      <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="rental-list.php") || (basename($_SERVER['PHP_SELF'])=="rental-register.php")? 'active': '';?>" href="rental-list.php"><i class="fa fa-car"></i> Rental Items </a>
                      </li>
                <?php } ?>


                <?php if(access_role("Rented Items","view_page",$_SESSION['user_type'])){?>    
                      <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="rental-to-return-list.php") || (basename($_SERVER['PHP_SELF'])=="rental-return.php")? 'active': '';?>" href="rental-to-return-list.php"><i class="fa fa-reply"></i> Rented Items</a>
                      </li>
                <?php } ?>

                <?php if(access_role("Purchase Requests","view_page",$_SESSION['user_type'])){?>
                      <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="purchase_request_list.php") || (basename($_SERVER['PHP_SELF'])=="purchase_request.php") || (basename($_SERVER['PHP_SELF'])=="purchased_request_save_approved.php")? 'active': '';?>" href="purchase_request_list.php"><i class="fa fa-files-o"></i> Purchase Requests</a>
                      </li>
                <?php } ?>

                <?php if(access_role("Reports","view_page",$_SESSION['user_type'])){?>
                      <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="report.php" || basename($_SERVER['PHP_SELF'])=="report_debit.php")? 'active': '';?>" href="report.php"><i class="fa fa-file-text" ></i> Reports</a>
                      </li>
                <?php } ?>
               
               <?php if(access_role("Gate Pass","view_page",$_SESSION['user_type'])){?>
                      <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="gatepass.php")? 'active': '';?>" href="gatepass.php"><i class="fa fa-key" aria-hidden="true"></i> Gate Pass</a>
                      </li>
                <?php } ?>



                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="setting.php") || (basename($_SERVER['PHP_SELF'])=="product-register-step.php") || (basename($_SERVER['PHP_SELF'])=="user-list.php") || (basename($_SERVER['PHP_SELF'])=="user-register.php") || (basename($_SERVER['PHP_SELF'])=="user-reset-pass.php") || (basename($_SERVER['PHP_SELF'])=="user-edit.php") ? 'active': '';?>" href="setting.php"><i class="fa fa-cog" aria-hidden="true"></i> Setting</a>
                </li>
              </ul>

              
    </nav>
    
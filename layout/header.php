<?php
  session_start();
  if(!isset($_SESSION['user_id'])){      
      header('Location: login.php');
  }
  include_once("classes/function.php");
?>
<!DOCTYPE html>
<!-- saved from url=(0054)https://getbootstrap.com/docs/4.0/examples/dashboard/# -->
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <meta name="description" content="">
          <meta name="author" content="">
          <link rel="shortcut icon" href="img/favicon.gif">

          <title>IGP Monitoring System</title>

          <!-- Custom fonts for this template-->
          <link href="./assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

          <!-- Custom fonts for this template-->
          <link href="./assets/font-awesome/css/font-chivo.css" rel="stylesheet" type="text/css">

          <!-- Bootstrap core CSS -->
          <link href="./assets/bootstrap.css" rel="stylesheet">

          <!-- Custom styles for this template -->
          <link href="./assets/dashboard.css" rel="stylesheet">

          <!-- animation css -->
          <link href="./assets/animate.css" rel="stylesheet">

          <script src="./assets/jquery.1.12.4.min.js"></script>
          <script src="./assets/requiredJS/openWindow.js"></script>

          <style>
             /* .bg-dark {
                  background-color: #0b2c4d!important;
              }*/
              body{
                font-size: 13px !important;
              }
              .alert{
                  position: fixed;
                  top: 25px; 
                  left:20%;
                  width: 60%;
                  z-index: 10000;
                  display: none;
              }

              .table-bordered td, .table-bordered th {
                 border: none !important;
              }

              #dataTable tr td {
                  height: 30px;
                  padding-bottom:0.1rem ;
                  padding-top:0.1rem ;
              }
              
              .btn{
                  font-size: 13px;
              }

              .has-error .form-control {
                  border-color: #a94442;
                  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                  box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
              }

              .un_authorized{
                  border: 1px solid #e1a3a3;
                  padding: 8px 13px;
                  background: #ffdede;
                  color: #a64c4c;
                }   

              .unreturn-item{
                  position: fixed;
                  bottom: 25px; 
                  left:25%;
                  width: 60%;
                  z-index: 10000;
                  
              } 

              .unreturn-item {
                  padding: .75rem 1.25rem;
                  margin-bottom: 1rem;
                  border: 1px solid transparent;
                  border-radius: .25rem;
                  color: #721c24;
                  background-color: #f8d7da;
                  border-color: #f5c6cb;
                  display: none;
              
              }
              .bounce {
                  animation-duration: 1.9s;
                  animation-iteration-count: infinite;
                  animation-name: bounce;
              }

              /*.table .thead-dark th {
                  background-color: #07284a!important;
                  border-color: #93bfeb!important;
              }

              .table .tfoot-dark td {
   
                  background-color: #0c335a!important;
                  border-color: #93bfeb!important;
              }*/

              /*.bg-dark {
                  background-color: #04274b!important;
              }*/

              .badge {
                font-weight: normal!important;
                
              }
          </style>
  

</head>
<body>
    <div style="display:none;" id="current_year"> <?php echo date("Y"); ?></div>
    <div class="alert alert-success" >
          
    </div>

    <?php  if(basename($_SERVER['PHP_SELF'])!="rental-to-return-list.php" 
            && basename($_SERVER['PHP_SELF'])!="rental-return.php"){ ?>
    <div class="unreturn-item animated bounce" >
          <span class='badge badge-danger overdue_rented'>2</span> &nbsp; Rented item(s) overdue as of <?php echo date('F d, Y'); ?>
          <span style="cursor: pointer;" class="close" title="close">×</span>
    </div>
    <?php } ?>

    <header>  
          <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="index.php"><img src="img/logo.png" style="width: 137px;" /></a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item header-nav">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="index.php")? 'active': '';?>"  href="index.php"> Home </a>
                </li>
                 <?php if(access_role("Location Map","view_page",$_SESSION['user_type'])){?>
                      <li class="nav-item header-nav">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="location-map.php")? 'active': '';?>"  href="location-map.php"> Location Map </a>
                      </li>
                 <?php } ?>

                 <?php if(access_role("Rental or Product Selection","view_page",$_SESSION['user_type'])){?>
                     <li class="nav-item header-nav">
                      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="item-selection.php") || (basename($_SERVER['PHP_SELF'])=="item-selection-rental.php")? 'active': '';?>" href="item-selection.php"> Order of Payment</a>
                    </li>
                <?php } ?>

                <?php if(access_role("Transaction List","view_page",$_SESSION['user_type'])){?>
                     <li class="nav-item header-nav">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="item-selection-list.php")? 'active': '';?>"  href="item-selection-list.php">Transactions 
                          <span class="badge badge-danger unpaid_transaction" style="display: none;">0</span>
                        </a>

                    </li>
                <?php } ?>


                <?php if(access_role("Project List","view_page",$_SESSION['user_type'])){?>
                    <li class="nav-item header-nav">
                      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="project-list.php")|| (basename($_SERVER['PHP_SELF'])=="project-list-spec.php")? 'active': '';?>" href="project-list.php"> Projects </a>
                    </li>
                <?php } ?>

                <?php if(access_role("Rental Item List","view_page",$_SESSION['user_type'])){?>
                     <li class="nav-item header-nav">
                      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="rental-list.php") || (basename($_SERVER['PHP_SELF'])=="rental-register.php")? 'active': '';?>" href="rental-list.php"></i> Rental Items </a>
                     </li>
                <?php } ?>

                <?php if(access_role("Rented Items","view_page",$_SESSION['user_type'])){?>
                    <li class="nav-item header-nav">
                      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="rental-to-return-list.php") || (basename($_SERVER['PHP_SELF'])=="rental-return.php")? 'active': '';?>" href="rental-to-return-list.php"> Rented Items
                        <span class="badge badge-danger rented_items"  style="display: none;">0</span>
                      </a>
                      
                    </li>
                <?php } ?>

                <?php if(access_role("Purchase Requests","view_page",$_SESSION['user_type'])){?>
                      <li class="nav-item header-nav ">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="purchase_request_list.php") || (basename($_SERVER['PHP_SELF'])=="purchase_request.php") || (basename($_SERVER['PHP_SELF'])=="purchased_request_save_approved.php")? 'active': '';?>" href="purchase_request_list.php">Purchase Requests 
                        <span class="badge badge-danger onprocess_request"  style="display: none;">0</span>
                        </a>
                        
                      </li>
                <?php } ?>


                <?php if(access_role("Reports","view_page",$_SESSION['user_type'])){?>
                    <li class="nav-item header-nav ">
                      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="report.php" || basename($_SERVER['PHP_SELF'])=="report_debit.php")? 'active': '';?>" href="report.php"> Reports</a>
                    </li>
                <?php } ?>
               
                <?php if(access_role("Gate Pass","view_page",$_SESSION['user_type'])){?>
                    <li class="nav-item header-nav">
                      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="gatepass.php")? 'active': '';?>" href="gatepass.php">Gate Pass</a>
                    </li>
                <?php } ?>
               
                <li class="nav-item header-nav">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="setting.php") || (basename($_SERVER['PHP_SELF'])=="product-register-step.php") || (basename($_SERVER['PHP_SELF'])=="user-list.php") || (basename($_SERVER['PHP_SELF'])=="user-register.php") || (basename($_SERVER['PHP_SELF'])=="user-reset-pass.php") || (basename($_SERVER['PHP_SELF'])=="user-edit.php") || (basename($_SERVER['PHP_SELF'])=="user_logs.php") ? 'active': '';?>" href="setting.php"><i class="fa fa-cog" aria-hidden="true"></i> Setting</a>
                </li>
              </ul>
             <!--  <form class="form-inline mt-2 mt-md-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form> -->
              <ul class="navbar-nav ml-auto">           
                <li class="nav-item">
                      <img src="<?php echo ($_SESSION['pic']=='')? 'img/pic_avatar.jpg':$_SESSION['pic'];?>" width="20" height="20" />
                      <a class="nav-link " title=" Update Profile Information" style="display: inline-block;" href="user-edit.php?u=<?php echo $_SESSION['user_id_'];?>"> <?php echo $_SESSION['lastname'].', '.$_SESSION['firstname'];?> </a>
                </li> 
                <li class="nav-item">
                      <a class="nav-link" href="help.php" <?php echo (basename($_SERVER['PHP_SELF'])=="help.php")? 'active': '';?>" ><i class="fa fa-question-circle"></i> Help</a>
                </li> 
                <li class="nav-item">
                      <a class="nav-link" href="javascript:void(0)" onclick="logout()"><i class="fa fa-fw fa-sign-out"></i>Logout</a>
                </li>
              </ul>
            </div>
          </nav>
    </header>


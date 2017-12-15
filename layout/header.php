<!DOCTYPE html>
<!-- saved from url=(0054)https://getbootstrap.com/docs/4.0/examples/dashboard/# -->
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <meta name="description" content="">
          <meta name="author" content="">
          <link rel="icon" href="https://getbootstrap.com/favicon.ico">

          <title>Dashboard Template for Bootstrap</title>

          <!-- Custom fonts for this template-->
          <link href="./assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

          <!-- Bootstrap core CSS -->
          <link href="./assets/bootstrap.min.css" rel="stylesheet">

          <!-- Custom styles for this template -->
          <link href="./assets/dashboard.css" rel="stylesheet">

          <!-- animation css -->
          <link href="./assets/animate.css" rel="stylesheet">

          <script src="./assets/jquery.1.12.4.min.js"></script>

          <style>
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
          </style>

</head>
<body>
    <div style="display:none;" id="current_year"> <?php echo date("Y"); ?></div>
    <div class="alert alert-success" >
          
    </div>

    <header>  
          <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="dashboard.php"><img src="img/logo.png" style="width: 137px;" /></a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="index.php")? 'active': '';?>"  href="index.php"> Home </a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="buy.php")? 'active': '';?>" href="buy.php"> Buy Product</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="project-list.php")? 'active': '';?>" href="project-list.php"> Products </a>
                </li>
               
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="setting.php")? 'active': '';?>" href="setting.php"><i class="fa fa-cog" aria-hidden="true"></i> Setting</a>
                </li>
              </ul>
              <form class="form-inline mt-2 mt-md-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>
            </div>
          </nav>
    </header>


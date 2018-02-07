<?php
  session_start();
  if(isset($_SESSION['user_id'])){
       header('Location: index.php');
  }
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

          <!-- Bootstrap core CSS -->
          <link href="./assets/bootstrap.min.css" rel="stylesheet">

          <!-- Custom styles for this template -->
          <link href="./assets/dashboard.css" rel="stylesheet">

          <!-- animation css -->
          <link href="./assets/animate.css" rel="stylesheet">

          <script src="./assets/jquery.1.12.4.min.js"></script>
          <style>
              .card-login {
                  max-width: 25rem;
                  margin-top: 3rem;
                  margin-bottom: 3rem;
              }

              .has-error .form-control {
                border-color: #a94442;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
              }

              body{
                font-size: 13px !important;
              }
              .container{
                 background: url('img/setting_assets/background.png');
                 background-size: contain;
              }
          </style>
</head>

<body class="bg-dark">
  <div class="container" >
      <div class="row">
          <div class="col-sm-1">
              <img src="img/logo.png"/>
          </div>
          <div class="col-sm-11">
              <div class="card card-login mx-auto mt-5">
                <div class="card-header"> <i class="fa fa-lock" aria-hidden="true"></i> Login</div>
                <div class="card-body">
                  <form id="form">
                    <div id="msg" class="red" style="text-align: center;"></div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control" id="username" type="text" name="username" required placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password" required placeholder="Password">
                    </div>
                    <br/>
                    <button class="btn btn-primary btn-block" type="submit" name="submit">Login</button>
                    <br/>
                    <div id="hint">&nbsp;</div>
                  </form>                  
                  <br/>
               
                </div>
                <div class="card-footer small text-muted" style="text-align: center;"> &copy; IGP Monitoring System 2017</div>
              </div>
         </div>
      </div>
  </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="./assets/popper.min.js"></script>
    <script src="./assets/bootstrap.min.js"></script>

    <script src='assets/validator.min.js'></script>   
    <script src='assets/requiredJS/login.js'></script>   
   
</body>
</html>
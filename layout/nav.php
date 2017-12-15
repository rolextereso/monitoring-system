
<div class="container-fluid">
 <div class="row">

     <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="index.php")? 'active': '';?>"  href="index.php"><i class="fa fa-tachometer"></i> Dashboard</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="buy.php")? 'active': '';?>" href="buy.php"><i class="fa fa-shopping-basket" ></i> Buy Product</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="project-list.php")? 'active': '';?>" href="project-list.php"><i class="fa fa-cube"></i> Products </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="report.php")? 'active': '';?>" href="report.php"><i class="fa fa-file-text" ></i> Reports</a>
                </li>
               
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="gatepass.php")? 'active': '';?>" href="gatepass.php"><i class="fa fa-key" aria-hidden="true"></i> Gate Pass</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="setting.php")? 'active': '';?>" href="setting.php"><i class="fa fa-cog" aria-hidden="true"></i> Setting</a>
                </li>
              </ul>

              
    </nav>
    
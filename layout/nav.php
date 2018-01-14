
<div class="container-fluid">
 <div class="row">

     <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
              <ul class="nav nav-pills flex-column ">
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="index.php")? 'active': '';?>"  href="index.php"><i class="fa fa-tachometer"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                      <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="item-selection.php")? 'active': '';?>" href="item-selection.php"  ><i class="fa fa-hand-pointer-o"></i> Item Selection</a>                      
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="item-selection-list.php") || (basename($_SERVER['PHP_SELF'])=="item-buy.php")? 'active': '';?>"  href="item-selection-list.php"><i class="fa fa-list"></i> Selection List</a>
                </li>
                <!-- <li class="nav-item">
                      <a class="nav-link <?php //echo (basename($_SERVER['PHP_SELF'])=="buy.php")? 'active': '';?>" data-toggle="collapse" href="#buy" ><i class="fa fa-shopping-basket"></i> Buy Product | Rent Item</a>
                      <ul id="buy" class="collapse in">
                          <li> <a href="#" class="nav-link">Buy</a></li>
                      </ul>
                </li> -->
                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="project-list.php") || (basename($_SERVER['PHP_SELF'])=="project-list-spec.php")? 'active': '';?>" href="project-list.php"><i class="fa fa-cube"></i> Project List </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF'])=="project-lists.php") || (basename($_SERVER['PHP_SELF'])=="project-list-spece.php")? 'active': '';?>" href="project-list.php"><i class="fa fa-car"></i> Machineries and facilities  </a>
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
    
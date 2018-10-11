<header class="main-header">
    <!-- Logo -->
    <a href="home.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>FinFrog</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>FinFrog</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!--<li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/no-user-image.png" class="user-image" alt="User Image">
              <span class="hidden-xs">Alexander Pierce</span>
            </a>
            <ul class="dropdown-menu">
               User image
              <li class="user-header">
                <img src="dist/img/no-user-image.png" class="img-circle" alt="User Image">
                <p>
                  Alexander Pierce - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </li>

              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>

              </li>

              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>-->
          <!-- Control Sidebar Toggle Button -->
          <!--<li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/no-user-image.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['UserName'];?></p>
            <span class="pull rigth-primary"><?php /*$_SESSION['UserStatus'] = "ADMIN"*/; echo $_SESSION['UserStatus'];?></span>
            <?php /*$_SESSION['UserID'] = "1";*/?>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <?php if($_SESSION['UserStatus'] == "MANAGER"){?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-dashboard"></i> <span>ข้อมูลพื้นฐาน</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="product_unit_page.php"><i class="fa fa-circle-o"></i>หน่วยของสินค้า</a></li>
              <li><a href="product_type_page.php"><i class="fa fa-circle-o"></i>ประเภทสินค้า</a></li>
              <li><a href="sales_status_page.php"><i class="fa fa-circle-o"></i>สถานะการขาย</a></li>
              <li><a href="payment_type_page.php"><i class="fa fa-circle-o"></i>ประเภทการชำระเงิน</a></li>
              <!-- <li><a href=".php"><i class="fa fa-circle-o"></i>รูปแบบการชำระเงิน</a></li>
              <li><a href=".php"><i class="fa fa-circle-o"></i>ธนาคาร</a></li> -->
              <!--<li><a href="delivery_status_page.php"><i class="fa fa-circle-o"></i>สถานะการจัดส่ง</a></li>-->
              <li><a href="product_status_page.php"><i class="fa fa-circle-o"></i>สถานะสินค้า</a></li>
              <li><a href="title_page.php"><i class="fa fa-circle-o"></i>คำนำหน้าชื่อ</a></li>
              <li><a href="vat_page.php"><i class="fa fa-circle-o"></i>ค่าจัดส่ง</a></li>
              <!-- <li><a href="point_page.php"><i class="fa fa-circle-o"></i>แต้มสะสม</a></li> -->
            </ul>
          </li>
        <?php
        }
        ?>
          <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>การจัดการข้อมูล</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php
              if($_SESSION['UserStatus'] == "ADMIN"){
            ?>
                <li><a href="employee_page.php"><i class="fa fa-circle-o"></i>พนักงาน</a></li>
            <?php
              }

              if($_SESSION['UserStatus'] != "ADMIN"){
                if($_SESSION['UserStatus'] == "MANAGER"){
            ?>
                  <li><a href="product_page.php"><i class="fa fa-circle-o"></i>สินค้า</a></li>
                  <li><a href="customer_page.php"><i class="fa fa-circle-o"></i>ลูกค้า</a></li>
            <?php
                }
            ?>
              <li><a href="sale_page.php"><i class="fa fa-circle-o"></i>การขาย</a></li>
              <li><a href="payment_page.php"><i class="fa fa-circle-o"></i>การชำระเงิน</a></li>
              <!-- <li><a href="purchase_page.php"><i class="fa fa-circle-o"></i>การสั่งซื้อสินค้า</a></li> -->
              <!-- <li><a href="taking_page.php"><i class="fa fa-circle-o"></i>การรับสินค้า</a></li> -->
              <!-- <li><a href="tracking.php"><i class="fa fa-circle-o"></i>การส่งสินค้า</a></li> -->
              <li><a href="contant_ans.php"><i class="fa fa-circle-o"></i>ตอบกลับลูกค้า</a></li>
            <?php
                if($_SESSION['UserStatus'] == "MANAGER"){
            ?>
              <!-- <li><a href="company_page.php"><i class="fa fa-circle-o"></i>บริษัทจัดจำหน่าย</a></li> -->
              <li><a href="report_page.php"><i class="fa fa-circle-o"></i>รายงาน</a>
            <?php
                }
              }
            ?>
            </li>
          </ul>
        </li>
        <!-- <li class="treeview">
          <a href="profile_page.php">
            <i class="fa fa-dashboard"></i> <span>ข้อมูลส่วนตัว</span>
          </a>
        </li> -->
        <li class="treeview">
          <a href="logout.php">
            <i class="fa fa-dashboard"></i> <span>ออกจากระบบ</span>
          </a>
        </li>
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

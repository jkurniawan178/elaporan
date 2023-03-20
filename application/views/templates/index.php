<?php $this->load->view('templates/header') ?>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title mt-2 mb-4" style="border: 0;">
            <a href="index.html" class="site_title">
              <i class="fa fa-openid"></i>
              <img src="<?php echo base_url() ?>resources/images/logo1.png" class="img-fluid ml-1" style="width: 65%;" alt="">
            </a>
          </div>
          <div class="clearfix"></div>


          <br />

          <!-- sidebar menu -->
          <?php $this->load->view('templates/sidebar') ?>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <div class="profile clearfix">
              <div class="profile_pic">
              </div>
              <div class="profile_info">
                <span>PTA Maluku Utara</span>
                <h2>Pengadilan Agama Ternate</h2>
              </div>
            </div>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu pt-3 pb-2" style="min-height: 50px;">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <div class="col-md-6">
            <h2><?php echo $settings['NamaPT'] ?></h2>
            <h4><?php echo $settings['NamaPN'] ?></h4>
          </div>
          <nav class="nav navbar-nav">
            <ul class=" navbar-right">
              <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                  Welcome, <span class="text-danger font-weight-bold">Administrator</span>
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="javascript:;"> Profile</a>
                  <a class="dropdown-item" href="javascript:;">
                    <span class="badge bg-red pull-right">50%</span>
                    <span>Settings</span>
                  </a>
                  <a class="dropdown-item" href="javascript:;">Help</a>
                  <a class="dropdown-item" href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                </div>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->

      <?php $this->load->view($contents) ?>

      <!-- /page content -->

      <?php $this->load->view('templates/footer') ?>

</body>

</html>
<?php $this->load->view('templates/header') ?>

<body class="nav-md footer_fixed">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col menu_fixed">
        <div class="left_col scroll-view">
          <div class="navbar nav_title mt-2 mb-4" style="border: 0;">
            <a href="<?php echo base_url() ?>dashboard" class="site_title">
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
          <!-- <div class="sidebar-footer hidden-small">
            <div class="profile clearfix">
              <div class="profile_pic">
              </div>
              <div class="profile_info">
                <span>PTA Maluku Utara</span>
                <h2>Pengadilan Agama Ternate</h2>
              </div>
            </div>
          </div> -->
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav sticky-top">
        <div class="nav_menu py-1" style="min-height: 40px;">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <div class="col-md-7 d-none d-md-block">
            <h2 id="nama_PTA"><?php echo $settings['NamaPT'] ?></h2>
            <h4 id="nama_PA"><?php echo $settings['NamaPN'] ?></h4>
          </div>
          <nav class="nav navbar-nav">
            <ul class="navbar-right pl-2">
              <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                  <img class="user-avatar rounded-circle" src="<?php echo base_url() ?>resources/images/avatar.png" alt="">
                  <span class="text-danger font-weight-bold"><?php echo $this->session->userdata('fullname') ?></span>
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="javascript:;"> Profile</a>
                  <a class="dropdown-item" id="logout" href="<?php echo base_url() . 'masuk/logout' ?>"><i class="fa fa-sign-out text-danger pull-right"></i> Log Out</a>
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
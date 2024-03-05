<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3></h3>
    <ul class="nav side-menu">
      <li><a href="<?php echo site_url() ?>dashboard"><i class="fa fa-home"></i> Dashboard </span></a>
      </li>

      <?php if ($menu['mn_pagu']) { ?>
        <li class=""><a><i class="fa fa-table"></i>Pagu Anggaran DIPA<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu" style="display: none;">
            <li class="sub_menu"><a href="<?php echo site_url() ?>LIPA_14/pagu_14">Pagu Sidkel (LIPA 14)</a>
            </li>
            <li class="sub_menu"><a href="<?php echo site_url() ?>LIPA_15/pagu_15">Pagu Prodeo (LIPA 15)</a>
            </li>
            <li class="sub_menu"><a href="<?php echo site_url() ?>LIPA_16/pagu_16">Pagu Posbakum (LIPA 16)</a>
            </li>
          </ul>
        </li>
      <?php } ?>
      <?php if ($menu['mn_input']) { ?>
        <li><a><i class="fa fa-edit"></i> Input Laporan Manual <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <!-- <li><a href="form_advanced.html">Laporan Keuangan Perkara Konsignasi (LIPA.7C)</a></li> -->
            <!-- <li><a href="<?php echo site_url() ?>input_iwadl">Laporan Pertanggungjawaban Uang Iwadl (LIPA.11) </a></li> -->
            <li><a href="<?php echo site_url() ?>LIPA_14/sidkel">Laporan Pelaksanaan Sidang Keliling (LIPA.14)</a></li>
            <li><a href="<?php echo site_url() ?>LIPA_15/prodeo">Laporan Pelaksanaan Prodeo (LIPA.15)</a></li>
            <li><a href="<?php echo site_url() ?>LIPA_16/posbakum">Laporan Pelaksanaan Posbakum (LIPA.16)</a></li>
            <li><a href="<?php echo site_url() ?>LIPA_24/elitigasi">Laporan Pelaksanaan Elitigasi (LIPA.24)</a></li>
          </ul>
        </li>
      <?php } ?>
      <?php if ($menu['mn_laporan']) { ?>
        <li><a><i class="fa fa-desktop"></i> Laporan <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="<?php echo site_url() ?>laporan_perkara">Laporan Perkara</a></li>
            <li><a href="<?php echo site_url() ?>laporan_penyerahan">Laporan Produk Pengadilan</a></li>
          </ul>
        </li>
      <?php } ?>
      <?php if ($menu['mn_monitoring']) { ?>
        <li><a><i class="fa fa-book"></i> Monitoring Perkara <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="<?php echo site_url() ?>monitoring_lama_perkara">Monitoring Lama Perkara</a></li>
          </ul>
        </li>
      <?php } ?>
      <?php if ($menu['mn_saldo']) { ?>
        <li><a href="<?php echo site_url() ?>LIPA_7/saldo_awal"><i class="fa fa-money"></i> Saldo Awal</span></a>
          <!-- TODO-Tambah menu untuk menyimpan data saldo bank dan cash -->
        </li>
      <?php } ?>
      <?php if ($menu['mn_other']) { ?>
        <li><a><i class="fa fa-globe"></i>Lain-lain<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="<?php echo site_url() ?>alamat">Input Alamat SIPP420</a></li>
          </ul>
        </li>
      <?php } ?>
    </ul>
  </div>

</div>
<div class="right_col" role="main">
  <h2 class="mb-4">Penanganan Perkara Tingkat Pertama Tahun <?php echo $dashboard->tahun ?></h2>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-xl-3">
        <div class="card bg-c-blue order-card">
          <div class="card-block">
            <h6 class="m-b-20">Rasio Penanganan Perkara</h6>
            <h2 class="text-right"><i class="fa fa-pie-chart f-left"></i><span class="persen"><?php echo $dashboard->kinerjaPN ?>%</span></h2>
            <p class="m-b-0">Masuk Tahun ini<span class="f-right"><?php echo $dashboard->masuk ?></span></p>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-xl-3">
        <div class="card bg-c-green order-card">
          <div class="card-block">
            <h6 class="m-b-20">Belum Minutasi</h6>
            <h2 class="text-right"><i class="fa fa-minus-square f-left"></i><span class="persen"><?php echo $dashboard->belumminutasi ?></span></h2>
            <p class="m-b-0">Minutasi Tahun Ini<span class="f-right"><?php echo $dashboard->minutasi ?></span></p>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-xl-3">
        <div class="card bg-c-pink order-card">
          <div class="card-block">
            <h6 class="m-b-20">Sisa Perkara</h6>
            <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span class="persen"><?php echo $dashboard->sisaperkara ?></span></h2>
            <p class="m-b-0">Putus Tahun Ini<span class="f-right"><?php echo $dashboard->putus ?></span></p>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-xl-3">
        <div class="card bg-c-yellow order-card">
          <div class="card-block">
            <h6 class="m-b-20">Rasio Perkara E-Court</h6>
            <h2 class="text-right"><i class="fa fa-globe f-left"></i><span class="persen"><?php echo $dashboard->rasio_ecourt ?>%</span></h2>
            <p class="m-b-0">E-Court Diterima Tahun Ini<span class="f-right"><?php echo $dashboard->ecourt ?></span></p>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>

<style>
  .order-card {
    color: #fff;
  }

  .bg-c-blue {
    background: #0089CB;
  }

  .bg-c-green {
    background: #70AA51;
  }

  .bg-c-yellow {
    background: #DEB887;
  }

  .bg-c-pink {
    background: #D74642;
  }


  .card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
  }

  .card .card-block {
    padding: 25px;
  }

  .order-card i {
    font-size: 26px;
  }

  .f-left {
    float: left;
  }

  .f-right {
    float: right;
  }

  .persen {
    font-size: 2rem;
    font-weight: 600;
  }
</style>
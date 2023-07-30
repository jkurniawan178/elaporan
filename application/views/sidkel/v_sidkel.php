<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Laporan Pelaksanaan Sidang Keliling (LIPA 14)</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <!-- Alert Atau pesan sukses -->
                <?php if ($this->session->flashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade in show mt-2" role="alert">
                        <?php echo $this->session->flashdata('success') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade in show mt-2" role="alert">
                        <?php echo $this->session->flashdata('error') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <div class="x_panel">
                    <div class="x_title">
                        <div class="item form-group">
                            <label class="col-form-label" for="tahun">
                                <h6>Filter :</h6>
                            </label>
                            <div style="min-width: 5rem;" class="ml-2">
                                <select class="form-control" name="tahun" id="tahun" style="padding:8px 0;">
                                    <?php $thn1 = date("Y");
                                    $thn2 = 2015;
                                    for ($i = $thn1; $i >= $thn2; $i = $i - 1) {  ?>
                                        <option value="<?php echo $i; ?>" <?php if (@$tahun == $i) {
                                                                                echo "selected";
                                                                            } ?>><?php echo $i; ?></option>';
                                    <?php }
                                    ?>
                                </select>
                            </div>

                            <div class="ml-2">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-modal">
                                    <i class="fa fa-plus"></i>
                                    Tambah
                                </button>
                            </div>

                            <div class="ml-auto">
                                <a href="<?php echo site_url() ?>LIPA_14/pagu_14" type="button" class="btn btn-danger">
                                    Setting Pagu Awal
                                </a>
                                <a href="<?php echo site_url() ?>laporan_perkara" type="button" class="btn btn-outline-secondary">
                                    <i class="fa fa-print"></i>
                                    Cetak Laporan
                                </a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <table id="table-sidkel" class=" text-center table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="align-middle" scope="col">No</th>
                                    <th class="align-middle" scope="col">Periode</th>
                                    <th class="align-middle" scope="col">Pagu Awal</th>
                                    <th class="align-middle" scope="col">Pagu Revisi</th>
                                    <th class="align-middle" scope="col">Realisasi s/d Bulan Lalu</th>
                                    <th class="align-middle" scope="col">Realisasi Bulan Ini</th>
                                    <th class="align-middle" scope="col">Jumlah</th>
                                    <th class="align-middle" scope="col">Sisa</th>
                                    <th class="align-middle" scope="col">Jumlah Kegiatan</th>
                                    <th class="align-middle" scope="col">Jumlah Perkara</th>
                                    <th class="align-middle" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($sidkel as $value) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= pilihbulan($value->bulan) . ' ' . $value->tahun ?></td>
                                        <td><?= number_format($value->pagu_awal, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->pagu_revisi, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->realisasi_sampai_bulan_lalu, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->realisasi, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->jumlah_realisasi, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->saldo, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->jml_kegiatan, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->jml_perkara, 0, ',', '.') ?></td>
                                        <td>
                                            <!-- <a href="javascript:void(0)" type="button" class="btn btn-primary btn-icon-split btn-sm button-update">
                                                            <span class="icon text-white-50">
                                                                <i class="fa fa-edit"></i>
                                                            </span>
                                                            <span class="text">Edit</span>
                                                        </a> -->
                                            <a href="javascript:void(0)" type="button" class="btn btn-danger btn-icon-split btn-sm button-delete" data-id="<?= $value->id ?>" title="Hapus data Sidkel" data-toggle="tooltip">
                                                <span class="icon text-white">
                                                    <i class="fa fa-trash"></i>
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /page content -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url() ?>resources/js/helper.js"></script>
<?php include('add_modal.php') ?>
<?php include('delete_modal.php') ?>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip]').tooltip();

        var table = $('#table-sidkel').DataTable({
            order: [
                [0, 'asc']
            ]
        });

        table.on('click', '.button-delete', function() {
            let id = $(this).data('id');
            const idSidkel = document.getElementById('id');
            idSidkel.value = id;

            $('#delete-modal').modal('show');
        })
    });
</script>
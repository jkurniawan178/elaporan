<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Laporan Pelaksanaan Pembebasan Biaya Perkara (LIPA 15)</h2>
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
                                <!-- TODO Aktifkan Filter ini guys yah -->
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
                                    Tambah Laporan
                                </button>
                            </div>

                            <div class="ml-auto">
                                <a href="<?php echo site_url() ?>LIPA_15/pagu_15" type="button" class="btn btn-danger">
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
                        <table id="table-prodeo" class=" text-center table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="align-middle" scope="col" data-priority="1">No</th>
                                    <th class="align-middle" scope="col" data-priority="1">Periode</th>
                                    <th class="align-middle" scope="col">Pagu Awal</th>
                                    <th class="align-middle" scope="col">Pagu Revisi</th>
                                    <th class="align-middle" scope="col">Realisasi s/d Bulan Lalu</th>
                                    <th class="align-middle" scope="col" data-priority="1">Realisasi Bulan Ini</th>
                                    <th class="align-middle" scope="col">Jumlah</th>
                                    <th class="align-middle" scope="col" data-priority="2">Sisa</th>
                                    <th class="align-middle" scope="col">Target</th>
                                    <th class="align-middle" scope="col">Jumlah Perkara</th>
                                    <th class="align-middle" scope="col">Ket</th>
                                    <th class="align-middle" scope="col" data-priority="1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($prodeo as $value) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= pilihbulan($value->bulan) . ' ' . $value->tahun ?></td>
                                        <td><?= number_format($value->pagu_awal, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->pagu_revisi, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->realisasi_sampai_bulan_lalu, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->realisasi, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->jumlah_realisasi, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->saldo, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->target_perkara, 0, ',', '.') ?></td>
                                        <td><?= number_format($value->jml_perkara, 0, ',', '.') ?></td>
                                        <td><?= $value->keterangan ?></td>
                                        <td>
                                            <a href="javascript:void(0)" type="button" class="btn btn-primary btn-icon-split btn-sm button-update" data-id="<?= $value->id ?>" title="Ubah data Prodeo" data-toggle="tooltip">
                                                <span class="icon text-white">
                                                    <i class="fa fa-edit"></i>
                                                </span>
                                            </a>
                                            <a href="javascript:void(0)" type="button" class="btn btn-danger btn-icon-split btn-sm button-delete" data-id="<?= $value->id ?>" title="Hapus data Prodeo" data-toggle="tooltip">
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
<script src="<?php echo base_url() ?>resources/js/thousandSeparator.js"></script>
<?php include('add_modal.php') ?>
<?php include('delete_modal.php') ?>
<?php include('edit_modal.php') ?>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip]').tooltip();

        var table = $('#table-prodeo').DataTable({
            order: [
                [0, 'asc']
            ],

            responsive: true
        });

        table.on('click', '.button-delete', function() {
            let id = $(this).data('id');
            const idSidkel = document.getElementById('id');
            idSidkel.value = id;

            $('#delete-modal').modal('show');
        });

        table.on('click', '.button-update', function() {
            let id = $(this).data('id');
            $.ajax({
                url: '<?php echo base_url('LIPA_14/sidkel/get_lipa14_id') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'id': id
                },
                success: function(response) {
                    // console.log(response)
                    $('#edit_id').val(response['id'])
                    $('#edit_bulan_modal').val(response['bulan'])
                    $('#edit_tahun_modal').val(response['tahun'])
                    $('#edit_tahun_hidden').val(response['tahun'])
                    $('#edit_bulan_hidden').val(response['bulan'])
                    $('#edit_pagu_awal').val(response['pagu_awal'])
                    $('#edit_sisa_pagu').val(response['saldo'])
                    $('#edit_realisasi').val(response['realisasi'])
                    $('#edit_jml_kegiatan').val(response['jml_kegiatan'])
                    $('#edit_jml_perkara').val(response['jml_perkara'])
                    $('#edit_keterangan').val(response['keterangan'])
                    $('#edit-modal').modal('show');
                }
            })


        });
    });
</script>
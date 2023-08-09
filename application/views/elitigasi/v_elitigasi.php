<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Laporan Pelaksanaan Elitigasi (LIPA 24)</h2>
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
                            <div style="min-width: 10rem;" class="ml-2">
                                <select class="form-control" name="filter" id="filter" style="padding:8px 0;">
                                    <option value="all"> -- Semua -- </option>
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
                                    Tambah Perkara
                                </button>
                            </div>

                            <div class="ml-auto">
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
                        <table id="table-elitigasi" class=" text-center table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="align-middle" scope="col" data-priority="1">No</th>
                                    <th class="align-middle" scope="col" data-priority="1">Nomor Perkara</th>
                                    <th class="align-middle" scope="col">Jenis Perkara</th>
                                    <th class="align-middle" scope="col">Nama Majelis Hakim</th>
                                    <th class="align-middle" scope="col">Nama Panitera</th>
                                    <th class="align-middle" scope="col">Tgl Pendaftaran</th>
                                    <th class="align-middle" scope="col" data-priority="1">Tgl Putus</th>
                                    <th class="align-middle" scope="col">Jenis Putusan</th>
                                    <th class="align-middle" scope="col" data-priority="2">Belum Diputus</th>
                                    <th class="align-middle" scope="col" data-priority="1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($elitigasi as $value) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $value->nomor_perkara ?></td>
                                        <td><?= $value->jenis_perkara_nama ?></td>
                                        <td><?= $value->majelis_hakim_nama ?></td>
                                        <td><?= $value->panitera_pengganti ?></td>
                                        <td><?= tgl_dari_mysql($value->tanggal_pendaftaran) ?></td>
                                        <td><?= tgl_dari_mysql($value->tanggal_putusan) ?></td>
                                        <td><?= $value->jenis_putusan ?></td>
                                        <td><?= $value->belum_diputus ?></td>
                                        <td>
                                            <a href="javascript:void(0)" type="button" class="btn btn-danger btn-icon-split btn-sm button-delete" data-id="<?= $value->id ?>" title="Hapus data Posbakum" data-toggle="tooltip">
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
<?php include('add_modal.php') ?>
<?php include('delete_modal.php') ?>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip]').tooltip();

        var table = $('#table-elitigasi').DataTable({
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

        $('#filter').on('change', function(event) {
            const tahun = $(this).val();
            // console.log(tahun);
            $.ajax({
                url: '<?php echo base_url('LIPA_16/posbakum/filter_lipa16_tahun') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'tahun': tahun
                },
                success: function(response) {
                    console.log(response)
                    // var table = $('#table-sidkel').DataTable();
                    table.clear(); // Clear existing data from the table

                    for (var i = 0; i < response.length; i++) {
                        response[i].button = `<a href="javascript:void(0)" type="button" class="btn btn-danger btn-icon-split 
                                            btn-sm button-delete" data-id="${response[i].id}" title="Hapus data Posbakum" data-toggle="tooltip">
                                                <span class="icon text-white">
                                                    <i class="fa fa-trash"></i>
                                                </span>
                                            </a>`
                        response[i].periode = `${pilihBulan(response[i].bulan)} ${response[i].tahun}`
                        table.row.add([
                            i + 1,
                            response[i].periode,
                            addThousandSeparator(response[i].pagu_awal),
                            addThousandSeparator(response[i].pagu_revisi),
                            addThousandSeparator(response[i].realisasi_sampai_bulan_lalu),
                            addThousandSeparator(response[i].realisasi),
                            addThousandSeparator(response[i].jumlah_realisasi),
                            addThousandSeparator(response[i].saldo),
                            response[i].target_layanan,
                            response[i].jml_layanan,
                            response[i].keterangan,
                            response[i].button
                            // Add other data columns here
                        ])
                    }
                    table.draw();
                },
                error: function(xhr, status, error) {
                    alert('AJAX Error:', error.massage);
                }
            })
        });
    });
</script>
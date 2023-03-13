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
                <div class="x_panel">
                    <div class="x_title">
                        <div class="item form-group">
                            <label class="col-form-label" for="tahun">
                                <h6>Tahun :</h6>
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
                                <a href="<?php echo site_url() ?>pagu_14" type="button" class="btn btn-danger">
                                    Setting Pagu Awal
                                </a>
                                <a href="<?php echo site_url() ?>laporan_perkara" type="button" class="btn btn-outline-secondary">
                                    <i class="fa fa-print"></i>
                                    Cetak
                                </a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <table id="datatable-responsive" class=" text-center table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
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
                                            <!-- <a href="javascript:void(0)" type="button" class="btn btn-danger btn-icon-split btn-sm button-delete" data-id="<%= jabatan[i].id %>">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                            <span class="text">Hapus</span>
                                                        </a> -->
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-info" id="spinner" style="width: 5rem; height: 5rem; display:none;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('add_modal.php') ?>
</div>
<!-- /page content -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#btn_reset').on('click', function() {
            $('#form_hide').hide();
            $('#btn_simpan').prop('disabled', true);
            $('#btn_cek').show();
            $('#tahun_modal').prop('disabled', false);
            $('#bulan_modal').prop('disabled', false);
            $('#pagu_awal').val('');
        })
        // set the initial value of hidden input field
        var selected_month = $('#bulan_modal').find(':selected').val();
        $('#bulan_hidden').val(selected_month);

        var selected_year = $('#tahun_modal').find(':selected').val();
        $('#tahun_hidden').val(selected_year);

        // Set the value of the hidden input field when the selected option changes
        $('#bulan_modal').on('change', function() {
            var selected_option = $(this).find(':selected').val();
            $('#bulan_hidden').val(selected_option);
        });

        $('#tahun_modal').on('change', function() {
            var selected_option = $(this).find(':selected').val();
            $('#tahun_hidden').val(selected_option);
        });

        $('#btn_cek').on('click', function() {
            var tahun = $('#tahun_modal').val();
            var bulan = $('#bulan_modal').val();
            // $('#panel-verifikasi').hide();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/sidkel/cek_pagu') ?>",
                dataType: "JSON",
                data: {
                    tahun: tahun,
                    bulan,
                    bulan
                },
                beforeSend: function() {
                    // $('#spinner').show();
                },
                success: function(data) {
                    if (data.kode == "200") {
                        $('#form_hide').show();
                        $('#btn_simpan').prop('disabled', false);
                        $('#btn_cek').hide();
                        $('#tahun_modal').prop('disabled', true);
                        $('#bulan_modal').prop('disabled', true);
                        $('#pagu_awal').val(data.data);
                    } else if (data.kode == "201") {
                        //create something here
                        alert(data.data)
                    }
                },
                complete: function(xhr, status) {
                    // $('#spinner').hide();
                }
            });
            return false;
        });
    })
</script>
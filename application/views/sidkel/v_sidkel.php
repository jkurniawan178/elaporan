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
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#add-modal">
                                    Setting Pagu Awal
                                </button>
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

<!-- <script type="text/javascript">
    $(document).ready(function() {
        const formatDate = 'DD/MM/YYYY'
        $("#date_lapor").daterangepicker({
                singleDatePicker: true,
                singleClasses: "picker_1",
                locale: {
                    format: formatDate,
                }
            },
            function(start, end, label) {
                // console.log(start.toISOString(), end.toISOString());
            }
        );
        $('#btn_generate').on('click', function() {
            var jenis_laporan = $('#jenis_laporan').val();
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            var tanggal_laporan = $('#date_lapor').val();
            $('#btn-download-laporan').attr("href", '')
            $('#panel-verifikasi').hide();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/laporan_perkara/get_lipa') ?>",
                dataType: "JSON",
                data: {
                    jenis_laporan: jenis_laporan,
                    bulan: bulan,
                    tahun: tahun,
                    tanggal_laporan: tanggal_laporan
                },
                beforeSend: function() {
                    $('#spinner').show();
                },
                success: function(data) {
                    if (data.kode == "200") {
                        var jenis = jenis_laporan.replace("_", " ").toUpperCase();
                        $('#panel-verifikasi').show();
                        $('#btn-download-laporan').attr("href", data.data)
                        $('#preview_laporan').html('Preview Laporan ' + jenis + '<small>Periksa Laporan Terlebih Dahulu Sebelum anda verifikasi</small>');
                    } else if (data.kode == "201" || data.kode == '202') {
                        //create something here
                        alert(data.data)
                    }
                },
                error: function(xhr, status, error) {
                    //do something here
                },
                complete: function(xhr, status) {
                    $('#spinner').hide();
                }
            });
            return false;
        });
    })
</script> -->
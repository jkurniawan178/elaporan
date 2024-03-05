<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Monitoring Lama Proses Perkara</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><small>Monitoring Lama Proses Perkara Berdasarkan Hari Sidang</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="form-laporan" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="form-group row">
                                <label for="date_lapor" class="col-form-label col-md-3 col-sm-3 d-flex justify-content-md-end">Tanggal Sidang<span class="required text-danger">*</span></label>
                                <fieldset class="col-md-3 col-sm-3">
                                    <div class="control-group">
                                        <div class="controls">
                                            <div class="xdisplay_inputx form-group row has-feedback">
                                                <input type="text" class="form-control has-feedback-left" id="date_lapor" placeholder="Tanggal laporan">
                                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <!-- <div class="ln_solid"></div> -->
                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 offset-md-3">
                                    <button id="btn_tampil" type="button" class="btn btn-success">Tampilkan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-info" id="spinner" style="width: 5rem; height: 5rem; display:none;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="x_panel" id="panel-verifikasi" style="display: none;">
                    <div class=" x_title">
                        <h2 id="preview_laporan">Laporan <small>Hasil Monitoring Lama Proses Perkara</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="form-verifikasi" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="item form-group">
                                <a href="#" id="btn-download-laporan" class="btn btn-primary pull-right btn-sm"><i class="fa fa-download"></i> Download Laporan</a>
                                <!-- <button type="button" class="btn btn-info btn-sm" style="display: none;">Verifikasi Laporan</button> -->
                            </div>
                        </form>
                        <div class="ln_solid my-1"></div>

                        <h2 class="text-center" id="judul_laporan"></h2>
                        <h2 class="text-center" id="nama_pengadilan"></h2>
                        <h2 class="text-center" id="periode_laporan"></h2>

                        <div id="table-content"></div>
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
<script src="<?php echo base_url() ?>resources/js/thousandSeparator.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        //datetime picker
        const format = 'DD/MM/YYYY'
        $("#date_lapor").daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: format,
                }
            },
            function(start, end, label) {
                // console.log(start.toISOString(), end.toISOString());
            }
        );

        function formatTanggal(date) {
            const tanggalMoment = moment(date, 'DD/MM/YYYY');
            // Mendapatkan hari dalam bahasa Indonesia
            const hari = tanggalMoment.locale('id').format('dddd').toUpperCase();

            // Mendapatkan bulan dalam bahasa Indonesia
            const bulan = tanggalMoment.locale('id').format('MMMM').toUpperCase();

            // Menggabungkan semuanya menjadi format yang diinginkan
            const hasil = `${hari}, ${tanggalMoment.format('DD')} ${bulan} ${tanggalMoment.format('YYYY')}`;
            return hasil;
        }

        $('#btn_tampil').on('click', function() {
            const jenis_monitor = 'monitoring_lama_perkara';
            // const bulan = $('#bulan').val();
            // const tahun = $('#tahun').val();
            const tanggal_monitor = $('#date_lapor').val();
            const nama_PA = $('#nama_PA').text();
            $('#btn-download-laporan').attr("href", '')
            $('#panel-verifikasi').hide();


            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/monitoring_lama_perkara/get_lama_perkara') ?>",
                dataType: "JSON",
                data: {
                    jenis_monitor: jenis_monitor,
                    tanggal_monitor: tanggal_monitor,
                    tanggal_laporan: formatTanggal(tanggal_monitor).toUpperCase(),
                },
                beforeSend: function() {
                    $('#spinner').show();
                },
                success: function(response) {
                    if (response.kode == "200") {
                        var jenis = jenis_monitor.replace(/_/g, " ").toUpperCase();
                        $('#panel-verifikasi').show();
                        $('#btn-download-laporan').attr("href", response.link)
                        // $('#preview_laporan').html('Preview Laporan ' + jenis + ' Periode ' + pilihBulan(bulan) + ' ' + tahun + '<small>Periksa Laporan Terlebih Dahulu Sebelum anda verifikasi</small>');

                        //table view
                        $('#judul_laporan').text(jenis);
                        $('#nama_pengadilan').text(`PADA ${nama_PA.toUpperCase()}`);
                        $('#periode_laporan').text(`SIDANG HARI ${formatTanggal(tanggal_monitor)}`);
                        $('#table-content').html(response.table);
                        generateTableRows(response.data);
                    } else if (response.kode == "201" || response.kode == '202') {
                        iziToast.error({
                            title: 'Error!',
                            message: response.data,
                            position: 'topCenter'
                        });
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
</script>
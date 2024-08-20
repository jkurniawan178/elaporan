<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Monitoring Persidangan by Panitera Pengganti</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><small>Monitoring Persidangan Berdasarkan Panitera Pengganti dan Hari Sidang</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="form-laporan" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3 d-flex justify-content-md-end" for="panitera_sidang">Panitera Sidang <span class="required text-danger">*</span></label>
                                <div class="col-md-5 col-sm-12">
                                    <select class="form-control" id="panitera_sidang">
                                        <option value="-" disabled selected>====== Silahkan Pilih Panitera Pengganti ======</option>
                                        <?php foreach ($pp_list as $value) { ?>
                                            <option value="<?= $value->id ?>"><?= $value->nama_gelar ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="date_lapor" class="col-form-label col-md-3 col-sm-3 d-flex justify-content-md-end">Periode Sidang<span class="required text-danger">*</span></label>
                                <fieldset class="col-md-5 col-sm-12">
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
                        <h2 id="preview_laporan">Laporan <small>Hasil Monitoring Persidangan by Panitera Pengganti</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <h2 class="text-center" id="judul_laporan"></h2>
                        <h2 class="text-center" id="nama_pengadilan"></h2>
                        <div class="row ml-2">
                            <label class="col-form-label d-flex justify-content-md-start">Panitera Pengganti :</label>
                            <label class="col-form-label col-md-5 col-sm-5" id="nama_pp"></label>
                        </div>
                        <div class="row ml-2 mb-3">
                            <label class="col-form-label d-flex justify-content-md-start">Periode Persidangan :</label>
                            <label class="col-form-label col-md-5 col-sm-5" id="period_laporan"></label>
                        </div>
                    </div>

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
        let startDate, endDate
        $("#date_lapor").daterangepicker({
                singleDatePicker: false,
                locale: {
                    format: format,
                }
            },
            function(start, end, label) {
                startDate = start.format("DD/MM/YYYY");
                endDate = end.format("DD/MM/YYYY");
            }
        );

        $('#btn_tampil').on('click', function() {
            const jenis_monitor = 'monitoring_sidang_pp';
            const ppid = $('#panitera_sidang').find(':selected').val();
            const ppnama = $('#panitera_sidang').find(':selected').text();
            const nama_PA = $('#nama_PA').text();
            $('#panel-verifikasi').hide();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/monitoring_sidang_pp/get_sidang_pp') ?>",
                dataType: "JSON",
                data: {
                    jenis_monitor: jenis_monitor,
                    tanggal_start: startDate,
                    tanggal_end: endDate,
                    panitera_id: ppid,
                    // tanggal_laporan: formatTanggal(tanggal_monitor).toUpperCase(),
                },
                beforeSend: function() {
                    $('#spinner').show();
                },
                success: function(response) {
                    if (response.kode == "200") {
                        var jenis = jenis_monitor.replace(/_/g, " ").toUpperCase();
                        $('#panel-verifikasi').show();

                        //table view
                        $('#judul_laporan').text(jenis);
                        $('#nama_pengadilan').text(`PADA ${nama_PA.toUpperCase()}`);
                        $('#nama_pp').text(ppnama);
                        $('#period_laporan').text(startDate + ' s/d ' + endDate);
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
        // $('#btn_tampil').on('click', function() {
        //     console.log('tanggal mulai ' + startDate + ' tanggal akhir ' + endDate + ' pp id ' + $('#panitera_sidang').find(':selected').val())
        // })
    })
</script>
<!-- Modal -->
<div class="modal fade" id="add-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Laporan Pelaksanaan Sidang Keliling</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_form" action="<?php echo base_url() . 'LIPA_14/sidkel/tambah_aksi' ?>" method="post" class="form-horizontal form-label-left needs-validation" novalidate>
                <div class="modal-body">
                    <div class="item form-group">
                        <label id="periode_label" class="col-form-label col-md-2 col-sm-2 label-align" for="bulan_modal">Periode <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-10 col-sm-10">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 ">
                                    <select class="form-control" name="bulan_modal" id="bulan_modal" style="padding:8px 0;">
                                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                                            <option value="<?php if (strlen($i) == 2) {
                                                                echo $i;
                                                            } else {
                                                                echo '0' . $i;
                                                            } ?>" <?php if (@$bulan == $i) {
                                                                        echo "selected";
                                                                    } ?>><?php echo $nm_bulan[$i]; ?></option><?php    } ?>

                                    </select>
                                    <div class="invalid-feedback">
                                        Please enter a valid period.
                                    </div>
                                    <input type="hidden" name="bulan_hidden" id="bulan_hidden" value="">
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <select class="form-control" name="tahun_modal" id="tahun_modal" style="padding:8px 0;">
                                        <?php $thn1 = date("Y");
                                        $thn2 = 2015;
                                        for ($i = $thn1; $i >= $thn2; $i = $i - 1) {  ?>
                                            <option value="<?php echo $i; ?>" <?php if (@$tahun == $i) {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $i; ?></option>';
                                        <?php }
                                        ?>
                                    </select>
                                    <input type="hidden" name="tahun_hidden" id="tahun_hidden" value="">
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <button type="button" id="btn_cek" class="btn btn-info">Cek</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="form_hide" style="display: none;">
                        <div class="item form-group">
                            <label for="pagu_awal" class="col-form-label col-md-4 col-sm-4 label-align">Pagu Awal<span class="required text-danger">*</span></label>
                            <div class="col-md-8 col-md-8 input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="text" id="pagu_awal" name="pagu_awal" disabled class="form-control">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="sisa_pagu" class="col-form-label col-md-4 col-sm-4 label-align">Sisa Pagu<span class="required text-danger">*</span></label>
                            <div class="col-md-8 col-md-8 input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="text" id="sisa_pagu" name="sisa_pagu" disabled class="form-control">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="realisasi" class="col-form-label col-md-4 col-sm-4 label-align">Realisasi Bulan Ini<span class="required text-danger">*</span></label>
                            <div class="col-md-8 col-md-8 input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="text" id="realisasi" name="realisasi" required="required" class="form-control">
                                <div class="invalid-feedback">
                                    Silahkan input data Realisasi Bulan ini dengan Benar
                                </div>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="jml_kegiatan" class="col-form-label col-md-4 col-sm-4 label-align">Jumlah Kegiatan<span class="required text-danger">*</span></label>
                            <div class="col-md-8 col-md-8">
                                <input type="number" id="jml_kegiatan" name="jml_kegiatan" required="required" class="form-control">
                                <div class="invalid-feedback">
                                    Silahkan input data Jumlah Kegiatan ini yang Benar
                                </div>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="jml_perkara" class="col-form-label col-md-4 col-sm-4 label-align">Jumlah Perkara<span class="required text-danger">*</span></label>
                            <div class="col-md-8 col-md-8">
                                <input type="number" id="jml_perkara" name="jml_perkara" required="required" class="form-control">
                                <div class="invalid-feedback">
                                    Silahkan input Jumlah Perkara yang Benar
                                </div>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="keterangan" class="col-form-label col-md-4 col-sm-4 label-align">Keterangan</label>
                            <div class="col-md-8 col-md-8">
                                <input type="text" id="keterangan" name="keterangan" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" id="btn_simpan" class="btn btn-primary" disabled>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        //---------------------------Add Modal Handle script ---------------------------------
        //---------------------------button Reset (Add Modal) Handle script ------------------
        $('#btn_reset').on('click', function() {
            $('#form_hide').hide();
            $('#btn_simpan').prop('disabled', true);
            $('#btn_cek').show();
            $('#tahun_modal').prop('disabled', false);
            $('#bulan_modal').prop('disabled', false);
            $('#pagu_awal').val('');
            $('#periode_label').removeClass('col-md-4').removeClass('col-sm-4').addClass('col-md-2').addClass('col-sm-2');
        })

        //---------------------------hidden input field (Add Modal) Handle script -------------
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

        //---------------------------button Cek (Add Modal) Handle script ------------------
        $('#btn_cek').on('click', function() {
            var tahun = $('#tahun_modal').val();
            var bulan = $('#bulan_modal').val();
            // $('#panel-verifikasi').hide();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('LIPA_14/sidkel/cek_pagu') ?>",
                dataType: "JSON",
                data: {
                    tahun: tahun,
                    bulan: bulan
                },
                beforeSend: function() {
                    // $('#spinner').show();
                },
                success: function(data) {
                    if (data.kode == "200") {
                        $('#bulan_modal').removeClass('is-invalid').addClass('is-valid');
                        $('#periode_label').removeClass('col-md-2').removeClass('col-sm-2').addClass('col-md-4').addClass('col-sm-4');
                        $('#form_hide').show();
                        $('#btn_simpan').prop('disabled', false);
                        $('#btn_cek').hide();
                        $('#tahun_modal').prop('disabled', true);
                        $('#bulan_modal').prop('disabled', true);
                        $('#pagu_awal').val(data.pagu_awal);
                        $('#sisa_pagu').val(data.saldo);
                    } else if (data.kode == "201") {
                        //create something here
                        // alert(data.data)
                        $('#bulan_modal').removeClass('is-valid').addClass('is-invalid');
                        $('#bulan_modal').siblings('.invalid-feedback').text(data.data);
                    }
                },
                complete: function(xhr, status) {
                    // $('#spinner').hide();
                }
            });
            return false;
        });
    })

    //---------------------------Thousand separator (Add Modal) field script-------------
    const realisasi = document.getElementById("realisasi");
    const saldo = document.getElementById("sisa_pagu");
    realisasi.addEventListener("keyup", function(event) {
        formatInputValue(event.target);
    });

    //function to remove thousand separator before send it to controller
    document.getElementById("add_form").addEventListener("submit", function(event) {
        let inputRealisasi = removeThousandSeparator(realisasi.value);
        let numRealisasi = parseFloat(inputRealisasi);
        if (!isNaN(numRealisasi)) {
            realisasi.value = numRealisasi;
        }
    })
</script>
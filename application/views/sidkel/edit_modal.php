<!-- Modal -->
<div class="modal fade" id="edit-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ubah Laporan Pelaksanaan Sidang Keliling</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_form" action="<?php echo base_url() . 'LIPA_14/sidkel/ubah_aksi' ?>" method="post" class="form-horizontal form-label-left needs-validation" novalidate>
                <div class="modal-body">
                    <div class="item form-group">
                        <label id="periode_label" class="col-form-label col-md-4 col-sm-4 label-align" for="bulan_modal">Periode <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8">
                            <div class="row">
                                <div class="col-md-5 col-sm-5 ">
                                    <select class="form-control" name="edit_bulan_modal" id="bulan_modal" style="padding:8px 0;" disabled>
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
                                    <input type="hidden" name="edit_bulan_hidden" id="edit_bulan_hidden" value="">
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <select class="form-control" name="edit_tahun_modal" id="edit_tahun_modal" style="padding:8px 0;" disabled>
                                        <?php $thn1 = date("Y");
                                        $thn2 = 2015;
                                        for ($i = $thn1; $i >= $thn2; $i = $i - 1) {  ?>
                                            <option value="<?php echo $i; ?>" <?php if (@$tahun == $i) {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $i; ?></option>';
                                        <?php }
                                        ?>
                                    </select>
                                    <input type="hidden" name="edit_tahun_hidden" id="edit_tahun_hidden" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="pagu_awal" class="col-form-label col-md-4 col-sm-4 label-align">Pagu Awal<span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" id="edit_pagu_awal" name="edit_pagu_awal" disabled class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="sisa_pagu" class="col-form-label col-md-4 col-sm-4 label-align">Sisa Pagu<span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" id="edit_sisa_pagu" name="edit_sisa_pagu" disabled class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="realisasi" class="col-form-label col-md-4 col-sm-4 label-align">Realisasi Bulan Ini<span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" id="edit_realisasi" name="edit_realisasi" required="required" class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Realisasi Bulan ini dengan Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="jml_kegiatan" class="col-form-label col-md-4 col-sm-4 label-align">Jumlah Kegiatan<span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8">
                            <input type="number" id="edit_jml_kegiatan" name="edit_jml_kegiatan" required="required" class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Jumlah Kegiatan ini yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="jml_perkara" class="col-form-label col-md-4 col-sm-4 label-align">Jumlah Perkara<span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8">
                            <input type="number" id="edit_jml_perkara" name="edit_jml_perkara" required="required" class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input Jumlah Perkara yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="keterangan" class="col-form-label col-md-4 col-sm-4 label-align">Keterangan</label>
                        <div class="col-md-8 col-md-8">
                            <input type="text" id="edit_keterangan" name="edit_keterangan" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <button type="button" id="btn_close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_ubah" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        //---------------------------hidden input field (Edit Modal) Handle script -------------
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
    })

    //---------------------------Thousand separator (Add Modal) field script-------------
    const edit_realisasi = document.getElementById("edit_realisasi");
    edit_realisasi.addEventListener("keyup", function(event) {
        formatInputValue(event.target);
    });

    //function to remove thousand separator before send it to controller
    document.getElementById("add_form").addEventListener("submit", function(event) {
        let inputRealisasi = removeThousandSeparator(edit_realisasi.value);
        let numRealisasi = parseFloat(inputRealisasi);
        if (!isNaN(numRealisasi)) {
            edit_realisasi.value = numRealisasi;
        }
    })
</script>
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
            <form action="<?php echo base_url() . 'sidkel/tambah_aksi' ?>" method="post" class="form-horizontal form-label-left">
                <div class="modal-body">
                    <div class="item form-group">
                        <label class="col-form-label col-md-4 col-sm-4 label-align" for="last-name">Periode <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 ">
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
                            <label for="middle-name" class="col-form-label col-md-4 col-sm-4 label-align">Pagu Awal</label>
                            <div class="col-md-8 col-md-8 input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="number" id="pagu_awal" name="pagu_awal" disabled class="form-control">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="middle-name" class="col-form-label col-md-4 col-sm-4 label-align">Realisasi Bulan Ini</label>
                            <div class="col-md-8 col-md-8 input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="number" id="realisasi" name="realisasi" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="middle-name" class="col-form-label col-md-4 col-sm-4 label-align">Jumlah Kegiatan</label>
                            <div class="col-md-8 col-md-8">
                                <input type="number" id="jml_kegiatan" name="jml_kegiatan" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="middle-name" class="col-form-label col-md-4 col-sm-4 label-align">Jumlah Perkara</label>
                            <div class="col-md-8 col-md-8">
                                <input type="number" id="jml_perkara" name="jml_perkara" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="middle-name" class="col-form-label col-md-4 col-sm-4 label-align">Keterangan</label>
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
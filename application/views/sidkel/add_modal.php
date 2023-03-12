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
            <form action="" class="form-horizontal form-label-left">
                <div class="modal-body">
                    <div class="item form-group">
                        <label class="col-form-label col-md-4 col-sm-4 label-align" for="last-name">Periode <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-md-9">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 ">
                                    <select class="form-control" name="bulan" id="bulan" style="padding:8px 0;">
                                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                                            <option value="<?php if (strlen($i) == 2) {
                                                                echo $i;
                                                            } else {
                                                                echo '0' . $i;
                                                            } ?>" <?php if (@$bulan == $i) {
                                                                        echo "selected";
                                                                    } ?>><?php echo $nm_bulan[$i]; ?></option><?php    } ?>

                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-3">
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
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="middle-name" class="col-form-label col-md-4 col-sm-4 label-align">Pagu Awal</label>
                        <div class="col-md-8 col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="number" id="first-name" disabled class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="middle-name" class="col-form-label col-md-4 col-sm-4 label-align">Realisasi Bulan Ini</label>
                        <div class="col-md-8 col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="number" id="first-name" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="middle-name" class="col-form-label col-md-4 col-sm-4 label-align">Jumlah Kegiatan</label>
                        <div class="col-md-8 col-md-8">
                            <input type="number" id="first-name" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="middle-name" class="col-form-label col-md-4 col-sm-4 label-align">Jumlah Perkara</label>
                        <div class="col-md-8 col-md-8">
                            <input type="number" id="first-name" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="middle-name" class="col-form-label col-md-4 col-sm-4 label-align">Keterangan</label>
                        <div class="col-md-8 col-md-8">
                            <input type="text" id="first-name" required="required" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
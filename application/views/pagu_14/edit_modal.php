<!-- Modal -->
<div class="modal fade" id="edit-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Revisi Pagu Awal - Pelaksanaan Sidang Diluar Gedung Pengadilan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_form" action="<?php echo base_url() . 'LIPA_14/pagu_14/ubah_aksi'; ?>" method="post" class="form-horizontal form-label-left needs-validation" novalidate>
                <div class="modal-body">
                    <div class="item form-group">
                        <label class="col-form-label col-md-4 col-sm-4 label-align" for="tahun">Tahun Anggaran <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-md-8">
                            <select disabled class="form-control" name="tahun" id="edit_tahun" required style="padding:8px 0;">
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
                    <div class="item form-group">
                        <label for="pagu_awal" class="col-form-label col-md-4 col-sm-4 label-align">Pagu Awal <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" id="edit_pagu_awal" name="pagu_awal" required class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Pagu Awal yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="pagu_revisi" class="col-form-label col-md-4 col-sm-4 label-align">Pagu Revisi</label>
                        <div class="col-md-8 col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" id="edit_pagu_revisi" name="pagu_revisi" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="lokasi" class="col-form-label col-md-4 col-sm-4 label-align">Target Lokasi <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8">
                            <input type="number" id="edit_lokasi" name="lokasi" required class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Target Lokasi yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="kegiatan" class="col-form-label col-md-4 col-sm-4 label-align">Target Kegiatan <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8">
                            <input type="number" id="edit_kegiatan" name="kegiatan" required class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Target Kegiatan yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="perkara" class="col-form-label col-md-4 col-sm-4 label-align">Target Perkara <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8">
                            <input type="number" id="edit_perkara" name="perkara" required class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Target Perkara yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group pt-3">
                        <label class="text-danger">* Isian harus dilengkapi, tidak boleh kosong!</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="edit_id" type="hidden" class="id" name="id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
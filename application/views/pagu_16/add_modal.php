<!-- Modal -->
<div class="modal fade" id="add-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Pagu Awal - Pelaksanaan Posbakum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_form" action="<?php echo base_url() . 'LIPA_16/pagu_16/tambah_aksi'; ?>" method="post" class="form-horizontal form-label-left needs-validation" novalidate>
                <div class="modal-body">
                    <div class="row form-group">
                        <label class="col-form-label col-md-4 d-flex justify-content-md-end" for="tahun">Tahun Anggaran <span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-8">
                            <select class="form-control" name="tahun" id="tahun" required style="padding:8px 0;">
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
                    <div class="row form-group">
                        <label for="pagu_awal" class="col-form-label col-md-4 d-flex justify-content-md-end">Pagu Awal <span class="required text-danger">*</span></label>
                        <div class="col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" id="pagu_awal" name="pagu_awal" required class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Pagu Awal yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="pagu_revisi" class="col-form-label col-md-4 d-flex justify-content-md-end">Pagu Revisi</label>
                        <div class="col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" id="pagu_revisi" name="pagu_revisi" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="layanan" class="col-form-label col-md-4 d-flex justify-content-md-end">Target Layanan <span class="required text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="number" id="layanan" name="layanan" required class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Target Layanan yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group pt-3">
                        <div class="text-danger">* Isian harus dilengkapi, tidak boleh kosong!</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    //--------------------------Script for modal section----------------------------------------
    //--------------------------- Get the input element Modal Tambah --------------------
    const paguAwal = new Cleave('#pagu_awal', {
        numeral: true,
        numeralDecimalMark: ',',
        delimiter: '.',
        numeralPositiveOnly: true,
        numeralThousandsGroupStyle: 'thousand'

    });

    const paguRevisi = new Cleave('#pagu_revisi', {
        numeral: true,
        numeralDecimalMark: ',',
        delimiter: '.',
        numeralPositiveOnly: true,
        numeralThousandsGroupStyle: 'thousand'

    });

    //function to remove thousand separator before send it to controller
    document.getElementById("add_form").addEventListener("submit", function(event) {
        // Get the current input value without dots (thousand separators)
        let inputPaguAwal = paguAwal.getRawValue();
        let inputPaguRevisi = paguRevisi.getRawValue();

        // Convert the value to a number
        let numPaguAwal = parseFloat(inputPaguAwal);
        let numPaguRevisi = parseFloat(inputPaguRevisi);

        // Set the numeric value as the new value of the input field
        if (!isNaN(numPaguAwal)) {
            document.getElementById("pagu_awal").value = numPaguAwal;
        }
        if (!isNaN(numPaguRevisi)) {
            document.getElementById("pagu_revisi").value = numPaguRevisi;
        }

    })
</script>
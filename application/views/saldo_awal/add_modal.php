<!-- Modal -->
<div class="modal fade" id="add-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Saldo Awal Keuangan Perkara - LIPA 07</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_form" action="<?php echo base_url() . 'LIPA_7/saldo_awal/tambah_aksi'; ?>" method="post" class="form-horizontal form-label-left needs-validation" novalidate>
                <div class="modal-body">
                    <div class="item form-group">
                        <label class="col-form-label col-md-4 col-sm-4 label-align" for="tahun">Tahun<span class="required text-danger">*</span>
                        </label>
                        <div class="col-md-8 col-md-8">
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
                    <div class="item form-group">
                        <label for="awal_7a" class="col-form-label col-md-4 col-sm-4 label-align">Saldo Awal LIPA 7.A <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" id="awal_7a" name="awal_7a" required class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Saldo Awal LIPA 7.A yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="awal_7b" class="col-form-label col-md-4 col-sm-4 label-align">Saldo Awal LIPA 7.B <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" id="awal_7b" name="awal_7b" required class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Saldo Awal LIPA 7.B yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="awal_7c" class="col-form-label col-md-4 col-sm-4 label-align">Saldo Awal LIPA 7.C <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" id="awal_7c" name="awal_7c" required class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Saldo Awal LIPA 7.C yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="keterangan" class="col-form-label col-md-4 col-sm-4 label-align">Keterangan</label>
                        <div class="col-md-8 col-md-8">
                            <input type="text" id="keterangan" name="keterangan" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group pt-3">
                        <label class="text-danger">* Isian harus dilengkapi, tidak boleh kosong!</label>
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
    const Awal7A = new Cleave('#awal_7a', {
        numeral: true,
        numeralDecimalMark: ',',
        delimiter: '.',
        numeralPositiveOnly: true,
        numeralThousandsGroupStyle: 'thousand'

    });

    const Awal7B = new Cleave('#awal_7b', {
        numeral: true,
        numeralDecimalMark: ',',
        delimiter: '.',
        numeralPositiveOnly: true,
        numeralThousandsGroupStyle: 'thousand'

    });

    const Awal7C = new Cleave('#awal_7c', {
        numeral: true,
        numeralDecimalMark: ',',
        delimiter: '.',
        numeralPositiveOnly: true,
        numeralThousandsGroupStyle: 'thousand'

    });

    //function to remove thousand separator before send it to controller
    document.getElementById("add_form").addEventListener("submit", function(event) {
        // Get the current input value without dots (thousand separators)
        let inputAwal7A = Awal7A.getRawValue();
        let inputAwal7B = Awal7B.getRawValue();
        let inputAwal7C = Awal7C.getRawValue();

        // Convert the value to a number
        let numAwal7A = parseFloat(inputAwal7A);
        let numAwal7B = parseFloat(inputAwal7B);
        let numAwal7C = parseFloat(inputAwal7C);

        // Set the numeric value as the new value of the input field
        if (!isNaN(numAwal7A)) {
            document.getElementById("awal_7a").value = numAwal7A;
        }
        if (!isNaN(numAwal7B)) {
            document.getElementById("awal_7b").value = numAwal7B;
        }
        if (!isNaN(numAwal7C)) {
            document.getElementById("awal_7c").value = numAwal7C;
        }
    })
</script>
<!-- Modal -->
<div class="modal fade" id="add-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Pagu Awal - Pelaksanaan Sidang Diluar Gedung Pengadilan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url() . 'LIPA_14/pagu_14/tambah_aksi'; ?>" method="post" class="form-horizontal form-label-left needs-validation" novalidate>
                <div class="modal-body">
                    <div class="item form-group">
                        <label class="col-form-label col-md-4 col-sm-4 label-align" for="tahun">Tahun Anggaran <span class="required text-danger">*</span>
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
                        <label for="pagu_awal" class="col-form-label col-md-4 col-sm-4 label-align">Pagu Awal <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8 input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="text" id="pagu_awal" name="pagu_awal" required class="form-control">
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
                            <input type="text" id="pagu_revisi" name="pagu_revisi" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="lokasi" class="col-form-label col-md-4 col-sm-4 label-align">Target Lokasi <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8">
                            <input type="number" id="lokasi" name="lokasi" required class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Target Lokasi yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="kegiatan" class="col-form-label col-md-4 col-sm-4 label-align">Target Kegiatan <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8">
                            <input type="number" id="kegiatan" name="kegiatan" required class="form-control">
                            <div class="invalid-feedback">
                                Silahkan input data Target Kegiatan yang Benar
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="perkara" class="col-form-label col-md-4 col-sm-4 label-align">Target Perkara <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8">
                            <input type="number" id="perkara" name="perkara" required class="form-control">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    //Function that using bootstrap validator
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    //------------------------------------------------------------------------------------------
    //--------------------------function that handle thosand separator--------------------------

    // Function to remove Indonesian thousand separators
    function removeThousandSeparator(formattedNumber) {
        return formattedNumber.replace(/\./g, "");
    }

    // Function to add Indonesian thousand separators
    function addThousandSeparator(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Function to format the input value
    function formatInputValue(inputElement) {
        // Get the current input value without dots
        let inputValue = removeThousandSeparator(inputElement.value);

        // Convert the value to a number (removes leading zeros, etc.)
        let number = parseFloat(inputValue);

        // Check if the value is a valid number
        if (!isNaN(number)) {
            // Format the number with Indonesian thousand separators and display it
            inputElement.value = addThousandSeparator(number);
        }
    }

    // Get the input element
    const paguAwal = document.getElementById("pagu_awal");
    const paguRevisi = document.getElementById("pagu_revisi");

    // Add event listener for keyup event
    paguAwal.addEventListener("keyup", function(event) {
        formatInputValue(event.target);
    });

    paguRevisi.addEventListener("keyup", function(event) {
        formatInputValue(event.target);
    });


    //function to remove thousand separator before send it to controller
    document.querySelector("form").addEventListener("submit", function(event) {
        // Get the current input value without dots (thousand separators)
        let inputPaguAwal = removeThousandSeparator(paguAwal.value);
        let inputPaguRevisi = removeThousandSeparator(paguRevisi.value);

        // Convert the value to a number
        let numPaguAwal = parseFloat(inputPaguAwal);
        let numPaguRevisi = parseFloat(inputPaguRevisi);

        // Set the numeric value as the new value of the input field
        paguAwal.value = numPaguAwal;
        paguRevisi.value = numPaguRevisi;
    })
</script>
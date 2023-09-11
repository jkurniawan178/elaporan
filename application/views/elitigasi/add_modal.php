<!-- Modal -->
<div class="modal fade" id="add-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Perkara E-Litigasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_form" action="<?php echo base_url() . 'LIPA_24/elitigasi/tambah_aksi'; ?>" method="post" class="form-horizontal form-label-left needs-validation" novalidate>
                <div class="modal-body">
                    <div class="row form-group">
                        <label for="nomor_perkara" class="col-form-label col-md-3 col-sm-3 d-flex justify-content-md-end">Nomor Perkara <span class="required text-danger">*</span></label>
                        <div class="col-md-8 col-md-8">
                            <input type="search" id="nomor_perkara" name="nomor_perkara" required class="form-control" placeholder="Cari nomor perkara...">
                            <div class="invalid-feedback">
                                Silahkan input Nomor Perkara yang Benar
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
    $(function() {
        $("#nomor_perkara").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?php echo base_url('LIPA_24/elitigasi/get_suggestions'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        var formattedSuggestions = []; // Array untuk menyimpan opsi yang diformat

                        // Mengonversi data dari server menjadi format yang sesuai
                        for (var i = 0; i < data.length; i++) {
                            formattedSuggestions.push({
                                label: data[i].nomor_perkara, // Menampilkan nomor_perkara dalam opsi
                                value: data[i].nomor_perkara // Nilai yang akan diinput saat dipilih
                            });
                        }

                        response(formattedSuggestions);
                    },
                    error: function(error) {
                        console.log("error", error);
                    }
                });
            },
            minLength: 1,
            select: function(event, ui) {
                // log("Selected: " + ui.item.value + " aka " + ui.item.id);
            }
        });
    });
</script>
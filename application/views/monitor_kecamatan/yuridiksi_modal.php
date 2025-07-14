<!-- Modal -->
<div class="modal fade" id="yuridiksi-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Form Yuridiksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_form" action="<?php echo base_url() . 'monitoring_yuridiksi/tambah_aksi'; ?>" method="post" class="form-horizontal form-label-left needs-validation" novalidate>
                <div class="modal-body">
                    <div class="row form-group">
                        <label for="provinsi" class="col-form-label col-md-2 col-sm-4 d-flex justify-content-md-start">Provinsi <span class="required text-danger">*</span></label>
                        <div class="col-md-10 col-sm-12">
                            <select class="form-control" id="provinsi" name="provinsi" required>
                                <option value="-" disabled selected>====== Silahkan Pilih Provinsi ======</option>
                                <?php foreach ($provinsi as $value) { ?>
                                    <option value="<?= $value->provinsi_kode ?>"><?= $value->provinsi_nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="kabupaten" class="col-form-label col-md-2 col-sm-4 d-flex justify-content-md-start">Kabupaten <span class="required text-danger">*</span></label>
                        <div class="col-md-10 col-sm-12">
                            <select class="form-control" id="kabupaten" name="kabupaten" required>
                                <option value="-" disabled selected>====== Pilih Provinsi Terlebih Dahulu ======</option>
                            </select>
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
    $(document).ready(function() {
        $('#provinsi').change(function() {
            var provinsi_kode = $(this).val();

            // Clear kabupaten dropdown
            $('#kabupaten').html('<option value="-">Loading...</option>');

            // AJAX request
            $.ajax({
                url: '<?php echo site_url('monitoring_yuridiksi/get_kabupaten'); ?>',
                method: 'post',
                data: {
                    provinsi_kode: provinsi_kode
                },
                dataType: 'json',
                success: function(response) {
                    var options = '<option value="-" disabled selected>====== Silahkan Pilih Kabupaten ======</option>';

                    if (response.length > 0) {
                        $.each(response, function(index, data) {
                            options += '<option value="' + data.kabupaten_kode + '">' + data.kabupaten_nama + '</option>';
                        });
                    } else {
                        options = '<option value="-" disabled selected>====== Data Tidak Ditemukan ======</option>';
                    }

                    $('#kabupaten').html(options);
                },
                error: function() {
                    $('#kabupaten').html('<option value="-" disabled selected>====== Gagal Memuat Data ======</option>');
                }
            });
        });
    });
</script>
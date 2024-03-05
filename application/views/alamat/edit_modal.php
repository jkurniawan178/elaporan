<!-- Modal -->
<div class="modal fade" id="edit-modal" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ubah Alamat Pihak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_form" action="<?php echo base_url() . 'alamat/ubah_aksi' ?>" method="post" class="form-horizontal form-label-left needs-validation" novalidate>
                <div class="modal-body">
                    <!-- <div class="row form-group">
                        <label for="edit_no_perkara" class="col-form-label col-md-4 d-flex justify-content-md-end">Nomor Perkara<span class="required text-danger">*</span></label>
                        <div class="col-md-8 input-group mb-2">
                            <input type="text" id="edit_no_perkara" name="no_perkara" disabled class="form-control">
                        </div>
                    </div> -->
                    <div class="row form-group">
                        <label for="edit_nama_pihak" class="col-form-label col-md-4 d-flex justify-content-md-end">Nama Pihak<span class="required text-danger">*</span></label>
                        <div class="col-md-8 input-group mb-2">
                            <input type="text" id="edit_nama_pihak" name="nama_pihak" disabled class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="edit_alamat" class="col-form-label col-md-4 d-flex justify-content-md-end">Alamat<span class="required text-danger">*</span></label>
                        <div class="col-md-8 input-group mb-2">
                            <textarea id="edit_alamat" name="alamat" disabled required="required" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row form-group">
                        <label for="edit_cari_alamat" class="col-form-label col-md-4 d-flex justify-content-md-end">Cari Alamat<span class="required text-danger">*</span></label>
                        <div class="col-md-8">
                            <select id="edit_cari_alamat" name="cari_alamat" required="required" class="form-control" style="width: 100%;">
                                <option value="0">Ketik Nama Kelurahan, Kecamatan, Kota/Kabupaten</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="edit_kelurahan" class="col-form-label col-md-4 d-flex justify-content-md-end">Desa/Kelurahan<span class="required text-danger">*</label>
                        <div class="col-md-8">
                            <input type="text" id="edit_kelurahan" name="kelurahan" disabled required="required" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="edit_kecamatan" class="col-form-label col-md-4 d-flex justify-content-md-end">Kecamatan<span class="required text-danger">*</label>
                        <div class="col-md-8">
                            <input type="text" id="edit_kecamatan" name="kecamatan" disabled required="required" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="edit_kabupaten" class="col-form-label col-md-4 d-flex justify-content-md-end">Kabupaten/Kota<span class="required text-danger">*</label>
                        <div class="col-md-8">
                            <input type="text" id="edit_kabupaten" name="kabupaten" disabled required="required" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="edit_propinsi" class="col-form-label col-md-4 d-flex justify-content-md-end">Propinsi<span class="required text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" id="edit_propinsi" name="propinsi" disabled required="required" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="edit_id" name="id">
                    <input type="hidden" id="edit_prov_kode" name="prov_kode">
                    <input type="hidden" id="edit_kab_kode" name="kab_kode">
                    <input type="hidden" id="edit_kec_kode" name="kec_kode">
                    <input type="hidden" id="edit_kel_kode" name="kel_kode">
                    <button type="button" id="btn_close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_ubah" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#edit_cari_alamat').select2({
            ajax: {
                url: '<?php echo base_url('alamat/get_suggestions'); ?>',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term
                    }
                },
                processResults: function(data) {
                    return {
                        results: data,
                    }
                },
                cache: true,
                minimumInputLength: 3,
            }
        });

        $('#edit_cari_alamat').change(function() {
            let kodeKelurahan = $('#edit_cari_alamat').find(":selected").val();
            // $("#edit_kelurahan").val(value)

            $.ajax({
                url: '<?php echo base_url('alamat/get_single_alamat') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'kodeKelurahan': kodeKelurahan
                },
                success: function(response) {
                    $('#edit_propinsi').val(response['provinsi_nama'])
                    $('#edit_prov_kode').val(response['provinsi_kode'])
                    $('#edit_kabupaten').val(response['kabupaten_nama'])
                    $('#edit_kab_kode').val(response['kabupaten_kode'])
                    $('#edit_kecamatan').val(response['kecamatan_nama'])
                    $('#edit_kec_kode').val(response['kecamatan_kode'])
                    $('#edit_kelurahan').val(response['kelurahan_nama'])
                    $('#edit_kel_kode').val(response['kelurahan_kode'])
                }
            })
        })
    });
</script>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Perbaikan Alamat Pihak Pada SIPP 420</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <!-- Alert Atau pesan sukses -->
                <?php if ($this->session->flashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade in show mt-2" role="alert">
                        <?php echo $this->session->flashdata('success') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade in show mt-2" role="alert">
                        <?php echo $this->session->flashdata('error') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <div class="x_panel">
                    <div class="x_title">
                        <div class="item form-group">
                            <label class="col-form-label" for="filter">
                                <h6>Filter :</h6>
                            </label>
                            <div style="min-width: 10rem;" class="ml-2">
                                <select class="form-control" name="filter" id="filter" style="padding:8px 0;">
                                    <option value="">--All Years--</option>
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
                            <div style="min-width: 10rem;" class="ml-2">
                                <select name="kelengkapan" id="kelengkapan" class="form-control" style="padding: 8px 0;">
                                    <option value="0">Tidak Lengkap</option>
                                    <option value="1">Lengkap</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <table id="table-alamat" class=" text-center table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="align-middle" scope="col" data-priority="1">No</th>
                                    <th class="align-middle" scope="col" data-priority="1">Nomor Perkara</th>
                                    <th class="align-middle" scope="col" data-priority="1">Nama Pihak</th>
                                    <th class="align-middle" scope="col" data-priority="2">Alamat</th>
                                    <th class="align-middle" scope="col">Provinsi</th>
                                    <th class="align-middle" scope="col">Kabupaten/Kota</th>
                                    <th class="align-middle" scope="col">Kecamatan</th>
                                    <th class="align-middle" scope="col">Desa/Kelurahan</th>
                                    <th class="align-middle" scope="col" data-priority="1">Action</th>
                                </tr>
                            </thead>
                            <!-- <tbody>
                                <?php $no = 1;
                                foreach ($alamat_pihak as $value) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $value->nomor_perkara ?></td>
                                        <td><?= $value->nama ?></td>
                                        <td><?= $value->alamat ?></td>
                                        <td><?= $value->propinsi ?></td>
                                        <td><?= $value->kabupaten ?></td>
                                        <td><?= $value->kecamatan ?></td>
                                        <td><?= $value->kelurahan ?></td>
                                        <td>
                                            <a href="javascript:void(0)" type="button" class="btn btn-primary btn-icon-split btn-sm button-update" data-id="<?= $value->id ?>" data-nomor="<?= $value->nomor_perkara ?>" title="Ubah data Alamat" data-toggle="tooltip">
                                                <span class="icon text-white">
                                                    <i class="fa fa-edit"></i>
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /page content -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>
<!-- Format Mask -->
<script src="<?php echo base_url() ?>resources/cleave/cleave.min.js"></script>
<script src="<?php echo base_url() ?>resources/js/thousandSeparator.js"></script>
<?php include('edit_modal.php') ?>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip]').tooltip();

        var table = $('#table-alamat').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            serverMethod: 'post',
            ajax: {
                url: '<?php echo base_url('alamat/pihakList') ?>',
                type: 'POST',
                data: function(data) {
                    data.searchYear = $('#filter').val();
                    data.searchStatus = $('#kelengkapan').val();
                }
            },
            columns: [{
                    data: 'id',
                    sortable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nomor_perkara'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'alamat'
                },
                {
                    data: 'propinsi'
                },
                {
                    data: 'kabupaten'
                },
                {
                    data: 'kecamatan'
                },
                {
                    data: 'kelurahan'
                },
                {
                    data: 'id',
                    render: function(data, type, row, meta) {
                        return `<a href="javascript:void(0)" type="button" class="btn btn-primary btn-icon-split btn-sm button-update" data-id="${data}" title="Ubah data Alamat" data-toggle="tooltip">
                                                <span class="icon text-white">
                                                    <i class="fa fa-edit"></i>
                                                </span>
                                            </a>`
                    }
                },
            ],
            stateSaveParams: function(setting, data) {
                data.filYear = $('#filter').val();
                data.filStat = $('#kelengkapan').val();
            },
            stateLoadParams: function(setting, data) {
                $('#filter').val(data.filYear);
                $('#kelengkapan').val(data.filStat);
            },
            order: [
                [0, 'asc']
            ],
            responsive: true
        });

        $('#kelengkapan, #filter').on('change', function(event) {
            table.draw();
        });


        table.on('click', '.button-update', function() {
            let id = $(this).data('id');
            // let nomor = $(this).data('nomor');
            $.ajax({
                url: '<?php echo base_url('alamat/get_pihak_id') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'id': id
                },
                success: function(response) {
                    $('#edit_id').val(response['id'])
                    // $('#edit_no_perkara').val(nomor)
                    $('#edit_nama_pihak').val(response['nama'])
                    $('#edit_alamat').val(response['alamat'])
                    $('#edit_propinsi').val(response['provinsi_nama'])
                    $('#edit_prov_kode').val(response['propinsi'])
                    $('#edit_kabupaten').val(response['kabupaten_nama'])
                    $('#edit_kab_kode').val(response['kabupaten'])
                    $('#edit_kecamatan').val(response['kecamatan_nama'])
                    $('#edit_kec_kode').val(response['kecamatan'])
                    $('#edit_kelurahan').val(response['kelurahan_nama'])
                    $('#edit_kel_kode').val(response['kelurahan'])
                    $('#edit-modal').modal('show');
                }
            })
        });

        $('#logout').on("click", function() {
            table.state.clear();
        })
    });
</script>
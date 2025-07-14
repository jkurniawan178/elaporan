<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Form Yuridiksi</h2>
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
                            <div class="ml-2">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#yuridiksi-modal">
                                    <i class="fa fa-plus"></i>
                                    Tambah Yuridiksi
                                </button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <table id="table-yuridiksi" class=" text-center table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="align-middle" scope="col" data-priority="1">No</th>
                                    <th class="align-middle" scope="col" data-priority="1">Kode Provinsi</th>
                                    <th class="align-middle" scope="col">Provinsi</th>
                                    <th class="align-middle" scope="col">Kode Kota/Kabupaten</th>
                                    <th class="align-middle" scope="col">Kota/Kabupaten</th>
                                    <th class="align-middle" scope="col" data-priority="1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($yuridiksi as $value) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $value->provinsi_kode ?></td>
                                        <td><?= $value->provinsi_nama ?></td>
                                        <td><?= $value->kabupaten_kode ?></td>
                                        <td><?= $value->kabupaten_nama ?></td>
                                        <td>
                                            <a href="javascript:void(0)" type="button" class="btn btn-danger btn-icon-split btn-sm button-delete" data-id="<?= $value->id ?>" title="Hapus Yuridiksi" data-toggle="tooltip">
                                                <span class="icon text-white">
                                                    <i class="fa fa-trash"></i>
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url() ?>resources/js/helper.js"></script>
<?php include('yuridiksi_modal.php') ?>
<?php include('delete_modal.php') ?>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip]').tooltip();

        var table = $('#table-yuridiksi').DataTable({
            order: [
                [0, 'asc']
            ],

            responsive: true
        });

        table.on('click', '.button-delete', function() {
            let id = $(this).data('id');
            const idSidkel = document.getElementById('id');
            idSidkel.value = id;

            $('#delete-modal').modal('show');
        });

    });
</script>
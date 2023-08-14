<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Saldo Awal Keuangan Perkara - LIPA 07</h2>
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
                <!-- --- -->
                <div class="x_panel mt-2">
                    <div class="x_title">
                        <div class="ml-2">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-modal">
                                <i class="fa fa-plus"></i>
                                Tambah Saldo Awal
                            </button>
                        </div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="table-pagu" class=" text-center table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="align-middle" scope="col" rowspan="2">No</th>
                                                <th class="align-middle" scope="col" rowspan="2" data-priority="1">Tahun</th>
                                                <th class="align-middle" scope="colgroup" colspan="3" data-priority="1">Saldo Awal</th>
                                                <th class="align-middle" scope="col" rowspan="2">Keterangan</th>
                                                <th class="align-middle" scope="col" rowspan="2">Actions</th>
                                            </tr>
                                            <tr>
                                                <th class="align-middle" scope="col">LIPA 7a</th>
                                                <th class="align-middle" scope="col">LIPA 7b</th>
                                                <th class="align-middle" scope="col">LIPA 7c</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($saldo_awal as $value) { ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $value->tahun ?></td>
                                                    <td><?= number_format($value->saldo_awal_7a, 0, ',', '.') ?></td>
                                                    <td><?= number_format($value->saldo_awal_7b, 0, ',', '.') ?></td>
                                                    <td><?= number_format($value->saldo_awal_7c, 0, ',', '.') ?></td>
                                                    <td><?= $value->keterangan ?></td>
                                                    <td>
                                                        <a href="javascript:void(0)" type="button" class="btn btn-primary btn-icon-split btn-sm button-update" data-id="<?= $value->id ?>" title="Edit Saldo Awal" data-toggle="tooltip">
                                                            <span class="icon text-white">
                                                                <i class="fa fa-edit"></i>
                                                            </span>
                                                        </a>

                                                        <a href="javascript:void(0)" type="button" class="btn btn-danger btn-icon-split btn-sm button-delete" data-id="<?= $value->id ?>" title="Hapus Saldo Awal" data-toggle="tooltip">
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
        </div>
    </div>
</div>
<!-- /page content -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>
<!-- Format Mask -->
<script src="<?php echo base_url() ?>resources/cleave.min.js"></script>
<script src="<?php echo base_url() ?>resources/js/thousandSeparator.js"></script>
<?php include('add_modal.php') ?>
<?php include('edit_modal.php') ?>
<?php include('delete_modal.php') ?>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        var table = $('#table-pagu').DataTable({
            order: [
                [0, 'asc']
            ],
            responsive: true
        });

        table.on('click', '.button-update', function() {
            let id = $(this).data('id');

            $.ajax({
                url: '<?php echo base_url('LIPA_7/saldo_awal/get_saldo_awal') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'id': id
                },
                success: function(response) {
                    // console.log(response)
                    $('#edit_id').val(response['id'])
                    $('#edit_tahun').val(response['tahun'])
                    $('#edit_awal_7a').val(response['saldo_awal_7a'])
                    $('#edit_awal_7b').val(response['saldo_awal_7b'])
                    $('#edit_awal_7c').val(response['saldo_awal_7c'])
                    $('#edit_keterangan').val(response['keterangan'])
                    $('#edit-modal').modal('show');
                }
            })
        });

        table.on('click', '.button-delete', function() {
            let id = $(this).data('id');
            const idInput = document.getElementById('id');
            idInput.value = id;

            $('#delete-modal').modal('show');
        })
    });

    //------------------------------------------------------------------------------------------
</script>
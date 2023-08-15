<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Pagu Anggaran - Pelaksanaan Pembebasan Biaya Perkara</h2>
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
                                Tambah Pagu Anggaran
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
                                                <th class="align-middle" scope="col">No</th>
                                                <th class="align-middle" scope="col" data-priority="1">Tahun</th>
                                                <th class="align-middle" scope="col" data-priority="1">Pagu Awal</th>
                                                <th class="align-middle" scope="col">Pagu Revisi</th>
                                                <th class="align-middle" scope="col">Target Perkara</th>
                                                <th class="align-middle" scope="col" data-priority="1">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($pagu_15 as $value) { ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $value->tahun_anggaran ?></td>
                                                    <td><?= number_format($value->pagu_awal, 0, ',', '.') ?></td>
                                                    <td><?= number_format($value->pagu_revisi, 0, ',', '.') ?></td>
                                                    <td><?= $value->target_perkara ?></td>
                                                    <td>
                                                        <a href="javascript:void(0)" type="button" class="btn btn-primary btn-icon-split btn-sm button-update" data-id="<?= $value->id ?>" title="Revisi pagu" data-toggle="tooltip">
                                                            <span class="icon text-white">
                                                                <i class="fa fa-edit"></i>
                                                            </span>
                                                        </a>

                                                        <a href="javascript:void(0)" type="button" class="btn btn-danger btn-icon-split btn-sm button-delete" data-id="<?= $value->id ?>" title="Hapus data pagu" data-toggle="tooltip">
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
<script src="<?php echo base_url() ?>resources/cleave/cleave.min.js"></script>
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
                url: '<?php echo base_url('LIPA_15/Pagu_15/get_pagu15') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'id': id
                },
                success: function(response) {
                    // console.log(response)
                    $('#edit_id').val(response['id'])
                    $('#edit_tahun').val(response['tahun_anggaran'])
                    $('#edit_pagu_awal').val(response['pagu_awal'])
                    $('#edit_pagu_revisi').val(response['pagu_revisi'])
                    $('#edit_perkara').val(response['target_perkara'])
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
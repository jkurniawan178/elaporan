<!-- page content -->
<?php if ($this->session->flashdata('alert')) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $this->session->flashdata('alert'); ?>
    </div>
<?php endif; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2>Pagu Anggaran - Pelaksanaan Sidang diluar Gedung Pengadilan</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
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
                                    <table id="datatable-responsive" class=" text-center table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="align-middle" scope="col" rowspan="2">No</th>
                                                <th class="align-middle" scope="col" rowspan="2">Tahun</th>
                                                <th class="align-middle" scope="col" rowspan="2">Pagu Awal</th>
                                                <th class="align-middle" scope="col" rowspan="2">Pagu Revisi</th>
                                                <th class="align-middle" colspan="3" scope="colgroup">Target</th>
                                                <th class="align-middle" scope="col" rowspan="2">Actions</th>
                                            </tr>
                                            <tr>
                                                <th class="align-middle" scope="col">Lokasi</th>
                                                <th class="align-middle" scope="col">Kegiatan</th>
                                                <th class="align-middle" scope="col">Perkara</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($pagu_14 as $value) { ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $value->tahun_anggaran ?></td>
                                                    <td><?= number_format($value->pagu_awal, 0, ',', '.') ?></td>
                                                    <td><?= number_format($value->pagu_revisi, 0, ',', '.') ?></td>
                                                    <td><?= $value->target_lokasi ?></td>
                                                    <td><?= $value->target_kegiatan ?></td>
                                                    <td><?= $value->target_perkara ?></td>
                                                    <td>
                                                        <!-- <a href="javascript:void(0)" type="button" class="btn btn-primary btn-icon-split btn-sm button-update">
                                                            <span class="icon text-white-50">
                                                                <i class="fa fa-edit"></i>
                                                            </span>
                                                            <span class="text">Edit</span>
                                                        </a> -->
                                                        <!-- <a href="javascript:void(0)" type="button" class="btn btn-danger btn-icon-split btn-sm button-delete" data-id="<%= jabatan[i].id %>">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                            <span class="text">Hapus</span>
                                                        </a> -->
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
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-info" id="spinner" style="width: 5rem; height: 5rem; display:none;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <?php include('add_modal.php') ?>
</div>
<!-- /page content -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>
<!-- page content -->
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
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-info" id="spinner" style="width: 5rem; height: 5rem; display:none;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <?php include('add_modal.php') ?>
    <?php include('edit_modal.php') ?>
    <?php include('delete_modal.php') ?>
</div>
<!-- /page content -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        var table = $('#table-pagu').DataTable({
            order: [
                [0, 'asc']
            ]
        });

        table.on('click', '.button-update', function() {
            let id = $(this).data('id');

            $.ajax({
                url: '<?php echo base_url('LIPA_14/Pagu_14/get_pagu14') ?>',
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
                    $('#edit_lokasi').val(response['target_lokasi'])
                    $('#edit_kegiatan').val(response['target_kegiatan'])
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
    //--------------------------Script for modal section----------------------------------------
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

    //--------------------------- Get the input element Modal Tambah --------------------
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
    document.getElementById("add_form").addEventListener("submit", function(event) {
        // Get the current input value without dots (thousand separators)
        let inputPaguAwal = removeThousandSeparator(paguAwal.value);
        let inputPaguRevisi = removeThousandSeparator(paguRevisi.value);

        // Convert the value to a number
        let numPaguAwal = parseFloat(inputPaguAwal);
        let numPaguRevisi = parseFloat(inputPaguRevisi);

        // Set the numeric value as the new value of the input field
        if (isNaN(numPaguAwal) == false) {
            paguAwal.value = numPaguAwal;
        }
        if (isNaN(numPaguRevisi) == false) {
            paguRevisi.value = numPaguRevisi;
        }

    })

    //--------------------------- Get the input element Modal edit --------------------
    const editPaguAwal = document.getElementById("edit_pagu_awal");
    const editPaguRevisi = document.getElementById("edit_pagu_revisi");

    // Add event listener for keyup event
    editPaguAwal.addEventListener("keyup", function(event) {
        formatInputValue(event.target);
    });

    editPaguRevisi.addEventListener("keyup", function(event) {
        formatInputValue(event.target);
    });

    //function to remove thousand separator before send it to controller
    document.getElementById("edit_form").addEventListener("submit", function(event) {
        // Get the current input value without dots (thousand separators)
        let inputPaguAwal = removeThousandSeparator(editPaguAwal.value);
        let inputPaguRevisi = removeThousandSeparator(editPaguRevisi.value);

        // Convert the value to a number
        let numPaguAwal = parseFloat(inputPaguAwal);
        let numPaguRevisi = parseFloat(inputPaguRevisi);

        // Set the numeric value as the new value of the input field
        if (isNaN(numPaguAwal) == false) {
            editPaguAwal.value = numPaguAwal;
        }
        if (isNaN(numPaguRevisi) == false) {
            editPaguRevisi.value = numPaguRevisi;
        }
    })
</script>
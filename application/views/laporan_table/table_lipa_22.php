<div class="table-responsive">
    <p class="font-weight-bold text-dark">A. BANTUAN PANGGILAN KELUAR</p>
    <table class="text-center table table-striped table-bordered" id="table_lipa22_keluar" cellspacing="0" width="100%">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" class="align-middle p-2">No.</th>
                <th scope="col" class="align-middle p-2">Nama Pengadilan</th>
                <th scope="col" class="align-middle p-2">No. Perkara</th>
                <th scope="col" class="align-middle p-2" style="min-width: 150px;">Nama Pihak</th>
                <th scope="col" class="align-middle p-2">No. Surat</th>
                <th scope="col" class="align-middle p-2">Tgl Surat</th>
                <th scope="col" class="align-middle p-2">Tgl Sidang</th>
                <th scope="col" class="align-middle p-2">Tgl Kirim</th>
                <th scope="col" class="align-middle p-2">Tgl Disposisi</th>
                <th scope="col" class="align-middle p-2">Tgl Relaas</th>
                <th scope="col" class="align-middle p-2">Tgl Pengembalian</th>
                <th scope="col" class="align-middle p-2">JS / JSP</th>
                <th scope="col" class="align-middle p-2">Ket</th>
            </tr>
            <tr class="bg-warning">
                <th scope="col" class="align-middle py-0 px-2">1</th>
                <th scope="col" class="align-middle py-0 px-2">2</th>
                <th scope="col" class="align-middle py-0 px-2">3</th>
                <th scope="col" class="align-middle py-0 px-2">4</th>
                <th scope="col" class="align-middle py-0 px-2">5</th>
                <th scope="col" class="align-middle py-0 px-2">6</th>
                <th scope="col" class="align-middle py-0 px-2">7</th>
                <th scope="col" class="align-middle py-0 px-2">8</th>
                <th scope="col" class="align-middle py-0 px-2">9</th>
                <th scope="col" class="align-middle py-0 px-2">10</th>
                <th scope="col" class="align-middle py-0 px-2">11</th>
                <th scope="col" class="align-middle py-0 px-2">12</th>
                <th scope="col" class="align-middle py-0 px-2">13</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
    <p class="font-weight-bold text-dark mt-4">B. BANTUAN PANGGILAN MASUK</p>
    <table class="text-center table table-striped table-bordered" id="table_lipa22_masuk" cellspacing="0" width="100%">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" class="align-middle p-2">No.</th>
                <th scope="col" class="align-middle p-2">Nama Pengadilan</th>
                <th scope="col" class="align-middle p-2">No. Perkara</th>
                <th scope="col" class="align-middle p-2" style="min-width: 150px;">Nama Pihak</th>
                <th scope="col" class="align-middle p-2">No. Surat</th>
                <th scope="col" class="align-middle p-2">Tgl Terima Surat</th>
                <th scope="col" class="align-middle p-2">Tgl Sidang</th>
                <th scope="col" class="align-middle p-2">Tgl Terima</th>
                <th scope="col" class="align-middle p-2">Tgl Disposisi</th>
                <th scope="col" class="align-middle p-2">Tgl Relaas</th>
                <th scope="col" class="align-middle p-2">Tgl Pengembalian</th>
                <th scope="col" class="align-middle p-2">JS / JSP</th>
                <th scope="col" class="align-middle p-2">Ket</th>
            </tr>
            <tr class="bg-warning">
                <th scope="col" class="align-middle py-0 px-2">1</th>
                <th scope="col" class="align-middle py-0 px-2">2</th>
                <th scope="col" class="align-middle py-0 px-2">3</th>
                <th scope="col" class="align-middle py-0 px-2">4</th>
                <th scope="col" class="align-middle py-0 px-2">5</th>
                <th scope="col" class="align-middle py-0 px-2">6</th>
                <th scope="col" class="align-middle py-0 px-2">7</th>
                <th scope="col" class="align-middle py-0 px-2">8</th>
                <th scope="col" class="align-middle py-0 px-2">9</th>
                <th scope="col" class="align-middle py-0 px-2">10</th>
                <th scope="col" class="align-middle py-0 px-2">11</th>
                <th scope="col" class="align-middle py-0 px-2">12</th>
                <th scope="col" class="align-middle py-0 px-2">13</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa22_keluar').DataTable({
            order: [
                [0, 'asc']
            ],
            "bFilter": false,
            columnDefs: [{
                    className: "align-middle",
                    targets: ["_all"]
                } // Apply class to specific columns
            ]
        });
        table.clear();
        // Loop through the received data and create rows for the table
        let valueDataKeluar = data.delegasi_keluar;

        for (var i = 0; i < valueDataKeluar.length; i++) {
            // var row = valueData[i];
            table.row.add([
                i + 1,
                valueDataKeluar[i].pa_tujuan_text,
                valueDataKeluar[i].nomor_perkara,
                valueDataKeluar[i].pihak,
                valueDataKeluar[i].nomor_surat,
                formatDate(valueDataKeluar[i].tgl_surat),
                formatDate(valueDataKeluar[i].tgl_sidang),
                formatDate(valueDataKeluar[i].tgl_surat_diterima),
                formatDate(valueDataKeluar[i].tgl_disposisi),
                formatDate(valueDataKeluar[i].tgl_relaas),
                formatDate(valueDataKeluar[i].tgl_pengiriman_relaas),
                valueDataKeluar[i].jurusita_nama,
                jenisDelegasi(valueDataKeluar[i].id_jenis_delegasi)
            ])
        }
        table.draw();

        const table1 = $('#table_lipa22_masuk').DataTable({
            order: [
                [0, 'asc']
            ],
            "bFilter": false,
            columnDefs: [{
                    className: "align-middle",
                    targets: ["_all"]
                } // Apply class to specific columns
            ]
        });
        table1.clear();
        // Loop through the received data and create rows for the table
        let valueDataMasuk = data.delegasi_masuk;

        for (var i = 0; i < valueDataMasuk.length; i++) {
            // var row = valueData[i];
            table1.row.add([
                i + 1,
                valueDataMasuk[i].pa_asal_text,
                valueDataMasuk[i].nomor_perkara,
                valueDataMasuk[i].pihak,
                valueDataMasuk[i].nomor_surat,
                formatDate(valueDataMasuk[i].tgl_surat),
                formatDate(valueDataMasuk[i].tgl_sidang),
                formatDate(valueDataMasuk[i].tgl_surat_diterima),
                formatDate(valueDataMasuk[i].tgl_disposisi),
                formatDate(valueDataMasuk[i].tgl_relaas),
                formatDate(valueDataMasuk[i].tgl_pengiriman_relaas),
                valueDataMasuk[i].jurusita_nama,
                jenisDelegasi(valueDataMasuk[i].id_jenis_delegasi)
            ])
        }
        table1.draw();
    }
</script>
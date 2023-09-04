<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa3">
        <thead class="bg-success">
            <tr>
                <th scope="col" rowspan="2" class="align-middle">No</th>
                <th scope="col" colspan="2" class="align-middle">Nomor Perkara</th>
                <th colspan="7" scope="colgroup" class="align-middle">Tanggal</th>
                <th scope="col" rowspan="2" class="align-middle">Ket</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle">Tingkat Pertama</th>
                <th scope="col" class="align-middle">Tingkat Banding</th>
                <th scope="col" class="align-middle">Permohonan Kasasi</th>
                <th scope="col" class="align-middle">Penerimaan Memori Kasasi</th>
                <th scope="col" class="align-middle">Penetapan Tidak Memenuhi Syarat Formal</th>
                <th scope="col" class="align-middle">Pengiriman Berkas ke MA</th>
                <th scope="col" class="align-middle">Putus Kasasi</th>
                <th scope="col" class="align-middle">Penerimaan Kembali Berkas Kasasi di PA</th>
                <th scope="col" class="align-middle">Pemberitahuan ke Para Pihak</th>
            </tr>
            <tr class="bg-warning">
                <th scope="col" class="align-middle py-0">1</th>
                <th scope="col" class="align-middle py-0">2</th>
                <th scope="col" class="align-middle py-0">3</th>
                <th scope="col" class="align-middle py-0">4</th>
                <th scope="col" class="align-middle py-0">5</th>
                <th scope="col" class="align-middle py-0">6</th>
                <th scope="col" class="align-middle py-0">7</th>
                <th scope="col" class="align-middle py-0">8</th>
                <th scope="col" class="align-middle py-0">9</th>
                <th scope="col" class="align-middle py-0">10</th>
                <th scope="col" class="align-middle py-0">11</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa3').DataTable({
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
        for (let i = 0; i < data.length; i++) {

            if (data[i].tanggal_cabut === "" || data[i].tanggal_cabut === null) {
                data[i].keterangan = "-";
            } else {
                data[i].keterangan = "cabut tanggal : " + formatDate(data[i].tanggal_cabut);
            }

            table.row.add([
                i + 1,
                data[i].nomor_perkara_pn,
                data[i].nomor_putusan_banding,
                formatDate(data[i].permohonan_kasasi),
                formatDate(data[i].penerimaan_memori_kasasi),
                formatDate(data[i].tidak_memenuhi_syarat),
                formatDate(data[i].pengiriman_berkas_kasasi),
                formatDate(data[i].putusan_kasasi),
                formatDate(data[i].penerimaan_berkas_kasasi),
                `P: ${formatDate(data[i].pbt_putusan_p)}<br/> T: ${formatDate(data[i].pbt_putusan_t)}`,
                data[i].keterangan
            ])
        }
        table.draw();
    }
</script>
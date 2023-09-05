<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa4">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" rowspan="2" class="align-middle p-2">No</th>
                <th scope="colgroup" colspan="3" class="align-middle p-2">Nomor Perkara</th>
                <th colspan="5" scope="colgroup" class="align-middle p-2">Tanggal</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Ket</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle p-2">Tingkat Pertama</th>
                <th scope="col" class="align-middle p-2">Tingkat Banding</th>
                <th scope="col" class="align-middle p-2">Tingkat Kasasi</th>
                <th scope="col" class="align-middle p-2">Permohonan dan Risalah PK</th>
                <th scope="col" class="align-middle p-2">Pengiriman Berkas ke MA</th>
                <th scope="col" class="align-middle p-2">Putus Peninjauan Kembali</th>
                <th scope="col" class="align-middle p-2">Penerimaan Kembali berkas PK di PA</th>
                <th scope="col" class="align-middle p-2">Pemberitahuan ke Para Pihak</th>
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
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa4').DataTable({
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
        for (var i = 0; i < data.length; i++) {

            if (data[i].tanggal_cabut === "" || data[i].tanggal_cabut === null) {
                data[i].keterangan = "-";
            } else {
                data[i].keterangan = "cabut tanggal : " + formatDate(data[i].tanggal_cabut);
            }

            table.row.add([
                i + 1,
                data[i].nomor_perkara_pn,
                data[i].nomor_putusan_banding,
                data[i].nomor_putusan_kasasi,
                formatDate(data[i].permohonan_pk),
                formatDate(data[i].pengiriman_berkas_pk),
                formatDate(data[i].putusan_pk),
                formatDate(data[i].penerimaan_berkas_pk),
                `P: ${formatDate(data[i].pbt_pk_p)} <br/> T: ${formatDate(data[i].pbt_pk_t)}`,
                data[i].keterangan
            ])
        }

        table.draw();
    }
</script>
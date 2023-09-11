<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa21" cellspacing="0" width="100%">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" rowspan="2" class="align-middle p-2">No</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Nomor Perkara</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Kode Perkara</th>
                <th scope="col" rowspan="2" class="align-middle p-2" style="min-width: 250px;">Nama Majelis Hakim</th>
                <th scope="col" rowspan="2" class="align-middle p-2" style="min-width: 150px;">Nama PP</th>
                <th scope="colgroup" colspan="9" class="align-middle p-2">Tanggal</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Ket</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle p-2">Penerimaan</th>
                <th scope="col" class="align-middle p-2">PMH</th>
                <th scope="col" class="align-middle p-2">PHS</th>
                <th scope="col" class="align-middle p-2">Sidang I</th>
                <th scope="col" class="align-middle p-2">Diputus</th>
                <th scope="col" class="align-middle p-2">Jenis Putusan</th>
                <th scope="col" class="align-middle p-2">Belum Dibagi</th>
                <th scope="col" class="align-middle p-2">Belum Diputus</th>
                <th scope="col" class="align-middle p-2">Belum Diminutasi</th>
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
                <th scope="col" class="align-middle py-0 px-2">14</th>
                <th scope="col" class="align-middle py-0 px-2">15</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa21').DataTable({
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

            if (data[i].belum_dibagi == null) {
                data[i].belum_dibagi = "-"
            } else {
                data[i].belum_dibagi = "v"
            }

            if (data[i].belum_putus == null) {
                data[i].belum_putus = "-"
            } else {
                data[i].belum_putus = "v"
            }

            if (data[i].belum_minutasi == null) {
                data[i].belum_minutasi = "-"
            } else {
                data[i].belum_minutasi = "v"
            }
            table.row.add([
                i + 1,
                data[i].nomor_perkara,
                data[i].kode_perkara,
                data[i].majelis_hakim,
                data[i].panitera_pengganti,
                formatDate(data[i].penerimaan),
                formatDate(data[i].pmh),
                formatDate(data[i].phs),
                formatDate(data[i].sidang_pertama),
                formatDate(data[i].diputus),
                data[i].jenis_putusan,
                data[i].belum_dibagi,
                data[i].belum_putus,
                data[i].belum_minutasi,
                "-"
            ])
        }
        table.draw();
    }
</script>
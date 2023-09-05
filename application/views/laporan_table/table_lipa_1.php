<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa1" cellspacing="0" width="100%">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" rowspan="2" class="align-middle p-2">No</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Nomor Perkara</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Kode Perkara</th>
                <th scope="col" rowspan="2" class="align-middle p-2" style="min-width: 250px;">Nama Majelis Hakim</th>
                <th scope="col" rowspan="2" class="align-middle p-2" style="min-width: 150px;">Nama PP</th>
                <th scope="colgroup" colspan="5" class="align-middle p-2">Tanggal</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Jenis Putusan</th>
                <th scope="colgroup" colspan="2" class="align-middle p-2">Tanggal</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Ket</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle p-2">Penerimaan</th>
                <th scope="col" class="align-middle p-2">PMH</th>
                <th scope="col" class="align-middle p-2">PHS</th>
                <th scope="col" class="align-middle p-2">Sidang I</th>
                <th scope="col" class="align-middle p-2">Diputus</th>
                <th scope="col" class="align-middle p-2">Belum Dibagi</th>
                <th scope="col" class="align-middle p-2">Belum Diputus</th>
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
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa1').DataTable({
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
        let valueData = data.hasil;
        for (var i = 0; i < valueData.length; i++) {
            // var row = valueData[i];
            table.row.add([
                i + 1,
                valueData[i].nomor_perkara,
                valueData[i].kode_perkara,
                valueData[i].majelis_hakim,
                valueData[i].panitera_pengganti,
                formatDate(valueData[i].tanggal_pendaftaran),
                formatDate(valueData[i].pmh),
                formatDate(valueData[i].phs),
                formatDate(valueData[i].sidang_pertama),
                formatDate(valueData[i].tanggal_putusan),
                valueData[i].jenis_putusan,
                valueData[i].belum_dibagi,
                valueData[i].belum_diputus,
                "-"
            ])
        }
        table.draw();
    }
</script>
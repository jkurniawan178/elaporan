<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa1" cellspacing="0" width="100%">
        <thead class="bg-success">
            <tr>
                <th scope="col" rowspan="2" class="align-middle">No</th>
                <th scope="col" rowspan="2" class="align-middle">Nomor Perkara</th>
                <th scope="col" rowspan="2" class="align-middle">Kode Perkara</th>
                <th scope="col" rowspan="2" class="align-middle" style="min-width: 300px;">Nama Majelis Hakim</th>
                <th scope="col" rowspan="2" class="align-middle">Nama PP</th>
                <th scope="colgroup" colspan="5" class="align-middle">Tanggal</th>
                <th scope="col" rowspan="2" class="align-middle">Jenis Putusan</th>
                <th scope="colgroup" colspan="2" class="align-middle">Tanggal</th>
                <th scope="col" rowspan="2" class="align-middle">Ket</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle">Penerimaan</th>
                <th scope="col" class="align-middle">PMH</th>
                <th scope="col" class="align-middle">PHS</th>
                <th scope="col" class="align-middle">Sidang I</th>
                <th scope="col" class="align-middle">Diputus</th>
                <th scope="col" class="align-middle">Belum Dibagi</th>
                <th scope="col" class="align-middle">Belum Diputus</th>
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
                <th scope="col" class="align-middle py-0">12</th>
                <th scope="col" class="align-middle py-0">13</th>
                <th scope="col" class="align-middle py-0">14</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        var tableContent = "";
        let valueData = data.hasil;

        console.log(valueData)
        var table = $('#table_lipa1').DataTable({
            order: [
                [0, 'asc']
            ],
        });
        table.clear();
        // Loop through the received data and create rows for the table
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
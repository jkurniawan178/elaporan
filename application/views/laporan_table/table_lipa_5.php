<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa5">
        <thead class="bg-success">
            <tr>
                <th scope="col" rowspan="2" class="align-middle">No</th>
                <th scope="col" colspan="2" class="align-middle">Nomor</th>
                <th colspan="8" scope="colgroup" class="align-middle">Tanggal</th>
                <th scope="col" rowspan="2" class="align-middle">Bergantung</th>
                <th scope="col" rowspan="2" class="align-middle">Alasan</th>
                <th scope="col" rowspan="2" class="align-middle">Ket</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle">Eksekusi</th>
                <th scope="col" class="align-middle">Putusan atau Grose Akta yang Dimohonkan Eksekusi</th>
                <th scope="col" class="align-middle">Permohonan Eksekusi</th>
                <th scope="col" class="align-middle">Penetapan aanmaning</th>
                <th scope="col" class="align-middle">Pelaksanaan aanmaning</th>
                <th scope="col" class="align-middle">Penetapan Sita Eksekusi</th>
                <th scope="col" class="align-middle">Pelaksanaan Sita Eksekusi</th>
                <th scope="col" class="align-middle">Penetapan Eksekusi</th>
                <th scope="col" class="align-middle">Pelaksanaan Eksekusi</th>
                <th scope="col" class="align-middle">Penetapan Non-Eksekutabel</th>
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
        const table = $('#table_lipa5').DataTable({
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

            table.row.add([
                i + 1,
                data[i].nomor_register_eksekusi,
                data[i].eksekusi_nomor_perkara,
                formatDate(data[i].permohonan_eksekusi),
                formatDate(data[i].penetapan_teguran_eksekusi),
                formatDate(data[i].pelaksanaan_teguran_eksekusi),
                formatDate(data[i].penetapan_sita_eksekusi),
                formatDate(data[i].pelaksanaan_sita_eksekusi),
                formatDate(data[i].penetapan_eksekusi_rill),
                formatDate(data[i].pelaksanaan_eksekusi_rill),
                formatDate(data[i].penetapan_noneksekusi),
                '-',
                data[i].alasan,
                '-'
            ])
        }
        table.draw();
    }
</script>
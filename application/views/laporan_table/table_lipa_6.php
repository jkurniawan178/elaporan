<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa6">
        <thead class="bg-success">
            <tr>
                <th class="align-middle" rowspan="2" align="center">No</th>
                <th class="align-middle" style="min-width: 250px;" rowspan="2" align="center">Nama Hakim/Majelis</th>
                <th class="align-middle" colspan="2" align="center">Sisa Bulan Lalu</th>
                <th class="align-middle" colspan="2" align="center">Tambah Bulan Ini</th>
                <th class="align-middle" colspan="2" align="center">Jumlah</th>
                <th class="align-middle" colspan="2" align="center">Diputus</th>
                <th class="align-middle" colspan="2" align="center">Sisa Bulan Ini</th>
                <th class="align-middle" colspan="2" align="center">Jumlah yang Diminutir</th>
                <th class="align-middle" colspan="2" align="center">Sisa yang Belum Diminutir</th>
            </tr>
            <tr>
                <th class="align-middle">G</th>
                <th class="align-middle">P</th>
                <th class="align-middle">G</th>
                <th class="align-middle">P</th>
                <th class="align-middle">G</th>
                <th class="align-middle">P</th>
                <th class="align-middle">G</th>
                <th class="align-middle">P</th>
                <th class="align-middle">G</th>
                <th class="align-middle">P</th>
                <th class="align-middle">G</th>
                <th class="align-middle">P</th>
                <th class="align-middle">G</th>
                <th class="align-middle">P</th>
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
                <th scope="col" class="align-middle py-0">15</th>
                <th scope="col" class="align-middle py-0">16</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa6').DataTable({
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
                data[i].nama_gelar,
                data[i].sisa_lalu_G,
                data[i].sisa_lalu_P,
                data[i].Diterima_G,
                data[i].Diterima_P,
                parseInt(data[i].sisa_lalu_G) + parseInt(data[i].Diterima_G),
                parseInt(data[i].sisa_lalu_P) + parseInt(data[i].Diterima_P),
                data[i].putus_G,
                data[i].putus_P,
                parseInt(data[i].sisa_lalu_G) + parseInt(data[i].Diterima_G) - parseInt(data[i].putus_G),
                parseInt(data[i].sisa_lalu_P) + parseInt(data[i].Diterima_P) - parseInt(data[i].putus_P),
                data[i].minut_G,
                data[i].minut_P,
                parseInt(data[i].putus_G) - parseInt(data[i].minut_G),
                parseInt(data[i].putus_P) - parseInt(data[i].minut_P)
            ])
        }
        table.draw();
    }
</script>
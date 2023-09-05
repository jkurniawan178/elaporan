<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa6">
        <thead class="bg-success text-dark">
            <tr>
                <th class="align-middle p-2" rowspan="2">No</th>
                <th class="align-middle p-2" style="min-width: 250px;" rowspan="2">Nama Hakim/Majelis</th>
                <th class="align-middle p-2" colspan="2">Sisa Bulan Lalu</th>
                <th class="align-middle p-2" colspan="2">Tambah Bulan Ini</th>
                <th class="align-middle p-2" colspan="2">Jumlah</th>
                <th class="align-middle p-2" colspan="2">Diputus</th>
                <th class="align-middle p-2" colspan="2">Sisa Bulan Ini</th>
                <th class="align-middle p-2" colspan="2">Jumlah yang Diminutir</th>
                <th class="align-middle p-2" colspan="2">Sisa yang Belum Diminutir</th>
            </tr>
            <tr>
                <th class="align-middle p-2">G</th>
                <th class="align-middle p-2">P</th>
                <th class="align-middle p-2">G</th>
                <th class="align-middle p-2">P</th>
                <th class="align-middle p-2">G</th>
                <th class="align-middle p-2">P</th>
                <th class="align-middle p-2">G</th>
                <th class="align-middle p-2">P</th>
                <th class="align-middle p-2">G</th>
                <th class="align-middle p-2">P</th>
                <th class="align-middle p-2">G</th>
                <th class="align-middle p-2">P</th>
                <th class="align-middle p-2">G</th>
                <th class="align-middle p-2">P</th>
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
                <th scope="col" class="align-middle py-0 px-2">16</th>
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
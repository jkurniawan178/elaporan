<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa24" cellspacing="0" width="100%">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" rowspan="2" class="align-middle p-2">No</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Sisa Bulan Lalu</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Diterima</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Dicabut</th>
                <th scope="col" colspan="3" class="align-middle p-2">Diputus</th>
                <th scope="colgroup" rowspan="2" class="align-middle p-2">Sisa / Masih Dalam Proses</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle p-2">Secara Elektronik</th>
                <th scope="col" class="align-middle p-2">Secara Biasa</th>
                <th scope="col" class="align-middle p-2">Jumlah</th>
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
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa23').DataTable({
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

            table.row.add([
                i + 1,
                addThousandSeparator(data[i].sisa_lalu),
                addThousandSeparator(data[i].diterima_bulan_ini),
                addThousandSeparator(data[i].dicabut),
                addThousandSeparator(data[i].putus_bulan_ini),
                addThousandSeparator(0),
                addThousandSeparator(data[i].putus_bulan_ini),
                addThousandSeparator(data[i].sisa_bulan_ini)
            ])
        }
        table.draw();
    }
</script>
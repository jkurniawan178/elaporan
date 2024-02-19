<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_monitoring_lama_perkara" cellspacing="0" width="100%">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" class="align-middle p-2">No</th>
                <th scope="col" class="align-middle p-2">Nomor Perkara</th>
                <th scope="col" class="align-middle p-2">Agenda</th>
                <th scope="col" class="align-middle p-2">Majelis Hakim</th>
                <th scope="col" class="align-middle p-2">Panitera Pengganti</th>
                <th scope="col" colspan="2" class="align-middle p-2">Lama Proses</th>
            </tr>
            <tr class="bg-warning">
                <th scope="col" class="align-middle py-0 px-2">1</th>
                <th scope="col" class="align-middle py-0 px-2">2</th>
                <th scope="col" class="align-middle py-0 px-2">3</th>
                <th scope="col" class="align-middle py-0 px-2">4</th>
                <th scope="col" class="align-middle py-0 px-2">5</th>
                <th scope="col" class="align-middle py-0 px-2">6</th>
                <th scope="col" class="align-middle py-0 px-2">7</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_monitoring_lama_perkara').DataTable({
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
        let valueData = data;
        for (var i = 0; i < valueData.length; i++) {
            // var row = valueData[i];
            table.row.add([
                i + 1,
                valueData[i].nomor_perkara,
                valueData[i].agenda,
                valueData[i].majelis_hakim_nama,
                valueData[i].panitera_pengganti,
                valueData[i].umur_perkara,
                'Hari'
            ])
        }
        table.draw();
    }
</script>
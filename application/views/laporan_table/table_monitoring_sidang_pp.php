<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_monitoring_sidang_pp" cellspacing="0" width="100%">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" class="align-middle p-2">No</th>
                <th scope="col" class="align-middle p-2">Nomor Perkara</th>
                <th scope="col" class="align-middle p-2">Jenis Perkara</th>
                <th scope="col" class="align-middle p-2">Tanggal Sidang</th>
                <th scope="col" class="align-middle p-2">Agenda Sidang</th>
                <th scope="col" class="align-middle p-2">Edoc BAS</th>
            </tr>
            <tr class="bg-warning">
                <th scope="col" class="align-middle py-0 px-2">1</th>
                <th scope="col" class="align-middle py-0 px-2">2</th>
                <th scope="col" class="align-middle py-0 px-2">3</th>
                <th scope="col" class="align-middle py-0 px-2">4</th>
                <th scope="col" class="align-middle py-0 px-2">5</th>
                <th scope="col" class="align-middle py-0 px-2">6</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_monitoring_sidang_pp').DataTable({
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
            let edoc_bas;
            let rowClass = '';
            if (valueData[i].edoc_bas != null) {
                edoc_bas = '<a href="' + valueData[i].edoc_bas + '" target="_blank">Download</a>';
            } else {
                edoc_bas = '';
                rowClass = 'bg-danger text-white';
            }
            table.row.add([
                i + 1,
                valueData[i].nomor_perkara,
                valueData[i].jenis_perkara_text,
                formatDate(valueData[i].tanggal_sidang),
                valueData[i].agenda,
                edoc_bas
            ]).node().className = rowClass;
        }
        table.draw();
    }
</script>
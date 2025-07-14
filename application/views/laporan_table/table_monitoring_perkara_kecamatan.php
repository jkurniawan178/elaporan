<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_monitoring_perkara_kecamatan" cellspacing="0" width="100%">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" class="align-middle p-2">No</th>
                <th scope="col" class="align-middle p-2">Nama Kecamatan</th>
                <th scope="col" class="align-middle p-2">Cerai Talak</th>
                <th scope="col" class="align-middle p-2">Cerai Gugat</th>
                <th scope="col" class="align-middle p-2">Itsbat Nikah</th>
                <th scope="col" class="align-middle p-2">Dispensasi Kawin</th>
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
        const table = $('#table_monitoring_perkara_kecamatan').DataTable({
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

            table.row.add([
                i + 1,
                valueData[i].nama_kecamatan,
                valueData[i].Cerai_Talak,
                valueData[i].Cerai_Gugat,
                valueData[i].Itsbat_Nikah,
                valueData[i].Dispensasi_Kawin
            ]);
        }
        table.draw();
    }
</script>
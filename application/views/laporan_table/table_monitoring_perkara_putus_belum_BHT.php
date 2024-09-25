<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_monitoring_bht" cellspacing="0" width="100%">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" class="align-middle p-2">No</th>
                <th scope="col" class="align-middle p-2">Nomor Perkara</th>
                <th scope="col" class="align-middle p-2">Jenis Perkara</th>
                <th scope="col" class="align-middle p-2">Tanggal Putusan</th>
                <th scope="col" class="align-middle p-2">Jenis Putusan</th>
                <th scope="col" class="align-middle p-2">Panitera Pengganti</th>
                <th scope="col" class="align-middle p-2">Tanggal PBT</th>
                <th scope="col" class="align-middle p-2">Tanggal BHT</th>
                <th scope="col" class="align-middle p-2">Selisih Hari</th>
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
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_monitoring_bht').DataTable({
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
            let rowClass = '';
            if (valueData[i].selisih_belum_BHT >= 20) {
                rowClass = 'bg-danger text-white';
            } else if (valueData[i].selisih_belum_BHT >= 14) {
                rowClass = 'bg-warning text-white';
            }

            table.row.add([
                i + 1,
                valueData[i].nomor_perkara,
                valueData[i].jenis_perkara_nama,
                formatDate(valueData[i].tanggal_putusan),
                valueData[i].jenis_putusan,
                valueData[i].PP,
                formatDate(valueData[i].PBT),
                formatDate(valueData[i].tanggal_bht),
                valueData[i].selisih_belum_BHT
            ]).node().className = rowClass;
        }
        table.draw();
    }
</script>
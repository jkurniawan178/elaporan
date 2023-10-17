<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_penyerahan_ac" cellspacing="0" width="100%">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" rowspan="2" class="align-middle p-2">No</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Nomor Perkara</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Nomor Akta Cerai</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Jenis Cerai</th>
                <th scope="colgroup" colspan="3" class="align-middle p-2">Tanggal Penetapan</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Tanggal Penyerahan</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Penerima</th>
                <th scope="col" rowspan="2" class="align-middle p-2">Ket</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle p-2">Putusan</th>
                <th scope="col" class="align-middle p-2">Ikrar Talak</th>
                <th scope="col" class="align-middle p-2">BHT</th>
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
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_penyerahan_ac').DataTable({
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
                valueData[i].nomor_akta_cerai,
                valueData[i].jenis_cerai,
                formatDate(valueData[i].tanggal_putusan),
                formatDate(valueData[i].tgl_ikrar_talak),
                formatDate(valueData[i].tanggal_bht),
                formatDate(valueData[i].tgl_penyerahan),
                valueData[i].penerima,
                "-"
            ])
        }
        table.draw();
    }
</script>
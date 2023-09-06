<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa13">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" class="align-middle p-2">No.</th>
                <th scope="col" class="align-middle p-2">Nomor Akta Cerai</th>
                <th scope="col" class="align-middle p-2">Tanggal Terbit</th>
                <th scope="col" class="align-middle p-2">No. Seri</th>
                <th scope="col" class="align-middle p-2">Nomor Perkara</th>
                <th scope="col" class="align-middle p-2">Tanggal Putus</th>
                <th scope="col" class="align-middle p-2">Tanggal BHT</th>
                <th scope="col" class="align-middle p-2">Tanggal Ikrar</th>
                <th scope="col" class="align-middle p-2">Keterangan</th>
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
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa13').DataTable({
            order: [
                [0, 'asc']
            ],
            "bFilter": false,
            columnDefs: [{
                    className: "align-middle",
                    targets: ["_all"]
                } // Apply class to specific columns
            ],
        });
        console.log(data);
        table.clear();
        // Loop through the received data and create rows for the table
        for (let i = 0; i < data.length; i++) {

            table.row.add([
                i + 1,
                data[i].nomor_akta_cerai,
                formatDate(data[i].tgl_terbit_ac),
                data[i].no_seri_akta_cerai,
                data[i].nomor_perkara,
                formatDate(data[i].tanggal_putusan),
                formatDate(data[i].tanggal_bht),
                formatDate(data[i].tgl_ikrar_talak),
                "-"
            ])
        }
        table.draw();
    }
</script>
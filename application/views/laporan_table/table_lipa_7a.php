<div class="table-responsive">
    <div class="d-flex justify-content-lg-center">
        <table class="text-center table table-striped table-bordered" id="table_lipa7a" style="width: 800px;">
            <thead class="bg-success">
                <tr>
                    <th class="align-middle" rowspan="3" align="center" style="max-width: 20px;">No Urut</th>
                    <th class="align-middle" rowspan="3" align="center" style="min-width: 250px;">Uraian</th>
                    <th class="align-middle" colspan="2" align="center">Jumlah</th>
                </tr>
                <tr>
                    <th class="align-middle py-0">Penerimaan</th>
                    <th class="align-middle py-0">Pengeluaran</th>
                </tr>
                <tr>
                    <th class="align-middle py-0">(Rp)</th>
                    <th class="align-middle py-0">(Rp)</th>
                </tr>
                <tr class="bg-warning">
                    <th scope="col" class="align-middle py-0">1</th>
                    <th scope="col" class="align-middle py-0">2</th>
                    <th scope="col" class="align-middle py-0">3</th>
                    <th scope="col" class="align-middle py-0">4</th>
                </tr>
            </thead>
            <tbody id="show_data"></tbody>
        </table>
    </div>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa7a').DataTable({
            "paging": false,
            "bFilter": false,
            "searching": false,
            "ordering": false,
            columnDefs: [{
                className: "align-middle",
                targets: ["_all"]
            }, ]
        });
        table.clear();
        // Loop through the received data and create rows for the table
        for (let i = 0; i < data.length; i++) {

            table.row.add([
                data[i].no,
                data[i].Keterangan,
                addThousandSeparator(data[i].jumlah_debet),
                addThousandSeparator(data[i].jumlah_kredit)
            ])
        }
        table.draw();
    }
</script>
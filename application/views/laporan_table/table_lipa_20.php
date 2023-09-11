<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa20">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" class="align-middle p-2" rowspan="2">No.</th>
                <th scope="col" class="align-middle p-2" colspan="4">Jumlah Perkara Yang Diselesaikan</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle p-2">Diputus s/d 3 Bulan</th>
                <th scope="col" class="align-middle p-2">Diputus 3-5 Bulan</th>
                <th scope="col" class="align-middle p-2">Diputus Lebih dari 5 Bulan</th>
                <th scope="col" class="align-middle p-2">Belum Putus Lebih Dari 5 Bulan</th>
            </tr>
            <tr class="bg-warning">
                <th scope="col" class="align-middle py-0 px-2">1</th>
                <th scope="col" class="align-middle py-0 px-2">2</th>
                <th scope="col" class="align-middle py-0 px-2">3</th>
                <th scope="col" class="align-middle py-0 px-2">4</th>
                <th scope="col" class="align-middle py-0 px-2">5</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa20').DataTable({
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
        table.clear();
        // Loop through the received data and create rows for the table
        for (let i = 0; i < data.length; i++) {
            table.row.add([
                i + 1,
                addThousandSeparator(data[i].putus_3_bln),
                addThousandSeparator(data[i].putus_3_5_bln),
                addThousandSeparator(data[i].putus_lebih_5_bln),
                addThousandSeparator(data[i].blm_putus_lebih_5_bln),
            ])
        }
        table.draw();
    }
</script>
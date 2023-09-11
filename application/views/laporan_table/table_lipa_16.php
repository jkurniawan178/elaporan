<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa16">
        <thead class="bg-success text-dark">
            <tr>
                <th scope="col" class="align-middle p-2">No.</th>
                <th scope="col" class="align-middle p-2">Pagu Awal(Rp)</th>
                <th scope="col" class="align-middle p-2">Pagu Revisi (Rp)</th>
                <th scope="col" class="align-middle p-2">Realisasi s/d Bulan Lalu</th>
                <th scope="col" class="align-middle p-2">Realisasi Bulan Ini</th>
                <th scope="col" class="align-middle p-2">Jumlah (Rp)</th>
                <th scope="col" class="align-middle p-2">Sisa</th>
                <th scope="col" class="align-middle p-2">Target</th>
                <th scope="col" class="align-middle p-2">Jumlah Layanan</th>
                <th scope="col" class="align-middle p-2">Ket</th>
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
        const table = $('#table_lipa16').DataTable({
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
                addThousandSeparator(data[i].pagu_awal),
                addThousandSeparator(data[i].pagu_revisi),
                addThousandSeparator(data[i].realisasi_sampai_bulan_lalu),
                addThousandSeparator(data[i].realisasi),
                addThousandSeparator(data[i].jumlah_realisasi),
                addThousandSeparator(data[i].saldo),
                addThousandSeparator(data[i].target_layanan),
                addThousandSeparator(data[i].jml_layanan),
                addThousandSeparator(data[i].keterangan)
            ])
        }
        table.draw();
    }
</script>
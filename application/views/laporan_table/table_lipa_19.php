<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa19">
        <thead class="bg-success text-dark">
            <tr>
                <th class="align-middle p-2" rowspan="3">No.</th>
                <th class="align-middle p-2" rowspan="3">Nomor Perkara</th>
                <th class="align-middle p-2" rowspan="3" style="min-width: 250px;">Majelis Hakim</th>
                <th class="align-middle p-2" colspan="4">Tanggal</th>
                <th class="align-middle p-2" rowspan="2" colspan="2">Sisa</th>
                <th class="align-middle p-2" rowspan="3">Ket</th>
            </tr>
            <tr>
                <th scope="col" colspan="2" class="align-middle p-2">Putusan</th>
                <th scope="col" colspan="2" class="align-middle p-2">Minutasi</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle p-2">G</th>
                <th scope="col" class="align-middle p-2">P</th>
                <th scope="col" class="align-middle p-2">G</th>
                <th scope="col" class="align-middle p-2">P</th>
                <th scope="col" class="align-middle p-2">G</th>
                <th scope="col" class="align-middle p-2">P</th>
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
        const table = $('#table_lipa19').DataTable({
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

            if (data[i].minutasi_g == null && data[i].putus_g != null) {
                data[i].sisa_g = 1
            } else if (data[i].minutasi_p == null && data[i].putus_p != null) {
                data[i].sisa_p = 1
            }

            table.row.add([
                i + 1,
                data[i].nomor_perkara,
                data[i].majelis_hakim,
                formatDate(data[i].putus_g),
                formatDate(data[i].putus_p),
                formatDate(data[i].minutasi_g),
                formatDate(data[i].minutasi_p),
                addThousandSeparator(data[i].sisa_g),
                addThousandSeparator(data[i].sisa_p),
                "-"
            ])
        }
        table.draw();
    }
</script>
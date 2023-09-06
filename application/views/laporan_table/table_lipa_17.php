<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa17">
        <thead class="bg-success text-dark">
            <tr>
                <th class="align-middle p-2" rowspan="2">No.</th>
                <th class="align-middle p-2" colspan="5">Hak-Hak Kepaniteraan (HHK)</th>
                <th class="align-middle p-2" rowspan="2">Jumlah (Rp)</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle p-2">Pendaftaran Tingkat Pertama (Rp)</th>
                <th scope="col" class="align-middle p-2">Pendaftaran Banding (Rp)</th>
                <th scope="col" class="align-middle p-2">Pendaftaran Kasasi (Rp)</th>
                <th scope="col" class="align-middle p-2">Pendaftaran PK (Rp)</th>
                <th scope="col" class="align-middle p-2">Pendaftaran Eksekusi (Rp)</th>
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
        const table = $('#table_lipa17').DataTable({
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
            data[i].eksekusi = parseInt(data[i].pendaftaran_eksekusi) +
                parseInt(data[i].pendaftaran_eksekusi_ht);

            table.row.add([
                i + 1,
                addThousandSeparator(parseInt(data[i].pendaftaran)),
                addThousandSeparator(parseInt(data[i].pendaftaran_banding)),
                addThousandSeparator(parseInt(data[i].pendaftaran_kasasi)),
                addThousandSeparator(parseInt(data[i].pendaftaran_pk)),
                addThousandSeparator(parseInt(data[i].eksekusi)),
                addThousandSeparator(parseInt(data[i].jumlah))
            ])
        }
        table.draw();
    }
</script>
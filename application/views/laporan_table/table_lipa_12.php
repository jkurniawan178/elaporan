<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa12">
        <thead class="bg-success text-dark">
            <tr>
                <th class="align-middle p-2" rowspan="2">No.</th>
                <th class="align-middle p-2" rowspan="2">Sisa Perkara Lalu</th>
                <th class="align-middle p-2" rowspan="2">Perkara Diterima Bulan Ini</th>
                <th class="align-middle p-2" rowspan="2">Jumlah Perkara Yang Tidak Bisa Dimediasi</th>
                <th class="align-middle p-2" rowspan="2">Jumlah Perkara Yang Dimediasi</th>
                <th class="align-middle p-2" colspan="3">Laporan Penyelesaian Mediasi</th>
                <th class="align-middle p-2" rowspan="2">Masih Dalam Proses Mediasi</th>
                <th class="align-middle p-2" rowspan="2">Sisa Perkara</th>
                <th class="align-middle p-2" rowspan="2">Ket</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle p-2">Tidak Berhasil</th>
                <th scope="col" class="align-middle p-2">Berhasil</th>
                <th scope="col" class="align-middle p-2">Gagal</th>
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
                <th scope="col" class="align-middle py-0">10</th>
                <th scope="col" class="align-middle py-0">11</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa12').DataTable({
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
            data[i].perkara_mediasi = parseInt(data[i].perkara_mediasi) +
                parseInt(data[i].sisa_mediasi_lalu);
            data[i].tidak_mediasi = parseInt(data[i].sisa_lalu) +
                parseInt(data[i].diterima_bulan_ini) -
                data[i].perkara_mediasi;
            data[i].sisa_perkara = parseInt(data[i].sisa_lalu) +
                parseInt(data[i].diterima_bulan_ini) -
                parseInt(data[i].putus_bulan_ini);

            table.row.add([
                i + 1,
                addThousandSeparator(data[i].sisa_lalu),
                addThousandSeparator(data[i].diterima_bulan_ini),
                addThousandSeparator(data[i].tidak_mediasi),
                addThousandSeparator(data[i].perkara_mediasi),
                addThousandSeparator(data[i].tidak_berhasil),
                addThousandSeparator(data[i].berhasil),
                addThousandSeparator(data[i].gagal),
                addThousandSeparator(data[i].perkara_proses_mediasi),
                addThousandSeparator(data[i].sisa_perkara),
                "-"
            ])
        }
        table.draw();
    }
</script>
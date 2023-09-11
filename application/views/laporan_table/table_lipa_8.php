<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa8">
        <thead class="bg-success text-dark">
            <tr>
                <th class="align-middle p-2" rowspan="2">Kode</th>
                <th class="align-middle p-2" rowspan="2" style="min-width: 100px;">Jenis perkara</th>
                <th class="align-middle p-2" colspan="3">Banyaknya perkara</th>
                <th class="align-middle p-2" colspan="7">Dicabut dan di Putus bulan ini</th>
                <th class="align-middle p-2" rowspan="2">Sisa akhir bulan 5-12</th>
                <th class="align-middle p-2" rowspan="2">Banding</th>
                <th class="align-middle p-2" rowspan="2">Kasasi</th>
                <th class="align-middle p-2" rowspan="2">PK</th>
                <th class="align-middle p-2" rowspan="2">Ket.&nbsp;</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle p-2">Sisa bulan lalu</th>
                <th scope="col" class="align-middle p-2">Diterima bulan ini</th>
                <th scope="col" class="align-middle p-2">Jumlah</th>
                <th scope="col" class="align-middle p-2">Dicabut</th>
                <th scope="col" class="align-middle p-2">Dikabulkan</th>
                <th scope="col" class="align-middle p-2">Ditolak</th>
                <th scope="col" class="align-middle p-2">Tidak Diterima</th>
                <th scope="col" class="align-middle p-2">Digugurkan</th>
                <th scope="col" class="align-middle p-2">Dicoret dari register</th>
                <th scope="col" class="align-middle p-2">Jumlah lajur 6 s/d 10</th>
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
                <th scope="col" class="align-middle py-0 px-2">11</th>
                <th scope="col" class="align-middle py-0 px-2">12</th>
                <th scope="col" class="align-middle py-0 px-2">13</th>
                <th scope="col" class="align-middle py-0 px-2">14</th>
                <th scope="col" class="align-middle py-0 px-2">15</th>
                <th scope="col" class="align-middle py-0 px-2">16</th>
                <th scope="col" class="align-middle py-0 px-2">17</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa8').DataTable({
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

            data[i].jml_perkara = parseInt(data[i].sisa_lalu) + parseInt(data[i].diterima_bulan_ini);
            data[i].jml_lajur = parseInt(data[i].dicabut) + parseInt(
                data[i].dikabulkan) + parseInt(
                data[i].ditolak) + parseInt(
                data[i].tidak_dapat_diterima) + parseInt(
                data[i].digugurkan) + parseInt(
                data[i].dicoret_dari_register);
            data[i].sisa_perkara = parseInt(data[i].jml_perkara) - parseInt(data[i].jml_lajur);

            table.row.add([
                i + 1,
                data[i].jenis_perkara,
                addThousandSeparator(data[i].sisa_lalu),
                addThousandSeparator(data[i].diterima_bulan_ini),
                addThousandSeparator(data[i].jml_perkara),
                addThousandSeparator(data[i].dicabut),
                addThousandSeparator(data[i].dikabulkan),
                addThousandSeparator(data[i].ditolak),
                addThousandSeparator(data[i].tidak_dapat_diterima),
                addThousandSeparator(data[i].digugurkan),
                addThousandSeparator(data[i].dicoret_dari_register),
                addThousandSeparator(data[i].jml_lajur),
                addThousandSeparator(data[i].sisa_perkara),
                addThousandSeparator(data[i].bandingnya),
                addThousandSeparator(data[i].kasasinya),
                addThousandSeparator(data[i].pk),
                "-"

            ])
        }
        table.draw();
    }
</script>
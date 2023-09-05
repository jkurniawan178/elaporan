<style>
    .vertical-text {
        height: 200px;
        white-space: nowrap;
        writing-mode: vertical-rl;
        transform: rotate(180deg);
        text-align: center;
    }
</style>
<div class="table-responsive">
    <table class="text-center table table-bordered" id="table_lipa9" style="border-collapse: collapse !important;">
        <thead class="bg-success text-dark">
            <tr>
                <th rowspan="4" class="vertical-text align-middle">Nomor</th>
                <th rowspan="2" colspan="6" class="align-middle">JENIS PERKARA</th>
                <th rowspan="4" class="vertical-text align-middle">Jumlah</th>
                <th rowspan="2" colspan="3" class="align-middle">DIPUTUS</th>
                <th rowspan="4" class="vertical-text align-middle">Jumlah</th>
                <th rowspan="2" colspan="3" class="align-middle">SISA</th>
                <th rowspan="4" class="vertical-text align-middle">Jumlah</th>
                <th rowspan="1" colspan="4" class="align-middle">PERKARA YANG DIPUTUS</th>
            </tr>
            <tr>
                <th colspan="2" class="align-middle">PENGGUGAT/<br>PEMOHON</th>
                <th colspan="2" class="align-middle">TERGUGAT/<br>TERMOHON</th>
            </tr>
            <tr>
                <th class="vertical-text align-middle" colspan="2">Izin Poligami</th>
                <th class="vertical-text align-middle" colspan="2">Cerai Talak </th>
                <th class="vertical-text align-middle" colspan="2">Cerai Gugat</th>
                <th class="vertical-text align-middle" rowspan="2">Izin Poligami </th>
                <th class="vertical-text align-middle" rowspan="2">Cerai Talak </th>
                <th class="vertical-text align-middle" rowspan="2">Cerai Gugat</th>
                <th class="vertical-text align-middle" rowspan="2">Izin Poligami </th>
                <th class="vertical-text align-middle" rowspan="2">Cerai Talak </th>
                <th class="vertical-text align-middle" rowspan="2">Cerai Gugat </th>
                <th class="vertical-text align-middle" rowspan="2">Ada Izin Pejabat</th>
                <th class="vertical-text align-middle" rowspan="2">Tidak Ada Izin Pejabat </th>
                <th class="vertical-text align-middle" rowspan="2">Ada Keterangan Pejabat </th>
                <th class="vertical-text align-middle" rowspan="2">Tidak Ada Keterangan Pejabat </th>
            </tr>
            <tr>
                <th class="align-middle py-1 text-center">Sisa</th>
                <th class="align-middle py-1 text-center">Terima</th>
                <th class="align-middle py-1 text-center">Sisa</th>
                <th class="align-middle py-1 text-center">Terima</th>
                <th class="align-middle py-1 text-center">Sisa</th>
                <th class="align-middle py-1 text-center">Terima</th>
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
                <th scope="col" class="align-middle py-0">12</th>
                <th scope="col" class="align-middle py-0">13</th>
                <th scope="col" class="align-middle py-0">14</th>
                <th scope="col" class="align-middle py-0">15</th>
                <th scope="col" class="align-middle py-0">16</th>
                <th scope="col" class="align-middle py-0">17</th>
                <th scope="col" class="align-middle py-0">18</th>
                <th scope="col" class="align-middle py-0">19</th>
                <th scope="col" class="align-middle py-0">20</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa9').DataTable({
            "paging": false,
            "bFilter": false,
            "searching": false,
            "ordering": false,
            columnDefs: [{
                    className: "align-middle",
                    targets: ["_all"]
                } // Apply class to specific columns
            ],
        });
        table.clear();
        // Loop through the received data and create rows for the table
        console.log(data)
        for (let i = 0; i < data.length; i++) {

            data[i].jml_putus = parseInt(data[i].putus_poligami) +
                parseInt(data[i].putus_talak) +
                parseInt(data[i].putus_gugat);
            data[i].jml_terima = parseInt(data[i].sisa_poligami) +
                parseInt(data[i].masuk_poligami) +
                parseInt(data[i].sisa_talak) +
                parseInt(data[i].masuk_talak) +
                parseInt(data[i].sisa_gugat) +
                parseInt(data[i].masuk_gugat);
            data[i].saldo_poligami = parseInt(data[i].sisa_poligami) +
                parseInt(data[i].masuk_poligami) -
                parseInt(data[i].putus_poligami);
            data[i].saldo_gugat = parseInt(data[i].sisa_gugat) +
                parseInt(data[i].masuk_gugat) -
                parseInt(data[i].putus_gugat);
            data[i].saldo_talak = parseInt(data[i].sisa_talak) +
                parseInt(data[i].masuk_talak) -
                parseInt(data[i].putus_talak);
            data[i].jml_sisa = parseInt(data[i].sisa_gugat) +
                parseInt(data[i].sisa_poligami) +
                parseInt(data[i].sisa_talak);

            table.row.add([
                i + 1,
                data[i].sisa_poligami,
                data[i].masuk_poligami,
                data[i].sisa_talak,
                data[i].masuk_talak,
                data[i].sisa_gugat,
                data[i].masuk_gugat,
                data[i].jml_terima,
                data[i].putus_poligami,
                data[i].putus_talak,
                data[i].putus_gugat,
                data[i].jml_putus,
                data[i].saldo_poligami,
                data[i].saldo_talak,
                data[i].saldo_gugat,
                data[i].jml_sisa,
                data[i].pemohonizin,
                data[i].pemohontidakizin,
                data[i].termohonizin,
                data[i].termohontidakizin
            ])
        }
        table.draw();
    }
</script>
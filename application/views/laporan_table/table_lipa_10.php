<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa10">
        <thead class="bg-success text-dark">
            <tr>
                <th class="align-middle p-2" rowspan="2">No.</th>
                <th class="align-middle p-2" colspan="13">Penyebab Terjadinya Perceraian</th>
                <th class="align-middle p-2" rowspan="2">Jumlah</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle p-2">Zina</th>
                <th scope="col" class="align-middle p-2">Mabuk</th>
                <th scope="col" class="align-middle p-2">Madat</th>
                <th scope="col" class="align-middle p-2">Judi</th>
                <th scope="col" class="align-middle p-2">Meninggalkan Salah Satu Pihak</th>
                <th scope="col" class="align-middle p-2">Dihukum Penjara</th>
                <th scope="col" class="align-middle p-2">Poligami</th>
                <th scope="col" class="align-middle p-2">KDRT</th>
                <th scope="col" class="align-middle p-2">Cacat Badan</th>
                <th scope="col" class="align-middle p-2">Perselisihan Dan Pertengkaran Terus Menerus</th>
                <th scope="col" class="align-middle p-2">Kawin Paksa</th>
                <th scope="col" class="align-middle p-2">Murtad</th>
                <th scope="col" class="align-middle p-2">Ekonomi</th>
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
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa10').DataTable({
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
                addThousandSeparator(data[i].zina),
                addThousandSeparator(data[i].mabuk),
                addThousandSeparator(data[i].madat),
                addThousandSeparator(data[i].judi),
                addThousandSeparator(data[i].meninggalkan),
                addThousandSeparator(data[i].dihukum),
                addThousandSeparator(data[i].poligami),
                addThousandSeparator(data[i].kdrt),
                addThousandSeparator(data[i].cacat),
                addThousandSeparator(data[i].perselisihan),
                addThousandSeparator(data[i].kawin_paksa),
                addThousandSeparator(data[i].murtad),
                addThousandSeparator(data[i].ekonomi),
                addThousandSeparator(data[i].jumlah)
            ])
        }
        table.draw();
    }
</script>
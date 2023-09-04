    <div class="table-responsive">
        <table class="text-center table table-striped table-bordered" id="table_lipa2">
            <thead class="bg-success">
                <tr>
                    <th scope="col" rowspan="2" class="align-middle">No</th>
                    <th scope="col" rowspan="2" class="align-middle">Nomor Perkara PA</th>
                    <th scope="col" rowspan="2" class="align-middle" style="min-width: 250px;">Nama Majelis Hakim</th>
                    <th colspan="8" scope="colgroup" class="align-middle">Tanggal</th>
                    <th scope="col" rowspan="2" class="align-middle">Ket</th>
                </tr>
                <tr>
                    <th scope="col" class="align-middle">Putusan PA</th>
                    <th scope="col" class="align-middle">Permohonan Banding</th>
                    <th scope="col" class="align-middle">Pemberitahuan Inzage</th>
                    <th scope="col" class="align-middle">Pengiriman Berkas PTA</th>
                    <th scope="col" class="align-middle">Putusan Banding/Cabut</th>
                    <th scope="col" class="align-middle">Penerimaan Kembali di PA</th>
                    <th scope="col" class="align-middle">Pemberitahuan ke Para Pihak</th>
                    <th scope="col" class="align-middle">Penyampaian FC Relas PBT ke PTA</th>
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
                </tr>
            </thead>
            <tbody id="show_data"></tbody>
        </table>
    </div>
    <script>
        function generateTableRows(data) {
            const table = $('#table_lipa2').DataTable({
                order: [
                    [0, 'asc']
                ],
                "bFilter": false,
                columnDefs: [{
                        className: "align-middle",
                        targets: ["_all"]
                    } // Apply class to specific columns
                ]
            });
            table.clear();

            // Loop through the received data and create rows for the table
            for (var i = 0; i < data.length; i++) {

                if (data[i].tanggal_cabut === "" || data[i].tanggal_cabut === null) {
                    data[i].keterangan = "-";
                } else {
                    data[i].keterangan = "cabut tanggal : " + formatDate(data[i].tanggal_cabut);
                }

                table.row.add([
                    i + 1,
                    data[i].nomor_perkara_pn,
                    data[i].majelis_hakim_nama,
                    formatDate(data[i].putusan_pn),
                    formatDate(data[i].permohonan_banding),
                    `P: ${formatDate(data[i].pbt_inzage_p)}<br/> T: ${formatDate(data[i].pbt_inzage_t)}`,
                    formatDate(data[i].pengiriman_berkas_banding),
                    formatDate(data[i].putusan_banding),
                    formatDate(data[i].penerimaan_kembali_berkas_banding),
                    `P: ${formatDate(data[i].pbt_banding_p)} <br/> T: ${formatDate(data[i].pbt_banding_t)}`,
                    "-",
                    data[i].keterangan
                ])
            }

            table.draw();
        }
    </script>
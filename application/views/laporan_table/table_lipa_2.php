    <div class="table-responsive">
        <table class="text-center table table-striped table-bordered" id="table_lipa2">
            <thead class="bg-success text-dark">
                <tr>
                    <th scope="col" rowspan="2" class="align-middle p-2">No</th>
                    <th scope="col" rowspan="2" class="align-middle p-2">Nomor Perkara PA</th>
                    <th scope="col" rowspan="2" class="align-middle p-2" style="min-width: 250px;">Nama Majelis Hakim</th>
                    <th colspan="8" scope="colgroup" class="align-middle p-2">Tanggal</th>
                    <th scope="col" rowspan="2" class="align-middle p-2">Ket</th>
                </tr>
                <tr>
                    <th scope="col" class="align-middle p-2">Putusan PA</th>
                    <th scope="col" class="align-middle p-2">Permohonan Banding</th>
                    <th scope="col" class="align-middle p-2">Pemberitahuan Inzage</th>
                    <th scope="col" class="align-middle p-2">Pengiriman Berkas PTA</th>
                    <th scope="col" class="align-middle p-2">Putusan Banding/Cabut</th>
                    <th scope="col" class="align-middle p-2">Penerimaan Kembali di PA</th>
                    <th scope="col" class="align-middle p-2">Pemberitahuan ke Para Pihak</th>
                    <th scope="col" class="align-middle p-2">Penyampaian FC Relas PBT ke PTA</th>
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
                </tr> px-2
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
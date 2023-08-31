    <h2 class="text-center">PREVIEW LAPORAN YANG DIMOHONKAN BANDING</h2>
    <h2 class="text-center">PADA PENGADILAN AGAMA TERNATE</h2>
    <h2 class="text-center">BULAN JANUARI 2023</h2>
    <h4 class="text-right">Lipa.2</h4>
    <div class="table-responsive">
        <table class="text-center table table-striped table-bordered" id="table_lipa2" cellspacing="0" width="100%">
            <thead class="table-success">
                <tr>
                    <th scope="col" rowspan="2" class="align-middle">No</th>
                    <th scope="col" rowspan="2" class="align-middle">Nomor Perkara PA</th>
                    <th scope="col" rowspan="2" class="align-middle">Nama Majelis Hakim</th>
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
            </thead>
            <tbody id="show_data"></tbody>
        </table>
    </div>
    <script>
        function generateTableRows(data) {
            var tableContent = "";

            // Loop through the received data and create rows for the table
            for (var i = 0; i < data.length; i++) {
                var row = data[i];
                tableContent += "<tr>";
                tableContent += "<td class='align-middle'>" + (i + 1) + "</td>"; // Increment i to show a 1-based index
                tableContent += "<td class='align-middle'>" + row.nomor_perkara_pn + "</td>";
                tableContent += "<td class='align-middle'>" + row.majelis_hakim_nama + "</td>";
                tableContent += "<td class='align-middle'>" + formatDate(row.putusan_pn) + "</td>";
                tableContent += "<td class='align-middle'>" + formatDate(row.permohonan_banding) + "</td>";
                tableContent += "<td class='align-middle'>" + "P: " + formatDate(row.pbt_inzage_p) + "<br/> T: " + formatDate(row.pbt_inzage_t) + "</td>";
                tableContent += "<td class='align-middle'>" + formatDate(row.pengiriman_berkas_banding) + "</td>";

                if (row.tanggal_cabut === "" || row.tanggal_cabut === null) {
                    tableContent += "<td class='align-middle'>" + formatDate(row.putusan_banding) + "</td>";
                } else {
                    tableContent += "<td class='align-middle'>" + formatDate(row.tanggal_cabut) + "</td>";
                }

                tableContent += "<td class='align-middle'>" + formatDate(row.penerimaan_kembali_berkas_banding) + "</td>";
                tableContent += "<td class='align-middle'>" + "P: " + formatDate(row.pbt_banding_p) + "<br/> T: " + formatDate(row.pbt_banding_t) + "</td>";
                tableContent += "<td class='align-middle'>" + "-" + "</td>";
                tableContent += "<td class='align-middle'>" + "-" + "</td>";
                tableContent += "</tr>";
            }

            return tableContent;
        }
    </script>
<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa2">
        <thead class="bg-success">
            <tr>
                <th scope="col" rowspan="2" class="align-middle">No</th>
                <th scope="col" colspan="2" class="align-middle">Nomor Perkara</th>
                <th colspan="7" scope="colgroup" class="align-middle">Tanggal</th>
                <th scope="col" rowspan="2" class="align-middle">Ket</th>
            </tr>
            <tr>
                <th scope="col" class="align-middle">Tingkat Pertama</th>
                <th scope="col" class="align-middle">Tingkat Banding</th>
                <th scope="col" class="align-middle">Permohonan Kasasi</th>
                <th scope="col" class="align-middle">Penerimaan Memori Kasasi</th>
                <th scope="col" class="align-middle">Penetapan Tidak Memenuhi Syarat Formal</th>
                <th scope="col" class="align-middle">Pengiriman Berkas ke MA</th>
                <th scope="col" class="align-middle">Putus Kasasi</th>
                <th scope="col" class="align-middle">Penerimaan Kembali Berkas Kasasi di PA</th>
                <th scope="col" class="align-middle">Pemberitahuan ke Para Pihak</th>
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
        var tableContent = "";

        // Loop through the received data and create rows for the table
        for (var i = 0; i < data.length; i++) {
            var row = data[i];
            tableContent += "<tr>";
            tableContent += "<td class='align-middle'>" + (i + 1) + "</td>"; // Increment i to show a 1-based index
            tableContent += "<td class='align-middle'>" + row.nomor_perkara_pn + "</td>";
            tableContent += "<td class='align-middle'>" + row.nomor_putusan_banding + "</td>";
            tableContent += "<td class='align-middle'>" + formatDate(row.permohonan_kasasi) + "</td>";
            tableContent += "<td class='align-middle'>" + formatDate(row.penerimaan_memori_kasasi) + "</td>";
            tableContent += "<td class='align-middle'>" + formatDate(row.tidak_memenuhi_syarat) + "</td>";
            tableContent += "<td class='align-middle'>" + formatDate(row.pengiriman_berkas_kasasi) + "</td>";
            tableContent += "<td class='align-middle'>" + formatDate(row.putusan_kasasi) + "</td>";
            tableContent += "<td class='align-middle'>" + formatDate(row.penerimaan_berkas_kasasi) + "</td>";
            tableContent += "<td class='align-middle'>" + "P: " + formatDate(row.pbt_putusan_p) + "<br/> T: " + formatDate(row.pbt_putusan_t) + "</td>";
            if (row.tanggal_cabut === "" || row.tanggal_cabut === null) {
                tableContent += "<td class='align-middle'>" + "-" + "</td>";
            } else {
                tableContent += "<td class='align-middle'>" + "cabut tanggal : " + formatDate(row.tanggal_cabut) + "</td>";
            }
            tableContent += "</tr>";
        }

        return tableContent;
    }
</script>
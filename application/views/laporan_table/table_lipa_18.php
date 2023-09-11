<div class="table-responsive">
    <table class="text-center table table-striped table-bordered" id="table_lipa18">
        <thead class="bg-success text-dark">
            <tr>
                <th class="align-middle p-2" rowspan="2">No.</th>
                <th class="align-middle p-2" colspan="17">HHKL</th>
                <th class="align-middle p-2" rowspan="2">Jumlah (Rp)</th>
            </tr>
            <tr>
                <th class="align-middle p-2" scope="col">Penyerahan turunan/ salinan putusan/penetapan</th>
                <th class="align-middle p-2" scope="col">Hak redaksi</th>
                <th class="align-middle p-2" scope="col">Memperlihatkan surat kepada yang berkepentingan mengenai surat-surat yang tersimpan kepaniteraan</th>
                <th class="align-middle p-2" scope="col">Mencarikan surat yang tersimpan diarsip yang tidak dimintakan turunan</th>
                <th class="align-middle p-2" scope="col">Pembuatan akta dimana seorang menyatakan menerima keputusan dalam perkara pelanggaran</th>
                <th class="align-middle p-2" scope="col">Penyitaan/eksekusi barang yang bergerak atau tidak bergerak untuk pencatatan pencabutan suatu penyitaan didalam berita turunan</th>
                <th class="align-middle p-2" scope="col">Melakukan penjualan dimuka umum /lelang atas perintah pengadilan</th>
                <th class="align-middle p-2" scope="col">Penyimpanan dan penyerahan kembali uang atau surat berharga yang disimpan di kepaniteraan</th>
                <th class="align-middle p-2" scope="col">Pencatatan pembuatan akta atau berita acara penyumpahan atau putusan lainnya yang bukan keputusan pengadilan</th>
                <th class="align-middle p-2" scope="col">Pencatatan : Sesuatu penyerahan akta di kepaniteraan yang dilakukan didalam hal yang diharuskan menurut hukum</th>
                <th class="align-middle p-2" scope="col">Pencatatan Penyerahan akta tersebut dalam kolom 11 panitera/ juru sita</th>
                <th class="align-middle p-2" scope="col">Pencatatan Penyerahan surat dari berkas perkara</th>
                <th class="align-middle p-2" scope="col">Akta asli yang dibuat di kepaniteraan</th>
                <th class="align-middle p-2" scope="col">Pendaftaran surat kuasa untuk mewakili pihak yang berperkara di Pengadilan</th>
                <th class="align-middle p-2" scope="col">Biaya pembuatan surat kuasa insidentil</th>
                <th class="align-middle p-2" scope="col">Pengesahan surat dibawah tangan</th>
                <th class="align-middle p-2" scope="col">Uang leges</th>
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
                <th scope="col" class="align-middle py-0 px-2">18</th>
                <th scope="col" class="align-middle py-0 px-2">19</th>
            </tr>
        </thead>
        <tbody id="show_data"></tbody>
    </table>
</div>
<script>
    function generateTableRows(data) {
        const table = $('#table_lipa18').DataTable({
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

        function calculateSum(obj) {
            let sum = 0;
            for (const key in obj) {
                if (key !== "jumlah") {
                    sum += parseFloat(obj[key]);
                }
            }
            return sum.toFixed(2);
        }

        // Menghitung jumlah dan menambahkan kolom "jumlah" ke setiap objek
        data.forEach((obj) => {
            obj["jumlah"] = calculateSum(obj);
        });

        table.clear();
        // Loop through the received data and create rows for the table
        for (let i = 0; i < data.length; i++) {

            table.row.add([
                i + 1,
                addThousandSeparator(parseFloat(data[i].salinan)),
                addThousandSeparator(parseFloat(data[i].redaksi)),
                addThousandSeparator(parseFloat(0)),
                addThousandSeparator(parseFloat(0)),
                addThousandSeparator(parseFloat(0)),
                addThousandSeparator(parseFloat(data[i].eksekusi)),
                addThousandSeparator(parseFloat(data[i].lelang)),
                addThousandSeparator(parseFloat(0)),
                addThousandSeparator(parseFloat(data[i].catatan_pembuatan_akta)),
                addThousandSeparator(parseFloat(data[i].penyerahan_akta)),
                addThousandSeparator(parseFloat(0)),
                addThousandSeparator(parseFloat(0)),
                addThousandSeparator(parseFloat(data[i].akta_asli)),
                addThousandSeparator(parseFloat(data[i].surat_kuasa)),
                addThousandSeparator(parseFloat(data[i].surat_kuasa_insidentil)),
                addThousandSeparator(parseFloat(data[i].surat_dibawah_tangan)),
                addThousandSeparator(parseFloat(data[i].leges)),
                addThousandSeparator(parseFloat(data[i].jumlah)),
            ])
        }
        table.draw();
    }
</script>
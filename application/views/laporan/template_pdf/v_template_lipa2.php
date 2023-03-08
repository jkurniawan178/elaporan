<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="<?php echo base_url() ?>resources/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            @page {
                size: landscape;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <h5 class="text-center mb-2">LAPORAN PERKARA YANG DIMOHONKAN BANDING</h5>
        <h5 class="text-center mb-2">PADA PENGADILAN AGAMA TERNATE</h5>
        <h5 class="text-center mb-2">BULAN MARET 2023</h5>
        <p class="text-right">LIPA 2</p>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th scope="col" rowspan="2" class="align-middle">No.</th>
                    <th scope="col" rowspan="2" class="align-middle">Nomor Perkara</th>
                    <th scope="col" rowspan="2" class="align-middle">Nama Hakim / Majelis</th>
                    <th colspan="8" scope="colgroup">Tanggal</th>
                    <th scope="col" rowspan="2" class="align-middle">Ket</th>
                </tr>
                <tr>
                    <th scope="col" class="align-middle">Putusan PA</th>
                    <th scope="col" class="align-middle">Permohonan Banding</th>
                    <th scope="col" class="align-middle">Pemberitahuan Inzage</th>
                    <th scope="col" class="align-middle">Pengiriman Berkas PTA</th>
                    <th scope="col" class="align-middle">Putusan Banding</th>
                    <th scope="col" class="align-middle">Penerimaan Kembali di PA</th>
                    <th scope="col" class="align-middle">Pemberitahuan ke Para Pihak</th>
                    <th scope="col" class="align-middle">Penyampaian Fotocopy Relas PBT ke PTA</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($lipa2 as $value) : ?>
                    <tr>
                        <td scope="col" class="align-middle"><?php echo $no++ ?></td>
                        <td scope="col" class="align-middle"><?php echo $value->nomor_perkara_pn ?></td>
                        <td scope="col" class="align-middle"><?php echo $value->majelis_hakim_nama ?></td>
                        <td scope="col" class="align-middle"><?php echo $value->putusan_pn ?></td>
                        <td scope="col" class="align-middle"><?php echo $value->pbt_inzage_p . '<br/>' . $value->pbt_inzage_t ?></td>
                        <td scope="col" class="align-middle"><?php echo $value->pengiriman_berkas_banding ?></td>
                        <td scope="col" class="align-middle"><?php echo $value->putusan_banding ?></td>
                        <td scope="col" class="align-middle"><?php echo $value->penerimaan_kembali_berkas_banding ?></td>
                        <td scope="col" class="align-middle"><?php echo $value->pbt_banding_p . '<br/>' . $value->pbt_banding_t ?></td>
                        <td scope="col" class="align-middle"></td>
                        <td scope="col" class="align-middle"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
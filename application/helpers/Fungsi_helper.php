<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Helpers Fungsi_helper
 *
 * This Helpers for ...
 * 
 * @package   CodeIgniter
 * @category  Helpers
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 *
 */

// ------------------------------------------------------------------------

if (!function_exists('hasil_mediasi')) {
  function hasil_mediasi($hasil)
  {
    switch ($hasil) {
      case "Y":
        return "Berhasil";
        break;
      case "S":
        return "Berhasil Sebagian";
        break;
      case "T":
        return "Tidak Berhasil";
        break;
      case "D":
        return "Tidak Dapat Dilaksanakan";
        break;
      case " ":
        return " ";
        break;
      case NULL:
        return " ";
        break;
    }
  }
}
if (!function_exists('pilihbulan')) {
  function pilihbulan($bln)
  {
    switch ($bln) {
      case "01":
        return "Januari";
        break;
      case "02":
        return "Pebruari";
        break;
      case "03":
        return "Maret";
        break;
      case "04":
        return "April";
        break;
      case "05":
        return "Mei";
        break;
      case "06":
        return "Juni";
        break;
      case "07":
        return "Juli";
        break;
      case "08":
        return "Agustus";
        break;
      case "09":
        return "September";
        break;
      case "10":
        return "Oktober";
        break;
      case "11":
        return "Nopember";
        break;
      case "12":
        return "Desember";
        break;
    }
  }
}


if (!function_exists('tgl_dari_mysql')) {
  function tgl_dari_mysql($tgl)
  {
    if ($tgl == null) {
      $tgl = '';
    } else {
      $pecah = explode("-", $tgl);
      $tanggal = $pecah[2];
      $bulan = $pecah[1];
      $thn =  $pecah[0];
      $tgl = $tanggal . '/' . $bulan . '/' . $thn;
    }
    return $tgl;
  }
}

if (!function_exists('tgl_panjang_dari_mysql')) {
  function tgl_panjang_dari_mysql($tgl)
  {
    if ($tgl == null) {
      $tgl = '';
    } else {
      $pecah = explode("-", $tgl);
      $tanggal = $pecah[2];
      $bulan = $pecah[1];
      $thn =  $pecah[0];
      $tgl = $tanggal . ' ' . pilihbulan($bulan) . ' ' . $thn;
    }
    return $tgl;
  }
}
if (!function_exists('tgl_panjang_indo')) {
  function tgl_panjang_indo($tgl)
  {
    if ($tgl == null) {
      $tgl = '';
    } else {
      $pecah = explode("/", $tgl);
      $tanggal = $pecah[0];
      $bulan = $pecah[1];
      $thn =  $pecah[2];
      $tgl = $tanggal . ' ' . pilihbulan($bulan) . ' ' . $thn;
    }
    return $tgl;
  }
}

if (!function_exists('tgl_ke_mysql')) {
  function tgl_ke_mysql($tgl)
  {
    if ($tgl == null) {
      $tgl = '';
    } else {
      $pecah = explode("/", $tgl);
      $tanggal = $pecah[0];
      $bulan = $pecah[1];
      $thn =  $pecah[2];
      $tgl = $thn . '-' . $bulan . '-' . $tanggal;
    }
    return $tgl;
  }
}
if (!function_exists('lempar')) {
  function lempar($url)
  {
    echo '<script language = "javascript">';
    echo 'window.location.href = "' . $url . '"';
    echo '</script>';
  }
}

if (!function_exists('terbilang')) {
  function terbilang($bilangan)
  {
    $angka = array(
      '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0',
      '0', '0', '0'
    );
    $kata = array(
      '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh',
      'delapan', 'sembilan'
    );
    $tingkat = array('', 'ribu', 'juta', 'milyar', 'triliun');

    $panjang_bilangan = strlen($bilangan);

    /* pengujian panjang bilangan */
    if ($panjang_bilangan > 15) {
      $kalimat = "Diluar Batas";
      return $kalimat;
    }

    /* mengambil angka-angka yang ada dalam bilangan,
    dimasukkan ke dalam array */
    for ($i = 1; $i <= $panjang_bilangan; $i++) {
      $angka[$i] = substr($bilangan, - ($i), 1);
    }

    $i = 1;
    $j = 0;
    $kalimat = "";


    /* mulai proses iterasi terhadap array angka */
    while ($i <= $panjang_bilangan) {
      $subkalimat = "";
      $kata1 = "";
      $kata2 = "";
      $kata3 = "";

      /* untuk ratusan */
      if ($angka[$i + 2] != "0") {
        if ($angka[$i + 2] == "1") {
          $kata1 = "seratus";
        } else {
          $kata1 = $kata[$angka[$i + 2]] . " ratus";
        }
      }

      /* untuk puluhan atau belasan */
      if ($angka[$i + 1] != "0") {
        if ($angka[$i + 1] == "1") {
          if ($angka[$i] == "0") {
            $kata2 = "sepuluh";
          } elseif ($angka[$i] == "1") {
            $kata2 = "sebelas";
          } else {
            $kata2 = $kata[$angka[$i]] . " belas";
          }
        } else {
          $kata2 = $kata[$angka[$i + 1]] . " puluh";
        }
      }

      /* untuk satuan */
      if ($angka[$i] != "0") {
        if ($angka[$i + 1] != "1") {
          $kata3 = $kata[$angka[$i]];
        }
      }

      /* pengujian angka apakah tidak nol semua,
        lalu ditambahkan tingkat */
      if (($angka[$i] != "0") or ($angka[$i + 1] != "0") or ($angka[$i + 2] != "0")) {
        $subkalimat = "$kata1 $kata2 $kata3 " . $tingkat[$j] . " ";
      }

      /* gabungkan variabe sub kalimat (untuk satu blok 3 angka)
        ke variabel kalimat */
      $kalimat = $subkalimat . $kalimat;
      $i = $i + 3;
      $j = $j + 1;
    }

    /* mengganti satu ribu jadi seribu jika diperlukan */
    if (($angka[5] == "0") and ($angka[6] == "0")) {
      $kalimat = str_replace("satu ribu", "seribu", $kalimat);
    }
    return trim($kalimat . "");
  }
}



// ------------------------------------------------------------------------

/* End of file Fungsi_helper.php */
/* Location: ./application/helpers/Fungsi_helper.php */
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
if (!function_exists('kode_pihak')) {
  function kode_pihak($alur_perkara, $kode_jenis, $pihak)
  {
    if ($alur_perkara = '16' || $kode_jenis = '346' || $kode_jenis = '341') {
      switch ($pihak) {
        case 'p':
          return 'Pemohon';
          break;
        case 'kp':
          return 'Kuasa Pemohon';
          break;
        case 't':
          return 'Termohon';
          break;
        case 'kt':
          return 'Kuasa Termohon';
          break;
        default:
          return 'Lainnya';
          break;
      }
    } else {
      switch ($pihak) {
        case 'p':
          return 'Penggugat';
          break;
        case 'kp':
          return 'Kuasa Penggugat';
          break;
        case 't':
          return 'Tergugat';
          break;
        case 'kt':
          return 'Kuasa Tergugat';
          break;
        default:
          return 'Lainnya';
          break;
      }
    }
  }
}
// ------------------------------------------------------------------------
if (!function_exists('kode_delegasi')) {
  function kode_delegasi($jenis_delegasi)
  {
    switch ($jenis_delegasi) {
      case '1':
        return 'Panggilan';
        break;
      case '2':
        return 'Pemberitahuan';
        break;
      case '3':
        return 'Pbt Akta Bdg';
        break;
      case '4':
        return 'Pbt Mem Bdg';
        break;
      case '5':
        return 'Pbt Inz Bdg';
        break;
      case '6':
        return 'Pbt Put Bdg';
        break;
      case '7':
        return 'Pbt Akta Kas';
        break;
      case '8':
        return 'Pbt Mem Kas';
        break;
      case '9':
        return 'Pbt Kon Mem Kas';
        break;
      case '10':
        return 'Pbt Put Kas';
        break;
      case '11':
        return 'Pbt Akta PK';
        break;
      case '12':
        return 'Pbt Mem PK';
        break;
      case '13':
        return 'Pbt Kon Mem PK';
        break;
      case '14':
        return 'Pbt Put PK';
        break;
      case '15':
        return 'Lain-Lain';
        break;
      case '16':
        return 'Pbt Kon Mem Bdg';
        break;
      case '17':
        return 'Penawaran Konsinyasi';
        break;
      default:
        return '';
        break;
    }
  }
}
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

if (!function_exists('generateAlphabet')) {
  function generateAlphabet($number)
  {
    $alphabet = range('A', 'Z');
    $count = count($alphabet);
    $result = '';

    // var_dump($number);
    while ($number > 0) {
      $remainder = ($number - 1) % $count;
      $result = $alphabet[$remainder] . $result;
      $number = ($number - $remainder - 1) / $count;
    }

    return $result;
  }
}



// ------------------------------------------------------------------------

/* End of file Fungsi_helper.php */
/* Location: ./application/helpers/Fungsi_helper.php */

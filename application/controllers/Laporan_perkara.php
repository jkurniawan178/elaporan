<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Laporan_perkara
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Laporan_perkara extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('masuk_model');
    $this->load->model('laporan_model');
    $this->load->library('Config_library');
    // $this->load->model('sidkel_model');
  }
  //-----------------------------------------------------------------------------------------------
  public function index()
  {
    $menu = $this->masuk_model->sequrity();
    $data['menu'] = $menu;
    $data['contents'] = 'v_laporan_perkara';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }
  //-----------------------------------------------------------------------------------------------
  //----------------Fungsi get laporan LIPA yang dipanggil dari view-------------------------------
  public function get_lipa()
  {
    $jenis_laporan = $this->input->post('jenis_laporan');
    $tahun = $this->input->post('tahun');
    $bulan = $this->input->post('bulan');
    $tanggal_laporan = tgl_ke_mysql($this->input->post('tanggal_laporan'));
    $settingSIPP = $this->config_library->get_config_SIPP();

    if ($jenis_laporan != null) {
      switch ($jenis_laporan) {
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_1':
          $data = $this->laporan_model->getLIPA1($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $datahasil = $data['hasil'];
            $rekap = $data['rekapitulasi'];
            $hasil = $this->export_excel_lipa1($datahasil, $rekap, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 1 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_2':
          $data = $this->laporan_model->getLIPA2($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa2($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            $view_table = 'laporan_table/table_' . $jenis_laporan;
            $response = [
              'kode' => '200',
              'link' => $hasil,
              'table' => $this->load->view($view_table, '', true),
              'data' => $data
            ];

            echo json_encode($response);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 2 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_3':
          $data = $this->laporan_model->getLIPA3($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa3($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            $view_table = 'laporan_table/table_' . $jenis_laporan;
            $response = [
              'kode' => '200',
              'link' => $hasil,
              'table' => $this->load->view($view_table, '', true),
              'data' => $data
            ];
            echo json_encode($response);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 3 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }

          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_4':
          $data = $this->laporan_model->getLIPA4($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa4($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 4 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }

          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_5':
          $data = $this->laporan_model->getLIPA5($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa5($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 5 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_6':
          $data = $this->laporan_model->getLIPA6($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa6($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 6 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_7a':
          $data = $this->laporan_model->getLIPA7a($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa7a($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 7.B Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_7b':
          $data = $this->laporan_model->getLIPA7b($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa7b($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 7.B Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_8':
          $data = $this->laporan_model->getLIPA8($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa8($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 8 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_9':
          $data = $this->laporan_model->getLIPA9($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa9($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 9 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_10':
          $data = $this->laporan_model->getLIPA10($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa10($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 10 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_12':
          $data = $this->laporan_model->getLIPA12($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa12($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 12 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_13':
          $data = $this->laporan_model->getLIPA13($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa13($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 13 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_14':
          $data = $this->laporan_model->getLIPA14($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa14($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 14 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_15':
          $data = $this->laporan_model->getLIPA15($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa15($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 15 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_16':
          $data = $this->laporan_model->getLIPA16($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa16($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 16 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_17':
          $data = $this->laporan_model->getLIPA17($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa17($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 17 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_18':
          $data = $this->laporan_model->getLIPA18($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa18($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 18 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_19':
          $data = $this->laporan_model->getLIPA19($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa19($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 19 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_20':
          $data = $this->laporan_model->getLIPA20($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa20($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 20 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_21':
          $data = $this->laporan_model->getLIPA21($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa21($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 21 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'lipa_22':
          $data = $this->laporan_model->getLIPA22($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $masuk = $data['delegasi_masuk'];
            $keluar = $data['delegasi_keluar'];
            $hasil = $this->export_excel_lipa22($masuk, $keluar, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 22 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;

        case 'lipa_23':
          $data = $this->laporan_model->getLIPA23($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa23($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 23 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;

        case 'lipa_24':
          $data = $this->laporan_model->getLIPA24($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_lipa24($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
            echo json_encode($hasil);
          } else {
            $response = [
              'kode' => '201',
              'data' => 'Laporan Lipa 24 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
        default:

          break;
      }
    } else {
      $response = [
        'kode' => '201',
        'data' => 'Laporan Belum dipilih'
      ];
      echo json_encode($response);
      //something wrong here
    }
  }
  //----------------------------------------------------------------------------------------------
  //--------------------------------Helper Output Excel-------------------------------------------
  protected function writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan)
  {
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $namafile = $tahun . '_' . $bulan . '_' . $jenis_laporan . '.xlsx';
    $file = FCPATH . 'hasil/' . $namafile;
    $objWriter->save($file);
    $link = base_url() . 'hasil/' . $namafile;
    return $link;
  }
  //----------------------------------------------------------------------------------------------
  //--------------------------------Function Write Kolom Ttd--------------------------------------
  protected function write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan)
  {
    $styleFont = array(
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
    );

    $kota_pa = ucwords(strtolower(str_replace("PENGADILAN AGAMA ", "", str_replace("MAHKAMAH SYAR'IYAH ", "", $settingSIPP['NamaPN']))));

    $KetuaPNNama = $settingSIPP['KetuaPNNama'];
    $PanSekNama = $settingSIPP['PanSekNama'];
    $KetuaPNNIP = $settingSIPP['KetuaPNNIP'];
    $PanSekNIP = $settingSIPP['PanSekNIP'];


    //fungsi tanda tangan
    $objPHPExcel->getActiveSheet()
      ->setCellValue($kolom_kpa . $row, "Mengetahui")
      ->setCellValue($kolom_pansek . $row, $kota_pa . ", " . tgl_panjang_dari_mysql($tanggal_laporan))
      ->getRowDimension($row)->setRowHeight(20);

    $row++;
    $objPHPExcel->getActiveSheet()
      ->setCellValue($kolom_kpa . $row, "Ketua " . ucwords(strtolower($settingSIPP['NamaPN']) . ','))
      ->setCellValue($kolom_pansek . $row, "Panitera, ")
      ->getRowDimension($row)->setRowHeight(20);
    $row = $row + 5;
    $objPHPExcel->getActiveSheet()
      ->setCellValue($kolom_kpa . $row, $KetuaPNNama)
      ->setCellValue($kolom_pansek . $row, $PanSekNama)
      ->getRowDimension($row)->setRowHeight(20);
    $row++;
    $objPHPExcel->getActiveSheet()
      ->setCellValue($kolom_kpa . $row, "NIP. " . $KetuaPNNIP)
      ->setCellValue($kolom_pansek . $row, "NIP. " . $PanSekNIP)
      ->getRowDimension($row)->setRowHeight(20);
    $objPHPExcel->getActiveSheet()->getStyle($kolom_kpa . $row_awal_ttd . ':' . $kolom_pansek . $row)->getAlignment()->setWrapText(false);
    $objPHPExcel->getActiveSheet()->getStyle($kolom_kpa . $row_awal_ttd . ':' . $kolom_pansek . $row)->applyFromArray($styleFont);
    $objPHPExcel->getActiveSheet()->getStyle($kolom_kpa . $row_awal_ttd . ':' . $kolom_pansek . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //fungsi tanda tangan 
    //tanda tangan

    return $row;
  }

  //----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 1 ke Excel-----------------------------------
  protected function export_excel_lipa1($data, $rekap, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    // $obj = json_decode($data, true);
    $no = 1;
    $no_urut = 0;
    $baseRow = 10;
    $alur_perkara_id = "xx";

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);

    // $hasil = $data['hasil'];
    foreach ($data as $item) {
      if ($alur_perkara_id == $item->alur_perkara_id) {
        $no_urut++;
      } else {
        $no_urut = 1;
      }

      $alur_perkara_id = $item->alur_perkara_id;
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no_urut)
        ->setCellValue('B' . $row, $item->nomor_perkara)
        ->setCellValue('C' . $row, $item->kode_perkara)
        ->setCellValue('D' . $row, str_replace('<br/>', chr(13), str_replace('</br>', chr(13), $item->majelis_hakim)))
        ->setCellValue('E' . $row, $item->panitera_pengganti)
        ->setCellValue('F' . $row, tgl_dari_mysql($item->tanggal_pendaftaran))
        ->setCellValue('G' . $row, tgl_dari_mysql($item->pmh))
        ->setCellValue('H' . $row, tgl_dari_mysql($item->phs))
        ->setCellValue('I' . $row, tgl_dari_mysql($item->sidang_pertama))
        ->setCellValue('J' . $row, tgl_dari_mysql($item->tanggal_putusan))
        ->setCellValue('K' . $row, $item->jenis_putusan)
        ->setCellValue('L' . $row, ($item->belum_dibagi === "" ? "" : 'v'))
        ->setCellValue('M' . $row, $item->belum_diputus)
        ->getRowDimension($row)->setRowHeight(48);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A10:N' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A10:N' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A10:N' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "I";
    $row = $row + 3;
    $row_awal_ttd = $row;

    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    //rekap 
    $baris_rekap = $row + 3;
    // $baris_rekap_awal = $baris_rekap;
    $row = $baris_rekap;
    //nambah 2 baris		
    $objPHPExcel->getActiveSheet()
      ->setCellValue('B' . $baris_rekap,  "Rekapitulasi :")
      ->setCellValue('C' . $baris_rekap,  "G")
      ->setCellValue('D' . $baris_rekap,  "P")
      ->setCellValue('E' . $baris_rekap,  "G.S")
      ->getRowDimension($baris_rekap)->setRowHeight(20);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap . ':E' . $baris_rekap)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //rekap sisa bulan lalu
    $baris_rekap++;
    $row = $baris_rekap;
    //nambah 1 baris		
    $objPHPExcel->getActiveSheet()
      ->setCellValue('B' . $baris_rekap,  "Sisa Bulan Lalu")
      ->setCellValue('C' . $baris_rekap,  $rekap['sisa_lalu_G'])
      ->setCellValue('D' . $baris_rekap,  $rekap['sisa_lalu_P'])
      ->setCellValue('E' . $baris_rekap,  $rekap['sisa_lalu_GS'])
      ->getRowDimension($baris_rekap)->setRowHeight(20);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap . ':E' . $baris_rekap)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //rekap diterima bulan ini
    $baris_rekap++;
    $row = $baris_rekap;
    //nambah 1 baris		
    $objPHPExcel->getActiveSheet()
      ->setCellValue('B' . $baris_rekap,  "Terima Bulan ini")
      ->setCellValue('C' . $baris_rekap,  $rekap['terima_G'])
      ->setCellValue('D' . $baris_rekap,  $rekap['terima_P'])
      ->setCellValue('E' . $baris_rekap,  $rekap['terima_GS'])
      ->getRowDimension($baris_rekap)->setRowHeight(20);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap . ':E' . $baris_rekap)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //rekap putus
    $baris_rekap++;
    $row = $baris_rekap;
    //nambah 1 baris		
    $objPHPExcel->getActiveSheet()
      ->setCellValue('B' . $baris_rekap,  "Putus")
      ->setCellValue('C' . $baris_rekap,  $rekap['putus_G'])
      ->setCellValue('D' . $baris_rekap,  $rekap['putus_P'])
      ->setCellValue('E' . $baris_rekap,  $rekap['putus_GS'])
      ->getRowDimension($baris_rekap)->setRowHeight(20);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap . ':E' . $baris_rekap)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


    //rekap sisa akhir
    $baris_rekap++;
    $row = $baris_rekap;
    $Sisa_G = $rekap['sisa_lalu_G'] + $rekap['terima_G'] - $rekap['putus_G'];
    $Sisa_P = $rekap['sisa_lalu_P'] + $rekap['terima_P'] - $rekap['putus_P'];
    $Sisa_GS = $rekap['sisa_lalu_GS'] + $rekap['terima_GS'] - $rekap['putus_GS'];
    $objPHPExcel->getActiveSheet()
      ->setCellValue('B' . $baris_rekap,  "Sisa Akhir")
      ->setCellValue('C' . $baris_rekap, $Sisa_G)
      ->setCellValue('D' . $baris_rekap, $Sisa_P)
      ->setCellValue('E' . $baris_rekap, $Sisa_GS)
      ->getRowDimension($baris_rekap)->setRowHeight(20);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap . ':E' . $baris_rekap)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    // rekap Belum dibagi
    $baris_rekap++;
    $row = $baris_rekap;
    $objPHPExcel->getActiveSheet()
      ->setCellValue('B' . $baris_rekap,  "a.Belum Dibagi")
      ->setCellValue('C' . $baris_rekap, $rekap['belumbagi_G'])
      ->setCellValue('D' . $baris_rekap, $rekap['belumbagi_P'])
      ->setCellValue('E' . $baris_rekap, $rekap['belumbagi_GS'])
      ->getRowDimension($baris_rekap)->setRowHeight(20);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap . ':E' . $baris_rekap)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //rekap belum diputus
    $baris_rekap++;
    $row = $baris_rekap;
    $BelumPutus_G = $rekap['sisa_lalu_G'] + $rekap['terima_G'] - $rekap['putus_G'];
    $BelumPutus_P = $rekap['sisa_lalu_P'] + $rekap['terima_P'] - $rekap['putus_P'];
    $BelumPutus_GS = $rekap['sisa_lalu_GS'] + $rekap['terima_GS'] - $rekap['putus_GS'];
    $objPHPExcel->getActiveSheet()
      ->setCellValue('B' . $baris_rekap,  "b.Belum Diputus")
      ->setCellValue('C' . $baris_rekap, $BelumPutus_G)
      ->setCellValue('D' . $baris_rekap, $BelumPutus_P)
      ->setCellValue('E' . $baris_rekap, $BelumPutus_GS)
      ->getRowDimension($baris_rekap)->setRowHeight(20);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap . ':E' . $baris_rekap)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baris_rekap)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //rekap
    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 2 ke Excel-----------------------------------
  protected function export_excel_lipa2($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 9;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['nomor_perkara_pn'])
        ->setCellValue('C' . $row, str_replace('<br/>', chr(13), str_replace('</br>', chr(13), $item['majelis_hakim_nama'])))
        ->setCellValue('D' . $row, tgl_dari_mysql($item['putusan_pn']))
        ->setCellValue('E' . $row, tgl_dari_mysql($item['permohonan_banding']))
        ->setCellValue('F' . $row, tgl_dari_mysql($item['pbt_inzage_p']) . chr(13) . tgl_dari_mysql($item['pbt_inzage_t']))
        ->setCellValue('G' . $row, tgl_dari_mysql($item['pengiriman_berkas_banding']))
        ->setCellValue('H' . $row, tgl_dari_mysql($item['putusan_banding']))
        ->setCellValue('I' . $row, tgl_dari_mysql($item['penerimaan_kembali_berkas_banding']))
        ->setCellValue('J' . $row, tgl_dari_mysql($item['pbt_banding_p']) . chr(13) . tgl_dari_mysql($item['pbt_banding_t']))
        ->setCellValue('K' . $row,  '')
        ->setCellValue('L' . $row, ($item['tanggal_cabut'] === null) ? '' : 'cabut tgl : ' . tgl_dari_mysql($item['tanggal_cabut']))
        ->getRowDimension($row)->setRowHeight(46);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A9:L' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A9:L' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A9:L' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "I";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //fungsi tanda tangan

    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 3 ke Excel------------------------------------
  protected function export_excel_lipa3($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 10;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['nomor_perkara_pn'])
        ->setCellValue('C' . $row, $item['nomor_putusan_banding'])
        ->setCellValue('D' . $row, tgl_dari_mysql($item['permohonan_kasasi']))
        ->setCellValue('E' . $row, tgl_dari_mysql($item['penerimaan_memori_kasasi']))
        ->setCellValue('F' . $row, tgl_dari_mysql($item['tidak_memenuhi_syarat']))
        ->setCellValue('G' . $row, tgl_dari_mysql($item['pengiriman_berkas_kasasi']))
        ->setCellValue('H' . $row, tgl_dari_mysql($item['putusan_kasasi']))
        ->setCellValue('I' . $row, tgl_dari_mysql($item['penerimaan_berkas_kasasi']))
        ->setCellValue('J' . $row, tgl_dari_mysql($item['pbt_putusan_p']) . chr(13) . tgl_dari_mysql($item['pbt_putusan_t']))
        ->setCellValue('K' . $row, ($item['tanggal_cabut'] !== null) ? 'cabut tgl: ' . tgl_dari_mysql($item['tanggal_cabut']) : null)
        ->getRowDimension($row)->setRowHeight(35);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A10:K' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A10:K' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A10:K' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "B";
    $kolom_pansek = "H";
    $row = $row + 3;
    $row_awal_ttd = $row;

    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    //tanda tangan 
    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 4 ke Excel------------------------------------
  protected function export_excel_lipa4($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 10;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['nomor_perkara_pn'])
        ->setCellValue('C' . $row, $item['nomor_putusan_banding'])
        ->setCellValue('D' . $row, $item['nomor_putusan_kasasi'])
        ->setCellValue('E' . $row, tgl_dari_mysql($item['permohonan_pk']))
        ->setCellValue('F' . $row, tgl_dari_mysql($item['pengiriman_berkas_pk']))
        ->setCellValue('G' . $row, tgl_dari_mysql($item['putusan_pk']))
        ->setCellValue('H' . $row, tgl_dari_mysql($item['penerimaan_berkas_pk']))
        ->setCellValue('I' . $row, tgl_dari_mysql($item['pbt_pk_p']) . chr(13) . tgl_dari_mysql($item['pbt_pk_t']))
        ->setCellValue('J' . $row, ($item['tanggal_cabut'] !== null) ? 'cabut tgl: ' . tgl_dari_mysql($item['tanggal_cabut']) : null)
        ->getRowDimension($row)->setRowHeight(35);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A10:J' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A10:K' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A10:K' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "H";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //fungsi tanda tangan

    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 5 ke Excel------------------------------------
  protected function export_excel_lipa5($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 10;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['nomor_register_eksekusi'])
        ->setCellValue('C' . $row, $item['eksekusi_nomor_perkara'])
        ->setCellValue('D' . $row, tgl_dari_mysql(($item['permohonan_eksekusi']) === '0000-00-00' ? null : $item['permohonan_eksekusi']))
        ->setCellValue('E' . $row, tgl_dari_mysql(($item['penetapan_teguran_eksekusi']) === '0000-00-00' ? null : $item['penetapan_teguran_eksekusi']))
        ->setCellValue('F' . $row, tgl_dari_mysql(($item['pelaksanaan_teguran_eksekusi']) === '0000-00-00' ? null : $item['pelaksanaan_teguran_eksekusi']))
        ->setCellValue('G' . $row, tgl_dari_mysql(($item['penetapan_sita_eksekusi']) === '0000-00-00' ? null : $item['penetapan_sita_eksekusi']))
        ->setCellValue('H' . $row, tgl_dari_mysql(($item['pelaksanaan_sita_eksekusi']) === '0000-00-00' ? null : $item['pelaksanaan_sita_eksekusi']))
        ->setCellValue('I' . $row, tgl_dari_mysql(($item['penetapan_eksekusi_rill']) === '0000-00-00' ? null : $item['penetapan_eksekusi_rill']))
        ->setCellValue('J' . $row, tgl_dari_mysql(($item['pelaksanaan_eksekusi_rill']) === '0000-00-00' ? null : $item['pelaksanaan_eksekusi_rill']))
        ->setCellValue('K' . $row, tgl_dari_mysql(($item['penetapan_noneksekusi']) === '0000-00-00' ? null : $item['penetapan_noneksekusi']))
        ->setCellValue('L' . $row, '')
        ->setCellValue('M' . $row, '')
        ->setCellValue('N' . $row, '')
        ->getRowDimension($row)->setRowHeight(25);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A10:N' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A10:N' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A10:N' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "J";

    $row = $row + 3;
    $row_awal_ttd = $row;

    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 6 ke Excel------------------------------------
  protected function export_excel_lipa6($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 9;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, str_replace('<br/>', chr(13), str_replace('</br>', chr(13), $item['nama_gelar'])))
        ->setCellValue('C' . $row, $item['sisa_lalu_G'])
        ->setCellValue('D' . $row, $item['sisa_lalu_P'])
        ->setCellValue('E' . $row, $item['Diterima_G'])
        ->setCellValue('F' . $row, $item['Diterima_P'])
        ->setCellValue('G' . $row, intval($item['sisa_lalu_G']) + intval($item['Diterima_G']))
        ->setCellValue('H' . $row, intval($item['sisa_lalu_P']) + intval($item['Diterima_P']))
        ->setCellValue('I' . $row, $item['putus_G'])
        ->setCellValue('J' . $row, $item['putus_P'])
        ->setCellValue('K' . $row, intval($item['sisa_lalu_G']) + intval($item['Diterima_G']) - intval($item['putus_G']))
        ->setCellValue('L' . $row, intval($item['sisa_lalu_P']) + intval($item['Diterima_P']) - intval($item['putus_P']))
        ->setCellValue('M' . $row, $item['minut_G'])
        ->setCellValue('N' . $row, $item['minut_P'])
        ->setCellValue('O' . $row, intval($item['putus_G']) - intval($item['minut_G']))
        ->setCellValue('P' . $row, intval($item['putus_P']) - intval($item['minut_P']))
        ->getRowDimension($row)->setRowHeight(42);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A9:P' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A9:P' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A9:P' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "M";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 7a ke Excel------------------------------------
  protected function export_excel_lipa7a($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '11'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 9;

    $objPHPExcel->getActiveSheet()->setCellValue('B2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('B3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('B' . $row, $item['no'])
        ->setCellValue('C' . $row, $item['Keterangan'])
        ->setCellValue('D' . $row, $item['jumlah_debet'] === null ? 0 : $item['jumlah_debet'])
        ->setCellValue('E' . $row, $item['jumlah_kredit'] === null ? 0 : $item['jumlah_kredit'])
        ->getRowDimension($row)->setRowHeight(18);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('B' . $baseRow . ':E' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baseRow . ':B' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $baseRow . ':C' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baseRow . ':E' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "E";
    $row = $row + 4;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 7b ke Excel------------------------------------
  protected function export_excel_lipa7b($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '11'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 9;

    $objPHPExcel->getActiveSheet()->setCellValue('B2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('B3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('B' . $row, $item['no'])
        ->setCellValue('C' . $row, $item['Keterangan'])
        ->setCellValue('D' . $row, $item['jumlah_debet'] === null ? 0 : $item['jumlah_debet'])
        ->setCellValue('E' . $row, $item['jumlah_kredit'] === null ? 0 : $item['jumlah_kredit'])
        ->getRowDimension($row)->setRowHeight(18);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('B' . $baseRow . ':E' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baseRow . ':B' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $baseRow . ':C' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $baseRow . ':E' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "E";
    $row = $row + 4;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 8 ke Excel------------------------------------
  protected function export_excel_lipa8($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 12;

    $objPHPExcel->getActiveSheet()->setCellValue('B2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('B3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);

    foreach ($obj as $item) {
      $row = $baseRow + $no;
      $jml_perkara = intval($item['sisa_lalu']) + intval($item['diterima_bulan_ini']);
      $jml_lajur = intval($item['dicabut']) + intval($item['dikabulkan']) + intval($item['ditolak'])
        + intval($item['tidak_dapat_diterima']) + intval($item['digugurkan']) + intval($item['dicoret_dari_register']);
      $sisa_perkara = $jml_perkara - $jml_lajur;

      $col_no = 'B';
      $col_jenis = 'C';
      $val_no = $no;
      if ($no > 23) {
        $col_no = 'A';
        $col_jenis = 'B';
        $urut = intval($no) - 22;
        // var_dump($urut);
        $val_no = generateAlphabet($urut) . '.';
      };

      $objPHPExcel->getActiveSheet()
        ->setCellValue($col_no . $row, $val_no)
        ->setCellValue($col_jenis . $row, $item['jenis_perkara'])
        ->setCellValue('D' . $row, $item['sisa_lalu'])
        ->setCellValue('E' . $row, $item['diterima_bulan_ini'])
        ->setCellValue('F' . $row, $jml_perkara)
        ->setCellValue('G' . $row, $item['dicabut'])
        ->setCellValue('H' . $row, $item['dikabulkan'])
        ->setCellValue('I' . $row, $item['ditolak'])
        ->setCellValue('J' . $row, $item['tidak_dapat_diterima'])
        ->setCellValue('K' . $row, $item['digugurkan'])
        ->setCellValue('L' . $row, $item['dicoret_dari_register'])
        ->setCellValue('M' . $row, $jml_lajur)
        ->setCellValue('N' . $row, $sisa_perkara)
        ->setCellValue('O' . $row, $item['bandingnya'])
        ->setCellValue('P' . $row, $item['kasasinya'])
        ->setCellValue('Q' . $row, $item['pk'])
        ->getRowDimension($row)->setRowHeight(15.60);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('D12:Q' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('D12:Q' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A12:Q' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "M";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 9 ke Excel------------------------------------
  protected function export_excel_lipa9($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      // 'borders' => array(
      //   'allborders' => array(
      //     'style' => PHPExcel_Style_Border::BORDER_THIN,
      //   )
      // ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 12;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;
      $sisaPoligami = intval($item['sisa_poligami']) + intval($item['masuk_poligami']) - intval($item['putus_poligami']);
      $sisaTalak = intval($item['sisa_talak']) + intval($item['masuk_talak']) - intval($item['putus_talak']);
      $sisaGugat = intval($item['sisa_gugat']) + intval($item['masuk_gugat']) - intval($item['putus_gugat']);

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['sisa_poligami'])
        ->setCellValue('C' . $row, $item['masuk_poligami'])
        ->setCellValue('D' . $row, $item['sisa_talak'])
        ->setCellValue('E' . $row, $item['masuk_talak'])
        ->setCellValue('F' . $row, $item['sisa_gugat'])
        ->setCellValue('G' . $row, $item['masuk_gugat'])
        ->setCellValue('H' . $row, '=sum(B' . $row . ':G' . $row . ')')
        ->setCellValue('I' . $row, $item['putus_poligami'])
        ->setCellValue('J' . $row, $item['putus_talak'])
        ->setCellValue('K' . $row, $item['putus_gugat'])
        ->setCellValue('L' . $row, '=sum(I' . $row . ':K' . $row . ')')
        ->setCellValue('M' . $row, $sisaPoligami)
        ->setCellValue('N' . $row, $sisaTalak)
        ->setCellValue('O' . $row, $sisaGugat)
        ->setCellValue('P' . $row, '=sum(M' . $row . ':O' . $row . ')')
        ->setCellValue('Q' . $row, $item['pemohonizin'])
        ->setCellValue('R' . $row, $item['pemohontidakizin'])
        ->setCellValue('S' . $row, $item['termohonizin'])
        ->setCellValue('T' . $row, $item['termohontidakizin'])
        ->getRowDimension($row)->setRowHeight(16.50);
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A12:T' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A12:T' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A12:T' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "D";
    $kolom_pansek = "P";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 10 ke Excel------------------------------------
  protected function export_excel_lipa10($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      // 'borders' => array(
      //   'allborders' => array(
      //     'style' => PHPExcel_Style_Border::BORDER_THIN,
      //   )
      // ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 11;

    $objPHPExcel->getActiveSheet()->setCellValue('B3', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('B4', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('B' . $row, $no)
        ->setCellValue('C' . $row, $item['zina'])
        ->setCellValue('D' . $row, $item['mabuk'])
        ->setCellValue('E' . $row, $item['madat'])
        ->setCellValue('F' . $row, $item['judi'])
        ->setCellValue('G' . $row, $item['meninggalkan'])
        ->setCellValue('H' . $row, $item['dihukum'])
        ->setCellValue('I' . $row, $item['poligami'])
        ->setCellValue('J' . $row, $item['kdrt'])
        ->setCellValue('K' . $row, $item['cacat'])
        ->setCellValue('L' . $row, $item['perselisihan'])
        ->setCellValue('M' . $row, $item['kawin_paksa'])
        ->setCellValue('N' . $row, $item['murtad'])
        ->setCellValue('O' . $row, $item['ekonomi'])
        ->setCellValue('P' . $row, $item['jumlah'])
        ->getRowDimension($row)->setRowHeight(15.60);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('B12:P' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('B12:P' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B12:P' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "M";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 12 ke Excel------------------------------------
  protected function export_excel_lipa12($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      // 'borders' => array(
      //   'allborders' => array(
      //     'style' => PHPExcel_Style_Border::BORDER_THIN,
      //   )
      // ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 10;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;
      $perkara_mediasi = intval($item['perkara_mediasi']) + intval($item['sisa_mediasi_lalu']);

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['sisa_lalu'])
        ->setCellValue('C' . $row, $item['diterima_bulan_ini'])
        ->setCellValue('D' . $row, intval($item['sisa_lalu']) + intval($item['diterima_bulan_ini']) - $perkara_mediasi)
        ->setCellValue('E' . $row, $perkara_mediasi)
        ->setCellValue('F' . $row, $item['tidak_berhasil'])
        ->setCellValue('G' . $row, intval($item['berhasil_akta']) + intval($item['berhasil_sebagian']) + intval($item['berhasil_cabut']))
        ->setCellValue('H' . $row, $item['gagal'])
        ->setCellValue('I' . $row, $item['perkara_proses_mediasi'])
        ->setCellValue('J' . $row, intval($item['sisa_lalu']) + intval($item['diterima_bulan_ini']) - intval($item['putus_bulan_ini']))
        ->getRowDimension($row)->setRowHeight(15.60);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A11:J' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A11:J' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A11:J' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "B";
    $kolom_pansek = "H";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 13 ke Excel------------------------------------
  protected function export_excel_lipa13($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 7;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;
      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['nomor_akta_cerai'])
        ->setCellValue('C' . $row, $item['tgl_terbit_ac'])
        ->setCellValue('D' . $row, $item['no_seri_akta_cerai'])
        ->setCellValue('E' . $row, $item['nomor_perkara'])
        ->setCellValue('F' . $row, $item['tanggal_putusan'])
        ->setCellValue('G' . $row, $item['tanggal_bht'])
        ->setCellValue('H' . $row, ($item['tgl_ikrar_talak'] == null ? '-' : $item['tgl_ikrar_talak']))
        ->setCellValue('I' . $row, '-')
        ->getRowDimension($row)->setRowHeight(19.80);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A6:I' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A6:I' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A6:I' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "B";
    $kolom_pansek = "G";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 14 ke Excel------------------------------------
  protected function export_excel_lipa14($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 9;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['pagu_awal'])
        ->setCellValue('C' . $row, $item['pagu_revisi'])
        ->setCellValue('D' . $row, $item['realisasi_sampai_bulan_lalu'])
        ->setCellValue('E' . $row, $item['realisasi'])
        ->setCellValue('F' . $row, $item['jumlah_realisasi'])
        ->setCellValue('G' . $row, $item['saldo'])
        ->setCellValue('H' . $row, $item['jml_kegiatan'])
        ->setCellValue('I' . $row, $item['jml_perkara'])
        ->setCellValue('J' . $row, $item['keterangan'])
        ->getRowDimension($row)->setRowHeight(25);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A10:J' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A10:J' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A10:J' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B10:G' . $row)->getNumberFormat()->setFormatCode('_(Rp* #,##0_);_(Rp* (#,##0);_(Rp* "-"??_);_(@_)', true);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "H";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 15 ke Excel------------------------------------
  protected function export_excel_lipa15($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 9;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['pagu_awal'])
        ->setCellValue('C' . $row, $item['pagu_revisi'])
        ->setCellValue('D' . $row, $item['realisasi_sampai_bulan_lalu'])
        ->setCellValue('E' . $row, $item['realisasi'])
        ->setCellValue('F' . $row, $item['jumlah_realisasi'])
        ->setCellValue('G' . $row, $item['saldo'])
        ->setCellValue('H' . $row, $item['target_perkara'])
        ->setCellValue('I' . $row, $item['jml_perkara'])
        ->setCellValue('J' . $row, $item['keterangan'])
        ->getRowDimension($row)->setRowHeight(25);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A10:J' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A10:J' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A10:J' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B10:G' . $row)->getNumberFormat()->setFormatCode('_(Rp* #,##0_);_(Rp* (#,##0);_(Rp* "-"??_);_(@_)', true);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "H";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 16 ke Excel------------------------------------
  protected function export_excel_lipa16($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 8;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['pagu_awal'])
        ->setCellValue('C' . $row, $item['pagu_revisi'])
        ->setCellValue('D' . $row, $item['realisasi_sampai_bulan_lalu'])
        ->setCellValue('E' . $row, $item['realisasi'])
        ->setCellValue('F' . $row, $item['jumlah_realisasi'])
        ->setCellValue('G' . $row, $item['saldo'])
        ->setCellValue('H' . $row, $item['target_layanan'])
        ->setCellValue('I' . $row, $item['jml_layanan'])
        ->setCellValue('J' . $row, $item['keterangan'])
        ->getRowDimension($row)->setRowHeight(25);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A9:J' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A9:J' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A9:J' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B9:G' . $row)->getNumberFormat()->setFormatCode('_(Rp* #,##0_);_(Rp* (#,##0);_(Rp* "-"??_);_(@_)', true);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "H";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 17 ke Excel------------------------------------
  protected function export_excel_lipa17($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 11;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['pendaftaran'])
        ->setCellValue('C' . $row, $item['pendaftaran_banding'])
        ->setCellValue('D' . $row, $item['pendaftaran_kasasi'])
        ->setCellValue('E' . $row, $item['pendaftaran_pk'])
        ->setCellValue('F' . $row, intval($item['pendaftaran_eksekusi']) + intval($item['pendaftaran_eksekusi_ht']))
        ->setCellValue('G' . $row, $item['jumlah'])
        ->getRowDimension($row)->setRowHeight(15.60);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A6:G' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A6:G' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A6:G' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "B";
    $kolom_pansek = "F";
    $row = $row + 5;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 18 ke Excel------------------------------------
  protected function export_excel_lipa18($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      // 'borders' => array(
      //   'allborders' => array(
      //     'style' => PHPExcel_Style_Border::BORDER_THIN,
      //   )
      // ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '10'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 15;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['salinan'])
        ->setCellValue('C' . $row, $item['redaksi'])
        ->setCellValue('D' . $row, 0)
        ->setCellValue('E' . $row, 0)
        ->setCellValue('F' . $row, 0)
        ->setCellValue('G' . $row, $item['eksekusi'])
        ->setCellValue('H' . $row, $item['lelang'])
        ->setCellValue('I' . $row, 0)
        ->setCellValue('J' . $row, $item['catatan_pembuatan_akta'])
        ->setCellValue('K' . $row, $item['penyerahan_akta'])
        ->setCellValue('L' . $row, 0)
        ->setCellValue('M' . $row, 0)
        ->setCellValue('N' . $row, $item['akta_asli'])
        ->setCellValue('O' . $row, $item['surat_kuasa'])
        ->setCellValue('P' . $row, $item['surat_kuasa_insidentil'])
        ->setCellValue('Q' . $row, $item['surat_dibawah_tangan'])
        ->setCellValue('R' . $row, $item['leges'])
        ->setCellValue('S' . $row, '=sum(B' . $row . ':R' . $row . ')')
        ->getRowDimension($row)->setRowHeight(16.50);
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A15:S' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A15:S' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A15:S' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "N";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 19 ke Excel------------------------------------
  protected function export_excel_lipa19($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );


    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 9;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;
      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['nomor_perkara'])
        ->setCellValue('C' . $row, str_replace('<br/>', chr(13), str_replace('</br>', chr(13), $item['majelis_hakim'])))
        ->setCellValue('D' . $row, ($item['putus_p']))
        ->setCellValue('E' . $row, $item['putus_g'])
        ->setCellValue('F' . $row, $item['minutasi_p'])
        ->setCellValue('G' . $row, $item['minutasi_g'])
        ->getRowDimension($row)->setRowHeight(44.5);
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A6:J' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A6:J' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A6:J' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "B";
    $kolom_pansek = "G";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 20 ke Excel------------------------------------
  protected function export_excel_lipa20($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 13;

    $objPHPExcel->getActiveSheet()->setCellValue('A5', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A6', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;
      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['putus_3_bln'])
        ->setCellValue('C' . $row, $item['putus_3_5_bln'])
        ->setCellValue('D' . $row, ($item['putus_lebih_5_bln']))
        ->setCellValue('E' . $row, $item['blm_putus_lebih_5_bln'])
        ->getRowDimension($row)->setRowHeight(47.25);
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A13:E' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A13:E' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A13:E' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "B";
    $kolom_pansek = "E";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 21 ke Excel------------------------------------
  protected function export_excel_lipa21($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 10;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;
      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['nomor_perkara'])
        ->setCellValue('C' . $row, $item['kode_perkara'])
        ->setCellValue('D' . $row, str_replace('<br/>', chr(13), str_replace('</br>', chr(13), $item['majelis_hakim'])))
        ->setCellValue('E' . $row, $item['panitera_pengganti'])
        ->setCellValue('F' . $row, $item['penerimaan'])
        ->setCellValue('G' . $row, $item['pmh'])
        ->setCellValue('H' . $row, $item['phs'])
        ->setCellValue('I' . $row, $item['sidang_pertama'])
        ->setCellValue('J' . $row, $item['diputus'])
        ->setCellValue('K' . $row, $item['jenis_putusan'])
        ->setCellValue('L' . $row, ($item['belum_dibagi'] === null ? "" : 'v'))
        ->setCellValue('M' . $row, ($item['belum_putus'] === null ? "" : 'v'))
        ->setCellValue('N' . $row, ($item['belum_minutasi'] === null ? "" : 'v'))
        ->getRowDimension($row)->setRowHeight(45.75);
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A10:O' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A10:O' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A10:O' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "L";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 22 ke Excel-----------------------------------
  protected function export_excel_lipa22($masuk, $keluar, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
      ),
      'font' => array(
        'name' => 'Arial Narrow'
      ),
      'alignment' => array(
        'wrap' => true,
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
    );

    // $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 7;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);

    // Delegasi Keluar;
    foreach ($keluar as $item) {

      $row = $baseRow + $no;
      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item->pa_tujuan_text)
        ->setCellValue('C' . $row, $item->nomor_perkara)
        ->setCellValue('D' . $row, $item->pihak)
        ->setCellValue('E' . $row, $item->nomor_surat)
        ->setCellValue('F' . $row, $item->tgl_surat)
        ->setCellValue('G' . $row, $item->tgl_sidang)
        ->setCellValue('H' . $row, $item->tgl_surat_diterima)
        ->setCellValue('I' . $row, $item->tgl_disposisi)
        ->setCellValue('J' . $row, $item->tgl_relaas)
        ->setCellValue('K' . $row, $item->tgl_pengiriman_relaas)
        ->setCellValue('L' . $row, $item->jurusita_nama)
        ->setCellValue('M' . $row, kode_delegasi($item->id_jenis_delegasi))
        ->getRowDimension($row)->setRowHeight(-1);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A7:M' . $row)->applyFromArray($styleArray);

    //Delegasi masuk
    //Tabel Header
    $row = $row + 3;
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'B. Bantuan Panggilan Masuk')
      ->getStyle('A' . $row)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getAlignment()->setWrapText(false);

    $row = $row + 1;
    $objPHPExcel->getActiveSheet()
      ->setCellValue('A' . $row, 'No')
      ->setCellValue('B' . $row, 'Nama Pengadilan')
      ->setCellValue('C' . $row, 'No. Perkara')
      ->setCellValue('D' . $row, 'Nama Pihak')
      ->setCellValue('E' . $row, 'No. Surat')
      ->setCellValue('F' . $row, 'Tgl Surat')
      ->setCellValue('G' . $row, 'Tgl Sidang')
      ->setCellValue('H' . $row, 'Tgl Terima')
      ->setCellValue('I' . $row, 'Tgl Disposisi')
      ->setCellValue('J' . $row, 'Tgl Relaas')
      ->setCellValue('K' . $row, 'Tgl Pengembalian')
      ->setCellValue('L' . $row, 'JS/JSP')
      ->setCellValue('M' . $row, 'KET')
      ->getRowDimension($row)->setRowHeight(36.75);

    $styleHeader = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'bold' => true,
      ),
      'alignment' => array(
        'wrap' => true,
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '92d050')
      )
    );
    $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':M' . $row)->applyFromArray($styleHeader);

    //Kolom SubHeader
    $row = $row + 1;
    $objPHPExcel->getActiveSheet()
      ->setCellValue('A' . $row, '1')
      ->setCellValue('B' . $row, '2')
      ->setCellValue('C' . $row, '3')
      ->setCellValue('D' . $row, '4')
      ->setCellValue('E' . $row, '5')
      ->setCellValue('F' . $row, '6')
      ->setCellValue('G' . $row, '7')
      ->setCellValue('H' . $row, '8')
      ->setCellValue('I' . $row, '9')
      ->setCellValue('J' . $row, '10')
      ->setCellValue('K' . $row, '11')
      ->setCellValue('L' . $row, '12')
      ->setCellValue('M' . $row, '13')
      ->getRowDimension($row)->setRowHeight(15.75);

    $styleHeader = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'bold' => true,
        'size' => 10,
        'italic' => true,
      ),
      'alignment' => array(
        'wrap' => true,
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'f4b084')
      ),
    );
    $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':M' . $row)->applyFromArray($styleHeader);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':M' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_GENERAL);


    //Delegasi Masuk
    $no_urut = 1;
    $baseRow_masuk = $row;

    foreach ($masuk as $item) {
      $row = $baseRow_masuk + $no_urut;
      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no_urut)
        ->setCellValue('B' . $row, $item->pa_asal_text)
        ->setCellValue('C' . $row, $item->nomor_perkara)
        ->setCellValue('D' . $row, $item->pihak)
        ->setCellValue('E' . $row, $item->nomor_surat)
        ->setCellValue('F' . $row, $item->tgl_surat)
        ->setCellValue('G' . $row, $item->tgl_sidang)
        ->setCellValue('H' . $row, $item->tgl_surat_diterima)
        ->setCellValue('I' . $row, $item->tgl_disposisi)
        ->setCellValue('J' . $row, $item->tgl_relaas)
        ->setCellValue('K' . $row, $item->tgl_pengiriman_relaas)
        ->setCellValue('L' . $row, $item->jurusita_nama)
        ->setCellValue('M' . $row, kode_delegasi($item->id_jenis_delegasi))
        ->getRowDimension($row)->setRowHeight(-1);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no_urut++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow_masuk . ':M' . $row)->applyFromArray($styleArray);


    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "J";
    $row = $row + 3;
    $row_awal_ttd = $row;

    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);
    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }

  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 23 ke Excel------------------------------------
  protected function export_excel_lipa23($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 9;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['sisa_lalu'])
        ->setCellValue('C' . $row, $item['diterima_bulan_ini'])
        ->setCellValue('D' . $row, $item['dicabut'])
        ->setCellValue('E' . $row, $item['putus_elektronik'])
        ->setCellValue('F' . $row, $item['putus_biasa'])
        ->setCellValue('G' . $row, $item['total_putus'])
        ->setCellValue('H' . $row, $item['sisa_bulan_ini'])
        ->getRowDimension($row)->setRowHeight(65);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A9:H' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A9:H' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A9:H' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "B";
    $kolom_pansek = "G";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }

  //-----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Lipa 24 ke Excel------------------------------------
  protected function export_excel_lipa24($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_laporan . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_laporan . ".xls");

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      ),
      'font' => array(
        'name' => 'Arial Narrow',
        'size' => '12'
      ),
      'alignment' => array(
        'wrap' => true,
      )
    );

    $obj = json_decode($data, true);
    $no = 1;
    $baseRow = 9;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['sisa_lalu'])
        ->setCellValue('C' . $row, $item['diterima_bulan_ini'])
        ->setCellValue('D' . $row, $item['dicabut'])
        ->setCellValue('E' . $row, $item['putus_bulan_ini'])
        ->setCellValue('F' . $row, '0')
        ->setCellValue('G' . $row, $item['putus_bulan_ini'])
        ->setCellValue('H' . $row, $item['sisa_bulan_ini'])
        ->getRowDimension($row)->setRowHeight(65);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A9:H' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A9:H' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A9:H' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "B";
    $kolom_pansek = "G";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
}


/* End of file Laporan_perkara.php */
/* Location: ./application/controllers/Laporan_perkara.php */
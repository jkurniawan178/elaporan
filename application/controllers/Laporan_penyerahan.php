<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Laporan_penyerahan
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

class Laporan_penyerahan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('masuk_model');
    $this->load->model('laporan_model');
    $this->load->library('Config_library');
  }

  public function index()
  {
    $this->masuk_model->sequrity('mn_laporan');
    $menu = $this->masuk_model->getMenu();
    $data['menu'] = $menu;
    $data['contents'] = 'v_laporan_penyerahan';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  //-----------------------------------------------------------------------------------------------
  //----------------Fungsi get laporan LIPA yang dipanggil dari view-------------------------------
  public function get_laporan()
  {
    $jenis_laporan = $this->input->post('jenis_laporan');
    $tahun = $this->input->post('tahun');
    $bulan = $this->input->post('bulan');
    $tanggal_laporan = tgl_ke_mysql($this->input->post('tanggal_laporan'));
    $settingSIPP = $this->config_library->get_config_SIPP();

    if ($jenis_laporan != null) {
      switch ($jenis_laporan) {
          //-------------------------------------------------------------------------------------------------------
        case 'penyerahan_ac':
          $data = $this->laporan_model->getPenyerahanAC($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_penyerahanAC($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
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
              'data' => 'Laporan Penyerahan AC Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
        case 'penyerahan_salinan':
          $data = $this->laporan_model->getPenyerahanSalinan($bulan, $tahun);

          if (count($data) != 0) {
            $encoded = json_encode($data);
            $hasil = $this->export_excel_penyerahanSalinan($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
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
              'data' => 'Laporan Penyerahan Salinan Putusan' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
            ];
            echo json_encode($response);
          }
          break;
          //-------------------------------------------------------------------------------------------------------
          // case 'penyerahan_kuasa':
          // $data = $this->laporan_model->getLIPA3($bulan, $tahun);

          // if (count($data) != 0) {
          //   $encoded = json_encode($data);
          //   $hasil = $this->export_excel_lipa3($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
          //   $view_table = 'laporan_table/table_' . $jenis_laporan;
          //   $response = [
          //     'kode' => '200',
          //     'link' => $hasil,
          //     'table' => $this->load->view($view_table, '', true),
          //     'data' => $data
          //   ];
          //   echo json_encode($response);
          // } else {
          //   $response = [
          //     'kode' => '201',
          //     'data' => 'Laporan Lipa 3 Periode ' . pilihbulan($bulan) . ' ' . $tahun . ' belum ada!'
          //   ];
          //   echo json_encode($response);
          // }
          // break;
          //-------------------------------------------------------------------------------------------------------
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
  //--------------------------------Export Data Penyerahan AC ke Excel-----------------------------------
  protected function export_excel_penyerahanAC($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
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
    $baseRow = 8;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['nomor_perkara'])
        ->setCellValue('C' . $row, $item['nomor_akta_cerai'])
        ->setCellValue('D' . $row, $item['jenis_cerai'])
        ->setCellValue('E' . $row, tgl_dari_mysql($item['tanggal_putusan']))
        ->setCellValue('F' . $row, tgl_dari_mysql($item['tgl_ikrar_talak']))
        ->setCellValue('G' . $row, tgl_dari_mysql($item['tanggal_bht']))
        ->setCellValue('H' . $row, tgl_dari_mysql($item['tgl_penyerahan']))
        ->setCellValue('I' . $row, $item['penerima'])
        ->setCellValue('J' . $row,  '-')
        ->getRowDimension($row)->setRowHeight(46);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow . ':J' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow . ':J' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow . ':J' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "G";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //fungsi tanda tangan

    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
  //----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Penyerahan AC ke Excel-----------------------------------
  protected function export_excel_penyerahanSalinan($data, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan)
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
    $baseRow = 8;

    $objPHPExcel->getActiveSheet()->setCellValue('A2', "PADA " . $settingSIPP['NamaPN']);
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "BULAN " . strtoupper(pilihbulan($bulan)) . " " . $tahun);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['nomor_perkara'])
        ->setCellValue('C' . $row, $item['jenis_perkara_nama'])
        ->setCellValue('D' . $row, tgl_dari_mysql($item['tanggal_pendaftaran']))
        ->setCellValue('E' . $row, tgl_dari_mysql($item['tanggal_putusan']))
        ->setCellValue('F' . $row, tgl_dari_mysql($item['tanggal_bht']))
        ->setCellValue('G' . $row, tgl_dari_mysql($item['tanggal_transaksi']))
        ->setCellValue('H' . $row, kode_pihak($item['alur_perkara_id'], $item['jenis_perkara_id'], $item['penerima']))
        ->setCellValue('I' . $row,  '-')
        ->getRowDimension($row)->setRowHeight(46);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow . ':I' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow . ':I' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow . ':I' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "C";
    $kolom_pansek = "G";
    $row = $row + 3;
    $row_awal_ttd = $row;
    //fungsi tanda tangan

    //Fungsi untuk kolom TTD
    $row = $this->write_kolom_TTD($objPHPExcel, $kolom_kpa, $kolom_pansek, $row, $row_awal_ttd, $settingSIPP, $tanggal_laporan);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
}


/* End of file Laporan_penyerahan.php */
/* Location: ./application/controllers/Laporan_penyerahan.php */
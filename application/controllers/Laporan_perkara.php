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
    $this->load->model('laporan_model');
    $this->load->helper('fungsi_helper');
    $this->load->library('Config_library');
  }
  //-----------------------------------------------------------------------------------------------
  public function index()
  {
    $data['contents'] = 'v_laporan_perkara';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();

    $this->load->view('templates/index', $data);
  }
  //-----------------------------------------------------------------------------------------------
  public function get_lipa()
  {
    $jenis_laporan = $this->input->post('jenis_laporan');
    $tahun = $this->input->post('tahun');
    $bulan = $this->input->post('bulan');
    $tanggal_laporan = tgl_ke_mysql($this->input->post('tanggal_laporan'));
    $settingSIPP = $this->config_library->get_config_SIPP();

    if ($jenis_laporan != null) {

      switch ($jenis_laporan) {
        case 'lipa_1':
          # code...
          break;
        case 'lipa_2':
          $data = $this->laporan_model->getLIPA2($bulan, $tahun);
          $encoded = json_encode($data);
          $hasil = $this->export_excel_lipa2($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
          echo json_encode($hasil);
          break;
        case 'lipa_3':
          $data = $this->laporan_model->getLIPA3($bulan, $tahun);
          $encoded = json_encode($data);
          $hasil = $this->export_excel_lipa3($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
          echo json_encode($hasil);
          break;
        default:
          # code...
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
  //-----------------------------------------------------------------------------------------------
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
          'style' => PHPExcel_Style_Border::BORDER_THIN
        ),
      ),
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
        ->setCellValue('L' . $row,  '')
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
    $kota_pa = ucwords(strtolower(str_replace("PENGADILAN AGAMA ", "", str_replace("MAHKAMAH SYAR'IYAH ", "", $settingSIPP['NamaPN']))));

    $KetuaPNNama = $settingSIPP['KetuaPNNama'];
    $PanSekNama = $settingSIPP['PanSekNama'];
    $KetuaPNNIP = $settingSIPP['KetuaPNNIP'];
    $PanSekNIP = $settingSIPP['PanSekNIP'];
    $row = $row + 3;
    $row_awal_ttd = $row;
    //fungsi tanda tangan

    $objPHPExcel->getActiveSheet()
      ->setCellValue($kolom_kpa . $row, "Mengetahui")
      ->setCellValue($kolom_pansek . $row, $kota_pa . ", " . tgl_panjang_dari_mysql($tanggal_laporan))
      ->getRowDimension($row)->setRowHeight(20);


    $row++;
    $objPHPExcel->getActiveSheet()
      ->setCellValue($kolom_kpa . $row, "Ketua " . ucwords(strtolower($settingSIPP['NamaPN'])))
      ->setCellValue($kolom_pansek . $row, "Panitera")
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
    $objPHPExcel->getActiveSheet()->getStyle($kolom_kpa . $row_awal_ttd . ':' . $kolom_pansek . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //fungsi tanda tangan 
    //tanda tangan 
    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $namafile = $tahun . '_' . $bulan . '_' . $jenis_laporan . '.xlsx';
    $file = FCPATH . 'hasil/' . $namafile;
    $objWriter->save($file);
    $response = [
      'kode' => '200',
      'data' => base_url() . 'hasil/' . $namafile
    ];
    return $response;
  }
  //-----------------------------------------------------------------------------------------------
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
        ),
      ),
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
        ->setCellValue('H' . $row, tgl_dari_mysql(($item['tanggal_cabut'] === null) ? $item['putusan_kasasi'] : $item['tanggal_cabut']))
        ->setCellValue('I' . $row, tgl_dari_mysql($item['penerimaan_berkas_kasasi']))
        ->setCellValue('J' . $row, tgl_dari_mysql($item['pbt_putusan_p']) . chr(13) . tgl_dari_mysql($item['pbt_putusan_t']))
        ->setCellValue('K' . $row, ($item['tanggal_cabut'] !== null) ? 'cabut' : null)
        ->getRowDimension($row)->setRowHeight(18);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A10:K' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A10:K' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A10:K' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    //tanda tangan 
    $kolom_kpa = "B";
    $kolom_pansek = "H";
    $kota_pa = ucwords(strtolower(str_replace("PENGADILAN AGAMA ", "", str_replace("MAHKAMAH SYAR'IYAH ", "", $settingSIPP['NamaPN']))));

    $KetuaPNNama = $settingSIPP['KetuaPNNama'];
    $PanSekNama = $settingSIPP['PanSekNama'];
    $KetuaPNNIP = $settingSIPP['KetuaPNNIP'];
    $PanSekNIP = $settingSIPP['PanSekNIP'];
    $row = $row + 3;
    $row_awal_ttd = $row;
    //fungsi tanda tangan

    $objPHPExcel->getActiveSheet()
      ->setCellValue($kolom_kpa . $row, "Mengetahui")
      ->setCellValue($kolom_pansek . $row, $kota_pa . ", " . tgl_panjang_dari_mysql($tanggal_laporan))
      ->getRowDimension($row)->setRowHeight(20);


    $row++;
    $objPHPExcel->getActiveSheet()
      ->setCellValue($kolom_kpa . $row, "Ketua " . ucwords(strtolower($settingSIPP['NamaPN'] . ',')))
      ->setCellValue($kolom_pansek . $row, "Panitera,")
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
    $objPHPExcel->getActiveSheet()->getStyle($kolom_kpa . $row_awal_ttd . ':' . $kolom_pansek . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //fungsi tanda tangan 
    //tanda tangan 
    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $namafile = $tahun . '_' . $bulan . '_' . $jenis_laporan . '.xlsx';
    $file = FCPATH . 'hasil/' . $namafile;
    $objWriter->save($file);
    $response = [
      'kode' => '200',
      'data' => base_url() . 'hasil/' . $namafile
    ];
    return $response;
  }
}


/* End of file Laporan_perkara.php */
/* Location: ./application/controllers/Laporan_perkara.php */
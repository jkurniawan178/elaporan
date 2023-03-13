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
    $this->load->library('Config_library');
    $this->load->model('sidkel_model');
  }
  //-----------------------------------------------------------------------------------------------
  public function index()
  {
    $data['contents'] = 'v_laporan_perkara';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();

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
        case 'lipa_4':
          $data = $this->laporan_model->getLIPA4($bulan, $tahun);
          $encoded = json_encode($data);
          $hasil = $this->export_excel_lipa4($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
          echo json_encode($hasil);
          break;
        case 'lipa_5':
          $data = $this->laporan_model->getLIPA5($bulan, $tahun);
          $encoded = json_encode($data);
          $hasil = $this->export_excel_lipa5($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
          echo json_encode($hasil);
          break;
        case 'lipa_14':
          $data = $this->sidkel_model->getLIPA14($bulan, $tahun);
          $encoded = json_encode($data);
          $hasil = $this->export_excel_lipa14($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
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
  //----------------------------------------------------------------------------------------------
  //--------------------------------Helper Output Excel-------------------------------------------
  protected function writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan)
  {
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
        ),
        'font' => array(
          'name' => 'Arial Narrow'
        ),
        'alignment' => array(
          'wrap' => true,
        )
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
        ->setCellValue('H' . $row, tgl_dari_mysql(($item['tanggal_cabut'] === null) ? $item['putusan_banding'] : $item['tanggal_cabut']))
        ->setCellValue('I' . $row, tgl_dari_mysql($item['penerimaan_kembali_berkas_banding']))
        ->setCellValue('J' . $row, tgl_dari_mysql($item['pbt_banding_p']) . chr(13) . tgl_dari_mysql($item['pbt_banding_t']))
        ->setCellValue('K' . $row,  '')
        ->setCellValue('L' . $row, ($item['tanggal_cabut'] === null) ? '' : 'cabut')
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
    $objPHPExcel->getActiveSheet()->getStyle($kolom_kpa . $row_awal_ttd . ':' . $kolom_pansek . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //fungsi tanda tangan 
    //tanda tangan 
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
        ),
        'font' => array(
          'name' => 'Arial Narrow'
        ),
        'alignment' => array(
          'wrap' => true,
        )
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
        ->getRowDimension($row)->setRowHeight(35);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A10:K' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A10:K' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A10:K' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

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
        ),
        'font' => array(
          'name' => 'Arial Narrow'
        ),
        'alignment' => array(
          'wrap' => true,
        )
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
        ->setCellValue('D' . $row, $item['nomor_putusan_kasasi'])
        ->setCellValue('E' . $row, tgl_dari_mysql($item['permohonan_pk']))
        ->setCellValue('F' . $row, tgl_dari_mysql($item['pengiriman_berkas_pk']))
        ->setCellValue('G' . $row, tgl_dari_mysql(($item['tanggal_cabut'] === null) ? $item['putusan_pk'] : $item['tanggal_cabut']))
        ->setCellValue('H' . $row, tgl_dari_mysql($item['penerimaan_berkas_pk']))
        ->setCellValue('I' . $row, tgl_dari_mysql($item['pbt_pk_p']) . chr(13) . tgl_dari_mysql($item['pbt_pk_t']))
        ->setCellValue('J' . $row, ($item['tanggal_cabut'] !== null) ? 'cabut' : null)
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
        ),
        'font' => array(
          'name' => 'Arial Narrow'
        ),
        'alignment' => array(
          'wrap' => true,
        )
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
        ),
        'font' => array(
          'name' => 'Arial Narrow'
        ),
        'alignment' => array(
          'wrap' => true,
        )
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

    return $this->writeExcel($objPHPExcel, $tahun, $bulan, $jenis_laporan);
  }
}


/* End of file Laporan_perkara.php */
/* Location: ./application/controllers/Laporan_perkara.php */
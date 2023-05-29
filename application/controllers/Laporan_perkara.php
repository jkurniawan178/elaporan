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
        case 'lipa_1':
          $data = $this->laporan_model->getLIPA1($bulan, $tahun);
          $encoded = json_encode($data);
          $datahasil = $data['hasil'];
          $rekap = $data['rekapitulasi'];
          $hasil = $this->export_excel_lipa1($datahasil, $rekap, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
          echo json_encode($hasil);
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

        case 'lipa_6':
          $data = $this->laporan_model->getLIPA6($bulan, $tahun);
          $encoded = json_encode($data);
          $hasil = $this->export_excel_lipa6($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
          echo json_encode($hasil);
          break;

        case 'lipa_8':
          $data = $this->laporan_model->getLIPA8($bulan, $tahun);
          $encoded = json_encode($data);
          $hasil = $this->export_excel_lipa8($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
          echo json_encode($hasil);
          break;

        case 'lipa_10':
          $data = $this->laporan_model->getLIPA10($bulan, $tahun);
          $encoded = json_encode($data);
          $hasil = $this->export_excel_lipa10($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
          echo json_encode($hasil);
          break;

        case 'lipa_14':
          $data = $this->sidkel_model->getLIPA14($bulan, $tahun);
          $encoded = json_encode($data);
          $hasil = $this->export_excel_lipa14($encoded, $jenis_laporan, $settingSIPP, $bulan, $tahun, $tanggal_laporan);
          echo json_encode($hasil);
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
    $response = [
      'kode' => '200',
      'data' => base_url() . 'hasil/' . $namafile
    ];
    return $response;
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
        ),
        'font' => array(
          'name' => 'Arial Narrow'
        ),
        'alignment' => array(
          'wrap' => true,
        )
      ),
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
    $row = $row + 4;
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
      'borders' => array(
        // 'allborders' => array(
        //   'style' => PHPExcel_Style_Border::BORDER_THIN,
        // ),
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
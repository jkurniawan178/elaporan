<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Monitoring_lama_perkara
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

class Monitoring_lama_perkara extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('masuk_model');
    $this->load->model('monitoring_model');
    $this->load->library('Config_library');
  }

  public function index()
  {
    $this->masuk_model->sequrity('mn_monitoring');
    $menu = $this->masuk_model->getMenu();
    $data['menu'] = $menu;
    $data['contents'] = 'v_lama_perkara';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  public function get_lama_perkara()
  {
    $jenis_monitor = $this->input->post('jenis_monitor');
    $tanggal_monitor = tgl_ke_mysql(($this->input->post('tanggal_monitor')));
    $tanggal_laporan = $this->input->post('tanggal_laporan');
    $settingSIPP = $this->config_library->get_config_SIPP();

    $data = $this->monitoring_model->get_lama_perkara($tanggal_monitor);
    if (count($data) != 0) {
      $encoded = json_encode($data);
      $hasil = $this->export_excel_lama($encoded, $jenis_monitor, $settingSIPP, $tanggal_monitor, $tanggal_laporan);
      $view_table = 'laporan_table/table_' . $jenis_monitor;
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
        'data' => 'Jadwal Sidang Pada Tanggal ' . $tanggal_monitor . ' belum ada!'
      ];
      echo json_encode($response);
    }
  }
  //----------------------------------------------------------------------------------------------
  //--------------------------------Helper Output Excel-------------------------------------------
  protected function writeExcel($objPHPExcel, $tanggal_monitor, $jenis_laporan)
  {
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $namafile = $tanggal_monitor . '_' . $jenis_laporan . '.xlsx';
    $file = FCPATH . 'hasil/' . $namafile;
    $objWriter->save($file);
    $link = base_url() . 'hasil/' . $namafile;
    return $link;
  }
  //----------------------------------------------------------------------------------------------
  //--------------------------------Export Data Monitoring Lama Perkara-------------------------------------------
  protected function export_excel_lama($data, $jenis_monitor, $settingSIPP, $tanggal_monitor, $tanggal_laporan)
  {
    if (!file_exists(FCPATH . "new_templates/" . $jenis_monitor . ".xls")) {
      $response = [
        'kode' => '202',
        'data' => 'Template Belum Tersedia'
      ];
      return $response;
      exit;
    }

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load(FCPATH . "new_templates/" . $jenis_monitor . ".xls");

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
    $objPHPExcel->getActiveSheet()->setCellValue('A3', "SIDANG HARI " . $tanggal_laporan);
    foreach ($obj as $item) {
      $row = $baseRow + $no;

      $objPHPExcel->getActiveSheet()
        ->setCellValue('A' . $row, $no)
        ->setCellValue('B' . $row, $item['nomor_perkara'])
        ->setCellValue('C' . $row, $item['agenda'])
        ->setCellValue('D' . $row, str_replace('<br/>', ", ", str_replace('</br>', ", ", $item['majelis_hakim_nama'])))
        ->setCellValue('E' . $row, $item['panitera_pengganti'])
        ->setCellValue('F' . $row, $item['umur_perkara'])
        ->setCellValue('G' . $row, 'Hari')
        ->getRowDimension($row)->setRowHeight(29);

      //$objPHPExcel->getActiveSheet()->insertNewRowAfter($row); 
      $no++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow . ':G' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow . ':G' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow . ':G' . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    $objPHPExcel->getActiveSheet()->removeRow($baseRow, 1);

    return $this->writeExcel($objPHPExcel, $tanggal_monitor, $jenis_monitor);
  }
}


/* End of file Monitoring_lama_perkara.php */
/* Location: ./application/controllers/Monitoring_lama_perkara.php */
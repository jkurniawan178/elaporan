<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'third_party/TCPDF-6.6.2/tcpdf.php';
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Verifikasi_lipa
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

class Verifikasi_lipa extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('perkara_lipa_model');
  }

  public function do_verifikasi()
  {
    $urlExcel = $this->input->post('url');
    $baselong = strlen(base_url());
    $path = substr($urlExcel, $baselong);

    $hasilPDF = $this->excel_to_pdf($path);
    var_dump($hasilPDF);
    //1.1. ubah file excel hasil generate menjadi pdf 
    //1.2. kirim file pdf untuk ditandatangani panitera
    //1.3. insert data to tabel laporan_lipa di database termasuk token hasil dari bssrn 
    //1.4. return hasil kembali
  }

  public function excel_to_pdf($path)
  {
    $this->load->library('pdf');

    $file = FCPATH . $path;
    if (file_exists($file)) {
      echo 'File exist';
    } else {
      echo 'file not found';
    }
    $objPHPExcel = PHPExcel_IOFactory::load($file);
    // $objPHPExcel->setActiveSheetIndex(0);
    // $html_writer = new PHPExcel_Writer_HTML($objPHPExcel);
    // $html = $html_writer->generateSheetData();
    $worksheet = $objPHPExcel->getActiveSheet();
    $data = $worksheet->toArray();

    $html = '<table>';
    foreach ($data as $row) {
      $html .= '<tr>';
      foreach ($row as $cell) {
        $html .= '<td>' . $cell . '</td>';
      }
      $html .= '</tr>';
    }
    $html .= '</table>';

    var_dump($html);
    $pdf = new Pdf();
    // $pdf->loadHtml($html);
    // $pdf->setPaper('A4', 'landscape');

    // $pdf->render();
    // $pdf_file_path = FCPATH . 'hasil/pdf2.pdf';
    // file_put_contents($pdf_file_path, $pdf->output());
  }
}


/* End of file Verifikasi_lipa.php */
/* Location: ./application/controllers/Verifikasi_lipa.php */
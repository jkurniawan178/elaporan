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
  }

  public function index()
  {
    $data['contents'] = 'v_laporan_perkara';
    $data['nm_bulan'] = array(
      '01' => 'Januari', '02' => 'Pebruari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
      '10' => 'Oktober', '11' => 'Nopember', '12' => 'Desember', '1' => 'Januari', '2' => 'Pebruari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni',
      '7' => 'Juli', '8' => 'Agustus', '9' => 'September',
    );

    $this->load->view('templates/index', $data);
  }

  public function get_lipa()
  {
    $jenis_laporan = $this->input->post('jenis_laporan');
    $tahun = $this->input->post('tahun');
    echo json_encode($jenis_laporan);
  }
}





/* End of file Laporan_perkara.php */
/* Location: ./application/controllers/Laporan_perkara.php */
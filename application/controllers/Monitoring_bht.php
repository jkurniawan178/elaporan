<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Monitoring_bht
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

class Monitoring_bht extends CI_Controller
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
    $data['contents'] = 'v_monitor_bht';
    $data['pp_list'] = $this->monitoring_model->get_pp();
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  public function get_monitor_bht()
  {
    $jenis_monitor = $this->input->post('jenis_monitor');
    $ppid = $this->input->post('panitera_id');
    $ppnama = $this->input->post('panitera_nama');
    $tahun = $this->input->post('tahun');

    $data = $this->monitoring_model->getMonitorBHT($ppid, $tahun);

    $response = [
      'kode' => '201',
      'data' => 'Perkara belum BHT PP :' . $ppnama . ' Tidak ada!'
    ];

    if (!empty($data)) {
      $response = [
        'kode' => '200',
        'table' => $this->load->view('laporan_table/table_' . $jenis_monitor, '', true),
        'data' => $data
      ];
    }
    echo json_encode($response);
  }
}


/* End of file Monitoring_bht.php */
/* Location: ./application/controllers/Monitoring_bht.php */
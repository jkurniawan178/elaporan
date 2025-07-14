<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Monitoring_perkara_kecamatan
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

class Monitoring_perkara_kecamatan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('masuk_model');
    $this->load->model('monitoring_model');
    $this->load->model('yuridiksi_model');
    $this->load->library('Config_library');
  }

  public function index()
  {
    $this->masuk_model->sequrity('mn_monitoring');
    $menu = $this->masuk_model->getMenu();
    $data['menu'] = $menu;
    $data['dateNow'] = date('d/m/Y');
    $data['yuridiksi'] = $this->yuridiksi_model->getYuridiksi();
    $data['contents'] = 'monitor_kecamatan/v_monitor_kecamatan';
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  public function get_monitor_perKecamatan()
  {
    $jenis_monitor = $this->input->post('jenis_monitor');
    $kabupaten_kode = $this->input->post('kabupaten_kode');
    $tanggal_start = tgl_ke_mysql($this->input->post('tanggal_start'));
    $tanggal_end = tgl_ke_mysql($this->input->post('tanggal_end'));

    $data = $this->monitoring_model->getMonitorPerkaraKecamatan($kabupaten_kode, $tanggal_start, $tanggal_end);
    $response = [
      'kode' => '201',
      'data' => 'Data Perkara Tidak ada!'
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


/* End of file Monitoring_perkara_kecamatan.php */
/* Location: ./application/controllers/Monitoring_perkara_kecamatan.php */
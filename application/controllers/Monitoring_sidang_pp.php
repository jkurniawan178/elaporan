<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Sidang_pp
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

class Monitoring_sidang_pp extends CI_Controller
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
    $data['dateNow'] = date('d/m/Y');
    $data['contents'] = 'v_sidang_pp';
    $data['pp_list'] = $this->monitoring_model->get_pp();
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  public function get_sidang_pp()
  {
    $jenis_monitor = $this->input->post('jenis_monitor');
    $ppid = $this->input->post('panitera_id');
    $tanggal_start = tgl_ke_mysql($this->input->post('tanggal_start'));
    $tanggal_end = tgl_ke_mysql($this->input->post('tanggal_end'));

    $data = $this->monitoring_model->get_sidang_pp($ppid, $tanggal_start, $tanggal_end);
    if (count($data) != 0) {
      $view_table = 'laporan_table/table_' . $jenis_monitor;
      $response = [
        'kode' => '200',
        'table' => $this->load->view($view_table, '', true),
        'data' => $data
      ];
      echo json_encode($response);
    } else {
      $response = [
        'kode' => '201',
        'data' => 'Persidangan periode ' . tgl_panjang_dari_mysql($tanggal_start) . ' s/d ' . tgl_panjang_dari_mysql($tanggal_end) . ' belum ada!'
      ];
      echo json_encode($response);
    }
  }
}


/* End of file Sidang_pp.php */
/* Location: ./application/controllers/Sidang_pp.php */
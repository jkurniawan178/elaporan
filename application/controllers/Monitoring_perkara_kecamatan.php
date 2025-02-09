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
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }
}


/* End of file Monitoring_perkara_kecamatan.php */
/* Location: ./application/controllers/Monitoring_perkara_kecamatan.php */
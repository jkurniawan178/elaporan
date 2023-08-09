<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Elitigasi
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

class Elitigasi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('elitigasi_model');
    $this->load->library('Config_library');
  }

  public function index()
  {
    $data['contents'] = 'elitigasi/v_elitigasi';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $data['elitigasi'] = $this->elitigasi_model->getLitigasiAll();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }
}


/* End of file Elitigasi.php */
/* Location: ./application/controllers/Elitigasi.php */
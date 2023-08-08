<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Posbakum
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

class Posbakum extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('config_library');
    $this->load->model('posbakum_model');
  }

  public function index()
  {
    $data['contents'] = 'posbakum/v_posbakum';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $data['posbakum'] = $this->posbakum_model->getLipa16All();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }
}


/* End of file Posbakum.php */
/* Location: ./application/controllers/Posbakum.php */
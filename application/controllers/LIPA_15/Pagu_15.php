<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Pagu_15
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

class Pagu_15 extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('prodeo_model');
    $this->load->library('config_library');
  }

  public function index()
  {
    $data['contents'] = 'pagu_15/v_pagu_15';
    $data['pagu_15'] = $this->prodeo_model->getPagu15All();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }
}


/* End of file Pagu_15.php */
/* Location: ./application/controllers/Pagu_15.php */
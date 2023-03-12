<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Sidkel
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

class Sidkel extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('config_library');
  }

  public function index()
  {
    $data['contents'] = 'sidkel/v_sidkel';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $this->load->view('templates/index', $data);
  }
}


/* End of file Sidkel.php */
/* Location: ./application/controllers/Sidkel.php */
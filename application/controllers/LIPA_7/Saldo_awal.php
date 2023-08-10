<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Saldo_awal
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

class Saldo_awal extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('keuangan_model');
    $this->load->library('config_library');
  }

  public function index()
  {
    $data['contents'] = 'saldo_awal/v_saldo_awal';
    $data['saldo_awal'] = $this->keuangan_model->getSaldoAwalAll();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }
}


/* End of file Saldo_awal.php */
/* Location: ./application/controllers/Saldo_awal.php */
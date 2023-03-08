<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Tes_laporan
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

class Tes_laporan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('laporan_model');
  }

  public function index()
  {
    // $data['lipa2'] = $this->laporan_model->getLIPA2('01', '2023');
    // $this->load->view('laporan/template_pdf/v_template_lipa2', $data);
  }
}


/* End of file Tes_laporan.php */
/* Location: ./application/controllers/Tes_laporan.php */
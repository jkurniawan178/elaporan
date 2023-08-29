<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Input_iwadl
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

class Input_iwadl extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('masuk_model');
    $this->masuk_model->sequrity();
  }

  public function index()
  {
    $data['contents'] = 'v_input_iwadl';
    $this->load->view('templates/index', $data);
  }
}


/* End of file Input_iwadl.php */
/* Location: ./application/controllers/Input_iwadl.php */
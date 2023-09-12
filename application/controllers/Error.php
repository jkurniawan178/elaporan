<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Error
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

class Error extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    // 
  }

  public function forbidden()
  {
    $this->load->view('errors/html/error_403');
  }
}


/* End of file Error.php */
/* Location: ./application/controllers/Error.php */
<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Jenis_laporan_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Jenis_laporan_model extends CI_Model
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function get_all_jenis()
  {
    $db2 = $this->load->database('dbelaporan', true);
    $query = $db2->get('jenis_laporan');
    // var_dump($query->result());
    return $query->result();
  }

  // ------------------------------------------------------------------------

}

/* End of file Jenis_laporan_model.php */
/* Location: ./application/models/Jenis_laporan_model.php */
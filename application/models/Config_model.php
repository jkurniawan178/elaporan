<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Config_model
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

class Config_model extends CI_Model
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function index()
  {
    // 
  }

  public function get_config()
  {
    $sql = "SELECT id, value FROM sys_config where (id>=61 AND   id<=73) or  id=76 or  id=80 or  id=82";
    $hasil = $this->db->query($sql);
    return $hasil->result();
  }

  // ------------------------------------------------------------------------

}

/* End of file Config_model.php */
/* Location: ./application/models/Config_model.php */
<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Masuk_model
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

class Masuk_model extends CI_Model
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  public function processLogin($userName = NULL, $password)
  {
    $q = $this->db->query("SELECT userid, fullname, username as nama_user , password as kata_sandi, code_activation, group_name, group_id, jurusita_id FROM v_users where username='$userName'");
    return $q;
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function index()
  {
    // 
  }

  // ------------------------------------------------------------------------

}

/* End of file Masuk_model.php */
/* Location: ./application/models/Masuk_model.php */
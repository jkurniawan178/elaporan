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

  public function sequrity($menu)
  {
    if ($this->session->userdata('userid') == NULL or $this->session->userdata('userid') == "") {
      $this->session->sess_destroy();
      redirect('masuk');
    } else {
      $group_id = $this->session->userdata('group_id');

      if ($group_id <= '10' || $group_id == '30' || $group_id == '430') { // Admin, Ketua, Wakil, Panitera, panmud hukum
        // Admin, Ketua, Wakil, Panitera
      } else if ($group_id == '431' || $group_id == '1003') { //Staff panmud hukum, meja 3 gugatan
        if ($menu == 'mn_saldo') {
          redirect('error/forbidden');
        }
      } else if ($group_id == '20' || $group_id == '1000' || $group_id == '1010' || $group_id == '1020' || $group_id == '500') // Hakim, Panmud, PP
      {
        if ($menu == 'mn_saldo' || $menu == 'mn_pagu' || $menu == 'mn_input') {
          redirect('error/forbidden');
        }
      } else if ($group_id == '702') { // KASIR

        if ($menu == 'mn_pagu' || $menu == 'mn_input') {
          redirect('error/forbidden');
        }
      } else {
        $this->session->sess_destroy();
        redirect('masuk');
        return;
      }
    }
  }

  // ------------------------------------------------------------------------
  public function getMenu()
  {
    if ($this->session->userdata('userid') != NULL or $this->session->userdata('userid') != "") {
      //set menu berdasarkan user
      $menu = array(
        'mn_pagu' => true,
        'mn_input' => true,
        'mn_laporan' => true,
        'mn_saldo' => true
      );

      $group_id = $this->session->userdata('group_id');

      if ($group_id <= '10' || $group_id == '30' || $group_id == '430') { // Admin, Ketua, Wakil, Panitera, panmud hukum
        // Admin, Ketua, Wakil, Panitera
      } else if ($group_id == '431' || $group_id == '1003') { //Staff panmud hukum, meja 3 gugatan
        $menu['mn_saldo'] = false;
      } else if ($group_id == '20' || $group_id == '1000' || $group_id == '1010' || $group_id == '1020' || $group_id == '500') // Hakim, Panmud, PP
      {
        $menu['mn_input'] = false;
        $menu['mn_pagu'] = false;
        $menu['mn_saldo'] = false;
      } else if ($group_id == '702') { // KASIR
        $menu['mn_input'] = false;
        $menu['mn_pagu'] = false;
      } else {
        $this->session->sess_destroy();
        redirect('masuk');
        return;
      }

      return $menu;
    }
  }

  // ------------------------------------------------------------------------
  public function index()
  {
    // 
  }

  // ------------------------------------------------------------------------

}

/* End of file Masuk_model.php */
/* Location: ./application/models/Masuk_model.php */
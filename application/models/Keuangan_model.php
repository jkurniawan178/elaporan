<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Keuangan_model
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

class Keuangan_model extends CI_Model
{

  protected $db2;
  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
    $this->db2 = $this->load->database('dbelaporan', true);
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  //--------------------------------------Saldo Awal LIPA Keuangan-----------------------
  //-------------------------------------------------------------------------------------
  public function getSaldoAwalAll()
  {
    $query  = $this->db2->get('elaporan_saldo_awal');
    $data = $query->result();

    //Encrypt the ID before sending it into client-side
    foreach ($data as $row) {
      $row->id = $this->encryption->encrypt($row->id);
    }

    return $data;
  }

  // ------------------------------------------------------------------------

}

/* End of file Keuangan_model.php */
/* Location: ./application/models/Keuangan_model.php */
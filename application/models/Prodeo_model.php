<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Prodeo_model_model
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

class Prodeo_model extends CI_Model
{

  // ------------------------------------------------------------------------
  protected $db2;
  public function __construct()
  {
    parent::__construct();
    //initialize db2
    $this->db2 = $this->load->database('dbelaporan', true);
  }


  //--------------------------------------PAGU LIPA 15-----------------------------------
  //-------------------------------------------------------------------------------------
  public function getPagu15All()
  {
    $query  = $this->db2->get('elaporan_pagu_15');
    $data = $query->result();

    //Encrypt the ID before sending it into client-side
    foreach ($data as $row) {
      $row->id = $this->encryption->encrypt($row->id);
    }

    return $data;
  }
  // ------------------------------------------------------------------------

}

/* End of file Prodeo_model_model.php */
/* Location: ./application/models/Prodeo_model_model.php */
<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Pagu_14_model
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

class Pagu_14_model extends CI_Model
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

  public function get_pagu_14_all()
  {
    $db2 = $this->load->database('dbelaporan', true);
    $query  = $db2->get('elaporan_pagu_14');
    // var_dump($query);
    return $query->result();
  }
  // ------------------------------------------------------------------------
  public function input_data($data)
  {
    $db2 = $this->load->database('dbelaporan', true);
    $db2->insert('elaporan_pagu_14', $data);
  }
  //-------------------------------------------------------------------------
  public function searchby_year($year)
  {
    $db2 = $this->load->database('dbelaporan', true);
    $sql = "SELECT COUNT(tahun_anggaran) AS jml, pagu_awal, pagu_revisi FROM elaporan_pagu_14 WHERE tahun_anggaran = $year";
    $hasil = $db2->query($sql);
    return $hasil->result();
  }
}

/* End of file Pagu_14_model.php */
/* Location: ./application/models/Pagu_14_model.php */
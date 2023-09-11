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
  public function searchSaldoAwalbyYear($year)
  {
    $sql = "SELECT tahun FROM elaporan_saldo_awal WHERE tahun = $year";
    $hasil = $this->db2->query($sql);
    return $hasil->result();
  }
  // ------------------------------------------------------------------------
  public function inputSaldoAwal($data)
  {
    $this->db2->insert('elaporan_saldo_awal', $data);
  }
  // ------------------------------------------------------------------------
  //-------------------------------------------------------------------------
  public function getSaldoAwalbyId($id)
  {
    $data = $this->db2->get_where('elaporan_saldo_awal', array('id' => $id));

    if ($data->num_rows() > 0) {
      return $data->row(); //REturn the first row as an object
    } else {
      return null;
    }
  }
  //-------------------------------------------------------------------------
  public function updateSaldoAwal($id, $data)
  {
    $this->db2->where('id', $id);
    $this->db2->update('elaporan_saldo_awal', $data);
  }
  //-------------------------------------------------------------------------
  public function deleteSaldoAwal($where)
  {
    $this->db2->where($where);
    $this->db2->delete('elaporan_saldo_awal');
  }
}

/* End of file Keuangan_model.php */
/* Location: ./application/models/Keuangan_model.php */
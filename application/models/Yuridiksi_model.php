<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Yuridiksi_model_model
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

class Yuridiksi_model extends CI_Model
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
    //initialize db2
    $this->db2 = $this->load->database('dbelaporan', true);
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function index()
  {
    // 
  }

  public function getProvinsi()
  {
    $this->db->select('*');
    $this->db->from('ref_provinsi_new');
    $hasil = $this->db->get()->result();
    return $hasil;
  }

  public function getKabupaten($provinsi_kode)
  {
    $this->db->select('*');
    $this->db->from('ref_kabupaten_new');
    $this->db->where('provinsi_kode', $provinsi_kode);
    $hasil = $this->db->get()->result();
    return $hasil;
  }

  public function getProvinsiById($provinsi_kode)
  {
    $this->db->select('*');
    $this->db->from('ref_provinsi_new');
    $this->db->where('provinsi_kode', $provinsi_kode);
    $hasil = $this->db->get()->row();
    return $hasil;
  }

  public function getKabupatenById($kabupaten_kode)
  {
    $this->db->select('*');
    $this->db->from('ref_kabupaten_new');
    $this->db->where('kabupaten_kode', $kabupaten_kode);
    $hasil = $this->db->get()->row();
    return $hasil;
  }
  public function getYuridiksi()
  {
    $this->db2->select('*');
    $this->db2->from('ref_yuridiksi');
    $hasil = $this->db2->get()->result();

    foreach ($hasil as $row) {
      $row->id = $this->encryption->encrypt($row->id);
    }
    return $hasil;
  }

  public function inputYuridiksi($data)
  {
    $this->db2->insert('ref_yuridiksi', $data);
  }

  public function deleteYuridiksi($id)
  {
    $this->db2->where('id', $id);
    $this->db2->delete('ref_yuridiksi');
  }

  // ------------------------------------------------------------------------

}

/* End of file Yuridiksi_model_model.php */
/* Location: ./application/models/Yuridiksi_model_model.php */
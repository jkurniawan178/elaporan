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
  public function searchPagu15byYear($year)
  {
    $sql = "SELECT tahun_anggaran, pagu_revisi, pagu_awal FROM elaporan_pagu_15 WHERE tahun_anggaran = $year";
    $hasil = $this->db2->query($sql);
    return $hasil->result();
  }
  // ------------------------------------------------------------------------
  public function inputPagu15($data)
  {
    $this->db2->insert('elaporan_pagu_15', $data);
  }
  //-------------------------------------------------------------------------
  public function getPagu15byId($id)
  {
    $data = $this->db2->get_where('elaporan_pagu_15', array('id' => $id));

    if ($data->num_rows() > 0) {
      return $data->row(); //REturn the first row as an object
    } else {
      return null;
    }
  }
  //-------------------------------------------------------------------------
  public function updatePagu15($id, $data)
  {
    $this->db2->where('id', $id);
    $this->db2->update('elaporan_pagu_15', $data);
  }
  //-------------------------------------------------------------------------
  function cekLipa15byPagu($idPagu)
  {
    $sql = "SELECT r.id
    FROM elaporan_lipa_15 r
    INNER JOIN elaporan_pagu_15 p ON r.tahun = p.tahun_anggaran
    where p.id = '$idPagu'";

    $hasil = $this->db2->query($sql);
    return $hasil->result();
  }
  //-------------------------------------------------------------------------
  public function deletePagu15($where)
  {
    $this->db2->where($where);
    $this->db2->delete('elaporan_pagu_15');
  }

  //-------------------------PART LAPORAN LIPA PRODEO (15)-------------------
  //-------------------------------------------------------------------------
  function getLipa15All()
  {
    $sql = "SELECT r.id, r.bulan, r.tahun, p.pagu_awal, p.pagu_revisi,
            COALESCE(SUM(r2.realisasi), 0) AS realisasi_sampai_bulan_lalu,
            r.realisasi,
            COALESCE(SUM(r2.realisasi), 0) + r.realisasi AS jumlah_realisasi,
            IF(p.pagu_revisi = 0, p.pagu_awal, p.pagu_revisi) - (COALESCE(SUM(r2.realisasi), 0) + r.realisasi) AS saldo,
            p.target_perkara, r.jml_perkara, r.keterangan
            FROM elaporan_lipa_15 r
            INNER JOIN elaporan_pagu_15 p ON r.tahun = p.tahun_anggaran
            LEFT JOIN elaporan_lipa_15 r2 ON r.bulan > r2.bulan AND r2.tahun = r.tahun
            GROUP BY r.id,r.bulan, r.tahun, p.pagu_awal, r.realisasi
            ORDER BY r.tahun desc, r.bulan DESC";
    $hasil = $this->db2->query($sql);
    return $hasil->result();
  }
}

/* End of file Prodeo_model_model.php */
/* Location: ./application/models/Prodeo_model_model.php */
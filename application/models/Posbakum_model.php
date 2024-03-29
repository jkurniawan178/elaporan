<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Posbakum_model
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

class Posbakum_model extends CI_Model
{

  // ------------------------------------------------------------------------
  protected $db2;
  public function __construct()
  {
    parent::__construct();
    $this->db2 = $this->load->database('dbelaporan', true);
  }

  //--------------------------------------PAGU LIPA 15-----------------------------------
  //-------------------------------------------------------------------------------------
  public function getPagu16All()
  {
    $query  = $this->db2->get('elaporan_pagu_16');
    $data = $query->result();

    //Encrypt the ID before sending it into client-side
    foreach ($data as $row) {
      $row->id = $this->encryption->encrypt($row->id);
    }

    return $data;
  }

  // ------------------------------------------------------------------------
  // ------------------------------------------------------------------------
  public function searchPagu16byYear($year)
  {
    $sql = "SELECT tahun_anggaran, pagu_revisi, pagu_awal FROM elaporan_pagu_16 WHERE tahun_anggaran = $year";
    $hasil = $this->db2->query($sql);
    return $hasil->result();
  }
  // ------------------------------------------------------------------------
  public function inputPagu16($data)
  {
    $this->db2->insert('elaporan_pagu_16', $data);
  }
  //-------------------------------------------------------------------------
  public function getPagu16byId($id)
  {
    $data = $this->db2->get_where('elaporan_pagu_16', array('id' => $id));

    if ($data->num_rows() > 0) {
      return $data->row(); //REturn the first row as an object
    } else {
      return null;
    }
  }
  //-------------------------------------------------------------------------
  public function updatePagu16($id, $data)
  {
    $this->db2->where('id', $id);
    $this->db2->update('elaporan_pagu_16', $data);
  }
  //-------------------------------------------------------------------------
  public function cekLipa16byPagu($idPagu)
  {
    $sql = "SELECT r.id
            FROM elaporan_lipa_16 r
            INNER JOIN elaporan_pagu_16 p ON r.tahun = p.tahun_anggaran
            where p.id = $idPagu";
    $hasil = $this->db2->query($sql);
    return $hasil->result();
  }
  //-------------------------------------------------------------------------
  public function deletePagu16($where)
  {
    $this->db2->where($where);
    $this->db2->delete('elaporan_pagu_16');
  }

  //-------------------------------------------------------------------------
  function cekSaldoPagu16($year)
  {
    $sql = "SELECT p.tahun_anggaran AS tahun,  p.pagu_awal,
          p.pagu_revisi,
          COALESCE(SUM(r.realisasi), 0) AS total_realisasi,
          CASE
              WHEN SUM(r.realisasi) IS NULL THEN
                  CASE
                      WHEN p.pagu_revisi = 0 THEN p.pagu_awal
                      ELSE p.pagu_revisi
                  END
              ELSE
                  IF(p.pagu_revisi = 0, p.pagu_awal, p.pagu_revisi) - COALESCE(SUM(r.realisasi), 0)
          END AS saldo_sisa
          FROM elaporan_pagu_16 p
          LEFT JOIN elaporan_lipa_16 r ON p.tahun_anggaran = r.tahun
          WHERE p.tahun_anggaran = '$year'
          GROUP BY p.tahun_anggaran, p.pagu_awal, p.pagu_revisi
          ORDER BY p.tahun_anggaran DESC";

    $hasil = $this->db2->query($sql);
    return $hasil->row();
  }

  //-------------------------PART LAPORAN LIPA PRODEO (15)-------------------
  //-------------------------------------------------------------------------
  public function cekLipa16byPeriode($bulan, $tahun)
  {
    $sql = "SELECT COUNT(r.id) as id_count
          FROM elaporan_lipa_16 r
          WHERE r.bulan = $bulan AND r.tahun = $tahun";
    $hasil = $this->db2->query($sql);
    return $hasil->row();
  }
  //-------------------------------------------------------------------------
  function getLipa16All()
  {
    $sql = "SELECT r.id, r.bulan, r.tahun, p.pagu_awal, p.pagu_revisi,
          COALESCE(SUM(r2.realisasi), 0) AS realisasi_sampai_bulan_lalu,
          r.realisasi,
          COALESCE(SUM(r2.realisasi), 0) + r.realisasi AS jumlah_realisasi,
          IF(p.pagu_revisi = 0, p.pagu_awal, p.pagu_revisi) - (COALESCE(SUM(r2.realisasi), 0) + r.realisasi) AS saldo,
          p.target_layanan, r.jml_layanan, r.keterangan
          FROM elaporan_lipa_16 r
          INNER JOIN elaporan_pagu_16 p ON r.tahun = p.tahun_anggaran
          LEFT JOIN elaporan_lipa_16 r2 ON r.bulan > r2.bulan AND r2.tahun = r.tahun
          GROUP BY r.id,r.bulan, r.tahun, p.pagu_awal, r.realisasi
          ORDER BY r.tahun desc, r.bulan DESC";
    $hasil = $this->db2->query($sql);
    $data = $hasil->result();
    foreach ($data as $row) {
      $row->id = $this->encryption->encrypt($row->id);
    }
    return $data;
  }
  //--------------------------------------------------------------------------
  public function inputLipa16($data)
  {
    $db2 = $this->load->database('dbelaporan', true);
    $db2->insert('elaporan_lipa_16', $data);
  }
  //-------------------------------------------------------------------------
  public function deleteLipa16($where)
  {
    $this->db2->where($where);
    $this->db2->delete('elaporan_lipa_16');
  }
  //-------------------------------------------------------------------------
  public function getLipa16byId($id)
  {
    $sql = " SELECT
            r.id, r.bulan, r.tahun,
            IF(p.pagu_revisi = 0, p.pagu_awal, p.pagu_revisi) AS pagu_awal,
            r.realisasi,
            r.jml_layanan,
            r.keterangan
            FROM elaporan_lipa_16 r
            INNER JOIN elaporan_pagu_16 p ON r.tahun = p.tahun_anggaran
            WHERE r.id = '$id'";
    $hasil = $this->db2->query($sql);
    return $hasil->row();
  }
  //-------------------------------------------------------------------------
  public function updateLipa16($id, $data)
  {
    $this->db2->where('id', $id);
    $this->db2->update('elaporan_lipa_16', $data);
  }
  //-------------------------------------------------------------------------
  public function getLipa16YearFilter($tahun)
  {
    if ($tahun === 'all') {
      $where = "";
    } else {
      $where = "WHERE r.tahun = $tahun";
    }

    $sql = "SELECT r.id, r.bulan, r.tahun,p.pagu_awal, p.pagu_revisi,
          COALESCE(SUM(r2.realisasi), 0) AS realisasi_sampai_bulan_lalu,
          r.realisasi,
          COALESCE(SUM(r2.realisasi), 0) + r.realisasi AS jumlah_realisasi,
          IF(p.pagu_revisi = 0, p.pagu_awal, p.pagu_revisi) - (COALESCE(SUM(r2.realisasi), 0) + r.realisasi) AS saldo,
          p.target_layanan, r.jml_layanan, r.keterangan
          FROM elaporan_lipa_16 r
          INNER JOIN elaporan_pagu_16 p ON r.tahun = p.tahun_anggaran
          LEFT JOIN elaporan_lipa_16 r2 ON r.bulan > r2.bulan AND r2.tahun = r.tahun
          $where
          GROUP BY r.id,r.bulan, r.tahun, p.pagu_awal, r.realisasi
          ORDER BY r.tahun desc, r.bulan DESC";
    $hasil = $this->db2->query($sql);
    $data = $hasil->result();

    foreach ($data as $row) {
      $row->id = $this->encryption->encrypt($row->id);
    }
    return $data;
  }
}

/* End of file Posbakum_model.php */
/* Location: ./application/models/Posbakum_model.php */
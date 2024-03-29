<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Sidkel_model
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

class Sidkel_model extends CI_Model
{
  protected $db2;
  public function __construct()
  {
    parent::__construct();
    //initialize db2
    $this->db2 = $this->load->database('dbelaporan', true);
  }

  public function index()
  {
    // 
  }
  //-------------------INPUT Manual Laporan Sidang Keliling (LIPA 14)--------------------
  //-------------------------------------------------------------------------------------
  public function input_data($data)
  {
    $this->db2->insert('elaporan_lipa_14', $data);
  }

  public function get_All()
  {
    $sql = "SELECT r.id, r.bulan, r.tahun, p.pagu_awal, p.pagu_revisi,
            COALESCE(SUM(r2.realisasi), 0) AS realisasi_sampai_bulan_lalu,
            r.realisasi,
            COALESCE(SUM(r2.realisasi), 0) + r.realisasi AS jumlah_realisasi,
            IF(p.pagu_revisi = 0, p.pagu_awal, p.pagu_revisi) - (COALESCE(SUM(r2.realisasi), 0) + r.realisasi) AS saldo,
            r.jml_kegiatan, r.jml_perkara, r.keterangan
            FROM elaporan_lipa_14 r
            INNER JOIN elaporan_pagu_14 p ON r.tahun = p.tahun_anggaran
            LEFT JOIN elaporan_lipa_14 r2 ON r.bulan > r2.bulan AND r2.tahun = r.tahun
            GROUP BY r.id,r.bulan, r.tahun, p.pagu_awal, r.realisasi
            ORDER BY r.tahun desc, r.bulan DESC";
    $hasil = $this->db2->query($sql);
    $data = $hasil->result();

    foreach ($data as $row) {
      $row->id = $this->encryption->encrypt($row->id);
    }
    return $data;
  }

  public function getLipa14YearFilter($tahun)
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
            r.jml_kegiatan, r.jml_perkara, r.keterangan
            FROM elaporan_lipa_14 r
            INNER JOIN elaporan_pagu_14 p ON r.tahun = p.tahun_anggaran
            LEFT JOIN elaporan_lipa_14 r2 ON r.bulan > r2.bulan AND r2.tahun = r.tahun
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

  public function cekLipa14byPeriode($bulan, $tahun)
  {
    $sql = "SELECT COUNT(r.id) as id_count
            FROM elaporan_lipa_14 r
            WHERE r.bulan = $bulan AND r.tahun = $tahun";
    $hasil = $this->db2->query($sql);
    return $hasil->row();
  }

  public function getLipa14byId($id)
  {
    $sql = " SELECT
              r.id, r.bulan, r.tahun,
              IF(p.pagu_revisi = 0, p.pagu_awal, p.pagu_revisi) AS pagu_awal,
              r.realisasi,
              r.jml_kegiatan,
              r.jml_perkara,
              r.keterangan
              FROM elaporan_lipa_14 r
              INNER JOIN elaporan_pagu_14 p ON r.tahun = p.tahun_anggaran
              WHERE r.id = '$id'";
    $hasil = $this->db2->query($sql);
    return $hasil->row();
  }
  //-------------------------------------------------------------------------
  public function deleteLipa14($where)
  {
    $this->db2->where($where);
    $this->db2->delete('elaporan_lipa_14');
  }
  //-------------------------------------------------------------------------
  public function updateLipa14($id, $data)
  {
    $this->db2->where('id', $id);
    $this->db2->update('elaporan_lipa_14', $data);
  }

  //--------------------------------------PAGU LIPA 14-----------------------------------
  //-------------------------------------------------------------------------------------
  public function getPagu14All()
  {
    $query  = $this->db2->get('elaporan_pagu_14');
    $data = $query->result();

    //Encrypt the ID before sending it into client-side
    foreach ($data as $row) {
      $row->id = $this->encryption->encrypt($row->id);
    }

    return $data;
  }
  // ------------------------------------------------------------------------
  public function inputPagu14($data)
  {
    $this->db2->insert('elaporan_pagu_14', $data);
  }
  //-------------------------------------------------------------------------
  public function searchPagu14byYear($year)
  {
    $sql = "SELECT tahun_anggaran, pagu_revisi, pagu_awal FROM elaporan_pagu_14 WHERE tahun_anggaran = $year";
    $hasil = $this->db2->query($sql);
    return $hasil->result();
  }
  //-------------------------------------------------------------------------
  public function cekSaldoPagu14($year)
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
            FROM elaporan_pagu_14 p
            LEFT JOIN elaporan_lipa_14 r ON p.tahun_anggaran = r.tahun
            WHERE p.tahun_anggaran = '$year'
            GROUP BY p.tahun_anggaran, p.pagu_awal, p.pagu_revisi
            ORDER BY p.tahun_anggaran DESC";
    $hasil = $this->db2->query($sql);
    return $hasil->row();
  }
  //-------------------------------------------------------------------------
  public function deletePagu14($where)
  {
    $this->db2->where($where);
    $this->db2->delete('elaporan_pagu_14');
  }
  //-------------------------------------------------------------------------
  public function updatePagu14($id, $data)
  {
    $this->db2->where('id', $id);
    $this->db2->update('elaporan_pagu_14', $data);
  }
  //-------------------------------------------------------------------------
  public function getPagu14byId($id)
  {
    $data = $this->db2->get_where('elaporan_pagu_14', array('id' => $id));

    if ($data->num_rows() > 0) {
      return $data->row(); //REturn the first row as an object
    } else {
      return null;
    }
  }
  //-------------------------------------------------------------------------
  public function cekLipa14byPagu($idPagu)
  {
    $sql = "SELECT r.id
    FROM elaporan_lipa_14 r
    INNER JOIN elaporan_pagu_14 p ON r.tahun = p.tahun_anggaran
    where p.id = '$idPagu'";

    $hasil = $this->db2->query($sql);
    return $hasil->result();
  }
}

/* End of file Sidkel_model.php */
/* Location: ./application/models/Sidkel_model.php */
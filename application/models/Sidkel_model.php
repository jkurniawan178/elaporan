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
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    // 
  }
  //-------------------INPUT Manual Laporan Sidang Keliling (LIPA 14)--------------------
  //-------------------------------------------------------------------------------------
  public function input_data($data)
  {
    $db2 = $this->load->database('dbelaporan', true);
    $db2->insert('elaporan_lipa_14', $data);
  }

  public function get_All()
  {
    $db2 = $this->load->database('dbelaporan', true);
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
    $hasil = $db2->query($sql);
    return $hasil->result();
  }

  public function getLIPA14($bulan, $tahun)
  {
    $db2 = $this->load->database('dbelaporan', true);
    $sql = "SELECT r.id, r.bulan, r.tahun,p.pagu_awal, p.pagu_revisi,
            COALESCE(SUM(r2.realisasi), 0) AS realisasi_sampai_bulan_lalu,
            r.realisasi,
            COALESCE(SUM(r2.realisasi), 0) + r.realisasi AS jumlah_realisasi,
            IF(p.pagu_revisi = 0, p.pagu_awal, p.pagu_revisi) - (COALESCE(SUM(r2.realisasi), 0) + r.realisasi) AS saldo,
            r.jml_kegiatan, r.jml_perkara, r.keterangan
            FROM elaporan_lipa_14 r
            INNER JOIN elaporan_pagu_14 p ON r.tahun = p.tahun_anggaran
            LEFT JOIN elaporan_lipa_14 r2 ON r.bulan > r2.bulan AND r2.tahun = r.tahun
            WHERE r.bulan = $bulan AND r.tahun = $tahun
            GROUP BY r.id,r.bulan, r.tahun, p.pagu_awal, r.realisasi
            ORDER BY r.tahun, r.bulan DESC";
    $hasil = $db2->query($sql);
    return $hasil->result();
  }

  public function cekby_periode($bulan, $tahun)
  {
    $db2 = $this->load->database('dbelaporan', true);
    $sql = "SELECT COUNT(r.id) as id_count
            FROM elaporan_lipa_14 r
            WHERE r.bulan = $bulan AND r.tahun = $tahun";
    $hasil = $db2->query($sql);
    return $hasil->result();
  }

  //--------------------------------------PAGU LIPA 14-----------------------------------
  //-------------------------------------------------------------------------------------
  public function get_pagu_14_all()
  {
    $db2 = $this->load->database('dbelaporan', true);
    $query  = $db2->get('elaporan_pagu_14');
    $data = $query->result();

    //Encrypt the ID before sending it into client-side
    foreach ($data as $row) {
      $row->id = $this->encryption->encrypt($row->id);
    }

    return $data;
  }
  // ------------------------------------------------------------------------
  public function input_pagu14($data)
  {
    $db2 = $this->load->database('dbelaporan', true);
    $db2->insert('elaporan_pagu_14', $data);
  }
  //-------------------------------------------------------------------------
  public function searchby_year($year)
  {
    $db2 = $this->load->database('dbelaporan', true);
    $sql = "SELECT tahun_anggaran FROM elaporan_pagu_14 WHERE tahun_anggaran = $year";
    $hasil = $db2->query($sql);
    return $hasil->result();
  }
  //-------------------------------------------------------------------------
  public function delete_pagu14($where)
  {
    $db2 = $this->load->database('dbelaporan', true);
    $db2->where($where);
    $db2->delete('elaporan_pagu_14');
  }
}

/* End of file Sidkel_model.php */
/* Location: ./application/models/Sidkel_model.php */
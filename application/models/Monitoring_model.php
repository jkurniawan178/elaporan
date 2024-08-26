<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Monitoring_model
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

class Monitoring_model extends CI_Model
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------
  // ------------------Monitoring Lama Perkara-------------------------------
  function get_lama_perkara($tanggal_monitor)
  {

    $sql = "SELECT 
            p.perkara_id, p.nomor_perkara, ps.agenda, pt.majelis_hakim_nama, trim(substring_index(pt.panitera_pengganti_text,':',-1)) as panitera_pengganti,
          CASE
              WHEN pp.tanggal_putusan IS NULL THEN TIMESTAMPDIFF(day,p.tanggal_pendaftaran,CURDATE()) - 
              coalesce(timestampdiff(day,pm.penetapan_penunjukan_mediator,pm.tgl_laporan_mediator),0) + 1
              ELSE timestampdiff(day,p.tanggal_pendaftaran,pp.tanggal_putusan)- 
              coalesce(timestampdiff(day,pm.penetapan_penunjukan_mediator,pm.tgl_laporan_mediator),0) + 1
            END AS umur_perkara
          FROM
            perkara p left join perkara_putusan pp using(perkara_id)
            left join perkara_jadwal_sidang ps using(perkara_id)
            left join perkara_mediasi pm using(perkara_id)
            left join perkara_penetapan pt using(perkara_id)
          where 
            ps.tanggal_sidang = '$tanggal_monitor'";
    $hasil = $this->db->query($sql);
    return $hasil->result();
  }

  // ------------------------------------------------------------------------
  // --------------------Monitoring Persidangan by PS------------------------

  function get_pp()
  {
    $this->db->select('id, nama_gelar');
    $this->db->from('panitera_pn');
    $this->db->where('aktif', 'Y');
    $hasil = $this->db->get()->result();
    return $hasil;
  }

  function get_sidang_pp($ppid, $tanggal_start, $tanggal_end)
  {

    $sql = "SELECT pr.nomor_perkara, pr.jenis_perkara_text, js.agenda, pp.panitera_nama, js.tanggal_sidang, js.edoc_bas
            FROM perkara pr INNER JOIN perkara_panitera_pn pp ON pp.perkara_id = pr.perkara_id
            INNER JOIN perkara_jadwal_sidang js ON js.perkara_id = pp.perkara_id
            WHERE js.tanggal_sidang >= '$tanggal_start' AND js.tanggal_sidang <= '$tanggal_end' 
            AND pp.panitera_id ='$ppid' AND aktif = 'Y'
            ORDER BY js.tanggal_sidang DESC";
    $hasil = $this->db->query($sql);

    $data = $hasil->result();
    $server_ip = 'http://' . $_SERVER['HTTP_HOST'];
    $sipp_folder = '/SIPP311/';

    foreach ($data as $row) {
      if ($row->edoc_bas != null) {
        $row->edoc_bas = $server_ip . $sipp_folder . $row->edoc_bas;
      }
    }
    return $data;
  }

  function getMonitorBHT($ppid, $tahun)
  {
    if ($ppid == "all") {
      $where = " WHERE YEAR(p.`tanggal_pendaftaran`) = $tahun
            AND pp.`tanggal_putusan` IS NOT NULL
            AND (pp.tanggal_bht IS NULL OR pp.`tanggal_bht` > NOW()) ";
    } else {
      $where = " WHERE YEAR(p.`tanggal_pendaftaran`) = $tahun
            and panitera_pengganti_id = $ppid
            AND pp.`tanggal_putusan` IS NOT NULL
            AND (pp.tanggal_bht IS NULL OR pp.`tanggal_bht` > NOW()) ";
    }

    $sql = "SELECT nomor_perkara, jenis_perkara_nama, tanggal_putusan,jenis_putusan, 
            PP,PBT, tanggal_bht, DATEDIFF(CURRENT_DATE(), IFNULL(PBT,tanggal_putusan)) AS selisih_belum_BHT
            FROM (
            SELECT p.nomor_perkara, p.jenis_perkara_nama, pp.tanggal_putusan,sp.`nama` AS jenis_putusan, 
            REPLACE(pt.`panitera_pengganti_text`,'Panitera Pengganti: ','') AS PP, MAX(pbt.tanggal_pemberitahuan_putusan) AS PBT,
            pp.tanggal_bht

            FROM perkara p LEFT JOIN perkara_putusan pp USING(perkara_id)
            LEFT JOIN status_putusan sp ON sp.id = pp.`status_putusan_id`
            LEFT JOIN perkara_penetapan pt USING(perkara_id)
            LEFT JOIN perkara_putusan_pemberitahuan_putusan pbt USING(perkara_id)

            $where

            GROUP BY 
                nomor_perkara, 
                jenis_perkara_nama, 
                PP
            ) AS subquery
            ORDER BY PP ASC, selisih_Belum_BHT DESC";
    $hasil = $this->db->query($sql);
    $data = $hasil->result();
    return $data;
  }
  function getMonitorAlihMedia($ppid, $tahun, $show_ikrar)
  {
    // Menampilkan nilai $show_ikrar di console browser
    $where = " WHERE YEAR(p.`tanggal_pendaftaran`) = $tahun";

    if ($ppid != "all") {
      $where .= " AND pt.panitera_pengganti_id = $ppid";
    }

    if ($show_ikrar == 'false') {
      $where .= " AND tahapan_terakhir_id <> 18 ";
    }

    $sql = "SELECT nomor_perkara,jenis_perkara_text, tanggal_putusan, jenis_putusan, PP, tanggal_bht, tgl_akta_cerai,proses_terakhir,
            nomor_arsip, selisih_hari,
            CASE
                WHEN selisih_hari <= 5 THEN '5'
                WHEN selisih_hari = 6 THEN '3'
                WHEN selisih_hari = 7 THEN '2'
                WHEN selisih_hari = 8 THEN '1'
                WHEN selisih_hari >= 9 THEN '0'
                ELSE 'Cek Kembali'
            END AS perkiraan_nilai
            FROM(
            SELECT p.nomor_perkara, pp.tanggal_putusan, sp.`nama` AS jenis_putusan, p.`jenis_perkara_text`,
            REPLACE(pt.`panitera_pengganti_text`,'Panitera Pengganti: ','') AS PP, p.`proses_terakhir_text` AS proses_terakhir,
            pp.tanggal_bht, pa.`tgl_akta_cerai`, a.`nomor_arsip`, DATEDIFF(CURRENT_DATE(), IFNULL(pa.tgl_akta_cerai,pp.`tanggal_bht`)) AS selisih_hari

            FROM perkara p LEFT JOIN perkara_putusan pp USING(perkara_id)
            LEFT JOIN perkara_akta_cerai pa USING(perkara_id)
            LEFT JOIN arsip a USING(perkara_id)
            LEFT JOIN status_putusan sp ON sp.id = pp.`status_putusan_id`
            LEFT JOIN perkara_penetapan pt USING(perkara_id)

            $where
            AND a.`nomor_arsip` IS NULL
            AND pp.`tanggal_putusan` IS NOT NULL
            AND pp.tanggal_bht IS NOT NULL) AS subquery
            ORDER BY PP ASC, selisih_hari DESC";
    $hasil = $this->db->query($sql);
    $data = $hasil->result();
    return $data;
  }
}

/* End of file Monitoring_model.php */
/* Location: ./application/models/Monitoring_model.php */
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
}

/* End of file Monitoring_model.php */
/* Location: ./application/models/Monitoring_model.php */
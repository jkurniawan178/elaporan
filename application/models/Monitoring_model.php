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

}

/* End of file Monitoring_model.php */
/* Location: ./application/models/Monitoring_model.php */
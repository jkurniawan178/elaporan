<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Elitigasi_model
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

class Elitigasi_model extends CI_Model
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
  public function index()
  {
    // 
  }

  // ------------------------------------------------------------------------
  public function getLitigasiAll()
  {
    $sql = "SELECT lit.id, p.perkara_id, p.nomor_perkara, p.jenis_perkara_nama, p.`tanggal_pendaftaran`,
            pen.majelis_hakim_nama,
            SUBSTRING_INDEX(pen.panitera_pengganti_text,': ',-1) AS panitera_pengganti,
            put.`tanggal_putusan`, st.`nama` AS jenis_putusan,
            IF(tanggal_putusan IS NULL,nomor_perkara,'') AS belum_diputus
            
            FROM perkara p LEFT JOIN perkara_putusan put USING(perkara_id)
            LEFT JOIN perkara_penetapan pen USING(perkara_id)
            LEFT JOIN status_putusan st ON st.id=put.`status_putusan_id`
            INNER JOIN dbelaporan.`elaporan_lipa_24` lit USING(perkara_id)";
    $hasil = $this->db->query($sql);
    $data = $hasil->result();

    foreach ($data as $row) {
      $row->id = $this->encryption->encrypt($row->id);
      $row->perkara_id = $this->encryption->encrypt($row->perkara_id);
    }
    return $data;
  }
}

/* End of file Elitigasi_model.php */
/* Location: ./application/models/Elitigasi_model.php */
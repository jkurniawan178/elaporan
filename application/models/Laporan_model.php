<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Laporan_model
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

class Laporan_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function index()
	{
		// 
	}

	public function getLIPA1($bulan, $tahun)
	{
	}

	public function getLIPA2($bulan, $tahun)
	{
		$sql = "
					SELECT 
					bdg.perkara_id
					,perkara_penetapan.majelis_hakim_nama
					, bdg.nomor_perkara_pn
					, bdg.putusan_pn
					, bdg.permohonan_banding
					, (SELECT pemberitahuan_inzage FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=1 limit 1) as pbt_inzage_p
					, (SELECT pemberitahuan_inzage FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=4 limit 1) as pbt_inzage_t
					, bdg.pengiriman_berkas_banding
					, bdg.putusan_banding
					, bdg.penerimaan_kembali_berkas_banding 
					, (SELECT pemberitahuan_putusan_banding FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=1 limit 1) as pbt_banding_p
					, (SELECT pemberitahuan_putusan_banding FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=4 limit 1) as pbt_banding_t
					FROM perkara_banding AS bdg
					LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=bdg.perkara_id
					WHERE LEFT(bdg.permohonan_banding,7)<'$tahun-$bulan' AND bdg.putusan_banding IS NULL OR LEFT(bdg.putusan_banding,7)>='$tahun-$bulan'

					UNION 

					SELECT 
					bdg.perkara_id
					,perkara_penetapan.majelis_hakim_nama
					, bdg.nomor_perkara_pn
					, bdg.putusan_pn
					, bdg.permohonan_banding
					, (SELECT pemberitahuan_inzage FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=1 limit 1) as pbt_inzage_p
					, (SELECT pemberitahuan_inzage FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=4 limit 1) as pbt_inzage_t
					, bdg.pengiriman_berkas_banding
					, bdg.putusan_banding
					, bdg.penerimaan_kembali_berkas_banding 
					, (SELECT pemberitahuan_putusan_banding FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=1 limit 1) as pbt_banding_p
					, (SELECT pemberitahuan_putusan_banding FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=4 limit 1) as pbt_banding_t
					FROM perkara_banding AS bdg
					LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=bdg.perkara_id
					WHERE LEFT(bdg.permohonan_banding,7)='$tahun-$bulan' AND bdg.putusan_banding IS NULL OR LEFT(bdg.putusan_banding,7)>='$tahun-$bulan'
				
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------

}

/* End of file Laporan_model.php */
/* Location: ./application/models/Laporan_model.php */
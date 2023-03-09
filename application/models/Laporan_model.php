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

	public function getLIPA1($bulan, $tahun)
	{
	}
	// ------------------------------------------------------------------------
	public function getLIPA2($bulan, $tahun)
	{
		$sql = "
				SELECT 	bdg.perkara_id
				,perkara_penetapan.majelis_hakim_nama
				,bdg.nomor_perkara_pn
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
				WHERE date_format( bdg.permohonan_banding,'%Y-%m')>='1900-01' and date_format( bdg.permohonan_banding,'%Y-%m')<='$tahun-$bulan' 
				AND (bdg.putusan_banding IS NULL OR date_format(bdg.putusan_banding,'%Y-%m')>='$tahun-$bulan')
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	public function getLIPA3($bulan, $tahun)
	{
		$sql = "
				SELECT 
					kas.perkara_id
					, kas.permohonan_kasasi
					, kas.permohonan_kasasi
					, kas.nomor_perkara_pn
					, kas.penerimaan_memori_kasasi
					, kas.tidak_memenuhi_syarat
					, kas.pengiriman_berkas_kasasi
					, kas.putusan_kasasi
					, kas.penerimaan_berkas_kasasi
					, (SELECT pemberitahuan_putusan_kasasi FROM perkara_kasasi_detil WHERE perkara_id=kas.perkara_id AND status_pihak_id=1 limit 1) AS pbt_putusan_p
					, (SELECT pemberitahuan_putusan_kasasi FROM perkara_kasasi_detil WHERE perkara_id=kas.perkara_id AND status_pihak_id=4 limit 1) AS pbt_putusan_t
					, bdg.nomor_putusan_banding
					FROM perkara_kasasi AS kas
					LEFT JOIN perkara_banding AS bdg ON bdg.perkara_id=kas.perkara_id
					WHERE LEFT(kas.permohonan_kasasi,7)< '$tahun-$bulan' AND kas.putusan_kasasi IS NULL OR LEFT(kas.putusan_kasasi,7)>='$tahun-$bulan'

					UNION
					SELECT 
					kas.perkara_id
					, kas.permohonan_kasasi
					, kas.permohonan_kasasi
					, kas.nomor_perkara_pn
					, kas.penerimaan_memori_kasasi
					, kas.tidak_memenuhi_syarat
					, kas.pengiriman_berkas_kasasi
					, kas.putusan_kasasi
					, kas.penerimaan_berkas_kasasi
					, (SELECT pemberitahuan_putusan_kasasi FROM perkara_kasasi_detil WHERE perkara_id=kas.perkara_id AND status_pihak_id=1 limit 1) AS pbt_putusan_p
					, (SELECT pemberitahuan_putusan_kasasi FROM perkara_kasasi_detil WHERE perkara_id=kas.perkara_id AND status_pihak_id=4 limit 1) AS pbt_putusan_t
					, bdg.nomor_putusan_banding
					FROM perkara_kasasi AS kas
					LEFT JOIN perkara_banding AS bdg ON bdg.perkara_id=kas.perkara_id
					WHERE LEFT(kas.permohonan_kasasi,7)='$tahun-$bulan' AND kas.putusan_kasasi IS NULL OR LEFT(kas.putusan_kasasi,7)>='$tahun-$bulan'
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
}

/* End of file Laporan_model.php */
/* Location: ./application/models/Laporan_model.php */
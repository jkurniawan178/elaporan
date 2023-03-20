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
	// -----------------------------Ambil Data Lipa 1--------------------------
	public function getLIPA1($bulan, $tahun)
	{
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 2--------------------------
	public function getLIPA2($bulan, $tahun)
	{
		$sql = "SELECT DISTINCT
				bdg.perkara_id
				,perkara_penetapan.majelis_hakim_nama
				,bdg.nomor_perkara_pn
				, bdg.putusan_pn
				, bdg.permohonan_banding
				, (SELECT pemberitahuan_inzage FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=1 LIMIT 1) AS pbt_inzage_p
				, (SELECT pemberitahuan_inzage FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=4 LIMIT 1) AS pbt_inzage_t
				, bdg.pengiriman_berkas_banding
				, bdg.putusan_banding
				,(SELECT tanggal_cabut FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=1 LIMIT 1) AS tanggal_cabut
				, bdg.penerimaan_kembali_berkas_banding 
				, (SELECT pemberitahuan_putusan_banding FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=1 LIMIT 1) AS pbt_banding_p
				, (SELECT pemberitahuan_putusan_banding FROM perkara_banding_detil WHERE perkara_id=bdg.perkara_id AND status_pihak_id=4 LIMIT 1) AS pbt_banding_t
				FROM perkara_banding AS bdg LEFT JOIN perkara_banding_detil AS batil ON bdg.`perkara_id` = batil.`perkara_id`
				LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=bdg.perkara_id
				WHERE DATE_FORMAT( bdg.permohonan_banding,'%Y-%m')>='1900-01' AND DATE_FORMAT( bdg.permohonan_banding,'%Y-%m')<='$tahun-$bulan' 
				AND (bdg.putusan_banding IS NULL OR DATE_FORMAT(bdg.putusan_banding,'%Y-%m')>='$tahun-$bulan')
				AND ((SELECT tanggal_cabut FROM perkara_banding_detil WHERE perkara_id=bdg.`perkara_id` AND status_pihak_id=1 LIMIT 1) IS NULL
				OR (SELECT DATE_FORMAT(tanggal_cabut,'%Y-%m') FROM perkara_banding_detil WHERE perkara_id=bdg.`perkara_id` AND status_pihak_id=1 LIMIT 1) >= '$tahun-$bulan')
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 3--------------------------
	public function getLIPA3($bulan, $tahun)
	{
		$sql = "SELECT DISTINCT
				kas.perkara_id
				, kas.permohonan_kasasi
				, kas.permohonan_kasasi
				, kas.nomor_perkara_pn
				, kas.penerimaan_memori_kasasi
				, kas.tidak_memenuhi_syarat
				, kas.pengiriman_berkas_kasasi
				, kas.putusan_kasasi
				, (SELECT tanggal_cabut FROM perkara_kasasi_detil WHERE perkara_id=kas.perkara_id AND status_pihak_id=1 LIMIT 1) AS tanggal_cabut
				, (SELECT catatan_putusan_kasasi FROM perkara_kasasi_detil WHERE perkara_id=kas.perkara_id AND status_pihak_id=1 LIMIT 1) AS keterangan
				, kas.penerimaan_berkas_kasasi
				, (SELECT pemberitahuan_putusan_kasasi FROM perkara_kasasi_detil WHERE perkara_id=kas.perkara_id AND status_pihak_id=1 LIMIT 1) AS pbt_putusan_p
				, (SELECT pemberitahuan_putusan_kasasi FROM perkara_kasasi_detil WHERE perkara_id=kas.perkara_id AND status_pihak_id=4 LIMIT 1) AS pbt_putusan_t
				, bdg.nomor_putusan_banding
				FROM perkara_kasasi AS kas LEFT JOIN perkara_kasasi_detil AS kasdi ON kasdi.`perkara_id`=kas.`perkara_id` 
				LEFT JOIN perkara_banding AS bdg ON bdg.perkara_id=kas.perkara_id
				WHERE DATE_FORMAT( kas.permohonan_kasasi,'%Y-%m')>='1900-01' AND DATE_FORMAT( kas.permohonan_kasasi,'%Y-%m')<='$tahun-$bulan' 
				AND (kas.putusan_kasasi IS NULL OR DATE_FORMAT(kas.putusan_kasasi,'%Y-%m')>='$tahun-$bulan')
				AND ((SELECT tanggal_cabut FROM perkara_kasasi_detil WHERE perkara_id=kas.`perkara_id` AND status_pihak_id=1 LIMIT 1) IS NULL
				OR (SELECT DATE_FORMAT(tanggal_cabut,'%Y-%m') FROM perkara_kasasi_detil WHERE perkara_id=kas.`perkara_id` AND status_pihak_id=1 LIMIT 1) >= '$tahun-$bulan')
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 4--------------------------
	public function getLIPA4($bulan, $tahun)
	{
		$sql = "SELECT DISTINCT
				pk.nomor_perkara_pn
				,bdg.nomor_putusan_banding
				,kas.nomor_putusan_kasasi
				,pk.permohonan_pk 
				,pk.pengiriman_berkas_pk
				,pk.putusan_pk
				,pk.penerimaan_berkas_pk
				,(SELECT pemberitahuan_putusan_pk FROM perkara_pk_detil WHERE perkara_id=pk.perkara_id AND status_pihak_id=1 LIMIT 1) AS pbt_pk_p	
				,(SELECT pemberitahuan_putusan_pk FROM perkara_pk_detil WHERE perkara_id=pk.perkara_id AND status_pihak_id=4 LIMIT 1) AS pbt_pk_t
				,(SELECT tanggal_cabut FROM perkara_pk_detil WHERE perkara_id=pk.`perkara_id` AND status_pihak_id=1 LIMIT 1) AS tanggal_cabut
				FROM perkara_pk AS pk
				LEFT JOIN perkara_pk_detil AS petil ON petil.perkara_id = pk.perkara_id
				LEFT JOIN perkara_banding AS bdg ON bdg.perkara_id=pk.perkara_id	
				LEFT JOIN perkara_kasasi AS kas ON kas.perkara_id=pk.perkara_id
				WHERE DATE_FORMAT( pk.permohonan_pk,'%Y-%m')>='1900-01' AND DATE_FORMAT( pk.permohonan_pk,'%Y-%m')<='$tahun-$bulan' 
				AND (pk.putusan_pk IS NULL OR DATE_FORMAT(pk.putusan_pk,'%Y-%m')>='$tahun-$bulan')
				AND ((SELECT tanggal_cabut FROM perkara_pk_detil WHERE perkara_id=pk.`perkara_id` AND status_pihak_id=1 LIMIT 1) IS NULL
				OR (SELECT DATE_FORMAT(tanggal_cabut,'%Y-%m') FROM perkara_pk_detil WHERE perkara_id=pk.`perkara_id` AND status_pihak_id=1 LIMIT 1) >= '$tahun-$bulan')
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 5--------------------------
	public function getLIPA5($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = "SELECT
				eks.nomor_register_eksekusi AS nomor_register_eksekusi,
				eks.eksekusi_nomor_perkara AS eksekusi_nomor_perkara,
				eks.permohonan_eksekusi AS permohonan_eksekusi,
				eks.penetapan_teguran_eksekusi	AS penetapan_teguran_eksekusi,
				eks.pelaksanaan_teguran_eksekusi AS pelaksanaan_teguran_eksekusi,
				eks.penetapan_sita_eksekusi AS penetapan_sita_eksekusi,
				eks.penetapan_perintah_eksekusi_rill AS penetapan_eksekusi_rill,
				eks.pelaksanaan_eksekusi_rill AS pelaksanaan_eksekusi_rill,
				eks.pelaksanaan_sita_eksekusi AS pelaksanaan_sita_eksekusi,
				eks.penetapan_noneksekusi AS penetapan_noneksekusi, 
				eks.alasan_eksekusi AS alasan									
				FROM perkara_eksekusi AS eks
				WHERE DATE_FORMAT( eks.permohonan_eksekusi,'%Y-%m')>='1900-01' AND DATE_FORMAT( eks.permohonan_eksekusi,'%Y-%m')<='$periode' 
				AND (eks.pelaksanaan_eksekusi_rill = '0000-00-00' OR DATE_FORMAT(eks.pelaksanaan_eksekusi_rill,'%Y-%m')>='$periode')
				AND (eks.penetapan_noneksekusi = '0000-00-00' OR DATE_FORMAT(eks.penetapan_noneksekusi, '%Y-%m') >= '$periode')
				
				UNION
	
				SELECT
				ht.eksekusi_nomor_perkara AS nomor_register_eksekusi,
				ht.putusan_pn AS eksekusi_nomor_perkara,
				ht.permohonan_eksekusi AS permohonan_eksekusi,
				ht.penetapan_teguran_eksekusi	AS penetapan_teguran_eksekusi,
				ht.pelaksanaan_teguran_eksekusi AS pelaksanaan_teguran_eksekusi,
				ht.penetapan_sita_eksekusi AS penetapan_sita_eksekusi,
				ht.penetapan_perintah_eksekusi_rill AS penetapan_eksekusi_rill,
				ht.pelaksanaan_eksekusi_rill AS pelaksanaan_eksekusi_rill,
				ht.pelaksanaan_sita_eksekusi AS pelaksanaan_sita_eksekusi,
				ht.penetapan_noneksekusi AS penetapan_noneksekusi, 
				ht.alasan_eksekusi AS alasan									
				FROM perkara_eksekusi_ht AS ht
				WHERE DATE_FORMAT( ht.permohonan_eksekusi,'%Y-%m')>='1900-01' AND DATE_FORMAT( ht.permohonan_eksekusi,'%Y-%m')<='$periode' 
				AND (ht.pelaksanaan_eksekusi_rill = '0000-00-00' OR DATE_FORMAT(ht.pelaksanaan_eksekusi_rill,'%Y-%m')>='$periode')
				AND (ht.penetapan_noneksekusi = '0000-00-00' OR DATE_FORMAT(ht.penetapan_noneksekusi, '%Y-%m') >= '$periode')
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -	----------------------------Ambil Data Lipa 6--------------------------
	public function getLIPA6($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = "SELECT F.majelis_hakim_text AS nama_gelar,
		(SELECT COUNT(A.nomor_perkara) FROM perkara A LEFT JOIN perkara_putusan B USING (perkara_id)
			LEFT JOIN perkara_penetapan C USING(perkara_id)
			WHERE C.majelis_hakim_id = F.majelis_hakim_id
			AND DATE_FORMAT(A.tanggal_pendaftaran,'%Y-%m')< '$periode' 
			AND (B.tanggal_putusan IS NULL OR DATE_FORMAT(B.tanggal_putusan,'%Y-%m') >= '$periode') 
			AND A.alur_perkara_id = 15
			ORDER BY C.majelis_hakim_text ASC) AS sisa_lalu_G,
		(SELECT COUNT(A.nomor_perkara) FROM perkara A LEFT JOIN perkara_putusan B USING (perkara_id)
			LEFT JOIN perkara_penetapan C USING(perkara_id)
			WHERE C.majelis_hakim_id = F.majelis_hakim_id
			AND DATE_FORMAT(A.tanggal_pendaftaran,'%Y-%m')< '$periode' 
			AND (B.tanggal_putusan IS NULL OR DATE_FORMAT(B.tanggal_putusan,'%Y-%m') >= '$periode') 
			AND A.alur_perkara_id = 16
			ORDER BY C.majelis_hakim_text ASC) AS sisa_lalu_P,
		(SELECT COUNT(A.nomor_perkara) FROM perkara A LEFT JOIN perkara_penetapan B USING(perkara_id)
			WHERE B.majelis_hakim_id = F.majelis_hakim_id AND
			DATE_FORMAT(A.tanggal_pendaftaran,'%Y-%m')='$periode' AND alur_perkara_id = 15) 
			AS Diterima_G,
			(SELECT COUNT(A.nomor_perkara) FROM perkara A LEFT JOIN perkara_penetapan B USING(perkara_id)
			WHERE B.majelis_hakim_id = F.majelis_hakim_id AND
			DATE_FORMAT(A.tanggal_pendaftaran,'%Y-%m')='$periode' AND alur_perkara_id = 16) 
			AS Diterima_P,
		(SELECT COUNT(A.nomor_perkara) FROM perkara A LEFT JOIN perkara_putusan B USING(perkara_id)
			LEFT JOIN perkara_penetapan C USING(perkara_id)
			WHERE C.majelis_hakim_id = F.majelis_hakim_id AND DATE_FORMAT(B.tanggal_putusan,'%Y-%m')='$periode' 
			AND alur_perkara_id = 15) AS putus_G,
		(SELECT COUNT(A.nomor_perkara) FROM perkara A LEFT JOIN perkara_putusan B USING(perkara_id)
			LEFT JOIN perkara_penetapan C USING(perkara_id)
			WHERE C.majelis_hakim_id = F.majelis_hakim_id AND DATE_FORMAT(B.tanggal_putusan,'%Y-%m')='$periode' 
			AND alur_perkara_id = 16) AS putus_P,
		(SELECT COUNT(A.nomor_perkara) FROM perkara A LEFT JOIN perkara_putusan B USING(perkara_id)
			LEFT JOIN perkara_penetapan C USING(perkara_id)
			WHERE C.majelis_hakim_id = F.majelis_hakim_id AND DATE_FORMAT(B.tanggal_minutasi,'%Y-%m')='$periode'
			AND alur_perkara_id = 15) AS minut_G,
		(SELECT COUNT(A.nomor_perkara) FROM perkara A LEFT JOIN perkara_putusan B USING(perkara_id)
			LEFT JOIN perkara_penetapan C USING(perkara_id)
			WHERE C.majelis_hakim_id = F.majelis_hakim_id AND DATE_FORMAT(B.tanggal_minutasi,'%Y-%m')='$periode'
			AND alur_perkara_id = 16) AS minut_P
		FROM perkara D LEFT JOIN perkara_putusan E USING(perkara_id)
		LEFT JOIN perkara_penetapan F USING(perkara_id) 
		WHERE DATE_FORMAT(D.tanggal_pendaftaran,'%Y-%m')<= '$periode' 
		AND (E.tanggal_putusan IS NULL OR DATE_FORMAT(E.tanggal_putusan,'%Y-%m') >= '$periode')
		GROUP BY F.majelis_hakim_id
		ORDER BY majelis_hakim_text ASC";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
}

/* End of file Laporan_model.php */
/* Location: ./application/models/Laporan_model.php */
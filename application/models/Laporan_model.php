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
		$awal_periode = $tahun . '-' . $bulan . '-01';
		$periode = $tahun . '-' . $bulan;

		//----------------------------------Rekapitulasi ---------------------------------------//
		//-------------------------------Sisa Bulan Lalu --------------------------------------//
		//G
		$sisa_bulan_lalu_g = $this->db->query("SELECT a.perkara_id FROM perkara AS a 
							LEFT JOIN perkara_putusan AS b
							ON b.`perkara_id`=a.`perkara_id`  
							WHERE tanggal_pendaftaran <  '$awal_periode' AND ( DATE_FORMAT(tanggal_putusan,'%Y-%m')>='$periode' 
							OR tanggal_putusan IS NULL) AND alur_perkara_id=15
							");
		//G

		//P
		$sisa_bulan_lalu_p = $this->db->query("SELECT a.perkara_id FROM perkara AS a 
							LEFT JOIN perkara_putusan AS b
							ON b.`perkara_id`=a.`perkara_id`  
							WHERE tanggal_pendaftaran <  '$awal_periode' AND ( DATE_FORMAT(tanggal_putusan,'%Y-%m')>='$periode' 
							OR tanggal_putusan IS NULL) AND alur_perkara_id=16
							");
		//P

		//GS
		$sisa_bulan_lalu_gs = $this->db->query("SELECT a.perkara_id FROM perkara AS a 
							LEFT JOIN perkara_putusan AS b
							ON b.`perkara_id`=a.`perkara_id`  
							WHERE tanggal_pendaftaran <  '$awal_periode' AND ( DATE_FORMAT(tanggal_putusan,'%Y-%m')>='$periode' 
							OR tanggal_putusan IS NULL) AND alur_perkara_id=17
							");
		//GS

		//-------------------------------------------Diterima Bulan ini------------------------------------//
		$terima_bulan_ini_g = $this->db->query("SELECT perkara_id FROM perkara 
							WHERE DATE_FORMAT(tanggal_pendaftaran,'%Y-%m')='$periode' AND  alur_perkara_id=15 
							");

		$terima_bulan_ini_p = $this->db->query("SELECT perkara_id FROM perkara 
							WHERE DATE_FORMAT(tanggal_pendaftaran,'%Y-%m')='$periode' AND  alur_perkara_id=16 
							");

		$terima_bulan_ini_gs = $this->db->query("SELECT perkara_id FROM perkara 
							WHERE DATE_FORMAT(tanggal_pendaftaran,'%Y-%m')='$periode' AND  alur_perkara_id=17
							");

		//-------------------------------------------Diputus Bulan ini------------------------------------//	
		$putus_g = $this->db->query("SELECT b.perkara_id FROM perkara AS a
					LEFT JOIN perkara_putusan AS b 
					ON b.`perkara_id`=a.`perkara_id`
					WHERE DATE_FORMAT(tanggal_putusan,'%Y-%m') ='$periode' AND  a.alur_perkara_id=15
					");
		$putus_p = $this->db->query("SELECT b.perkara_id FROM perkara AS a
					LEFT JOIN perkara_putusan AS b 
					ON b.`perkara_id`=a.`perkara_id`
					WHERE DATE_FORMAT(tanggal_putusan,'%Y-%m') ='$periode' AND  a.alur_perkara_id=16
					");
		$putus_gs = $this->db->query("SELECT b.perkara_id FROM perkara AS a
					LEFT JOIN perkara_putusan AS b 
					ON b.`perkara_id`=a.`perkara_id`
					WHERE DATE_FORMAT(tanggal_putusan,'%Y-%m') ='$periode' AND  a.alur_perkara_id=17
					");

		//-------------------------------------------belumdibagi Bulan ini------------------------------------//	
		$belumbagi_g = $this->db->query("SELECT a.perkara_id , a.nomor_perkara FROM perkara AS a
					LEFT JOIN perkara_penetapan AS b ON b.`perkara_id`=a.`perkara_id`
					LEFT JOIN perkara_putusan AS c ON c.perkara_id = a.perkara_id
					WHERE DATE_FORMAT(a.`tanggal_pendaftaran`,'%Y-%m')<='$periode' 
					AND (c.tanggal_putusan IS NULL OR DATE_FORMAT(c.tanggal_putusan,'%Y-%m')>='$periode')
					AND a.alur_perkara_id=15
					AND (b.`penetapan_majelis_hakim` IS NULL OR 
						(SELECT DATE_FORMAT(tanggal_penetapan,'%Y-%m') FROM perkara_hakim_pn WHERE perkara_id = a.`perkara_id`
						AND urutan = 1 ORDER BY tanggal_penetapan ASC LIMIT 1)>'$periode')");

		$belumbagi_p = $this->db->query("SELECT a.perkara_id , a.nomor_perkara FROM perkara AS a
					LEFT JOIN perkara_penetapan AS b ON b.`perkara_id`=a.`perkara_id`
					LEFT JOIN perkara_putusan AS c ON c.perkara_id = a.perkara_id
					WHERE DATE_FORMAT(a.`tanggal_pendaftaran`,'%Y-%m')<='$periode' 
					AND (c.tanggal_putusan IS NULL OR DATE_FORMAT(c.tanggal_putusan,'%Y-%m')>='$periode')
					AND a.alur_perkara_id=16
					AND (b.`penetapan_majelis_hakim` IS NULL OR 
						(SELECT DATE_FORMAT(tanggal_penetapan,'%Y-%m') FROM perkara_hakim_pn WHERE perkara_id = a.`perkara_id`
						AND urutan = 1 ORDER BY tanggal_penetapan ASC LIMIT 1)>'$periode')");


		$belumbagi_gs = $this->db->query("SELECT a.perkara_id , a.nomor_perkara FROM perkara AS a
					LEFT JOIN perkara_penetapan AS b ON b.`perkara_id`=a.`perkara_id`
					LEFT JOIN perkara_putusan AS c ON c.perkara_id = a.perkara_id
					WHERE DATE_FORMAT(a.`tanggal_pendaftaran`,'%Y-%m')<='$periode' 
					AND (c.tanggal_putusan IS NULL OR DATE_FORMAT(c.tanggal_putusan,'%Y-%m')>='$periode')
					AND a.alur_perkara_id=17
					AND (b.`penetapan_majelis_hakim` IS NULL OR 
						(SELECT DATE_FORMAT(tanggal_penetapan,'%Y-%m') FROM perkara_hakim_pn WHERE perkara_id = a.`perkara_id`
						AND urutan = 1 ORDER BY tanggal_penetapan ASC LIMIT 1)>'$periode')");

		//------------------------------------------Data Perkara-------------------------------------------//
		$sql = "SELECT perkara.perkara_id, perkara.alur_perkara_id AS alur_perkara_id, perkara.nomor_perkara AS nomor_perkara,
				perkara.jenis_perkara_nama AS kode_perkara,
				case when DATE_FORMAT(penetapan_majelis_hakim,'%Y-%m')>'$periode' then
					case when (select date_Format(tanggal_penetapan,'%Y-%m') from perkara_hakim_pn where perkara_id = perkara.`perkara_id` 
						order by tanggal_penetapan asc limit 1) <= '$periode' then
						
						(select group_concat(jabatan_hakim_nama,':', hakim_nama separator '<br/>') from perkara_hakim_pn WHERE perkara_id = perkara.`perkara_id`
						and urutan between 1 and 3 and aktif = 'T'
						group by tanggal_penetapan
						order by tanggal_penetapan asc  limit 1)
					else ''
					end
				else majelis_hakim_text
				end as majelis_hakim,				
				SUBSTRING_INDEX(panitera_pengganti_text,': ',-1) AS panitera_pengganti,
				tanggal_pendaftaran AS tanggal_pendaftaran,
				
				case when DATE_FORMAT(penetapan_majelis_hakim,'%Y-%m')>'$periode' then
					case when (select date_Format(tanggal_penetapan,'%Y-%m') from perkara_hakim_pn where perkara_id = perkara.`perkara_id` 
						order by tanggal_penetapan asc limit 1) <= '$periode' then
						(select tanggal_penetapan from perkara_hakim_pn WHERE perkara_id = perkara.`perkara_id`
						and urutan = 1 and aktif = 'T'
						order by tanggal_penetapan asc  limit 1)
					else ''
					end
				else penetapan_majelis_hakim
				end as pmh,
		
				IF(DATE_FORMAT(penetapan_hari_sidang,'%Y-%m')>'$periode','',penetapan_hari_sidang) AS phs,
				IF(DATE_FORMAT(penetapan_hari_sidang,'%Y-%m')>'$periode','',sidang_pertama) AS sidang_pertama,
				IF(DATE_FORMAT(tanggal_putusan,'%Y-%m')>'$periode','',tanggal_putusan) AS tanggal_putusan,
				IF(DATE_FORMAT(tanggal_putusan,'%Y-%m')>'$periode' OR tanggal_putusan IS NULL,'',status_putusan.nama) AS jenis_putusan,
				IF(Date_Format((select tanggal_penetapan from perkara_hakim_pn WHERE perkara_id = perkara.`perkara_id`
						and urutan = 1 order by tanggal_penetapan asc limit 1),'%Y-%m') > '$periode'
						or penetapan_majelis_hakim IS NULL,nomor_perkara,'') AS  belum_dibagi,
				IF(DATE_FORMAT(tanggal_putusan,'%Y-%m')>'$periode' OR tanggal_putusan IS NULL,nomor_perkara,'') AS belum_diputus

				FROM 
				perkara 
					LEFT JOIN perkara_penetapan ON perkara_penetapan.`perkara_id`=perkara.`perkara_id`
					LEFT JOIN perkara_putusan ON perkara_putusan.`perkara_id`=perkara.`perkara_id`
					LEFT JOIN status_putusan ON status_putusan.id=perkara_putusan.`status_putusan_id`

				WHERE (DATE_FORMAT(tanggal_pendaftaran,'%Y-%m')<='$periode'
				AND (tanggal_putusan IS NULL OR DATE_FORMAT(tanggal_putusan,'%Y-%m')>='$periode' ))

				group by perkara.perkara_id
				ORDER BY alur_perkara_id asc , tanggal_pendaftaran asc, nomor_perkara  asc
				";

		$hasil = $this->db->query($sql);
		// return $hasil->result();

		$response = array(
			'rekapitulasi' => array(
				'sisa_lalu_G' => $sisa_bulan_lalu_g->num_rows(),
				'sisa_lalu_P' => $sisa_bulan_lalu_p->num_rows(),
				'sisa_lalu_GS' => $sisa_bulan_lalu_gs->num_rows(),
				'terima_G' => $terima_bulan_ini_g->num_rows(),
				'terima_P' => $terima_bulan_ini_p->num_rows(),
				'terima_GS' => $terima_bulan_ini_gs->num_rows(),
				'putus_G' => $putus_g->num_rows(),
				'putus_P' => $putus_p->num_rows(),
				'putus_GS' => $putus_gs->num_rows(),
				'belumbagi_G' => $belumbagi_g->num_rows(),
				'belumbagi_P' => $belumbagi_p->num_rows(),
				'belumbagi_GS' => $belumbagi_gs->num_rows(),
			),
			'hasil' => $hasil->result()
		);

		return $response;
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 2--------------------------
	public function getLIPA2($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
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
				WHERE DATE_FORMAT( bdg.permohonan_banding,'%Y-%m')>='1900-01' AND DATE_FORMAT( bdg.permohonan_banding,'%Y-%m')<='$periode' 
				AND (bdg.putusan_banding IS NULL OR DATE_FORMAT(bdg.putusan_banding,'%Y-%m')>='$periode')
				AND ((SELECT tanggal_cabut FROM perkara_banding_detil WHERE perkara_id=bdg.`perkara_id` AND status_pihak_id=1 LIMIT 1) IS NULL
				OR (SELECT DATE_FORMAT(tanggal_cabut,'%Y-%m') FROM perkara_banding_detil WHERE perkara_id=bdg.`perkara_id` AND status_pihak_id=1 LIMIT 1) >= '$periode')
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 3--------------------------
	public function getLIPA3($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
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
				WHERE DATE_FORMAT( kas.permohonan_kasasi,'%Y-%m')>='1900-01' AND DATE_FORMAT( kas.permohonan_kasasi,'%Y-%m')<='$periode' 
				AND (kas.putusan_kasasi IS NULL OR DATE_FORMAT(kas.putusan_kasasi,'%Y-%m')>='$periode')
				AND ((SELECT tanggal_cabut FROM perkara_kasasi_detil WHERE perkara_id=kas.`perkara_id` AND status_pihak_id=1 LIMIT 1) IS NULL
				OR (SELECT DATE_FORMAT(tanggal_cabut,'%Y-%m') FROM perkara_kasasi_detil WHERE perkara_id=kas.`perkara_id` AND status_pihak_id=1 LIMIT 1) >= '$periode')
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 4--------------------------
	public function getLIPA4($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
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
				WHERE DATE_FORMAT( pk.permohonan_pk,'%Y-%m')>='1900-01' AND DATE_FORMAT( pk.permohonan_pk,'%Y-%m')<='$periode' 
				AND (pk.putusan_pk IS NULL OR DATE_FORMAT(pk.putusan_pk,'%Y-%m')>='$periode')
				AND ((SELECT tanggal_cabut FROM perkara_pk_detil WHERE perkara_id=pk.`perkara_id` AND status_pihak_id=1 LIMIT 1) IS NULL
				OR (SELECT DATE_FORMAT(tanggal_cabut,'%Y-%m') FROM perkara_pk_detil WHERE perkara_id=pk.`perkara_id` AND status_pihak_id=1 LIMIT 1) >= '$periode')
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
	// -----------------------------Ambil Data Lipa 6--------------------------
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
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 8--------------------------
	public function getLIPA8($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = "SELECT jp.nama AS jenis_perkara,
		SUM( CASE WHEN DATE_FORMAT(vpk.tanggal_pendaftaran,'%Y-%m') < '$periode' AND ((vpk.tanggal_putusan IS NULL) OR (DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m') >= '$periode'))  THEN 1 ELSE 0 END) AS sisa_lalu,
		SUM( CASE WHEN DATE_FORMAT(vpk.tanggal_pendaftaran,'%Y-%m') = '$periode'  THEN 1 ELSE 0 END) AS diterima_bulan_ini,
		SUM( CASE WHEN ((DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m')='$periode'  AND vpk.`status_putusan_id` IN (7,67,85)) OR DATE_FORMAT(vpk.tanggal_cabut,'%Y-%m')='$periode') THEN 1 ELSE 0 END) AS dicabut,
		SUM( CASE WHEN DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m')='$periode'  AND vpk.`status_putusan_id`=62 THEN 1 ELSE 0 END) AS dikabulkan,
		SUM( CASE WHEN DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m')='$periode'  AND (vpk.`status_putusan_id`=63 OR vpk.`status_putusan_id`=92) THEN 1 ELSE 0 END) AS ditolak,
		SUM( CASE WHEN DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m')='$periode' AND vpk.`status_putusan_id`=64  THEN 1 ELSE 0 END) AS tidak_dapat_diterima,
		SUM( CASE WHEN DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m')='$periode' AND (vpk.`status_putusan_id`=65 OR vpk.`status_putusan_id`=93)  THEN 1 ELSE 0 END) AS digugurkan,
		SUM( CASE WHEN DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m')='$periode'  AND vpk.`status_putusan_id`=66   THEN 1 ELSE 0 END) AS dicoret_dari_register,
		SUM( CASE WHEN DATE_FORMAT(vpk.permohonan_banding,'%Y-%m')='$periode'    THEN 1 ELSE 0 END) AS bandingnya,
		SUM( CASE WHEN DATE_FORMAT(vpk.permohonan_kasasi,'%Y-%m')='$periode'    THEN 1 ELSE 0 END) AS kasasinya,
		SUM( CASE WHEN DATE_FORMAT(vpk.permohonan_pk,'%Y-%m')='$periode'    THEN 1 ELSE 0 END) AS pk
							
		FROM jenis_perkara jp
		LEFT JOIN 
		(SELECT p.tanggal_pendaftaran, p.jenis_perkara_id, pp.status_putusan_id, pp.tanggal_cabut, 
		 pp.tanggal_putusan, b.permohonan_banding, k.`permohonan_kasasi`, pk.permohonan_pk
		 FROM perkara p LEFT JOIN perkara_putusan pp ON pp.perkara_id=p.perkara_id
		 LEFT JOIN perkara_banding b ON b.perkara_id=p.perkara_id
		 LEFT JOIN perkara_kasasi k ON k.`perkara_id`=p.`perkara_id`
		 LEFT JOIN perkara_pk pk ON pk.`perkara_id` = p.`perkara_id`) AS
		 vpk ON jp.id=vpk.jenis_perkara_id
		 WHERE (jp.id >=341 AND jp.id<=371) GROUP BY jp.nama ORDER BY jp.id";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
}

/* End of file Laporan_model.php */
/* Location: ./application/models/Laporan_model.php */
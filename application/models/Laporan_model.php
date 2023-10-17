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
	protected $db2;
	public function __construct()
	{
		parent::__construct();
		//initialize db2
		$this->db2 = $this->load->database('dbelaporan', true);
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
	// -----------------------------Ambil Data Lipa 7a--------------------------
	public function getLIPA7a($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$awal_tahun = $tahun . '-01-01';
		$sql = "SELECT 1 AS 'urutan', 1 AS 'no','Saldo Awal' AS 'Keterangan',
				(SELECT CASE WHEN (SELECT t1.`saldo_awal_7a` FROM dbelaporan.`elaporan_saldo_awal` as t1 WHERE tahun = '$tahun') IS not NULL THEN 
						(select t1.saldo_awal_7a from dbelaporan.`elaporan_saldo_awal` as t1 where tahun = '$tahun') +
						COALESCE((SELECT SUM(jumlah) FROM perkara_biaya WHERE jenis_transaksi='1' and date_format(tanggal_transaksi,'%Y-%m-%d') >= '$awal_tahun' AND date_format(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id <= 40),0) -
						COALESCE((SELECT SUM(jumlah) FROM perkara_biaya WHERE jenis_transaksi='-1' and date_format(tanggal_transaksi,'%Y-%m-%d') >= '$awal_tahun' AND Date_format(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id <= 40),0)
					else 
						0 END) AS jumlah_debet, 
					'' AS jumlah_kredit
				union
					SELECT 2 AS 'urutan',2 AS 'no', 'Penerimaan Bulan ini' AS 'keterangan', SUM(jumlah) AS jumlah_debet,'' AS jumlah_kredit 
					FROM perkara_biaya WHERE jenis_transaksi='1' AND date_format(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id<=40
				union
					SELECT 3 AS 'urutan',3 AS 'no', 'Biaya Proses/ATK/Pemberkasan' AS 'keterangan','' AS jumlah_debet, 
					SUM(jumlah) AS jumlah_kredit FROM perkara_biaya WHERE kategori_id='12' AND date_format(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id<=40
				union
					SELECT 4 AS 'urutan',4 AS 'no', 'Biaya Panggilan' AS 'keterangan','' AS jumlah_debet, 
					SUM(jumlah)AS jumlah_kredit FROM perkara_biaya WHERE kategori_id='4' AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id<=40
				union
					SELECT 5 AS 'urutan',5 AS 'no', 'Biaya Penerjemah' AS 'Keterangan', '' AS jumlah_debet, 
					SUM(jumlah) AS jumlah_kredit FROM perkara_biaya WHERE kategori_id='10' AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id<=40
				union
					SELECT 6 AS 'urutan',6 AS 'no', 'Biaya Pemberitahuan' AS 'keterangan', '' AS jumlah_debet,
					SUM(jumlah)AS jumlah_kredit FROM perkara_biaya WHERE kategori_id='6' AND date_format(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id<=40
				union
					SELECT 7 AS 'urutan',7 AS 'no', 'Biaya Sita' AS 'Keterangan','' AS jumlah_debet,
					SUM(jumlah) AS jumlah_kredit FROM perkara_biaya WHERE kategori_id='5' AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id<=40
				UNION
					SELECT 8 AS 'urutan',8 AS 'no', 'Biaya Pemeriksaan Setempat' AS 'Keterangan','' AS jumlah_debet,
					SUM(jumlah)AS jumlah_kredit FROM perkara_biaya WHERE kategori_id='7' AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id<=40
				UNION
					SELECT 9 AS 'urutan',9 AS 'no', 'Biaya Sumpah' AS 'keterangan','' AS jumlah_debet,
					SUM(jumlah)AS jumlah_kredit FROM perkara_biaya WHERE kategori_id='9' AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id<=40
				UNION
					SELECT 10 AS 'urutan',10 AS 'no', 'Biaya Pengiriman' AS 'Keterangan', '' AS jumlah_debet, 
					SUM(jumlah) AS jumlah_kredit FROM perkara_biaya WHERE kategori_id='3' AND date_format(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id<=40
				UNION
					SELECT 11 AS 'urutan',11 AS 'no','Materai' AS 'keterangan', '' AS jumlah_debet, 
					SUM(jumlah)AS jumlah_kredit FROM perkara_biaya WHERE kategori_id='8' AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id<=40
				UNION
					SELECT 12 AS 'urutan',12 AS 'no','PNBP' AS 'Keterangan','' AS jumlah_debet,'' AS jumlah_kredit
				union
					SELECT 13 AS 'urutan','' AS 'no','Panggilan, pemberitahuan dan lain-lain' AS 'keterangan', '' AS jumlah_debet, 
					SUM(jumlah)AS jumlah_kredit FROM perkara_biaya 
					WHERE jenis_biaya_id not IN ('61','62','63','64') and kategori_id='11' AND date_format(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id<=40
				union
					SELECT 14 AS 'urutan','' AS 'no', 'Pendaftaran' AS 'Keterangan','' AS jumlah_debet, 
					SUM(jumlah) AS jumlah_kredit FROM perkara_biaya 
					WHERE jenis_biaya_id in ('61','62','63','64') 
					AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id<=40
				union
					SELECT 15 AS 'urutan',' ' AS 'no', 'Redaksi' AS 'Keterangan', '' AS jumlah_debet,
					SUM(jumlah)AS jumlah_kredit FROM perkara_biaya WHERE jenis_biaya_id='157' AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id<=40
				union
					SELECT 16 AS 'urutan',13 AS 'no', 'Pengembalian Sisa Panjar' AS 'keterangan','' AS jumlah_debet,
					SUM(jumlah)AS jumlah_kredit FROM perkara_biaya WHERE kategori_id='2' AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id<=40
				union	
					SELECT 17 AS 'urutan',' ' AS 'no', 'Jumlah' AS 'Keterangan',
					((SELECT CASE WHEN (SELECT t1.`saldo_awal_7a` FROM dbelaporan.`elaporan_saldo_awal` AS t1 WHERE tahun = '$tahun') IS NOT NULL THEN 
							(SELECT t1.saldo_awal_7a FROM dbelaporan.`elaporan_saldo_awal` AS t1 WHERE tahun = '$tahun') +
							COALESCE((SELECT SUM(jumlah) FROM perkara_biaya WHERE jenis_transaksi='1' AND date_format(tanggal_transaksi,'%Y-%m-%d') >= '$awal_tahun' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id <= 40),0) -
							COALESCE((SELECT SUM(jumlah) FROM perkara_biaya WHERE jenis_transaksi='-1' AND date_format(tanggal_transaksi,'%Y-%m-%d') >= '$awal_tahun' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id <= 40),0)
						ELSE 
							0 END) +
							COALESCE((select SUM(jumlah) FROM perkara_biaya WHERE jenis_transaksi='1' AND date_format(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id<=40),0)) as jumlah_debet,
					
					COALESCE((SELECT SUM(jumlah) FROM perkara_biaya WHERE jenis_transaksi='-1' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m') = '$periode'
					AND tahapan_id<=40),0) AS jumlah_kredit
				order by urutan";
		//TODO-tambah saldo
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 7b--------------------------
	public function getLIPA7b($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$awal_tahun = $tahun . '-01-01';
		$sql = "SELECT 1 AS 'urutan', 1 AS 'no','Saldo Awal' AS 'Keterangan',
					(SELECT CASE WHEN (SELECT t1.`saldo_awal_7b` FROM dbelaporan.`elaporan_saldo_awal` as t1 WHERE tahun = '$tahun') IS not NULL THEN 
					(select t1.saldo_awal_7b from dbelaporan.`elaporan_saldo_awal` as t1 where tahun = '$tahun') +
					COALESCE((SELECT SUM(jumlah) 
					FROM (select jumlah from perkara_biaya WHERE jenis_transaksi='1' and date_format(tanggal_transaksi,'%Y-%m-%d') >= '$awal_tahun' AND date_format(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id = 50
					union all
					select jumlah from perkara_biaya_ht WHERE jenis_transaksi='1' and date_format(tanggal_transaksi,'%Y-%m-%d') >= '$awal_tahun' AND date_format(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id = 51
					)data_penerimaan),0) -
					COALESCE((SELECT SUM(jumlah) 
					FROM (SELECT jumlah FROM perkara_biaya WHERE jenis_transaksi='-1' AND DATE_FORMAT(tanggal_transaksi,'%Y-%m-%d') >= '$awal_tahun' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id = 50
					UNION ALL
					SELECT jumlah FROM perkara_biaya_ht WHERE jenis_transaksi='-1' AND DATE_FORMAT(tanggal_transaksi,'%Y-%m-%d') >= '$awal_tahun' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id = 51
					)data_pengeluaran),0)
					else 
					0 END) AS jumlah_debet, 
					'' AS jumlah_kredit
				union
					SELECT 2 AS 'urutan',2 AS 'no', 'Penerimaan Bulan ini' AS 'keterangan', SUM(jumlah) AS jumlah_debet,'' AS jumlah_kredit 
					FROM (select jumlah from perkara_biaya WHERE jenis_transaksi='1' AND date_format(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id=50
					union all
					select jumlah from perkara_biaya_ht where jenis_transaksi='1' and DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id=51) data_penerimaan
				union
					SELECT 3 AS 'urutan',3 AS 'no', 'Materai' AS 'keterangan','' AS jumlah_debet, SUM(jumlah) AS jumlah_kredit 
					FROM (select jumlah from perkara_biaya WHERE kategori_id='8' AND date_format(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id=50
					union all
					select jumlah from `perkara_biaya_ht` where kategori_id='8' AND date_format(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id=51) data_materai
				union
					SELECT 4 AS 'urutan','4' AS 'no', 'Legalisir' AS 'Keterangan', '' AS jumlah_debet, SUM(jumlah)AS jumlah_kredit 
					FROM (select jumlah from perkara_biaya WHERE jenis_biaya_id='347' AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=50
					union all
					select jumlah from perkara_biaya_ht where jenis_biaya_id='347' AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=51) data_leges
				union 
					SELECT 5 AS 'urutan','5' AS 'no', 'Sita Eksekusi' AS 'Keterangan', '' AS jumlah_debet, SUM(jumlah)AS jumlah_kredit 
					FROM (select jumlah from perkara_biaya WHERE jenis_biaya_id in ('317','318','319','321') AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=50
					union all
					select jumlah from perkara_biaya_ht where jenis_biaya_id in ('317','318','319','321') AND date_format(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=51) data_sita
				union
					SELECT 6 AS 'urutan','6' AS 'no', 'Jurusita' AS 'Keterangan', '' AS jumlah_debet, 0 AS jumlah_kredit
				union
					SELECT 7 AS 'urutan','7' AS 'no', 'Iklan' AS 'Keterangan', '' AS jumlah_debet, SUM(jumlah)AS jumlah_kredit 
					FROM (SELECT jumlah FROM perkara_biaya WHERE jenis_biaya_id ='313' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=50
					UNION ALL
					SELECT jumlah FROM perkara_biaya_ht WHERE jenis_biaya_id ='313' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=51) data_iklan
				union
					SELECT 8 AS 'urutan','8' AS 'no', 'Juru Lelang' AS 'Keterangan', '' AS jumlah_debet, 0 AS jumlah_kredit
				union
					SELECT 9 AS 'urutan','9' AS 'no', 'Biaya Lelang' AS 'Keterangan', '' AS jumlah_debet, SUM(jumlah)AS jumlah_kredit 
					FROM (SELECT jumlah FROM perkara_biaya WHERE jenis_biaya_id ='320' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=50
					UNION ALL
					SELECT jumlah FROM perkara_biaya_ht WHERE jenis_biaya_id ='320' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=51) data_lelang
				union
					SELECT 10 AS 'urutan','10' AS 'no', 'Saksi' AS 'Keterangan', '' AS jumlah_debet, SUM(jumlah)AS jumlah_kredit 
					FROM (SELECT jumlah FROM perkara_biaya WHERE jenis_biaya_id ='349' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=50
					UNION ALL
					SELECT jumlah FROM perkara_biaya_ht WHERE jenis_biaya_id ='349' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=51) data_saksi
				union
					SELECT 11 AS 'urutan','11' AS 'no', 'Keamanan' AS 'Keterangan', '' AS jumlah_debet, SUM(jumlah)AS jumlah_kredit 
					FROM (SELECT jumlah FROM perkara_biaya WHERE jenis_biaya_id ='350' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=50
					UNION ALL
					SELECT jumlah FROM perkara_biaya_ht WHERE jenis_biaya_id ='350' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=51) data_keamanan
				union
					SELECT 12 AS 'urutan','12' AS 'no', 'Panggilan / Pemberitahuan' AS 'Keterangan', '' AS jumlah_debet, SUM(jumlah)AS jumlah_kredit 
					FROM (SELECT jumlah FROM perkara_biaya WHERE (jenis_biaya_id in ('314','325') or kategori_id = 4) AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=50
					UNION ALL
					SELECT jumlah FROM perkara_biaya_ht WHERE (jenis_biaya_id IN ('314','325') OR kategori_id = 4) AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=51) data_panggilan
				union
					SELECT 13 AS 'urutan',13 AS 'no', 'Pengembalian Sisa Panjar Eksekusi' AS 'keterangan','' AS jumlah_debet, SUM(jumlah) AS jumlah_kredit 
					FROM (SELECT jumlah FROM perkara_biaya WHERE kategori_id='2' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id=50
					UNION ALL
					SELECT jumlah FROM `perkara_biaya_ht` WHERE kategori_id='2' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode' AND tahapan_id=51) data_psp
				union
					SELECT 14 AS 'urutan','14' AS 'no', 'PNBP' AS 'Keterangan', '' AS jumlah_debet, SUM(jumlah)AS jumlah_kredit 
					FROM (SELECT jumlah FROM perkara_biaya WHERE (jenis_biaya_id IN ('216','217','219','220','221') OR kategori_id = 11) AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=50
					UNION ALL
					SELECT jumlah FROM perkara_biaya_ht WHERE (jenis_biaya_id IN ('216','217','219','220','221') OR kategori_id = 11) AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=51) data_pnbp
				union
					SELECT 15 AS 'urutan','15' AS 'no', 'Lain-lain' AS 'Keterangan', '' AS jumlah_debet, SUM(jumlah)AS jumlah_kredit 
					FROM (SELECT jumlah FROM perkara_biaya WHERE (jenis_biaya_id = '222' OR kategori_id in ('7','9','10','12')) AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=50
					UNION ALL
					SELECT jumlah FROM perkara_biaya_ht WHERE (jenis_biaya_id = '222' OR kategori_id IN ('7','9','10','12')) AND DATE_FORMAT(tanggal_transaksi, '%Y-%m')='$periode'  AND tahapan_id=51) data_lain
				union
					SELECT 17 AS 'urutan',' ' AS 'no', 'Jumlah' AS 'Keterangan',
					(SELECT CASE WHEN (SELECT t1.`saldo_awal_7b` FROM dbelaporan.`elaporan_saldo_awal` as t1 WHERE tahun = '2023') IS not NULL THEN 
					(select t1.saldo_awal_7b from dbelaporan.`elaporan_saldo_awal` as t1 where tahun = '2023') +
					COALESCE((SELECT SUM(jumlah) 
					FROM (select jumlah from perkara_biaya WHERE jenis_transaksi='1' and date_format(tanggal_transaksi,'%Y-%m-%d') >= '$periode-01' AND date_format(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id = 50
					union all
					select jumlah from perkara_biaya_ht WHERE jenis_transaksi='1' and date_format(tanggal_transaksi,'%Y-%m-%d') >= '$periode-01' AND date_format(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id = 51
					)data_penerimaan),0) -
					COALESCE((SELECT SUM(jumlah) 
					FROM (SELECT jumlah FROM perkara_biaya WHERE jenis_transaksi='-1' AND DATE_FORMAT(tanggal_transaksi,'%Y-%m-%d') >= '$periode-01' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id = 50
					UNION ALL
					SELECT jumlah FROM perkara_biaya_ht WHERE jenis_transaksi='-1' AND DATE_FORMAT(tanggal_transaksi,'%Y-%m-%d') >= '$periode-01' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m') < '$periode' AND tahapan_id = 51
					)data_pengeluaran),0)
					else 
					0 END) +
					
					COALESCE((SELECT SUM(jumlah) 
					FROM (select jumlah from perkara_biaya WHERE jenis_transaksi='1' AND date_format(tanggal_transaksi, '%Y-%m') = '$periode' AND tahapan_id = 50
					union all
					select jumlah from perkara_biaya_ht WHERE jenis_transaksi='1'  AND date_format(tanggal_transaksi, '%Y-%m') = '$periode' AND tahapan_id = 51
					)data_penerimaan),0) as jumlah_debet,
					
					COALESCE((SELECT SUM(jumlah) 
					FROM (SELECT jumlah FROM perkara_biaya WHERE jenis_transaksi='-1' AND DATE_FORMAT(tanggal_transaksi, '%Y-%m') = '$periode' AND tahapan_id = 50
					UNION ALL
					SELECT jumlah FROM perkara_biaya_ht WHERE jenis_transaksi='-1'  AND DATE_FORMAT(tanggal_transaksi, '%Y-%m') = '$periode' AND tahapan_id = 51
					)data_pengeluaran),0) as jumlah_kredit
					";
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
		//TODO-add jumlah per kolom
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 9--------------------------
	public function getLIPA9($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = " SELECT  
				SUM(CASE WHEN jenis_perkara_id = 341 AND (tanggal_putusan IS NULL OR DATE_FORMAT(tanggal_putusan,'%Y-%m') >='$periode') AND DATE_FORMAT(tanggal_pendaftaran,'%Y-%m')  < '$periode' 
						THEN 1 ELSE 0 END ) AS sisa_poligami,
				SUM(CASE WHEN jenis_perkara_id = 341 AND DATE_FORMAT(tanggal_pendaftaran,'%Y-%m')  = '$periode' THEN 1 ELSE 0 END ) AS masuk_poligami,
				SUM(CASE WHEN jenis_perkara_id = 341 AND (tanggal_putusan IS NOT NULL AND DATE_FORMAT(tanggal_putusan,'%Y-%m') ='$periode')  THEN 1 ELSE 0 END ) AS putus_poligami,
				SUM(CASE WHEN jenis_perkara_id = 346 AND (tanggal_putusan IS NULL OR DATE_FORMAT(tanggal_putusan,'%Y-%m') >='$periode') AND DATE_FORMAT(tanggal_pendaftaran,'%Y-%m')  < '$periode' 
						THEN 1 ELSE 0 END ) AS sisa_talak,
				SUM(CASE WHEN jenis_perkara_id = 346 AND DATE_FORMAT(tanggal_pendaftaran,'%Y-%m')  = '$periode' THEN 1 ELSE 0 END ) AS masuk_talak,
				SUM(CASE WHEN jenis_perkara_id = 346 AND (tanggal_putusan IS NOT NULL AND DATE_FORMAT(tanggal_putusan,'%Y-%m') ='$periode')  THEN 1 ELSE 0 END) AS putus_talak,
				SUM(CASE WHEN jenis_perkara_id = 347 AND (tanggal_putusan IS NULL OR DATE_FORMAT(tanggal_putusan,'%Y-%m') >='$periode') AND DATE_FORMAT(tanggal_pendaftaran,'%Y-%m')  < '$periode' 
						THEN 1 ELSE 0 END) AS sisa_gugat,
				SUM(CASE WHEN jenis_perkara_id = 347 AND DATE_FORMAT(tanggal_pendaftaran,'%Y-%m')  = '$periode' THEN 1 ELSE 0 END ) AS masuk_gugat,
				SUM(CASE WHEN jenis_perkara_id = 347 AND tanggal_putusan IS NOT NULL AND DATE_FORMAT(tanggal_putusan,'%Y-%m') ='$periode'  THEN 1 ELSE 0 END) AS putus_gugat,
				SUM(CASE WHEN statusizin = 1 AND status_pihak = 1 AND tanggal_putusan IS NOT NULL AND DATE_FORMAT(tanggal_putusan,'%Y-%m') ='$periode' THEN 1 ELSE 0 END) AS pemohonizin,
				SUM(CASE WHEN (statusizin = 0 OR statusizin IS NULL OR statusizin='') AND status_pihak=1 AND tanggal_putusan IS NOT NULL AND DATE_FORMAT(tanggal_putusan,'%Y-%m') ='$periode' THEN 1 ELSE 0 END) AS pemohontidakizin,
				SUM(CASE WHEN statusizin = 1 AND status_pihak=2 AND tanggal_putusan IS NOT NULL AND DATE_FORMAT(tanggal_putusan,'%Y-%m') ='$periode' THEN 1 ELSE 0 END) AS termohonizin,
				SUM(CASE WHEN (statusizin = 0 OR statusizin IS NULL OR statusizin='') AND status_pihak=2 AND tanggal_putusan IS NOT NULL AND DATE_FORMAT(tanggal_putusan,'%Y-%m') ='$periode' THEN 1 ELSE 0 END) AS termohontidakizin
				FROM v_perkara vpk LEFT JOIN (SELECT * FROM 
								(SELECT p1.perkara_id,p1.pihak_id,p1.nama,p.pekerjaan,izin.status AS statusizin,'1' AS status_pihak 
								FROM perkara_pihak1 AS p1 LEFT JOIN  pihak AS p ON p1.pihak_id = p.id
								LEFT JOIN perkara_izin_cerai AS izin ON izin.perkara_id = p1.perkara_id AND p1.pihak_id = izin.pihak_id) AS pihak
								UNION
								(SELECT p2.perkara_id,p2.pihak_id,p2.nama,p.pekerjaan,izin.status AS statusizin,'2' AS status_pihak 
								FROM perkara_pihak2 AS p2 LEFT JOIN  pihak AS p ON p2.pihak_id = p.id
								LEFT JOIN perkara_izin_cerai AS izin ON izin.perkara_id = p2.perkara_id AND p2.pihak_id = izin.pihak_id)) AS pihaks
								ON vpk.perkara_id=pihaks.perkara_id
											
				WHERE jenis_perkara_id IN (341,347,346) AND pekerjaan IN ('Tentara Nasional Indonesia','Pegawai Negeri Sipil','Pegawai BUMN/BUMD','POLRI')
				AND DATE_FORMAT(tanggal_pendaftaran,'%Y-%m') <='$periode' 
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 10--------------------------
	public function getLIPA10($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = "SELECT 
					SUM(CASE faktor_perceraian_id WHEN 1 THEN 1 ELSE 0 END) AS zina,
					SUM(CASE faktor_perceraian_id WHEN 2 THEN 1 ELSE 0 END) AS mabuk,
					SUM(CASE faktor_perceraian_id WHEN 3 THEN 1 ELSE 0 END) AS madat,
					SUM(CASE faktor_perceraian_id WHEN 4 THEN 1 ELSE 0 END) AS judi,
					SUM(CASE WHEN faktor_perceraian_id IN (5,18) THEN 1 ELSE 0 END) AS meninggalkan,
					SUM(CASE WHEN faktor_perceraian_id IN (6,20) THEN 1 ELSE 0 END) AS dihukum,
					SUM(CASE WHEN faktor_perceraian_id IN (7,25,26) THEN 1 ELSE 0 END) AS kdrt,
					SUM(CASE WHEN faktor_perceraian_id IN (8,21) THEN 1 ELSE 0 END) AS cacat,
					SUM(CASE WHEN faktor_perceraian_id IN (9,24) THEN 1 ELSE 0 END) AS perselisihan,
					SUM(CASE WHEN faktor_perceraian_id IN (10,19) THEN 1 ELSE 0 END) AS kawin_paksa,
					SUM(CASE faktor_perceraian_id WHEN 11 THEN 1 ELSE 0 END) AS murtad,
					SUM(CASE faktor_perceraian_id WHEN 12 THEN 1 ELSE 0 END) AS ekonomi,
					SUM(CASE WHEN faktor_perceraian_id IN (13,15) THEN 1 ELSE 0 END) AS poligami, 
					SUM(CASE WHEN faktor_perceraian_id IN (16,17,22,23) THEN 1 ELSE 0 END) AS lain,
					COUNT(nomor_akta_cerai) AS jumlah								 
					FROM perkara_akta_cerai  
					WHERE DATE_FORMAT(tgl_akta_cerai,'%Y-%m')= '$periode'
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 12--------------------------
	public function getLIPA12($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = "SELECT 
					SUM(CASE WHEN DATE_FORMAT(tanggal_pendaftaran,'%Y-%m') < '$periode' AND ((tanggal_putusan IS NULL) OR (DATE_FORMAT(tanggal_putusan,'%Y-%m') >= '$periode')) AND jenis_pengadilan=4 THEN 1 ELSE 0 END) AS sisa_lalu,
					SUM(CASE WHEN DATE_FORMAT(tanggal_pendaftaran,'%Y-%m') = '$periode' AND jenis_pengadilan=4 THEN 1 ELSE 0 END) AS diterima_bulan_ini,
					SUM(CASE WHEN DATE_FORMAT(dimulai_mediasi,'%Y-%m')<'$periode' AND (DATE_FORMAT(keputusan_mediasi,'%Y-%m')>= '$periode' OR hasil_mediasi IS NULL) AND jenis_pengadilan=4 THEN 1 ELSE 0 END) 
					AS sisa_mediasi_lalu,
					SUM(CASE WHEN DATE_FORMAT(dimulai_mediasi,'%Y-%m')='$periode' AND jenis_pengadilan=4 THEN 1 ELSE 0 END)  AS perkara_mediasi,
					SUM(CASE WHEN DATE_FORMAT(keputusan_mediasi,'%Y-%m')='$periode' AND jenis_pengadilan=4  AND hasil_mediasi IN ('Y1','S','Y2') THEN 1 ELSE 0 END) AS berhasil,
					SUM(CASE WHEN DATE_FORMAT(keputusan_mediasi,'%Y-%m')='$periode' AND jenis_pengadilan=4 AND hasil_mediasi='T' THEN 1 ELSE 0 END) AS tidak_berhasil,
					SUM(CASE WHEN DATE_FORMAT(keputusan_mediasi,'%Y-%m')='$periode' AND hasil_mediasi='D' THEN 1 ELSE 0 END) AS gagal,
					SUM(CASE WHEN DATE_FORMAT(dimulai_mediasi,'%Y-%m')='$periode' AND jenis_pengadilan=4 AND (DATE_FORMAT(keputusan_mediasi,'%Y-%m')>'$periode' or hasil_mediasi IS NULL) THEN 1 ELSE 0 END)  AS perkara_proses_mediasi,
					SUM(CASE WHEN DATE_FORMAT(tanggal_putusan,'%Y-%m')='$periode'  AND status_putusan_id IS NOT NULL THEN 1 ELSE 0 END) AS putus_bulan_ini
					FROM v_perkara
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 13--------------------------
	public function getLIPA13($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = "SELECT pac.nomor_akta_cerai,
				pac.tgl_akta_cerai AS tgl_terbit_ac,
				pac.no_seri_akta_cerai,
				vpk.nomor_perkara, 
				vpk.tanggal_putusan AS tanggal_putusan,
				vpk.tanggal_bht AS tanggal_bht,
				pit.tgl_ikrar_talak AS tgl_ikrar_talak
				FROM perkara_akta_cerai pac 
				LEFT JOIN v_perkara vpk ON pac.perkara_id=vpk.perkara_id
				LEFT JOIN perkara_ikrar_talak pit ON pac.perkara_id=pit.perkara_id 
				WHERE 
				vpk.jenis_pengadilan=4 AND DATE_FORMAT(pac.tgl_akta_cerai,'%Y-%m') = '$periode' ORDER BY pac.tgl_akta_cerai,pac.nomor_akta_cerai
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 14--------------------------
	public function getLIPA14($bulan, $tahun)
	{
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
				ORDER BY r.tahun, r.bulan DESC
				";
		$hasil = $this->db2->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 15--------------------------
	public function getLIPA15($bulan, $tahun)
	{
		$sql = "SELECT r.id, r.bulan, r.tahun,p.pagu_awal, p.pagu_revisi,
				COALESCE(SUM(r2.realisasi), 0) AS realisasi_sampai_bulan_lalu,
				r.realisasi,
				COALESCE(SUM(r2.realisasi), 0) + r.realisasi AS jumlah_realisasi,
				IF(p.pagu_revisi = 0, p.pagu_awal, p.pagu_revisi) - (COALESCE(SUM(r2.realisasi), 0) + r.realisasi) AS saldo,
				p.target_perkara, r.jml_perkara, r.keterangan
				FROM elaporan_lipa_15 r
				INNER JOIN elaporan_pagu_15 p ON r.tahun = p.tahun_anggaran
				LEFT JOIN elaporan_lipa_15 r2 ON r.bulan > r2.bulan AND r2.tahun = r.tahun
				WHERE r.bulan = $bulan AND r.tahun = $tahun
				GROUP BY r.id,r.bulan, r.tahun, p.pagu_awal, r.realisasi
				ORDER BY r.tahun, r.bulan DESC
				";
		$hasil = $this->db2->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 16--------------------------
	public function getLIPA16($bulan, $tahun)
	{
		$sql = "SELECT r.id, r.bulan, r.tahun,p.pagu_awal, p.pagu_revisi,
				COALESCE(SUM(r2.realisasi), 0) AS realisasi_sampai_bulan_lalu,
				r.realisasi,
				COALESCE(SUM(r2.realisasi), 0) + r.realisasi AS jumlah_realisasi,
				IF(p.pagu_revisi = 0, p.pagu_awal, p.pagu_revisi) - (COALESCE(SUM(r2.realisasi), 0) + r.realisasi) AS saldo,
				p.target_layanan, r.jml_layanan, r.keterangan
				FROM elaporan_lipa_16 r
				INNER JOIN elaporan_pagu_16 p ON r.tahun = p.tahun_anggaran
				LEFT JOIN elaporan_lipa_16 r2 ON r.bulan > r2.bulan AND r2.tahun = r.tahun
				WHERE r.bulan = $bulan AND r.tahun = $tahun
				GROUP BY r.id,r.bulan, r.tahun, p.pagu_awal, r.realisasi
				ORDER BY r.tahun, r.bulan DESC
				";
		$hasil = $this->db2->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 17--------------------------
	public function getLIPA17($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = "SELECT
					coalesce(pendaftaran,0) as pendaftaran, 
					coalesce(pendaftaran_banding,0) AS pendaftaran_banding,
					coalesce(pendaftaran_kasasi,0) AS pendaftaran_kasasi,
					coalesce(pendaftaran_pk,0) AS pendaftaran_pk,
					coalesce(pendaftaran_eksekusi,0) AS pendaftaran_eksekusi,
					coalesce(pendaftaran_eksekusi_ht,0) AS pendaftaran_eksekusi_ht,
					
					(COALESCE(pendaftaran,0)+ 
					COALESCE(pendaftaran_banding,0)+
					COALESCE(pendaftaran_kasasi,0)+
					COALESCE(pendaftaran_pk,0)+
					COALESCE(pendaftaran_eksekusi,0)+
					COALESCE(pendaftaran_eksekusi_ht,0)) AS jumlah
				FROM
				(
					SELECT
					pendaftaran, pendaftaran_banding, pendaftaran_kasasi, pendaftaran_pk, pendaftaran_eksekusi, pendaftaran_eksekusi_ht
					FROM
					(
					SELECT
						(SELECT SUM(jumlah) FROM perkara_biaya pb LEFT JOIN v_perkara vpk ON pb.perkara_id=vpk.perkara_id
						WHERE pb.tahapan_id=10 AND pb.jenis_biaya_id=61 AND vpk.jenis_pengadilan=4
						AND DATE_FORMAT(pb.tanggal_transaksi,'%Y-%m') = '$periode') AS pendaftaran,
						(SELECT SUM(jumlah) FROM perkara_biaya pb LEFT JOIN v_perkara vpk ON pb.perkara_id=vpk.perkara_id
						WHERE pb.tahapan_id=20 AND pb.jenis_biaya_id=62 AND vpk.jenis_pengadilan=4
						AND DATE_FORMAT(pb.tanggal_transaksi,'%Y-%m') = '$periode') AS pendaftaran_banding,
						(SELECT SUM(jumlah) FROM perkara_biaya pb LEFT JOIN v_perkara vpk ON pb.perkara_id=vpk.perkara_id
						WHERE pb.tahapan_id=30 AND pb.jenis_biaya_id=63 AND vpk.jenis_pengadilan=4
						AND DATE_FORMAT(pb.tanggal_transaksi,'%Y-%m') = '$periode') AS pendaftaran_kasasi,
						(SELECT SUM(jumlah) FROM perkara_biaya pb LEFT JOIN v_perkara vpk ON pb.perkara_id=vpk.perkara_id
						WHERE pb.tahapan_id=40 AND pb.jenis_biaya_id=64 AND vpk.jenis_pengadilan=4
						AND DATE_FORMAT(pb.tanggal_transaksi,'%Y-%m') = '$periode') AS pendaftaran_pk,
						(SELECT SUM(jumlah) FROM perkara_biaya WHERE jenis_biaya_id = 64 AND tahapan_id = 50 AND
						DATE_FORMAT(tanggal_transaksi,'%Y-%m') = '$periode') AS pendaftaran_eksekusi,
						(SELECT SUM(jumlah) FROM perkara_biaya_ht WHERE jenis_biaya_id = 64 AND tahapan_id = 51 AND
						DATE_FORMAT(tanggal_transaksi,'%Y-%m') = '$periode') AS pendaftaran_eksekusi_ht
					) AS subquery
				) AS total_sum_subquery;
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 18--------------------------
	public function getLIPA18($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = "SELECT  SUM(CASE WHEN jenis_biaya_id IN (348,363,376) THEN jumlah ELSE 0 END) AS salinan,
				SUM(CASE WHEN jenis_biaya_id IN (157,172,187,202,217) THEN jumlah ELSE 0 END) AS redaksi,
				SUM(CASE WHEN jenis_biaya_id IN (329,367,354) THEN jumlah ELSE 0 END) AS eksekusi,
				SUM(CASE WHEN jenis_biaya_id IN (331,369,356) THEN jumlah ELSE 0 END) AS lelang,
				SUM(CASE WHEN jenis_biaya_id IN (352,146,365) THEN jumlah ELSE 0 END) AS catatan_pembuatan_akta,
				SUM(CASE WHEN jenis_biaya_id IN (332,370,357) THEN jumlah ELSE 0 END) AS penyerahan_akta, 
				SUM(CASE WHEN jenis_biaya_id IN (334,359,372) THEN jumlah ELSE 0 END) AS akta_asli, 
				SUM(CASE WHEN jenis_biaya_id IN (336,374,361) THEN jumlah ELSE 0 END) AS surat_kuasa, 
				SUM(CASE WHEN jenis_biaya_id IN (337,362,375) THEN jumlah ELSE 0 END) AS surat_kuasa_insidentil,
				SUM(CASE WHEN jenis_biaya_id IN (330,361,355) THEN jumlah ELSE 0 END) AS surat_dibawah_tangan,
				SUM(CASE WHEN jenis_biaya_id IN (335,373,360,343) THEN jumlah ELSE 0 END) AS leges       
				FROM perkara_biaya WHERE DATE_FORMAT(tanggal_transaksi,'%Y-%m')='$periode' AND tahapan_id IN (10,99) 
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 19--------------------------
	public function getLIPA19($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = " SELECT perkara.nomor_perkara, perkara_penetapan.majelis_hakim_text AS majelis_hakim,
		CASE WHEN perkara.alur_perkara_id =15 OR perkara.alur_perkara_id =17  THEN perkara_putusan.tanggal_putusan ELSE '' END  AS putus_g,
		CASE WHEN perkara.alur_perkara_id =16  THEN perkara_putusan.tanggal_putusan ELSE '' END  AS putus_p,
		CASE WHEN perkara.alur_perkara_id =15 OR perkara.alur_perkara_id =17 THEN perkara_putusan.tanggal_minutasi ELSE '' END  AS minutasi_g,
		CASE WHEN perkara.alur_perkara_id =16  THEN perkara_putusan.tanggal_minutasi ELSE '' END  AS minutasi_p
		FROM perkara_putusan
		LEFT JOIN perkara ON perkara.perkara_id=perkara_putusan.perkara_id
		LEFT JOIN perkara_penetapan ON perkara_penetapan.perkara_id=perkara_putusan.perkara_id
		WHERE  DATE_FORMAT(perkara_putusan.tanggal_minutasi,'%Y-%m') = '$periode'  
		ORDER BY perkara.alur_perkara_id ASC,  perkara_putusan.tanggal_putusan ASC, perkara_putusan.tanggal_minutasi ASC, perkara_putusan.perkara_id ASC
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 20--------------------------
	public function getLIPA20($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$tgl_awal_bulanini = $periode . "-01";
		$sql = " SELECT 
				SUM(CASE WHEN DATEDIFF(tanggal_putusan,tanggal_pendaftaran) <90 THEN 1 ELSE 0 END ) AS putus_3_bln,
				SUM(CASE WHEN DATEDIFF(tanggal_putusan,tanggal_pendaftaran) >=90 AND DATEDIFF(tanggal_putusan,tanggal_pendaftaran) <= 150 THEN 1 ELSE 0 END) AS putus_3_5_bln,
				SUM(CASE WHEN DATEDIFF(tanggal_putusan,tanggal_pendaftaran) >150 THEN 1 ELSE 0 END) AS putus_lebih_5_bln,
				SUM(CASE WHEN tanggal_putusan IS NULL AND DATEDIFF(LAST_DAY('$tgl_awal_bulanini'),tanggal_pendaftaran) > 150 THEN 1 ELSE 0 END) AS blm_putus_lebih_5_bln
				FROM
				perkara AS a LEFT JOIN perkara_putusan  AS b  USING(perkara_id)	 
				WHERE (DATE_FORMAT(tanggal_putusan,'%Y-%m') = '$periode') OR (DATE_FORMAT(tanggal_pendaftaran,'%Y-%m') <= '$periode' AND tanggal_putusan IS NULL) 
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 21--------------------------
	public function getLIPA21($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = " SELECT 
					vpk.nomor_perkara AS nomor_perkara,
					vpk.jenis_perkara_nama AS kode_perkara,
					pv.majelis_hakim_text AS majelis_hakim,
					SUBSTRING_INDEX(pv.panitera_pengganti_text,': ',-1) AS panitera_pengganti,
					pv.tanggal_pendaftaran_verzet AS penerimaan,
					pv.penetapan_majelis_hakim AS pmh,
					pv.tanggal_penetapan_sidang_verzet AS phs,
					pv.tanggal_sidang_pertama_verzet AS sidang_pertama,
					pv.putusan_verzet AS diputus,
					sp.nama AS jenis_putusan,   
					CASE WHEN pv.penetapan_majelis_hakim  IS NULL THEN vpk.nomor_perkara  END AS belum_dibagi,
					CASE WHEN pv.putusan_verzet IS NULL THEN vpk.nomor_perkara END AS belum_putus,
        			CASE WHEN pv.tanggal_minutasi_verzet IS NULL THEN vpk.nomor_perkara END AS belum_minutasi
					FROM perkara_verzet pv 
					LEFT JOIN v_perkara vpk ON pv.perkara_id=vpk.perkara_id
					LEFT JOIN status_putusan sp ON pv.status_putusan_verzet_id = sp.id        
					WHERE vpk.jenis_pengadilan=4 AND DATE_FORMAT(pv.tanggal_pendaftaran_verzet,'%Y-%m') < '$periode' AND 
					(pv.putusan_verzet IS NULL OR DATE_FORMAT(pv.putusan_verzet,'%Y-%m') >= '$periode') 
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 22--------------------------
	public function getLIPA22($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql_masuk = "  SELECT
							REPLACE(REPLACE(delegasi_masuk.pn_asal_text, 'PENGADILAN AGAMA', 'PA'),'MAHKAMAH SYAR\'IYAH','MS') AS pa_asal_text,
							delegasi_masuk.nomor_perkara,
							REPLACE(SUBSTRING_INDEX(delegasi_masuk.pihak, '<br>', 1), 'Nama  :', '') AS pihak,
							delegasi_masuk.nomor_surat,
							delegasi_masuk.tgl_surat AS tgl_surat,
							delegasi_masuk.tgl_sidang AS tgl_sidang,
							delegasi_proses_masuk.tgl_surat_diterima AS tgl_surat_diterima,
							delegasi_proses_masuk.tgl_penunjukan_jurusita AS tgl_disposisi,
							delegasi_proses_masuk.tgl_relaas AS tgl_relaas,
							delegasi_proses_masuk.tgl_pengiriman_relaas AS tgl_pengiriman_relaas,
							delegasi_proses_masuk.jurusita_nama,
							delegasi_masuk.id_jenis_delegasi       
						FROM 
							delegasi_masuk LEFT JOIN delegasi_proses_masuk ON delegasi_proses_masuk.delegasi_id=delegasi_masuk.id 
						WHERE 
							DATE_FORMAT(delegasi_masuk.tgl_delegasi,'%Y-%m')<='$periode'
							AND
							(DATE_FORMAT(delegasi_proses_masuk.tgl_pengiriman_relaas,'%Y-%m')>='$periode'
							OR  
							delegasi_masuk.status_kirim <> 1) 
						";
		$sql_keluar = " SELECT
							REPLACE(REPLACE(delegasi_keluar.pn_tujuan_text, 'PENGADILAN AGAMA', 'PA'),'MAHKAMAH SYAR\'IYAH','MS') AS pa_tujuan_text,
							delegasi_keluar.nomor_perkara,
							REPLACE(SUBSTRING_INDEX(delegasi_keluar.pihak, '<br>', 1), 'Nama  :', '') AS pihak,
							delegasi_keluar.nomor_surat,
							delegasi_keluar.tgl_surat AS tgl_surat,
							delegasi_keluar.tgl_sidang AS tgl_sidang,
							delegasi_proses_keluar.tgl_surat_diterima AS tgl_surat_diterima,
							delegasi_proses_keluar.tgl_penunjukan_jurusita AS tgl_disposisi,
							delegasi_proses_keluar.tgl_relaas AS tgl_relaas,
							delegasi_proses_keluar.tgl_pengiriman_relaas AS tgl_pengiriman_relaas,
							TRIM(REPLACE(REPLACE(perkara_penetapan.jurusita_text, 'Jurusita:',''), 'Juru Sita Pengganti:','')) AS jurusita_nama,
							delegasi_keluar.id_jenis_delegasi 
						FROM 
							delegasi_keluar LEFT JOIN delegasi_proses_keluar ON delegasi_proses_keluar.delegasi_id=delegasi_keluar.id
							LEFT JOIN perkara_penetapan ON perkara_penetapan.`perkara_id` = delegasi_keluar.`perkara_id`
						WHERE 
							DATE_FORMAT(delegasi_keluar.tgl_delegasi,'%Y-%m')='$periode'
							AND
							(DATE_FORMAT(delegasi_proses_keluar.tgl_pengiriman_relaas,'%Y-%m')>='$periode'
							OR  
							delegasi_proses_keluar.`tgl_pengiriman_relaas` IS NULL) 
						";

		$hasil_masuk = $this->db->query($sql_masuk);
		$hasil_keluar = $this->db->query($sql_keluar);
		$response = array(
			'delegasi_masuk' => $hasil_masuk->result(),
			'delegasi_keluar' => $hasil_keluar->result()
		);

		return $response;
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 23--------------------------
	public function getLIPA23($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = "SELECT C.sisa_lalu, C.diterima_bulan_ini, C.dicabut, C.putus_elektronik, SUM(C.total_putus) - SUM(C.putus_elektronik) AS putus_biasa, C.total_putus,
				SUM(C.sisa_lalu) + SUM(C.diterima_bulan_ini) - SUM(C.total_putus) AS sisa_bulan_ini
				FROM (SELECT
					SUM(CASE WHEN DATE_FORMAT(vpk.tanggal_pendaftaran,'%Y-%m') < '$periode' AND ((vpk.tanggal_putusan IS NULL) OR (DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m') >= '$periode')) THEN 1 ELSE 0 END) AS sisa_lalu,
					SUM(CASE WHEN DATE_FORMAT(vpk.tanggal_pendaftaran,'%Y-%m') = '$periode' THEN 1 ELSE 0 END) AS diterima_bulan_ini,
					SUM( CASE WHEN ((DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m')='$periode'  AND vpk.`status_putusan_id` IN (7,67,85)) OR DATE_FORMAT(vpk.tanggal_cabut,'%Y-%m')='$periode') THEN 1 ELSE 0 END) AS dicabut,
					(SELECT COUNT(perkara_id) FROM v_perkara vpk INNER JOIN dbelaporan.`elaporan_lipa_24` USING (perkara_id)
						WHERE DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m')='$periode'  AND vpk.status_putusan_id IS NOT NULL) AS putus_elektronik,
					SUM(CASE WHEN DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m')='$periode'  AND vpk.status_putusan_id IS NOT NULL THEN 1 ELSE 0 END) AS total_putus
					FROM v_perkara vpk INNER JOIN perkara_efiling_id USING(perkara_id)) AS C 
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Lipa 24--------------------------
	public function getLIPA24($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$dblitigasi = getenv('DB_DATABASE2') . '.elaporan_lipa_24';
		$sql = "SELECT
				SUM(CASE WHEN DATE_FORMAT(lit.tgl_elitigasi,'%Y-%m') < '$periode' AND ((vpk.tanggal_putusan IS NULL) OR (DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m') >= '$periode')) THEN 1 ELSE 0 END) AS sisa_lalu,
				SUM(CASE WHEN DATE_FORMAT(lit.tgl_elitigasi,'%Y-%m') = '$periode' THEN 1 ELSE 0 END) AS diterima_bulan_ini,
				SUM( CASE WHEN ((DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m')='$periode'  AND vpk.`status_putusan_id` IN (7,67,85)) OR DATE_FORMAT(vpk.tanggal_cabut,'%Y-%m')='$periode') THEN 1 ELSE 0 END) AS dicabut,
				SUM(CASE WHEN DATE_FORMAT(vpk.tanggal_putusan,'%Y-%m')='$periode'  AND vpk.status_putusan_id IS NOT NULL THEN 1 ELSE 0 END) AS putus_bulan_ini,
				(SUM(CASE WHEN DATE_FORMAT(lit.tgl_elitigasi, '%Y-%m') < '$periode' AND ((vpk.tanggal_putusan IS NULL) OR (DATE_FORMAT(vpk.tanggal_putusan, '%Y-%m') >= '$periode')) THEN 1 ELSE 0 END) + 
					SUM(CASE WHEN DATE_FORMAT(lit.tgl_elitigasi, '%Y-%m') = '$periode' THEN 1 ELSE 0 END)) - 
					SUM(CASE WHEN DATE_FORMAT(vpk.tanggal_putusan, '%Y-%m') = '$periode' AND vpk.status_putusan_id IS NOT NULL THEN 1 ELSE 0 END) AS sisa_bulan_ini
				FROM v_perkara vpk INNER JOIN $dblitigasi lit USING (perkara_id) 
				";
		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
	// ------------------------------------------------------------------------
	// -----------------------------Ambil Data Penyerahan AC--------------------------
	public function getPenyerahanAC($bulan, $tahun)
	{
		$periode = $tahun . '-' . $bulan;
		$sql = "SELECT p.nomor_perkara, a.nomor_akta_cerai, a.jenis_cerai, pp.tanggal_putusan, i.tgl_ikrar_talak, 
					a.tgl_penyerahan_akta_cerai AS tgl_penyerahan, pp.tanggal_bht,
					(SELECT (CASE WHEN alur_perkara_id=16 OR jenis_perkara_id=346 OR jenis_perkara_id=341 THEN 'Pemohon' ELSE 'Penggugat' END)) AS penerima
					FROM perkara p LEFT JOIN perkara_putusan pp USING(perkara_id) LEFT JOIN perkara_ikrar_talak i USING(perkara_id)
					LEFT JOIN perkara_akta_cerai a USING(perkara_id)
					WHERE DATE_FORMAT(a.tgl_penyerahan_akta_cerai,'%Y-%m') = '$periode'
				UNION
				SELECT p.nomor_perkara, a.nomor_akta_cerai, a.jenis_cerai, pp.tanggal_putusan, i.tgl_ikrar_talak, 
					a.tgl_penyerahan_akta_cerai_pihak2 AS tgl_penyerahan, pp.tanggal_bht,
					(SELECT (CASE WHEN alur_perkara_id=16 OR jenis_perkara_id=346 OR jenis_perkara_id=341 THEN 'Termohon' ELSE 'Tergugat' END)) AS penerima
					FROM perkara p LEFT JOIN perkara_putusan pp USING(perkara_id) LEFT JOIN perkara_ikrar_talak i USING(perkara_id)
					LEFT JOIN perkara_akta_cerai a USING(perkara_id)
					WHERE DATE_FORMAT(a.tgl_penyerahan_akta_cerai_pihak2,'%Y-%m') = '$periode'
				ORDER BY tgl_penyerahan";

		$hasil = $this->db->query($sql);
		return $hasil->result();
	}
}

/* End of file Laporan_model.php */
/* Location: ./application/models/Laporan_model.php */
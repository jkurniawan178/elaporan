<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('masuk_model');
		$this->load->library('config_library');
	}
	public function index()
	{
		$menu = $this->masuk_model->sequrity();
		$data['menu'] = $menu;
		$data['contents'] = 'v_dashboard';
		$data['dashboard'] = $this->getDashboard();
		$data['settings'] = $this->config_library->get_config_SIPP();
		$this->load->view('templates/index', $data);
	}

	public function getDashboard()
	{
		$sql = "SELECT C.tahun, C.sisatahunlalu, C.masuk, C.minutasi, C.sisaperkara, C.putus, C.belumminutasi, C.ecourt,
		ROUND(SUM(C.minutasi)*100/(SUM(C.masuk)+SUM(C.sisatahunlalu)),2) AS kinerjaPN,
		round((C.ecourt/C.masuk)*100,2) as rasio_ecourt
		FROM (SELECT
		YEAR(NOW()) as tahun,
		SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)<=YEAR(NOW())-1 AND (YEAR(B.tanggal_minutasi)>=YEAR(NOW()) OR (B.tanggal_minutasi IS NULL OR B.tanggal_minutasi='')) THEN 1 ELSE 0 END) AS sisatahunlalu,
		SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)=YEAR(NOW()) THEN 1 ELSE 0 END) AS masuk,
		SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)<=YEAR(NOW()) AND YEAR(B.tanggal_minutasi)=YEAR(NOW()) THEN 1 ELSE 0 END) AS minutasi,
		SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)<=YEAR(NOW()) AND (B.tanggal_minutasi)IS NULL THEN 1 ELSE 0 END) AS sisaperkara,
		SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)<=YEAR(NOW()) AND YEAR(B.tanggal_putusan)=YEAR(NOW()) THEN 1 ELSE 0 END) AS putus,
		SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)<=YEAR(NOW()) AND (YEAR(B.tanggal_putusan)<=YEAR(NOW()) AND (B.tanggal_minutasi IS NULL OR B.tanggal_minutasi='')) THEN 1 ELSE 0 END) AS belumminutasi,
		(SELECT SUM(CASE WHEN efiling_id THEN 1 ELSE 0 END) FROM `perkara_efiling` WHERE nomor_perkara IS NOT NULL AND YEAR(tgl_pendaftaran_perkara) = year(now())) as ecourt
		FROM perkara AS A LEFT JOIN perkara_putusan AS B ON A.perkara_id=B.perkara_id WHERE A.alur_perkara_id <> 114) AS C
		";
		$hasil = $this->db->query($sql);
		return $hasil->row();
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Pagu_14
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Pagu_14 extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('pagu_14_model');
  }

  public function index()
  {
    $data['contents'] = 'pagu_14/v_pagu_14';
    $data['pagu_14'] = $this->pagu_14_model->get_pagu_14_all();
    $this->load->view('templates/index', $data);
  }

  public function tambah_aksi()
  {
    $tahun = $this->input->post('tahun');
    $pagu_awal = $this->input->post('pagu_awal');
    $pagu_revisi = $this->input->post('pagu_revisi');
    $lokasi = $this->input->post('lokasi');
    $kegiatan = $this->input->post('kegiatan');
    $perkara = $this->input->post('perkara');

    $data = array(
      'tahun_anggaran' => $tahun,
      'pagu_awal' => $pagu_awal,
      'pagu_revisi' => $pagu_revisi,
      'target_lokasi' => $lokasi,
      'target_kegiatan' => $kegiatan,
      'target_perkara' => $perkara
    );

    //validasi
    $ada = $this->pagu_14_model->searchby_year($tahun);

    if (count($ada) == 0) {
      $this->pagu_14_model->input_data($data);
      redirect('pagu_14/index');
    }
    redirect('pagu_14/index');
  }
}


/* End of file Pagu_14.php */
/* Location: ./application/controllers/Pagu_14.php */
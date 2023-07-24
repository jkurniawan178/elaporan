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
    $this->load->model('sidkel_model');
    $this->load->library('config_library');
  }

  public function index()
  {
    $data['contents'] = 'pagu_14/v_pagu_14';
    $data['pagu_14'] = $this->sidkel_model->get_pagu_14_all();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  public function _rules()
  {
    $this->form_validation->set_rules('tahun', 'tahun', 'required|numeric');
    $this->form_validation->set_rules('pagu_awal', 'pagu awal', 'required|numeric');
    $this->form_validation->set_rules('lokasi', 'taget lokasi', 'required|numeric');
    $this->form_validation->set_rules('kegiatan', 'target kegiatan', 'required|numeric');
    $this->form_validation->set_rules('perkara', 'target perkara', 'required|numeric');
  }

  public function tambah_aksi()
  {
    $this->_rules();
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Data pagu tidak berhasil ditambahkan!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('LIPA_14/pagu_14');
      $this->index();
    } else {
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
      //cek apabila data pagu di tahun yang sama sudah diinput
      $ada_tahun = $this->sidkel_model->searchby_year($tahun);

      if (count($ada_tahun) == 0) {
        $this->sidkel_model->input_pagu14($data);
        $this->session->set_flashdata('success', '<strong>Data pagu berhasil ditambahkan!</strong>');
        redirect('LIPA_14/pagu_14');
      }

      $this->session->set_flashdata('error', '
        <strong>Data pagu tidak berhasil ditambahkan!</strong> Pagu pada ' . $tahun . ' telah ada!');
      redirect('LIPA_14/pagu_14');
    }
  }

  public function delete_aksi()
  {
    $idEncrypted = $this->input->post('id');
    $id = $this->encryption->decrypt($idEncrypted);
    $where = array('id' => $id);
    $this->sidkel_model->delete_pagu14($where);
    $this->session->set_flashdata('error', '<strong>Data pagu berhasil dihapus!</strong>');
    redirect('LIPA_14/pagu_14');
  }
}


/* End of file Pagu_14.php */
/* Location: ./application/controllers/Pagu_14.php */
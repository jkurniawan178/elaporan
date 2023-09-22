<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Elitigasi
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

class Elitigasi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('masuk_model');
    $this->load->model('elitigasi_model');
    $this->load->library('Config_library');
  }

  public function index()
  {
    $this->masuk_model->sequrity('mn_input');
    $menu = $this->masuk_model->getMenu();
    $data['menu'] = $menu;
    $data['contents'] = 'elitigasi/v_elitigasi';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $data['elitigasi'] = $this->elitigasi_model->getLitigasiAll();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }
  //---------------------------------------------------------------
  public function get_suggestions()
  {
    $query = $this->input->get('term');
    $suggestions = $this->elitigasi_model->get_suggestions($query);

    // Return suggestions in JSON format
    echo json_encode($suggestions);
  }
  //------------------------------------------------------------------------
  public function cek_tgl_perkara()
  {
    $nomor_perkara = $this->input->post('nomor_perkara');
    $tgl_pendaftaran = $this->elitigasi_model->getTglPendaftaran($nomor_perkara);
    // var_dump(json_encode($tgl_pendaftaran));
    echo json_encode($tgl_pendaftaran);
  }
  //----------------------------------------------------------------------------------------------------
  protected function _rules()
  {
    $this->form_validation->set_rules('nomor_perkara', 'nomor perkara', 'required|trim');
    $this->form_validation->set_rules('tgl_elitigasi', 'tanggal elitigasi', 'required|trim');
  }
  //----------------------------------------------------------------------------------------------------
  public function tambah_aksi()
  {
    $this->_rules();
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Perkara Elitigasi tidak berhasil ditambahkan!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('LIPA_24/elitigasi');
    } else {
      $perkara = $this->input->post('nomor_perkara');
      $tgl_elitigasi = $this->input->post('tgl_elitigasi');
      $perkara_id = $this->elitigasi_model->getPerkaraId($perkara);

      $data = array(
        'perkara_id' => $perkara_id->perkara_id,
        'tgl_elitigasi' => tgl_ke_mysql($tgl_elitigasi)
      );


      if (!is_null($perkara_id)) {
        $id = $this->elitigasi_model->cekPerkaraId($perkara_id->perkara_id);

        if (count($id) == 0) {
          $this->elitigasi_model->inputElitigasi($data);
          $this->session->set_flashdata('success', '<strong>Perkara Elitigasi berhasil ditambahkan!</strong>');
          redirect('LIPA_24/elitigasi');
        } else {
          $this->session->set_flashdata('error', '
          <strong>Perkara Elitigasi Gagal ditambahkan!</strong> Nomor Perkara ' . $perkara . '; Sudah Pernah di Input');
          redirect('LIPA_24/elitigasi');
        }
      } else {
        $this->session->set_flashdata('error', '
        <strong>Perkara Elitigasi Gagal ditambahkan!</strong> Nomor Perkara ' . $perkara . '; salah / tidak ditemukan');
        redirect('LIPA_24/elitigasi');
      }
    }
  }

  //--------------------------------------------------------------------------------------
  public function delete_aksi()
  {
    $idEncrypted = $this->input->post('id');
    $id = $this->encryption->decrypt($idEncrypted);
    $where = array('id' => $id);
    $this->elitigasi_model->deleteLipa24($where);
    $this->session->set_flashdata('success', '<strong>Perkara Elitigasi berhasil dihapus!</strong>');
    redirect('LIPA_24/elitigasi');
  }
  //----------------------------------------------------------------------
  function filter_lipa24_tahun()
  {
    $tahun = $this->input->post('tahun');

    $data = $this->elitigasi_model->getLipa24YearFilter($tahun);
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}


/* End of file Elitigasi.php */
/* Location: ./application/controllers/Elitigasi.php */
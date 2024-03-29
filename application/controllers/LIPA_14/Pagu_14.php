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
    $this->load->model('masuk_model');
    $this->load->model('sidkel_model');
    $this->load->library('config_library');
  }

  public function index()
  {
    $this->masuk_model->sequrity('mn_pagu');
    $menu = $this->masuk_model->getMenu();
    $data['menu'] = $menu;
    $data['contents'] = 'pagu_14/v_pagu_14';
    $data['pagu_14'] = $this->sidkel_model->getPagu14All();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  protected function _rules($aksi)
  {
    // var_dump($aksi);
    if ($aksi === 'tambah') {
      $this->form_validation->set_rules('tahun', 'tahun', 'required|trim|numeric');
    }
    $this->form_validation->set_rules('pagu_awal', 'pagu awal', 'required|trim|numeric');
    $this->form_validation->set_rules('lokasi', 'taget lokasi', 'required|trim|numeric');
    $this->form_validation->set_rules('kegiatan', 'target kegiatan', 'required|trim|numeric');
    $this->form_validation->set_rules('perkara', 'target perkara', 'required|trim|numeric');
  }

  public function tambah_aksi()
  {
    $this->_rules('tambah');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Data pagu tidak berhasil ditambahkan!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('LIPA_14/pagu_14');
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
      $ada_tahun = $this->sidkel_model->searchPagu14byYear($tahun);

      if (count($ada_tahun) == 0) {
        $this->sidkel_model->inputPagu14($data);
        $this->session->set_flashdata('success', '<strong>Data pagu berhasil ditambahkan!</strong>');
        redirect('LIPA_14/pagu_14');
      }

      $this->session->set_flashdata('error', '
        <strong>Data pagu Gagal ditambahkan!</strong> Pagu pada ' . $tahun . ' telah ada!');
      redirect('LIPA_14/pagu_14');
    }
  }

  public function delete_aksi()
  {
    $idEncrypted = $this->input->post('id');
    $id = $this->encryption->decrypt($idEncrypted);

    $dataLipa = $this->sidkel_model->cekLipa14byPagu($id);

    if (count($dataLipa) == 0) {
      $where = array('id' => $id);
      $this->sidkel_model->deletePagu14($where);
      $this->session->set_flashdata('success', '<strong>Data pagu berhasil dihapus!</strong>');
      redirect('LIPA_14/pagu_14');
    }
    $this->session->set_flashdata('error', '<strong>Data pagu tidak bisa dihapus!</strong> Sudah ada Laporan Lipa 14 untuk tahun tersebut');
    redirect('LIPA_14/pagu_14');
  }

  public function ubah_aksi()
  {
    $this->_rules('edit');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Data pagu tidak berhasil diubah!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('LIPA_14/pagu_14');
    } else {
      $idEncrypted = $this->input->post('id');
      $id = $this->encryption->decrypt($idEncrypted);

      // $tahun = $this->input->post('tahun');
      $pagu_awal = $this->input->post('pagu_awal');
      $pagu_revisi = $this->input->post('pagu_revisi');
      $lokasi = $this->input->post('lokasi');
      $kegiatan = $this->input->post('kegiatan');
      $perkara = $this->input->post('perkara');

      $data = array(
        // 'tahun_anggaran' => $tahun,
        'pagu_awal' => $pagu_awal,
        'pagu_revisi' => $pagu_revisi,
        'target_lokasi' => $lokasi,
        'target_kegiatan' => $kegiatan,
        'target_perkara' => $perkara
      );

      // var_dump($data);
      $this->sidkel_model->updatePagu14($id, $data);
      $this->session->set_flashdata('success', '<strong>Data pagu berhasil diubah!</strong>');
      redirect('LIPA_14/pagu_14');
    }
  }

  //Pencarian data PAGU 14 by id
  public function get_pagu14()
  {
    $encodedId = $this->input->post('id');
    $id = $this->encryption->decrypt($encodedId);
    $data = $this->sidkel_model->getPagu14byId($id);

    $data->id = $this->encryption->encrypt($data->id);
    $data->pagu_awal = number_format($data->pagu_awal, 0, ',', '.');
    $data->pagu_revisi = number_format($data->pagu_revisi, 0, ',', '.');

    header('Content-Type: application/json');
    echo json_encode($data);
  }
}


/* End of file Pagu_14.php */
/* Location: ./application/controllers/Pagu_14.php */
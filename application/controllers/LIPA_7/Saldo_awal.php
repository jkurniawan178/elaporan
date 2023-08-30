<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Saldo_awal
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

class Saldo_awal extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('masuk_model');
    $this->load->model('keuangan_model');
    $this->load->library('config_library');
  }

  public function index()
  {
    $menu = $this->masuk_model->sequrity();
    $data['menu'] = $menu;
    $data['contents'] = 'saldo_awal/v_saldo_awal';
    $data['saldo_awal'] = $this->keuangan_model->getSaldoAwalAll();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  //------------------------------------------------------------------------------
  protected function _rules($aksi)
  {
    // var_dump($aksi);
    if ($aksi === 'tambah') {
      $this->form_validation->set_rules('tahun', 'tahun', 'required|trim|numeric');
    }
    $this->form_validation->set_rules('awal_7a', 'awal_7a', 'required|trim|numeric');
    $this->form_validation->set_rules('awal_7b', 'awal 7b', 'required|trim|numeric');
    $this->form_validation->set_rules('awal_7c', 'awal 7c', 'required|trim|numeric');
    $this->form_validation->set_rules('keterangan', 'keterangan', 'trim');
  }

  //-----------------------------------------------------------------------------------

  function tambah_aksi()
  {
    $this->_rules('tambah');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Data Saldo Awal tidak berhasil ditambahkan!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('LIPA_7/saldo_awal');
    } else {
      $tahun = $this->input->post('tahun');
      $awal_7a = $this->input->post('awal_7a');
      $awal_7b = $this->input->post('awal_7b');
      $awal_7c = $this->input->post('awal_7c');
      $keterangan = $this->input->post('keterangan');

      $data = array(
        'tahun' => $tahun,
        'saldo_awal_7a' => $awal_7a,
        'saldo_awal_7b' => $awal_7b,
        'saldo_awal_7c' => $awal_7c,
        'keterangan' => $keterangan,
      );

      //validasi
      //cek apabila data pagu di tahun yang sama sudah diinput
      $ada_tahun = $this->keuangan_model->searchSaldoAwalbyYear($tahun);

      if (count($ada_tahun) == 0) {
        $this->keuangan_model->inputSaldoAwal($data);
        $this->session->set_flashdata('success', '<strong>Data Saldo Awal berhasil ditambahkan!</strong>');
        redirect('LIPA_7/saldo_awal');
      }

      $this->session->set_flashdata('error', '
        <strong>Data Saldo Awal Gagal ditambahkan!</strong> Saldo Awal pada tahun ' . $tahun . ' telah ada!');
      redirect('LIPA_7/saldo_awal');
    }
  }
  //-------------------------------------------------------------------------------------------------------------
  //Pencarian data Saldo Awal by id
  public function get_saldo_awal()
  {
    $encodedId = $this->input->post('id');
    $id = $this->encryption->decrypt($encodedId);
    $data = $this->keuangan_model->getSaldoAwalbyId($id);

    $data->id = $this->encryption->encrypt($data->id);
    $data->saldo_awal_7a = number_format($data->saldo_awal_7a, 0, ',', '.');
    $data->saldo_awal_7b = number_format($data->saldo_awal_7b, 0, ',', '.');
    $data->saldo_awal_7c = number_format($data->saldo_awal_7c, 0, ',', '.');

    header('Content-Type: application/json');
    echo json_encode($data);
  }
  //----------------------------------------------------------------------------------------------------
  public function ubah_aksi()
  {
    $this->_rules('edit');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Data Saldo Awal Tidak berhasil diubah!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('LIPA_7/saldo_awal');
    } else {
      $idEncrypted = $this->input->post('id');
      $id = $this->encryption->decrypt($idEncrypted);

      $awal_7a = $this->input->post('awal_7a');
      $awal_7b = $this->input->post('awal_7b');
      $awal_7c = $this->input->post('awal_7c');
      $keterangan = $this->input->post('keterangan');

      $data = array(
        'saldo_awal_7a' => $awal_7a,
        'saldo_awal_7b' => $awal_7b,
        'saldo_awal_7c' => $awal_7c,
        'keterangan' => $keterangan,
      );

      // var_dump($data);
      $this->keuangan_model->updateSaldoAwal($id, $data);
      $this->session->set_flashdata('success', '<strong>Data Saldo Awal berhasil diubah!</strong>');
      redirect('LIPA_7/saldo_awal');
    }
  }
  //-------------------------------------------------------------------------------
  public function delete_aksi()
  {
    $idEncrypted = $this->input->post('id');
    $id = $this->encryption->decrypt($idEncrypted);

    $where = array('id' => $id);
    $this->keuangan_model->deleteSaldoAwal($where);
    $this->session->set_flashdata('success', '<strong>Data Saldo Awal berhasil dihapus!</strong>');
    redirect('LIPA_7/saldo_awal');
  }
}


/* End of file Saldo_awal.php */
/* Location: ./application/controllers/Saldo_awal.php */
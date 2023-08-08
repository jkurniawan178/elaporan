<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Posbakum
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

class Posbakum extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('config_library');
    $this->load->model('posbakum_model');
  }

  public function index()
  {
    $data['contents'] = 'posbakum/v_posbakum';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $data['posbakum'] = $this->posbakum_model->getLipa16All();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  //-------------------------------------------------------------------------
  public function cek_pagu()
  {
    $year = $this->input->post('tahun');
    $month = $this->input->post('bulan');
    $hasil_pagu = $this->posbakum_model->cekSaldoPagu16($year);
    $hasil_lipa = $this->posbakum_model->cekLipa16byPeriode($month, $year);


    if (count($hasil_pagu) >= 1) {
      $revisi = intval($hasil_pagu->pagu_revisi);
      $ada = intval($hasil_lipa->id_count);

      $pagu_awal = number_format($hasil_pagu->pagu_awal, 0, ',', '.');
      $pagu_revisi = number_format($hasil_pagu->pagu_revisi, 0, ',', '.');
      $saldo = number_format($hasil_pagu->saldo_sisa, 0, ',', '.');
      if ($ada == 0) {
        if (is_null($revisi) || $revisi == 0) {
          $response = [
            'kode' => '200',
            'pagu_awal' => $pagu_awal,
            'saldo' => $saldo
          ];
          echo json_encode($response);
        } else {
          $response = [
            'kode' => '200',
            'pagu_awal' => $pagu_revisi,
            'saldo' => $saldo
          ];
          echo json_encode($response);
        }
      } else {
        $response = [
          'kode' => '201',
          'data' => 'Laporan periode ' . pilihbulan($month) . ' ' . $year . ' sudah pernah diisi, silahkan ganti periode!'
        ];
        echo json_encode($response);
      }
    } else {
      $response = [
        'kode' => '201',
        'data' => 'Pagu Anggaran LIPA 16 tahun ' . $year . ' belum diisi, silahkan diisi terlebih dahulu'
      ];
      echo json_encode($response);
    }
  }
  //-----------------------------------------------------------------------
  protected function _rules($aksi)
  {
    if ($aksi === 'tambah') {
      $this->form_validation->set_rules('tahun_hidden', 'tahun', 'required|trim|numeric');
      $this->form_validation->set_rules('bulan_hidden', 'bulan', 'required|trim');
    }

    $this->form_validation->set_rules('realisasi', 'realisasi', 'required|trim|numeric');
    $this->form_validation->set_rules('jml_layanan', 'jumlah layanan', 'required|trim|numeric');
    $this->form_validation->set_rules('keterangan', 'keterangan', 'trim');
  }
  //-------------------------------------------------------------------------
  public function tambah_aksi()
  {
    $this->_rules('tambah');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Data LIPA 16 Gagal ditambahkan!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('LIPA_16/posbakum');
    } else {
      $tahun = $this->input->post('tahun_hidden');
      $bulan = $this->input->post('bulan_hidden');
      $realisasi = $this->input->post('realisasi');
      $layanan = $this->input->post('jml_layanan');
      $keterangan = $this->input->post('keterangan');

      $data = array(
        'bulan' => $bulan,
        'tahun' => $tahun,
        'realisasi' => $realisasi,
        'jml_layanan' => $layanan,
        'keterangan' => $keterangan,
      );

      $data_saldo = $this->posbakum_model->cekSaldoPagu16($tahun);
      $saldo = $data_saldo->saldo_sisa;
      // var_dump($saldo);

      if (floatval($realisasi) <= floatval($saldo)) {
        $this->posbakum_model->inputLipa16($data);
        $this->session->set_flashdata('success', '<strong>Data Posbakum berhasil ditambahkan!</strong>');
        redirect('LIPA_16/posbakum');
      }

      $this->session->set_flashdata('error', '
        <strong>Data Posbakum gagal ditambahkan!</strong> Realisasi lebih besar daripada Saldo Pagu saat ini!');
      redirect('LIPA_16/posbakum');
    }
  }
  //--------------------------------------------------------------------------------------
  public function delete_aksi()
  {
    $idEncrypted = $this->input->post('id');
    $id = $this->encryption->decrypt($idEncrypted);
    $where = array('id' => $id);
    $this->posbakum_model->deleteLipa16($where);
    $this->session->set_flashdata('success', '<strong>Data Posbakum berhasil dihapus!</strong>');
    redirect('LIPA_16/posbakum');
  }
  //---------------------------------------------------------------------------------------
  function get_lipa16_id()
  {
    $encodedId = $this->input->post('id');
    $id = $this->encryption->decrypt($encodedId);
    $data = $this->posbakum_model->getLipa16byId($id);
    $raw_saldo = $this->posbakum_model->cekSaldoPagu16($data->tahun);
    $saldo = floatval($raw_saldo->saldo_sisa) + floatval($data->realisasi);

    $data->id = $this->encryption->encrypt($data->id);
    $data->pagu_awal = number_format($data->pagu_awal, 0, ',', '.');
    $data->realisasi = number_format($data->realisasi, 0, ',', '.');
    $data->saldo = number_format($saldo, 0, ',', '.');

    header('Content-Type: application/json');
    echo json_encode($data);
  }
  //----------------------------------------------------------------------
  function ubah_aksi()
  {
    $this->_rules('ubah');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Data LIPA 16 Gagal ditambahkan!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('LIPA_16/posbakum');
    } else {
      $encodedId = $this->input->post('edit_id');
      $id = $this->encryption->decrypt($encodedId);
      $tahun = $this->input->post('tahun_hidden');
      $realisasi = $this->input->post('realisasi');
      $layanan = $this->input->post('jml_layanan');
      $keterangan = $this->input->post('keterangan');

      $data = array(
        'realisasi' => $realisasi,
        'jml_layanan' => $layanan,
        'keterangan' => $keterangan,
      );

      $data_saldo = $this->posbakum_model->cekSaldoPagu16($tahun);
      $datarealisasi_sebelumnya = $this->posbakum_model->getLipa16byId($id);
      $realisasi_sebelumnya = floatval($datarealisasi_sebelumnya->realisasi);
      $saldo = floatval($data_saldo->saldo_sisa) + floatval($realisasi_sebelumnya);

      if (floatval($realisasi) <= $saldo) {
        $this->posbakum_model->updateLipa16($id, $data);
        $this->session->set_flashdata('success', '<strong>Data Posbakum berhasil diubah!</strong>');
        redirect('LIPA_16/posbakum');
      }

      $this->session->set_flashdata('error', '
        <strong>Data Posbakum Gagal ditambahkan!</strong> Realisasi lebih besar daripada Saldo Pagu saat ini!');
      redirect('LIPA_16/posbakum');
    }
  }
  //----------------------------------------------------------------------
  function filter_lipa16_tahun()
  {
    $tahun = $this->input->post('tahun');

    $data = $this->posbakum_model->getLipa16YearFilter($tahun);
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}


/* End of file Posbakum.php */
/* Location: ./application/controllers/Posbakum.php */
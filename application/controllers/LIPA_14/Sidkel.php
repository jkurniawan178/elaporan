<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Sidkel
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

class Sidkel extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('config_library');
    $this->load->model('sidkel_model');
  }

  public function index()
  {
    $data['contents'] = 'sidkel/v_sidkel';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $data['sidkel'] = $this->sidkel_model->get_All();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  protected function _rules($aksi)
  {
    if ($aksi === 'tambah') {
      $this->form_validation->set_rules('tahun_hidden', 'tahun', 'required|trim|numeric');
      $this->form_validation->set_rules('bulan_hidden', 'bulan', 'required|trim');
    }

    $this->form_validation->set_rules('realisasi', 'realisasi', 'required|trim|numeric');
    $this->form_validation->set_rules('jml_kegiatan', 'jumlah kegiatan', 'required|trim|numeric');
    $this->form_validation->set_rules('jml_perkara', 'jumlah perkara', 'required|trim|numeric');
    $this->form_validation->set_rules('keterangan', 'keterangan', 'trim');
  }

  public function tambah_aksi()
  {
    $this->_rules('tambah');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Data LIPA 14 Gagal ditambahkan!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('LIPA_14/sidkel');
    } else {
      $tahun = $this->input->post('tahun_hidden');
      $bulan = $this->input->post('bulan_hidden');
      $realisasi = $this->input->post('realisasi');
      $kegiatan = $this->input->post('jml_kegiatan');
      $perkara = $this->input->post('jml_perkara');
      $keterangan = $this->input->post('keterangan');

      $data = array(
        'bulan' => $bulan,
        'tahun' => $tahun,
        'realisasi' => $realisasi,
        'jml_kegiatan' => $kegiatan,
        'jml_perkara' => $perkara,
        'keterangan' => $keterangan,
      );

      $data_saldo = $this->sidkel_model->cekSaldoPagu14($tahun);
      $saldo = $data_saldo->saldo_sisa;
      // var_dump($saldo);

      if (floatval($realisasi) <= floatval($saldo)) {
        $this->sidkel_model->input_data($data);
        $this->session->set_flashdata('success', '<strong>Data Sidang Keliling berhasil ditambahkan!</strong>');
        redirect('LIPA_14/sidkel');
      }

      $this->session->set_flashdata('error', '
        <strong>Data Sidang Keliling Gagal ditambahkan!</strong> Realisasi lebih besar daripada Saldo Pagu saat ini!');
      redirect('LIPA_14/sidkel');
    }
  }

  public function cek_pagu()
  {
    $year = $this->input->post('tahun');
    $month = $this->input->post('bulan');
    $hasil_pagu = $this->sidkel_model->cekSaldoPagu14($year);
    $hasil_lipa = $this->sidkel_model->cekLipa14byPeriode($month, $year);


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
        'data' => 'Pagu Anggaran LIPA 14 tahun ' . $year . ' belum diisi, silahkan diisi terlebih dahulu'
      ];
      echo json_encode($response);
    }
  }

  public function delete_aksi()
  {
    $idEncrypted = $this->input->post('id');
    $id = $this->encryption->decrypt($idEncrypted);
    $where = array('id' => $id);
    $this->sidkel_model->deleteLipa14($where);
    $this->session->set_flashdata('success', '<strong>Data Sidkel berhasil dihapus!</strong>');
    redirect('LIPA_14/Sidkel');
  }

  function get_lipa14_id()
  {
    $encodedId = $this->input->post('id');
    $id = $this->encryption->decrypt($encodedId);
    $data = $this->sidkel_model->getLipa14byId($id);
    $raw_saldo = $this->sidkel_model->cekSaldoPagu14($data->tahun);
    $saldo = floatval($raw_saldo->saldo_sisa) + floatval($data->realisasi);

    $data->id = $this->encryption->encrypt($data->id);
    $data->pagu_awal = number_format($data->pagu_awal, 0, ',', '.');
    $data->realisasi = number_format($data->realisasi, 0, ',', '.');
    $data->saldo = number_format($saldo, 0, ',', '.');

    header('Content-Type: application/json');
    echo json_encode($data);
  }

  function ubah_aksi()
  {
    $this->_rules('ubah');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Data LIPA 14 Gagal ditambahkan!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('LIPA_14/sidkel');
    } else {
      $encodedId = $this->input->post('edit_id');
      $id = $this->encryption->decrypt($encodedId);
      $tahun = $this->input->post('tahun_hidden');
      // $bulan = $this->input->post('bulan_hidden');
      $realisasi = $this->input->post('realisasi');
      $kegiatan = $this->input->post('jml_kegiatan');
      $perkara = $this->input->post('jml_perkara');
      $keterangan = $this->input->post('keterangan');

      $data = array(
        // 'bulan' => $bulan,
        // 'tahun' => $tahun,
        'realisasi' => $realisasi,
        'jml_kegiatan' => $kegiatan,
        'jml_perkara' => $perkara,
        'keterangan' => $keterangan,
      );

      $data_saldo = $this->sidkel_model->cekSaldoPagu14($tahun);
      $datarealisasi_sebelumnya = $this->sidkel_model->getLipa14byId($id);
      $realisasi_sebelumnya = floatval($datarealisasi_sebelumnya->realisasi);
      $saldo = floatval($data_saldo->saldo_sisa) + floatval($realisasi_sebelumnya);
      // var_dump($saldo, $realisasi);

      if (floatval($realisasi) <= $saldo) {
        $this->sidkel_model->updateLipa14($id, $data);
        $this->session->set_flashdata('success', '<strong>Data Sidang Keliling berhasil diubah!</strong>');
        redirect('LIPA_14/sidkel');
      }

      $this->session->set_flashdata('error', '
        <strong>Data Sidang Keliling Gagal ditambahkan!</strong> Realisasi lebih besar daripada Saldo Pagu saat ini!');
      redirect('LIPA_14/sidkel');
    }
  }
}


/* End of file Sidkel.php */
/* Location: ./application/controllers/Sidkel.php */
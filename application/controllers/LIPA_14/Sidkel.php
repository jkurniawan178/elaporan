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
    // var_dump($aksi);
    if ($aksi === 'tambah') {
      $this->form_validation->set_rules('tahun_hidden', 'tahun', 'required|numeric');
      $this->form_validation->set_rules('bulan_hidden', 'bulan', 'required');
    }
    $this->form_validation->set_rules('realisasi', 'realisasi', 'required|numeric');
    $this->form_validation->set_rules('jml_kegiatan', 'jumlah kegiatan', 'required|numeric');
    $this->form_validation->set_rules('jml_perkara', 'jumlah perkara', 'required|numeric');
  }

  public function tambah_aksi()
  {
    //TODO: add validation
    $tahun = $this->input->post('tahun_hidden');
    $bulan = $this->input->post('bulan_hidden');
    // $pagu_awal = $this->input->post('pagu_awal');
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

    // var_dump($data);

    $this->sidkel_model->input_data($data);
    redirect('LIPA_14/sidkel/index');
  }

  public function cek_pagu()
  {
    $year = $this->input->post('tahun');
    $month = $this->input->post('bulan');
    $hasil_pagu = $this->sidkel_model->cekSaldoPagu14($year);
    $hasil_lipa = $this->sidkel_model->cekLipa14byPeriode($month, $year);
    // $jml = intval(count($hasil_pagu[0]), 0);


    if (count($hasil_pagu) >= 1) {
      $revisi = intval($hasil_pagu[0]->pagu_revisi);
      $ada = intval($hasil_lipa[0]->id_count);

      $pagu_awal = number_format($hasil_pagu[0]->pagu_awal, 0, ',', '.');
      $pagu_revisi = number_format($hasil_pagu[0]->pagu_revisi, 0, ',', '.');
      $saldo = number_format($hasil_pagu[0]->saldo_sisa, 0, ',', '.');
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
    $this->session->set_flashdata('success', '<strong>Data pagu berhasil dihapus!</strong>');
    redirect('LIPA_14/Sidkel');
  }
}


/* End of file Sidkel.php */
/* Location: ./application/controllers/Sidkel.php */
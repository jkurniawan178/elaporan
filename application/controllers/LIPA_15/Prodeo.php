<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Prodeo
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

class Prodeo extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('config_library');
    $this->load->model('prodeo_model');
  }
  //-------------------------------------------------------------------------
  public function index()
  {
    $data['contents'] = 'prodeo/v_prodeo';
    $data['nm_bulan'] = $this->config_library->get_nm_bulan();
    $data['prodeo'] = $this->prodeo_model->getLipa15All();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }
  //-------------------------------------------------------------------------
  public function cek_pagu()
  {
    $year = $this->input->post('tahun');
    $month = $this->input->post('bulan');
    $hasil_pagu = $this->prodeo_model->cekSaldoPagu15($year);
    $hasil_lipa = $this->prodeo_model->cekLipa15byPeriode($month, $year);


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
        'data' => 'Pagu Anggaran LIPA 15 tahun ' . $year . ' belum diisi, silahkan diisi terlebih dahulu'
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
    $this->form_validation->set_rules('jml_perkara', 'jumlah perkara', 'required|trim|numeric');
    $this->form_validation->set_rules('keterangan', 'keterangan', 'trim');
  }
  //-------------------------------------------------------------------------
  public function tambah_aksi()
  {
    $this->_rules('tambah');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Data LIPA 15 Gagal ditambahkan!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('LIPA_15/prodeo');
    } else {
      $tahun = $this->input->post('tahun_hidden');
      $bulan = $this->input->post('bulan_hidden');
      $realisasi = $this->input->post('realisasi');
      $perkara = $this->input->post('jml_perkara');
      $keterangan = $this->input->post('keterangan');

      $data = array(
        'bulan' => $bulan,
        'tahun' => $tahun,
        'realisasi' => $realisasi,
        'jml_perkara' => $perkara,
        'keterangan' => $keterangan,
      );

      $data_saldo = $this->prodeo_model->cekSaldoPagu15($tahun);
      $saldo = $data_saldo->saldo_sisa;
      // var_dump($saldo);

      if (floatval($realisasi) <= floatval($saldo)) {
        $this->prodeo_model->inputLipa15($data);
        $this->session->set_flashdata('success', '<strong>Data Prodeo berhasil ditambahkan!</strong>');
        redirect('LIPA_15/prodeo');
      }

      $this->session->set_flashdata('error', '
        <strong>Data Sidang Prodeo ditambahkan!</strong> Realisasi lebih besar daripada Saldo Pagu saat ini!');
      redirect('LIPA_15/prodeo');
    }
  }
}


/* End of file Prodeo.php */
/* Location: ./application/controllers/Prodeo.php */
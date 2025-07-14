<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Monitoring_yuridiksi
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

class Monitoring_yuridiksi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('masuk_model');
    $this->load->model('monitoring_model');
    $this->load->model('yuridiksi_model');
    $this->load->library('Config_library');
  }

  public function index()
  {
    $this->masuk_model->sequrity('mn_monitoring');
    $menu = $this->masuk_model->getMenu();
    $data['menu'] = $menu;
    $data['dateNow'] = date('d/m/Y');
    $data['provinsi'] = $this->yuridiksi_model->getProvinsi();
    $data['yuridiksi'] = $this->yuridiksi_model->getYuridiksi();
    $data['contents'] = 'monitor_kecamatan/v_yuridiksi';
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  public function get_kabupaten()
  {
    $provinsi_kode = $this->input->post('provinsi_kode');
    $kabupaten = $this->yuridiksi_model->getKabupaten($provinsi_kode);
    echo json_encode($kabupaten);
  }

  protected function _rules()
  {
    $this->form_validation->set_rules('provinsi', 'provinsi', 'required|trim');
    $this->form_validation->set_rules('kabupaten', 'kabupaten', 'required|trim');
  }

  public function tambah_aksi()
  {
    $this->_rules();
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Wilayah Yuridiksi tidak berhasil ditambahkan!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('monitoring_yuridiksi');
    } else {
      $kabupaten_kode = $this->input->post('kabupaten');
      $provinsi_kode = $this->input->post('provinsi');
      $kabupaten = $this->yuridiksi_model->getKabupatenById($kabupaten_kode);
      $provinsi = $this->yuridiksi_model->getProvinsiById($provinsi_kode);
      $data = array(
        'provinsi_kode' => $provinsi->provinsi_kode,
        'provinsi_nama' => $provinsi->provinsi_nama,
        'kabupaten_kode' => $kabupaten->kabupaten_kode,
        'kabupaten_nama' => $kabupaten->kabupaten_nama
      );

      $this->yuridiksi_model->inputYuridiksi($data);
      $this->session->set_flashdata('success', '<strong>Wilayah Yuridiksi berhasil ditambahkan!</strong>');
      redirect('monitoring_yuridiksi');
    }
  }

  public function delete_aksi()
  {
    $idEncrypted = $this->input->post('id');
    $id = $this->encryption->decrypt($idEncrypted);
    $this->yuridiksi_model->deleteYuridiksi($id);
    $this->session->set_flashdata('success', '<strong>Wilayah Yuridiksi berhasil dihapus!</strong>');
    redirect('monitoring_yuridiksi');
  }
}


/* End of file Monitoring_yuridiksi.php */
/* Location: ./application/controllers/Monitoring_yuridiksi.php */
<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Alamat
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

class Alamat extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('masuk_model');
    $this->load->model('alamat_pihak_model');
    $this->load->library('config_library');
    $this->load->helper('fungsi_helper');
  }

  public function index()
  {
    $this->masuk_model->sequrity('mn_other');
    $menu = $this->masuk_model->getMenu();
    $data['menu'] = $menu;
    $data['contents'] = 'alamat/v_alamat_pihak';
    // $data['alamat_pihak'] = $this->alamat_pihak_model->get_All();
    $data['settings'] = $this->config_library->get_config_SIPP();
    $this->load->view('templates/index', $data);
  }

  protected function _rules()
  {
    $this->form_validation->set_rules('id', 'id', 'required|trim');
    $this->form_validation->set_rules('prov_kode', 'provinsi kode', 'required|trim');
    $this->form_validation->set_rules('kab_kode', 'kabupaten kode', 'required|trim');
    $this->form_validation->set_rules('kec_kode', 'kecamatan kode', 'required|trim');
    $this->form_validation->set_rules('kel_kode', 'kelurahan kode', 'required|trim');
  }

  public function pihakList()
  {
    //POST data
    $postData = $this->input->post();
    $data = $this->alamat_pihak_model->get_All($postData);
    echo json_encode($data);
  }

  public function get_pihak_id()
  {
    $encodedId = $this->input->post('id');
    $id = $this->encryption->decrypt($encodedId);

    $data = $this->alamat_pihak_model->getPihakbyid($id);

    header('Content-Type: application/json');
    echo json_encode($data);
  }
  //---------------------------------------------------------------------
  //---------------------------------------------------------------------
  public function get_suggestions()
  {
    $query = $this->input->post('searchTerm');
    $suggestions = $this->alamat_pihak_model->get_suggestions($query);

    // Return suggestions in JSON format
    echo json_encode($suggestions);
  }
  //---------------------------------------------------------------------
  //---------------------------------------------------------------------
  public function get_single_alamat()
  {
    $query = $this->input->post('kodeKelurahan');
    $data = $this->alamat_pihak_model->getAlamatbykode($query);

    // Return suggestions in JSON format
    echo json_encode($data);
  }
  //--------------------------------------------------------------------
  //--------------------------------------------------------------------
  function ubah_aksi()
  {
    $this->_rules('ubah');
    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', '<strong>Data Alamat Pihak Gagal diubah!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
      redirect('alamat');
    } else {
      $encodedId = $this->input->post('id');
      $id = $this->encryption->decrypt($encodedId);
      $prov_kode = $this->input->post('prov_kode');
      $kab_kode = $this->input->post('kab_kode');
      $kec_kode = $this->input->post('kec_kode');
      $kel_kode = $this->input->post('kel_kode');
      $user = $this->session->userdata('nama_user');
      $ubah_tanggal = date('Y-m-d H:i:s');

      $data = array(
        'kelurahan' => $kel_kode,
        'kecamatan' => $kec_kode,
        'kabupaten' => $kab_kode,
        'propinsi' => $prov_kode,
        'diperbaharui_oleh' => $user,
        'diperbaharui_tanggal' => $ubah_tanggal
      );

      if ($id != null) {
        $this->alamat_pihak_model->updateAlamatPihak($id, $data);
        $this->session->set_flashdata('success', '<strong>Data Alamat berhasil diubah!</strong>');
        redirect('alamat');
      }
      redirect('alamat');
    }
  }
}
/* End of file Alamat.php */
/* Location: ./application/controllers/Alamat.php */
<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Pagu_15
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

class Pagu_16 extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('posbakum_model');
        $this->load->library('config_library');
    }
    //----------------------------------------------------------------------------------------------------
    public function index()
    {
        $data['contents'] = 'pagu_16/v_pagu_16';
        $data['pagu_16'] = $this->posbakum_model->getPagu16All();
        $data['settings'] = $this->config_library->get_config_SIPP();
        $this->load->view('templates/index', $data);
    }
    //----------------------------------------------------------------------------------------------------
    protected function _rules($aksi)
    {
        // var_dump($aksi);
        if ($aksi === 'tambah') {
            $this->form_validation->set_rules('tahun', 'tahun', 'required|trim|numeric');
        }
        $this->form_validation->set_rules('pagu_awal', 'pagu awal', 'required|trim|numeric');
        $this->form_validation->set_rules('layanan', 'target layanan', 'required|trim|numeric');
    }
    //----------------------------------------------------------------------------------------------------
    public function tambah_aksi()
    {
        $this->_rules('tambah');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', '<strong>Data pagu tidak berhasil ditambahkan!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
            redirect('LIPA_16/pagu_16');
        } else {
            $tahun = $this->input->post('tahun');
            $pagu_awal = $this->input->post('pagu_awal');
            $pagu_revisi = $this->input->post('pagu_revisi');
            $layanan = $this->input->post('layanan');

            $data = array(
                'tahun_anggaran' => $tahun,
                'pagu_awal' => $pagu_awal,
                'pagu_revisi' => $pagu_revisi,
                'target_layanan' => $layanan
            );

            //validasi
            //cek apabila data pagu di tahun yang sama sudah diinput
            $ada_tahun = $this->posbakum_model->searchPagu16byYear($tahun);

            if (count($ada_tahun) == 0) {
                $this->posbakum_model->inputPagu16($data);
                $this->session->set_flashdata('success', '<strong>Data pagu berhasil ditambahkan!</strong>');
                redirect('LIPA_16/pagu_16');
            }

            $this->session->set_flashdata('error', '
        <strong>Data pagu Gagal ditambahkan!</strong> Pagu pada Tahun' . $tahun . ' telah ada!');
            redirect('LIPA_16/pagu_16');
        }
    }
    //----------------------------------------------------------------------------------------------------
    //Pencarian data PAGU 16 by id
    public function get_pagu16()
    {
        $encodedId = $this->input->post('id');
        $id = $this->encryption->decrypt($encodedId);
        $data = $this->posbakum_model->getPagu16byId($id);

        $data->id = $this->encryption->encrypt($data->id);
        $data->pagu_awal = number_format($data->pagu_awal, 0, ',', '.');
        $data->pagu_revisi = number_format($data->pagu_revisi, 0, ',', '.');

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    //----------------------------------------------------------------------------------------------------
    public function ubah_aksi()
    {
        $this->_rules('edit');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', '<strong>Data pagu tidak berhasil diubah!</strong> Isi kembali dengan benar dan silahkan coba lagi!');
            redirect('LIPA_16/pagu_16');
        } else {
            $idEncrypted = $this->input->post('id');
            $id = $this->encryption->decrypt($idEncrypted);

            // $tahun = $this->input->post('tahun');
            $pagu_awal = $this->input->post('pagu_awal');
            $pagu_revisi = $this->input->post('pagu_revisi');
            $layanan = $this->input->post('layanan');

            $data = array(
                // 'tahun_anggaran' => $tahun,
                'pagu_awal' => $pagu_awal,
                'pagu_revisi' => $pagu_revisi,
                'target_layanan' => $layanan
            );

            // var_dump($data);
            $this->posbakum_model->updatePagu16($id, $data);
            $this->session->set_flashdata('success', '<strong>Data pagu berhasil diubah!</strong>');
            redirect('LIPA_16/pagu_16');
        }
    }
    //----------------------------------------------------------------------------------------------------
    // public function delete_aksi()
    // {
    //     $idEncrypted = $this->input->post('id');
    //     $id = $this->encryption->decrypt($idEncrypted);

    //     $dataLipa = $this->prodeo_model->cekLipa15byPagu($id);

    //     if (count($dataLipa) == 0) {
    //         $where = array('id' => $id);
    //         $this->prodeo_model->deletePagu15($where);
    //         $this->session->set_flashdata('success', '<strong>Data pagu berhasil dihapus!</strong>');
    //         redirect('LIPA_15/pagu_15');
    //     }
    //     $this->session->set_flashdata('error', '<strong>Data pagu tidak bisa dihapus!</strong> Sudah ada Laporan Lipa 15 untuk tahun tersebut');
    //     redirect('LIPA_15/pagu_15');
    // }
}


/* End of file Pagu_15.php */
/* Location: ./application/controllers/Pagu_15.php */
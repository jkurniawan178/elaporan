<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Libraries Config_library
 *
 * This Libraries for ...
 * 
 * @package		CodeIgniter
 * @category	Libraries
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Config_library
{

  protected $appSettings;
  protected $nm_bulan;
  protected $CI;
  protected $sysConfig;
  // ------------------------------------------------------------------------

  public function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->model('config_model');
    $this->nm_bulan = array(
      '01' => 'Januari', '02' => 'Pebruari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
      '10' => 'Oktober', '11' => 'Nopember', '12' => 'Desember', '1' => 'Januari', '2' => 'Pebruari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni',
      '7' => 'Juli', '8' => 'Agustus', '9' => 'September',
    );
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------

  public function index()
  {
  }

  public function get_nm_bulan()
  {
    return $this->nm_bulan;
  }

  public function get_config_SIPP()
  {
    $hasil = $this->CI->config_model->get_config();
    // return json_encode($hasil);
    foreach ($hasil as $row) {
      switch ($row->id) {
        case '61':
          $KodePN = $row->value;
          break;
        case '62':
          $NamaPN = $row->value;
          break;
        case '63':
          $AlamatPN = $row->value;
          break;
        case '64':
          $KetuaPNNama = $row->value;
          break;
        case '65':
          $KetuaPNNIP = $row->value;
          break;
        case '66':
          $WakilKetuaPNNama = $row->value;
          break;
        case '67':
          $WakilKetuaPNNIP = $row->value;
          break;
        case '68':
          $PanSekNama = $row->value;
          break;
        case '69':
          $PanSekNIP = $row->value;
          break;
        case '70':
          $WaPanNama = $row->value;
          break;
        case '71':
          $WaPanNIP = $row->value;
          break;
        case '72':
          $WaSekNama = $row->value;
          break;
        case '73':
          $WaSekNIP = $row->value;
          break;
        case '76':
          $NamaPT = $row->value;
          break;
        case '80':
          $app_version = $row->value;
          break;
        case '82':
          $id_satker = $row->value;
          break;
      }
    }
    $settingSIPP = array(
      'KodePN' => $KodePN, 'NamaPN' => $NamaPN, 'AlamatPN' => $AlamatPN,
      'KetuaPNNIP' => $KetuaPNNIP, 'KetuaPNNama' => $KetuaPNNama, 'PanSekNama' => $PanSekNama,
      'PanSekNIP' => $PanSekNIP, 'NamaPT' => $NamaPT
    );
    return $settingSIPP;
  }
  // ------------------------------------------------------------------------
}

/* End of file Config_library.php */
/* Location: ./application/libraries/Config_library.php */
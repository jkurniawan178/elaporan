<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'libraries/dompdf/autoload.inc.php';
/**
 *
 * Libraries pdf
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

use Dompdf\Dompdf;

class Pdf extends Dompdf
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
}

/* End of file ExceltoPdf.php */
/* Location: ./application/libraries/ExceltoPdf.php */
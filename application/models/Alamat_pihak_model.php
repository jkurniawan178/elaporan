<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Alamat_pihak_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Alamat_pihak_model extends CI_Model
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------

  // ------------------------------------------------------------------------
  public function get_All($postData = null)
  {
    $response = array();

    ##Read Value
    $draw = $postData['draw'];
    $start = $postData['start'];
    $rowperpage = $postData['length']; // Rows display per page
    $columnIndex = $postData['order'][0]['column']; //Column Index
    $columnName = $postData['columns'][$columnIndex]['data']; //Column Name
    $columnSortOrder = $postData['order'][0]['dir']; //asc or desc
    $searchValue = $postData['search']['value']; // Search Value

    //Custom search filter
    $searchYear = $postData['searchYear'];
    $searchStatus = $postData['searchStatus'];

    ##Search
    $search_arr = array();
    $searchQuery = "";
    if ($searchValue != '') {
      $search_arr[] = " (ph.nama like '%" . $searchValue . "%' or
      ph.alamat like'%" . $searchValue . "%') ";
    }

    if ($searchYear != '') {
      $search_arr[] = " YEAR(p.tanggal_pendaftaran) = '" . $searchYear . "' ";
    }

    if ($searchStatus != '') {
      switch ($searchStatus) {
        case '0':
          $search_arr[] = " (ph.`kelurahan` IS NULL OR ph.`kecamatan` IS NULL OR ph.`kabupaten` IS NULL OR ph.`propinsi` IS NULL) ";
          break;

        case '1':
          $search_arr[] = " (ph.`kelurahan` IS NOT NULL AND ph.`kecamatan` IS NOT NULL AND ph.`kabupaten` IS NOT NULL AND ph.`propinsi` IS NOT NULL) ";
          break;

        default:
          $search_arr[] = " (ph.`kelurahan` IS NULL OR ph.`kecamatan` IS NULL OR ph.`kabupaten` IS NULL OR ph.`propinsi` IS NULL) ";
          break;
      }
    }

    if (count($search_arr) > 0) {
      $searchQuery = implode(" AND ", $search_arr);
    }

    ##Total number of records without filtering
    $sqlcount1 = "SELECT SUM(allcount) AS allcount FROM (
                  SELECT COUNT(p.`perkara_id`) AS allcount
                  FROM perkara_pihak1 p1 LEFT JOIN perkara p USING(perkara_id)
                  LEFT JOIN pihak ph ON ph.`id` = p1.`pihak_id`               
                  UNION
                  SELECT COUNT(p.`perkara_id`) AS allcount
                  FROM perkara_pihak2 p2 LEFT JOIN perkara p USING(perkara_id)
                  LEFT JOIN pihak ph ON ph.`id` = p2.`pihak_id`
                  ) AS subquery";
    $totalRecords = $this->db->query($sqlcount1)->row()->allcount;

    // if ($searchQuery != '') {

    // }
    ##Fetch records
    $whereClause = '';
    if ($searchQuery != '') {
      $whereClause = " WHERE " . $searchQuery;
    }

    $sqlcount2 = "SELECT SUM(allcount) AS allcount FROM (
      SELECT COUNT(p.`perkara_id`) AS allcount
      FROM perkara_pihak1 p1 LEFT JOIN perkara p USING(perkara_id)
      LEFT JOIN pihak ph ON ph.`id` = p1.`pihak_id`
      $whereClause
      UNION
      SELECT COUNT(p.`perkara_id`) AS allcount
      FROM perkara_pihak2 p2 LEFT JOIN perkara p USING(perkara_id)
      LEFT JOIN pihak ph ON ph.`id` = p2.`pihak_id`
      $whereClause
      ) AS subquery";
    $totalRecordsWithFilter = $this->db->query($sqlcount2)->row()->allcount;

    $sql = "SELECT p.`alur_perkara_id`, p.`perkara_id`, ph.id, p.nomor_perkara, ph.`nama`, ph.`alamat`, 
                  ph.`propinsi`,d.`provinsi_nama`, ph.`kabupaten`, c.`kabupaten_nama`, ph.`kecamatan`, b.`kecamatan_nama`, 
                  ph.`kelurahan`, a.`kelurahan_nama`
            FROM perkara_pihak1 p1 LEFT JOIN perkara p USING(perkara_id)
            LEFT JOIN pihak ph ON ph.`id` = p1.`pihak_id`
            LEFT JOIN ref_provinsi_new d ON d.`provinsi_kode` = ph.propinsi 
            LEFT JOIN ref_kabupaten_new c ON c.`kabupaten_kode` = ph.kabupaten
            LEFT JOIN ref_kecamatan_new b ON b.`kecamatan_kode` = ph.kecamatan
            LEFT JOIN ref_kelurahan_new a ON a.`kelurahan_kode` = ph.kelurahan $whereClause
            UNION
            SELECT p.`alur_perkara_id`, p.`perkara_id`, ph.id, p.nomor_perkara, ph.`nama`, ph.`alamat`, 
                  ph.`propinsi`,d.`provinsi_nama`, ph.`kabupaten`, c.`kabupaten_nama`, ph.`kecamatan`, b.`kecamatan_nama`, 
                  ph.`kelurahan`, a.`kelurahan_nama`
            FROM perkara_pihak2 p2 LEFT JOIN perkara p USING(perkara_id)
            LEFT JOIN pihak ph ON ph.`id` = p2.`pihak_id`
            LEFT JOIN ref_provinsi_new d ON d.`provinsi_kode` = ph.propinsi 
            LEFT JOIN ref_kabupaten_new c ON c.`kabupaten_kode` = ph.kabupaten
            LEFT JOIN ref_kecamatan_new b ON b.`kecamatan_kode` = ph.kecamatan
            LEFT JOIN ref_kelurahan_new a ON a.`kelurahan_kode` = ph.kelurahan $whereClause 
            ORDER BY alur_perkara_id ASC, perkara_id ASC
            LIMIT $start, $rowperpage";

    $hasil = $this->db->query($sql)->result();
    $data = array();

    foreach ($hasil as $row) {
      $row->id = $this->encryption->encrypt($row->id);
      $data[] = array(
        'id' => $row->id,
        'nomor_perkara' => $row->nomor_perkara,
        'nama' => $row->nama,
        'alamat' => $row->alamat,
        'propinsi' => '<span style="color: red;">' . $row->propinsi . '</span><br>' . $row->provinsi_nama,
        'kabupaten' => '<span style="color: red;">' . $row->kabupaten . '</span><br>' . $row->kabupaten_nama,
        'kecamatan' => '<span style="color: red;">' . $row->kecamatan . '</span><br>' . $row->kecamatan_nama,
        'kelurahan' => '<span style="color: red;">' . $row->kelurahan . '</span><br>' . $row->kelurahan_nama,
      );
    }

    ## Response
    $response = array(
      'draw' => intval($draw),
      'iTotalRecords' => $totalRecords,
      'iTotalDisplayRecords' => $totalRecordsWithFilter,
      'aaData' => $data
    );

    return $response;
  }

  public function getPihakbyid($id)
  {
    $sql = "SELECT ph.id, ph.`nama`, ph.`alamat`, 
            ph.`propinsi`,d.`provinsi_nama`, ph.`kabupaten`, c.`kabupaten_nama`, ph.`kecamatan`, b.`kecamatan_nama`, 
            ph.`kelurahan`, a.`kelurahan_nama`
            FROM pihak ph
            LEFT JOIN ref_provinsi_new d ON d.`provinsi_kode` = ph.propinsi 
            LEFT JOIN ref_kabupaten_new c ON c.`kabupaten_kode` = ph.kabupaten
            LEFT JOIN ref_kecamatan_new b ON b.`kecamatan_kode` = ph.kecamatan
            LEFT JOIN ref_kelurahan_new a ON a.`kelurahan_kode` = ph.kelurahan
            WHERE id = '$id'";

    $hasil = $this->db->query($sql);
    $data = $hasil->row();
    $data->id = $this->encryption->encrypt($data->id);
    return $data;
  }
  //--------------------------------------------------------------------------
  public function get_suggestions($query)
  {
    $sql = "SELECT a.kelurahan_kode, CONCAT(a.`kelurahan_nama`,', ',b.`kecamatan_nama`,', ', c.`kabupaten_nama`,', ',d.`provinsi_nama`) AS alamat
            FROM ref_provinsi_new d LEFT JOIN ref_kabupaten_new c USING(provinsi_kode)
            LEFT JOIN ref_kecamatan_new b ON c.`kabupaten_kode` = b.`kabupaten_kode`
            LEFT JOIN ref_kelurahan_new a ON a.`kecamatan_kode` = b.`kecamatan_kode` 
            WHERE CONCAT(a.`kelurahan_nama`,', ',b.`kecamatan_nama`,', ', c.`kabupaten_nama`,', ',d.`provinsi_nama`) LIKE '%$query%'
            LIMIT 15
            ";
    $query = $this->db->query($sql);
    $addreses =  $query->result_array();

    //initialize array with feched data
    $data = array();
    foreach ($addreses as $addres) {
      $data[] = array(
        "id" => $addres['kelurahan_kode'],
        "text" => $addres["alamat"]
      );
    }
    return $data;
  }
  //-----------------------------------------------------------------------------
  function getAlamatbykode($kelkode)
  {
    $sql = " SELECT a.`kelurahan_kode`, a.`kelurahan_nama`, b.`kecamatan_kode`, b.`kecamatan_nama`,
                c.`kabupaten_kode`, c.`kabupaten_nama`, d.`provinsi_kode`, d.`provinsi_nama`
                FROM ref_provinsi_new d LEFT JOIN ref_kabupaten_new c USING(provinsi_kode)
                LEFT JOIN ref_kecamatan_new b ON c.`kabupaten_kode` = b.`kabupaten_kode`
                LEFT JOIN ref_kelurahan_new a ON a.`kecamatan_kode` = b.`kecamatan_kode`
                where a.`kelurahan_kode` = '$kelkode'";

    $hasil = $this->db->query($sql);
    return $hasil->row();
  }
  //------------------------------------------------------------------------------
  //-------------------------------------------------------------------------
  public function updateAlamatPihak($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('pihak', $data);
  }
}

/* End of file Alamat_pihak_model.php */
/* Location: ./application/models/Alamat_pihak_model.php */
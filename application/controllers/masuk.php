<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masuk extends CI_Controller
{
    public function index()
    {

        $this->load->view('login/v_login');
    }
}

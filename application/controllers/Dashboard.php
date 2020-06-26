<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        // $this->load->model('m_home');
    }

    public function index()
    {
        // check_persmission_pages($this->session->userdata('group_id'), 'home');
        $data['active'] = 'dashboard';
        // $data['title'] = 'Home';
        $data['subview'] = 'dashboard/view';
        $this->load->view('template/main', $data);
        // $this->load->view('', $data);
    }
}

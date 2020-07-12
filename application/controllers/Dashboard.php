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
        $this->load->model('hrms_');
        $this->load->model('competency_');
    }

    public function index()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'dashboard');
        $data['employee'] = $this->hrms_->getEmployee()->num_rows();
        $data['unit_comp'] = $this->competency_->getUnitCompetency()->num_rows();
        $data['license'] = $this->competency_->getLicense()->num_rows();
        $data['expire'] = $this->competency_->getNotifLicense()->num_rows();
        // log_r($this->db->last_query());
        $data['active'] = 'dashboard';
        $data['title'] = 'Dashboard';
        $data['subview'] = 'dashboard/view';
        $this->load->view('template/main', $data);
    }
}

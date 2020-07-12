<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Information extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('m_emp');
    }

    public function index()
    {
        $data['unit'] = $this->_license()->result();
        // log_r($data);
        $data['active'] = 'information';
        $data['title'] = 'Information';
        $data['subview'] = 'index';
        $this->load->view('template/main', $data);
    }

    private function _license()
    {
        $nip = $this->input->get('nip');

        $this->db->select('A.exp_date, B.name as license, A.emp_id, C.full_name, C.profile, C.nip');
        $this->db->join('comp_unit B', 'A.comp_id = B.id');
        $this->db->join('employee C', 'A.emp_id = C.id');
        $this->db->where('A.status', 'PASSED');
        $this->db->where('C.nip', $nip);
        $this->db->group_by('A.comp_id');
        return $this->db->get('comp_license A');
    }
}

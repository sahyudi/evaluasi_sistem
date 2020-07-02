<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resource extends CI_Controller
{

    public $departement = 'departement';
    public $unit_comp_detail = 'comp_unit_criteria';

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        $this->load->model('hrms_');
    }

    function index()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'resource');
        $data['active'] = 'resource';
        $data['title'] = 'Employee';
        $data['subview'] = 'hrms/employee';
        $this->load->view('template/main', $data);
    }

    function departement()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'resource/departement');
        $data['active'] = 'resource/departement';
        $data['title'] = 'Departement';
        $data['subview'] = 'hrms/depart';
        $this->load->view('template/main', $data);
    }

    function getJsonDepartment()
    {
        echo $this->hrms_->getJsonDepartment();
    }

    function saveDepartement()
    {
        $id = $this->input->post('id');

        $data = [
            'full_name' => $this->input->post('full_name'),
            'short_name' => $this->input->post('short_name'),
        ];

        if ($id) {
            $this->db->update($this->departement, $data, ['id' => $id]);
        } else {
            $this->db->insert($this->departement, $data);
        }

        echo json_encode(['status' => 1]);
    }

    function editDepartement()
    {
        $id = $this->input->post('id');

        $data = $this->db->get_where($this->departement, ['id' => $id])->row();
        echo json_encode($data);
    }

    function deleteDepartement()
    {
        $id = $this->input->post('id');
        if ($this->db->delete($this->departement, ['id' => $id])) {
            $status = 1;
        } else {
            $status = 2;
        }

        echo json_encode(['status' => $status]);
    }
}

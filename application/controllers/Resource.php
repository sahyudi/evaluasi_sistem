<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resource extends CI_Controller
{

    public $departement = 'departement';
    public $employee = 'employee';

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
        $data['depart'] = $this->db->get($this->departement)->result();
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

    function getJsonEmployee()
    {
        echo $this->hrms_->getJsonEmployee();
    }

    function saveEmployee()
    {
        $id = $this->input->post('id');

        $data['nip'] = $this->input->post('nip');
        $data['full_name'] = $this->input->post('full_name');
        $data['telegram_id'] = $this->input->post('telegram_id');
        $data['depart_id'] = $this->input->post('depart_id');

        $upload_image = $_FILES['profile']['name'];



        if ($upload_image) {
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']     = '5048';
            $config['upload_path']  = './assets/img';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('profile')) {

                if ($id) {
                    $employee_ = $this->db->get_where($this->employee, ['id' => $id])->row();
                    // if ($old_image != 'default.jpg') {
                    unlink(FCPATH . 'assets/img/' . $employee_->profile);
                    // }
                }

                $newProfile = $this->upload->data('file_name');
                $data['profile'] =  $newProfile;
            } else {
                echo $this->upload->display_errors();
            }
        }

        if ($id) {
            $this->db->update($this->employee, $data, ['id' => $id]);
        } else {
            $this->db->insert($this->employee, $data);
        }

        // $this->db->trans_start();
        echo json_encode(['status' => 1]);
    }

    function editEmployee()
    {
        $id = $this->input->post('id');
        if ($id) {
            $data = $this->db->get_where($this->employee, ['id' => $id])->row();
            echo json_encode($data);
        }
    }

    function deleteEmployee()
    {
        $id = $this->input->post('id');

        if ($id) {
            $employee_ = $this->db->get_where($this->employee, ['id' => $id])->row();
            if ($this->db->delete($this->employee, ['id' => $id])) {
                if ($employee_->profile) {
                    unlink(FCPATH . 'assets/img/' . $employee_->profile);
                }
                $status = 1;
            } else {
                $status = 2;
            }
        }

        echo json_encode(['status' => $status]);
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

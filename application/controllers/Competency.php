<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Competency extends CI_Controller
{

    public $unit_comptency = 'comp_unit';
    public $unit_comp_detail = 'comp_unit_criteria';

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        $this->load->model('competency_');
    }

    function index()
    {
        redirect('competency/license');
    }

    public function license()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'competency/license');
        $data['active'] = 'competency/license';
        $data['title'] = 'License';
        $data['subview'] = 'competency/license';
        $this->load->view('template/main', $data);
    }

    function getJsonLincense()
    {
        echo $this->competency_->get_license();
    }

    function unit_competency()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'competency/unit_competency');
        $data['active'] = 'competency/unit_competency';
        $data['title'] = 'Unit Competency';
        $data['subview'] = 'competency/unit_competency';
        $this->load->view('template/main', $data);
    }


    function getJsonUnitComp()
    {
        echo $this->competency_->getJsonUnitComp();
    }

    function saveUnitCompetency()
    {
        $id = $this->input->post('id');

        $data = [
            'name' => $this->input->post('name'),
            'min_score' => $this->input->post('min_score')
        ];

        if ($id) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->update($this->unit_comptency, $data, ['id' => $id]);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert($this->unit_comptency, $data);
        }

        echo json_encode(['status' => 1]);
    }

    function deleteUnitCompetency()
    {
        $id = $this->input->post('id');

        if ($id) {
            $this->db->delete($this->unit_comptency, ['id' => $id]);
            $status = 1;
        } else {
            $status = 2;
        }

        echo json_encode(['status' => $status]);
    }

    function editUnitCompetency()
    {
        $id = $this->input->post('id');

        if ($id) {
            $data = $this->db->get_where($this->unit_comptency, ['id' => $id])->row();
        }

        echo json_encode($data);
    }

    function unit_detail($id)
    {
        check_persmission_pages($this->session->userdata('group_id'), 'competency/unit_competency');
        if ($id) {
            $data['competency'] = $this->competency_->getUnitCompetency($id)->row();
            $data['active'] = 'competency/unit_competency';
            $data['title'] = 'Unit Detail';
            $data['subview'] = 'competency/unit_detail';
            $this->load->view('template/main', $data);
        }
    }

    function get_detail_competency()
    {
        $id = $this->input->post('id');
        $data = $this->competency_->get_unit_detail($id)->result();
        echo json_encode($data);
    }

    function saveUnitDetailCompetency($id_comp_unit)
    {
        $id = $this->input->post('id');
        $data = [
            'comp_unit_id' => $id_comp_unit,
            'name' => $this->input->post('criteria'),
            'value_weight' => $this->input->post('value_weight')
        ];

        if ($id) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->update($this->unit_comp_detail, $data, ['id' => $id]);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert($this->unit_comp_detail, $data);
        }

        echo json_encode(['status' => 1]);
    }

    function deleteUnitCompDetail()
    {
        $id = $this->input->post('id');

        if ($id) {
            $this->db->delete($this->unit_comp_detail, ['id' => $id]);
            $status = 1;
        } else {
            $status = 2;
        }

        echo json_encode(['status' => $status]);
    }

    function editUnitCompDetail()
    {
        $id = $this->input->post('id');

        if ($id) {
            $data = $this->db->get_where($this->unit_comp_detail, ['id' => $id])->row();
        }

        echo json_encode($data);
    }

    function form()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'competency/form');
        $data['active'] = 'competency/form';
        $data['title'] = 'Form EvaluationCompetency';
        $data['subview'] = 'competency/form';
        $this->load->view('template/main', $data);
    }
}

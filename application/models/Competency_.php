<?php

class Competency_ extends CI_Model
{
    public $competency_unit = 'comp_unit';
    public $comp_unit_detail = 'comp_unit_criteria';

    function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
    }

    public function get_license($id = null)
    {
        $this->datatables->select('A.id, A.score, A.comp_date, A.exp_date, C.full_name as employee, B.name as lincense, D.full_name as assesor, F.full_name as ack_by, ');
        $this->datatables->join('comp_unit B', 'A.comp_id = B.id');
        $this->datatables->join('employee C', 'A.emp_id = C.id');
        $this->datatables->join('employee D', 'A.assesor = D.id');
        $this->datatables->join('employee F', 'A.ack_by = F.id');
        $this->datatables->from('comp_license A');
        return $this->datatables->generate();
    }

    function getJsonUnitComp()
    {
        $this->datatables->select('id, name, min_score, duration');
        $this->datatables->from($this->competency_unit);
        return $this->datatables->generate();
    }

    function getUnitCompetency($id)
    {
        return $this->db->get_where('comp_unit', ['id' => $id]);
    }

    function get_unit_detail($id = null)
    {
        return $this->db->get_where($this->comp_unit_detail, ['comp_unit_id' => $id]);
    }

    function getCriteriaComp($comp_id = null)
    {
        $this->db->select('*');
        if ($comp_id) {
            $this->db->where('comp_unit_id', $comp_id);
        }

        return $this->db->get($this->comp_unit_detail);
    }

    function getUnitComp($id = null)
    {
        $this->db->select('*');
        if ($id) {
            $this->db->where('id', $id);
        }

        return $this->db->get($this->competency_unit);
    }
}

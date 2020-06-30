<?php

class Competency_ extends CI_Model
{
    // public

    function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
    }

    public function get_license($id = null)
    {
        $this->datatables->select('A.id, A.score, A.comp_date, A.exp_date, C.full_name as employee, B.name as lincense, D.name as assesor, F.name as ack_by, ');
        $this->datatables->join('comp_unit B', 'A.com_id = B.id');
        $this->datatables->join('employee C', 'A.emp_id = C.id');
        $this->datatables->join('users D', 'A.assesor = D.id');
        $this->datatables->join('users F', 'A.ack_by = F.id');
        $this->datatables->from('comp_license A');
        return $this->datatables->generate();
    }

    function getJsonUnitComp()
    {
        $this->datatables->select('id, name, min_score');
        $this->datatables->from('comp_unit');
        return $this->datatables->generate();
    }

    function getUnitCompetency($id)
    {
        return $this->db->get_where('comp_unit', ['id' => $id]);
    }
}

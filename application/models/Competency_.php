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
        $this->datatables->select('A.id, A.score, A.status, A.comp_date, A.exp_date, C.full_name as employee, B.name as lincense, D.full_name as assesor, F.full_name as ack_by, ');
        $this->datatables->join('comp_unit B', 'A.comp_id = B.id');
        $this->datatables->join('employee C', 'A.emp_id = C.id');
        $this->datatables->join('employee D', 'A.assesor = D.id');
        $this->datatables->join('employee F', 'A.ack_by = F.id');
        $this->datatables->from('comp_license A');
        return $this->datatables->generate();
    }

    function getLicenseById($licenseId)
    {
        $this->db->select('A.id, A.score, A.status, A.comp_date, A.exp_date, C.full_name as employee, C.nip, C.profile as profile_emp, CA.full_name as depart_name, B.name as lincense, D.full_name as assesor, D.profile as profile_assesor, F.full_name as ack_by, F.profile as profile_ack ');
        $this->db->join('comp_unit B', 'A.comp_id = B.id');
        $this->db->join('employee C', 'A.emp_id = C.id');
        $this->db->join('departement CA', 'C.depart_id = CA.id');
        $this->db->join('employee D', 'A.assesor = D.id');
        $this->db->join('employee F', 'A.ack_by = F.id');
        $this->db->where('A.id', $licenseId);
        return $this->db->get('comp_license A');
    }

    function getNotifLicense()
    {
        $this->db->select('A.exp_date, B.name as lincense, A.emp_id, B.telegram_id');
        $this->db->join('comp_unit B', 'A.comp_id = B.id');
        $this->db->join('employee C', 'A.emp_id = C.id');
        $this->db->where('A.status', 'PASSED');
        $this->db->where('A.exp_date <=  DATE_ADD(NOW(), INTERVAL 1 MONTH)');
        return $this->db->get('comp_license A');
        // exp_date <=  DATE_ADD(NOW(), INTERVAL 1 MONTH)
    }

    function getPerforrmanceCriteria($licenseId)
    {
        return $this->db->get_where('comp_license_criteria', ['comp_id' => $licenseId]);
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

    function getJsonUniDetail($id = null)
    {
        $this->datatables->select('*');
        $this->datatables->from($this->comp_unit_detail);
        if ($id) {
            $this->datatables->where('comp_unit_id', $id);
        }
        return $this->datatables->generate();
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

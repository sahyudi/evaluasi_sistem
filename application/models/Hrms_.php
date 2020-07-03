<?php

class Hrms_ extends CI_Model
{
    public $departement = 'departement';
    public $employee = 'employee';

    function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
    }

    function getJsonDepartment()
    {
        $this->datatables->select('id, full_name, short_name');
        $this->datatables->from($this->departement);
        return $this->datatables->generate();
    }


    function getJsonEmployee()
    {
        $this->datatables->select('a.id, a.nip, a.full_name, a.telegram_id, a.profile, a.telegram_id, b.full_name as depart_name, ');
        $this->datatables->from($this->employee . ' a');
        $this->datatables->join($this->departement . ' b', 'a.depart_id = b.id');
        return $this->datatables->generate();
    }

    function getEmployee($id = null)
    {
        $this->db->select('a.*, b.full_name as depart_name');
        $this->db->join($this->departement . ' b', 'a.depart_id = b.id');
        if ($id) {
            $this->db->where('a.id', $id);
        }
        return $this->db->get($this->employee . ' a');
    }

    function getUserAccess($id = null, $group_id = null)
    {
        $this->db->select('a.id as user_id, a.*, b.*');
        $this->db->join($this->employee . ' b', 'a.employee_id = b.id');
        if ($id) {
            $this->db->where('a.id', $id);
        }
        if ($group_id) {
            $this->db->where('group_id', $group_id);
        }
        return $this->db->get('users a');
    }
}

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
}

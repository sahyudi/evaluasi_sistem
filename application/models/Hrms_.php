<?php

class Hrms_ extends CI_Model
{
    public $departement = 'departement';

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
}

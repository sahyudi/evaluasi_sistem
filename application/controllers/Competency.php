<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Competency extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        $this->load->model('competency_');
    }

    public function license()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'competency/license');

        // $data['license'] = $this->competency->get_license();
        $data['active'] = 'competency/license';
        $data['title'] = 'License';
        $data['subview'] = 'competency/license';
        $this->load->view('template/main', $data);
    }

    function getJsonLincense()
    {
        echo $this->competency_->get_license();
    }
}

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
            'min_score' => $this->input->post('min_score'),
            'duration' => $this->input->post('duration')
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
        echo $this->competency_->getJsonUniDetail($id);
    }

    function saveUnitDetailCompetency($id_comp_unit)
    {
        $id = $this->input->post('id');
        $data = [
            'comp_unit_id' => $id_comp_unit,
            'name' => $this->input->post('criteria'),
            'is_active' => $this->input->post('is_active')
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
        $this->load->model('hrms_');

        $data['employee'] = $this->hrms_->getEmployee()->result();
        $data['userAccess'] = $this->hrms_->getUserAccess()->result();
        $data['UniComp'] = $this->competency_->getUnitComp()->result();

        $data['active'] = 'competency/form';
        $data['title'] = 'Form Evaluation Competency';
        $data['subview'] = 'competency/form';
        $this->load->view('template/main', $data);
    }

    function getEmployee()
    {
        $employee_id = $this->input->post('employeeId');

        $this->load->model('hrms_');

        $data = $this->hrms_->getEmployee($employee_id)->row();

        echo json_encode($data);
    }

    function getCriteriaComp()
    {
        $compId = $this->input->post('compId');

        $data = $this->db->get_where($this->unit_comp_detail, ['comp_unit_id' => $compId])->result();
        echo json_encode($data);
    }

    function save_evaluasi()
    {

        // log_r(count($this->input->post('remark')));

        $this->db->trans_begin();

        $acknowled_by = $this->input->post('acknowled_by');
        $asesor = $this->input->post('asesor');
        $employee = $this->input->post('employee');
        $date_com = $this->input->post('date_com');
        $unit_competency = $this->input->post('unit_competency');

        // $bobot = $this->input->post('bobot');
        // $value = $this->input->post('value');
        // $sub_total = $this->input->post('sub_total');
        $detail_criteria = $this->input->post('detail_criteria');
        $status = $this->input->post('status');
        $remark = $this->input->post('remark');
        // log_r($status[0]);

        $competency = $this->db->get_where($this->unit_comptency, ['id' => $unit_competency])->row();

        $expiry = date('Y-m-d', strtotime('+' . $competency->duration . ' year', strtotime($date_com)));

        $license = [
            'emp_id' => $employee,
            'comp_id' => $unit_competency,
            'comp_date' => $date_com,
            'assesor' => $asesor,
            'ack_by' => $acknowled_by,
            'created_at' => date('Y-m-d H:i:s'),
            'exp_date' => $expiry,
            'score' => 0
        ];

        $this->db->insert('comp_license', $license);

        $new_id = $this->db->insert_id();

        $final = 0;
        $detail = [];
        $score = 0;
        for ($i = 0; $i < count($detail_criteria); $i++) {
            $detail[] = [
                'comp_id' => $new_id,
                'name' => $detail_criteria[$i],
                'status' => $status[$i],
                'note' => $remark[$i],
                // 'note' => null
            ];
            if ($status[$i] == 0) {
                $final += 1;
            }
        }

        // log_r($detail);

        $this->db->insert_batch('comp_license_criteria', $detail);

        if ($final > 0) {
            $final_ = 'FAILED';
        } else {
            $final_ = 'PASSED';
        }
        // $this->db->set('score', $score);
        $this->db->update('comp_license', ['status' => $final_], ['id' => $new_id]);

        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed evaluation, please check connection</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfull evaluation!</div>');
        }

        redirect('competency/license');
    }


    function print($linceseId = null)
    {
        $data['competency'] = $this->competency_->getLicenseById($linceseId)->row();
        $data['performance'] = $this->competency_->getPerforrmanceCriteria($linceseId)->result();
        // log_r($data);
        $this->load->view('competency/print', $data);
    }

    function testTanggal()
    {
        $expiry = date('Y-m-d', strtotime('2 year', strtotime(date('Y-m-d'))));
        log_r($expiry);
    }

    function deleteLicense()
    {
        $id = $this->input->post('id');

        if ($this->db->delete('comp_license', ['id' => $id])) {
            $status = 1;
        } else {
            $status = 2;
        }

        echo json_encode(['status' => $status]);
    }


    function send_notif_telegram()
    {

        // $msg = 'Pesan kosong';
        $array_nik = array(); // tampung per nik (DISTINCT)
        $array_content = array();
        $array_tg_id = array();


        $pembuka = "Hi Sobat !!!! \n";
        $pembuka .= "License Alert \n \n";
        $pembuka .= "Jangan lupa Kompetensi sobat akan habis masa berlakunya. \n";

        $master = $this->competency_->getNotifLicense()->result();

        foreach ($master as $key => $value) {

            // $data = date('Y-m-d', strtotime('-3month', strtotime($end->ex_date)));
            $nik = $value->emp_id;
            // $status = $end->status;
            $telegram_id = $value->telegram_id;

            // if ($data <= $data2 && $status == 'PASSED') {
            if (!in_array($nik, $array_nik)) {
                // cek nik yang mulainya dengan 0
                $array_nik[] = $nik;
                $array_tg_id[strval($nik)] = $telegram_id;
            }

            $msg = $value->license . " expiry pada : " . date("d M Y", strtotime(@$value->exp_date)) . "\n";

            if (empty($array_content[strval($nik)])) {
                $array_content[strval($nik)] = $msg;
            } else {
                $array_content[strval($nik)] .= $msg;
            }
            $penutup = "SEGERA LAKUKAN PERPANJANGAN YA!!! \n";
            $penutup .= "Jika tidak dilakukan perpanjangan kompetensi sobat akan expired.Silahkan menghubungi Training Center di Ext. 108 atau 118 untuk melakukan perpanjangan. \n";
            $penutup .= "Sukses Selalu!!";

            $kirim = $pembuka . "\n" . $array_content[strval($nik)] . "\n" . $penutup;
            // }
        }

        // log_r($kirim);
        // PENGIRIMAN TELEGRAM
        // for ($i = 0; $i < sizeof($array_nik); $i++) {
        sendTelegram($kirim);
        // }

        // $this->view_data();
        redirect('competency/license');
    }
}

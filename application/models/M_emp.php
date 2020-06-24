<?php

class M_emp extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_emp($id = null)
    {
        $this->db->select('A.*, B.nama as agama, c.nama as pendidikan, D.nama as gol_darah');
        $this->db->join('tb_agama B', 'B.id = A.agama', 'left');
        $this->db->join('tb_pendidikan C', 'C.id = A.pendidikan', 'left');
        $this->db->join('tb_gol_darah D', 'D.id = A.gol_darah', 'left');
        if ($id != 0) {
            $this->db->where('A.id', $id);
        }
        $data = $this->db->get('tb_employee A');
        return $data;
    }
}

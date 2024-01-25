<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    public $userTable = '';
    public $memberTable = '';
    public function grupPenggunaRules($mode = 'add')
    {
        $id = $this->input->post('id');
        $kode = $mode == 'add' ? 'trim|required|is_unique[user_grup.kode_grup]' : 'trim|required|edit_unique[user_grup.kode_grup.' . $id . ']';
        $rules =  [
            [
                'field'     => 'nama_grup',
                'label'     => 'Nama grup',
                'rules'     => 'trim|required',
                'errors'    => array('required' => '%s wajib diisi'),

            ],

            [
                'field'     => 'kode_grup',
                'label'     => 'Kode Grup',
                'rules'     => $kode,
                'errors'    => array('required' => '%s wajib diisi', 'is_unique' => 'kode sudah digunakan', 'edit_unique' => 'kode sudah digunakan'),
            ]

        ];
        return $rules;
    }


    public function dataTagRules()
    {
        $id = $this->input->post('id');
        $tableName = 'jenis_tag';
        $uniqField = 'kode_tag';
        $kode = (int)$id > 0 ? 'trim|required|is_unique[' . $tableName . '.' . $uniqField . ']' : 'trim|required|edit_unique[' . $tableName . '.' . $uniqField . '.' . $id . ']';
        $rules =  [
            [
                'field'     => 'kode_tag',
                'label'     => 'Kode Tag',
                'rules'     => $kode,
                'errors'    => array('required' => '%s wajib diisi'),

            ],

            [
                'field'     => 'deskripsi_tag',
                'label'     => 'Deskripsi Tag',
                'rules'     => 'trim|required',
                'errors'    => array('required' => '%s wajib diisi', 'is_unique' => 'kode sudah digunakan', 'edit_unique' => 'kode sudah digunakan'),
            ]

        ];
        return $rules;
    }
}

/* End of file Pengaturan_model.php */
/* Location: ./application/modules/pengaturan/models/Pengaturan_model.php */
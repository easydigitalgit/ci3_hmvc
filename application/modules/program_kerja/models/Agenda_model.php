<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agenda_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }


    public function eventSosperRules($mode = 'add')
    {
        $id = $this->input->post('id');
        $kode = $mode == 'add' ? 'trim|required|is_unique[event_sosper.kode]' : 'trim|required|edit_unique[event_sosper.kode.' . $id . ']';
        $rules =  [
            [
                'field'    => 'nama',
                'label'    => 'Nama Kegiatan',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],

            [
                'field'    => 'kode',
                'label'    => 'Kode Kegiatan',
                'rules' => $kode,
                'errors' => array('required' => '%s wajib diisi', 'is_unique' => 'kode sudah digunakan', 'edit_unique' => 'kode sudah digunakan'),
            ],
            [
                'field'    => 'waktu',
                'label'    => 'Waktu Kegiatan',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],
            [
                'field'    => 'tempat',
                'label'    => 'Tempat Kegiatan',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],
            [
                'field'    => 'aleg',
                'label'    => 'Nama Aleg',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],

        ];
        return $rules;
    }

    public function dataEventRules($mode = 'add')
    {
        $rules =  [
            [
                'field' => 'nama_event',
                'label' => 'Nama Program',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],

            [
                'field' => 'kode_event',
                'label' => 'Kode Kegiatan',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi', 'is_unique' => 'kode sudah digunakan', 'edit_unique' => 'kode sudah digunakan'),
            ],
            [
                'field' => 'id_jenis_event',
                'label' => 'Jenis Event',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],
            [
                'field' => 'start_event',
                'label' => 'Waktu Mulai',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],
            [
                'field' => 'end_event',
                'label' => 'Waktu Selesai',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],

        ];
        return $rules;
    }

    public function dataAgendaRules()
    {
        $rules =  [
            [
                'field' => 'caleg_akun_id',
                'label' => 'Nama Caleg',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],
            [
                'field' => 'jenis_agenda_id',
                'label' => 'Jenis Agenda',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih'),

            ],

            [
                'field' => 'nama_agenda',
                'label' => 'Nama Agenda',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),
            ],
            [
                'field' => 'waktu',
                'label' => 'Waktu Kegiatan',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],
            [
                'field' => 'tempat',
                'label' => 'Tempat Kegiatan',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],


        ];
        return $rules;
    }

    public function dataJenisAgendaRules()
    {
        $rules =  [
            [
                'field' => 'nama_jenis_agenda',
                'label' => 'Nama Jenis Agenda',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],
            [
                'field' => 'kode_jenis_agenda',
                'label' => 'Kode Agenda',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih'),

            ],




        ];
        return $rules;
    }

    public function addDataLaporanAgenda()
    {
        $rules =  [
            [
                'field' => 'catatan_kegiatan',
                'label' => 'Catatan Hasil Kegiatan',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),

            ],
            [
                'field' => 'status_agenda',
                'label' => 'Status Pelaksanaan',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih'),

            ],




        ];
        return $rules;
    }

    public function getDataAgendaByID($id)
    {
        $q = " a.*, b.nama as nama_prop, c.nama as nama_kab, d.nama as nama_kec , e.nama as nama_desa, f.nama as nama_caleg FROM data_agenda a LEFT JOIN propinsi b ON a.prop_kode = b.kode LEFT JOIN kabupaten c ON a.kab_kode = c.kode LEFT JOIN kecamatan d ON a.kec_kode = d.kode LEFT JOIN desa e ON a.desa_kode = e.kode LEFT JOIN user_akun f ON a.caleg_akun_id = f.id ";
        $query = $this->db->select($q, false)->where('a.id', $id)->get();
        return $query;
    }

    public function getDataJenisAgendaByID($id)
    {
        $q = $this->db->get_where('jenis_agenda', array('id' => $id));
        return $q;
    }
}

/* End of file ProgramKerja_model.php */
/* Location: ./application/modules/program_kerja/models/ProgramKerja_model.php */
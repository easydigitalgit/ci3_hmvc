<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramKerja_model extends MY_Model {
public function __construct()
{
	parent::__construct();
	//Do your magic here
}


public function eventSosperRules($mode='add'){
    $id = $this->input->post('id');
    $kode = $mode == 'add' ? 'trim|required|is_unique[event_sosper.kode]':'trim|required|edit_unique[event_sosper.kode.'.$id.']';
   	 $rules =  [
     				[
                        'field'	=> 'nama',
                        'label'	=> 'Nama Kegiatan',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi'),

                    ],
                   
                    [
                        'field'	=> 'kode',
                        'label'	=> 'Kode Kegiatan',
                        'rules' => $kode,
                        'errors'=> array('required'=>'%s wajib diisi','is_unique'=>'kode sudah digunakan','edit_unique'=>'kode sudah digunakan'), 
                    ],
                    [
                        'field'	=> 'waktu',
                        'label'	=> 'Waktu Kegiatan',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi'),

                    ],
                    [
                        'field'	=> 'tempat',
                        'label'	=> 'Tempat Kegiatan',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi'),

                    ],
                    [
                        'field'	=> 'aleg',
                        'label'	=> 'Nama Aleg',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi'),

                    ],
                      
            ];
       return $rules;
   }	

public function dataEventRules($mode='add'){
     $rules =  [
                    [
                        'field' => 'nama_event',
                        'label' => 'Nama Program',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi'),

                    ],
                   
                    [
                        'field' => 'kode_event',
                        'label' => 'Kode Kegiatan',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi','is_unique'=>'kode sudah digunakan','edit_unique'=>'kode sudah digunakan'), 
                    ],
                    [
                        'field' => 'id_jenis_event',
                        'label' => 'Jenis Event',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi'),

                    ],
                    [
                        'field' => 'start_event',
                        'label' => 'Waktu Mulai',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi'),

                    ],
                   [
                        'field' => 'end_event',
                        'label' => 'Waktu Selesai',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi'),

                    ],
                      
            ];
       return $rules;
}

}

/* End of file ProgramKerja_model.php */
/* Location: ./application/modules/program_kerja/models/ProgramKerja_model.php */